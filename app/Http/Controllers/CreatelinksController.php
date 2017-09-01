<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Project;
use App\File;
use Cache;
use Storage;
use DB;


class CreatelinksController extends Controller {
    
    use \App\RDFTrait;
    
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index(Project $project) {
        session_start();
        $this->cacheOntologies();
        $nameSource = implode("_", ["project", $project->id, "source", $project->source->id, '']);
        $nameTarget = implode("_", ["project", $project->id, "target", $project->target->id, '']);
        $filenameS = 'json_serializer/' . $nameSource . ".json";
        $filenameT = 'json_serializer/' . $nameTarget . ".json";
        $_SESSION["source_json"] = $filenameS;
        $_SESSION["target_json"] = $filenameT;
        //$this->D3_convert($project, 'source');
        //$this->D3_convert($project, 'target');
        $groups = $this->getGroups();        
        return view('createlinks',
                ['project' => $project,
                    'groups'=>$groups,
                    ]);
        }

    private function cacheOntologies(){
        if(Cache::has('ontologies_graph')){
            return "Ontologies already on Cache";
        }
        else{
            $graph1 = new \EasyRdf_Graph;
            $graph1->parseFile(storage_path('app/ontologies/owl.rdf'));

            $graph2 = new \EasyRdf_Graph;
            $graph2->parseFile(storage_path('app/ontologies/rdfs.rdf'));

            $graph3 = new \EasyRdf_Graph;
            $graph3->parseFile(storage_path('app/ontologies/skos.rdf'));

            $graph1_2 = $this->mergeGraphs($graph1, $graph2);
            $merged_graph = $this->mergeGraphs($graph1_2, $graph3);

            Cache::forever( 'ontologies_graph', $merged_graph);
            return "Ontologies Cached";
        }
    }

    public function json_serializer($file) {
        try{
            $jsonfile = Storage::disk('public')->get('json_serializer/' . $file);
        }
        catch (\Exception $ex){
            $newfile = explode("_", explode(".", $file)[0]);
            $this->D3_convert(Project::find($newfile[1]), $newfile[2], $newfile[4]);
            $jsonfile = Storage::disk('public')->get('json_serializer/' . $file);
        }
        return (new Response($jsonfile, 200))
                        ->header('Content-Type', 'application/json');
    }

    public function infobox(Request $request) {
        $project = Project::find($request->project_id);
        $dump = $request->dump;
        $file = $project->$dump;
        $graph_name =  $file->id . "_graph";
        $graph = Cache::get($graph_name);
        $url = urldecode($request["url"]);
        $result =  $graph->dumpResource($url, "html");
        return $result;
    }

    public function short_infobox(Request $request) {
        $project = Project::find($request->project_id);
        $dump = $request->dump;
        $file = $project->$dump;
        $graph_name =  $file->id . "_graph";
        $graph = Cache::get($graph_name);
        $url = urldecode($request["url"]);
        $prefLabel = $this->label($graph, $url);
        $collapsed = isset($request->collapsed) ? ($request->collapsed === "true" ? "plus" : "minus") : "plus";
        $details = CreatelinksController::infobox($request);
        return view('createlinks.partials.info',['header'=> $prefLabel, 'dump'=>$request["dump"], "details"=>$details, "collapsed"=>$collapsed]);
    }

    public function comparison(Request $request, Project $project) {
        $iri = urldecode($request['url']);
        $graph_name = $project->target->id . "_graph";
        $graph = Cache::get($graph_name);
        $scores = Cache::get("scores_graph_project" . $project->id);
        $results = $scores->resourcesMatching("http://knowledgeweb.semanticweb.org/heterogeneity/alignment#entity1", new \EasyRdf_Resource($iri));
        $candidates =  array();
        foreach ($results as $result) {
            $target = $scores->get($result, new \EasyRdf_Resource("http://knowledgeweb.semanticweb.org/heterogeneity/alignment#entity2"));
            $score = $scores->get($result, new \EasyRdf_Resource("http://knowledgeweb.semanticweb.org/heterogeneity/alignment#measure"))->getValue();
            $label = $this->label($graph, $target);
            $class = ( $score < 0.3 ) ? "low" : (( $score >= 0.3 && $score < 0.8 ) ? "medium" : "high");  
            $candidate = [
                "target" => $target,
                "score" => $score,
                "label" => $label,
                "class" => $class,
            ];
            array_push($candidates, $candidate);
        }
        return view('createlinks.partials.comparison', ["candidates"=>$candidates]);
    }

    public function createSourceSubgraph($source_iri, Project $project) {
        $graph = new \EasyRdf_Graph;
        $graph->parseFile($project->source->resource->path(), 'rdfxml');
        $resource = $graph->resource($source_iri);
        $properties = $resource->properties();
        $resourceGraph = new \EasyRdf_Graph;
        foreach ($properties as $property) {
            $value = $graph->get($resource, $property);
            $resourceGraph->add($resource, $property, $value);
        }
        $export = $resourceGraph->serialise('rdfxml');
        file_put_contents(storage_path() . "/app/projects/project" . $project->id . "/source.rdf", $export);
    }
    
    public function getGroups()
    {
        $user = auth()->user();
        $select = DB::table('link_types')->select('group as option')
                ->where('public', '=', 'true')
                ->orWhere('user_id', '=', $user)
                ->distinct()
                ->get();
        return $select;
    }
    
    private function parseGraph(File $file){
        try {
            $graph = new \EasyRdf_Graph;
            $suffix = ($file->filetype != 'rdfxml' ) ? '.rdf' : '';
            $graph->parseFile($file->resource->path() . $suffix, 'rdfxml');
            Cache::forever($file->id . "_graph", $graph);
            return $graph;
        } catch (Exception $ex) {
            error_log($ex);
        }
    }
    
    public function D3_convert(Project $project, $dump, $orderBy = null) {

        $file = $project->$dump;
        /*
         * Read the graph
         */
        $graph = $this->parseGraph($file);
        /*
         * Get the parent node
         */        
        $type = 'http://www.w3.org/2004/02/skos/core#ConceptScheme';
        $parents = $graph->allOfType($type);
        /*
         * Iterate through all parents
         */
        if($dump === "source"){
            $score = Cache::get("scores_graph_project" . $project->id);
        }
        else{
            $score = null;
        }
        foreach ($parents as $parent) {
            /*
             * Create Root Entry
             */
            $name = $this->label($graph, $parent);
            $JSON['name'] = "$name";
            $JSON['url'] = urlencode($parent);
            $children = $this->find_children($graph, "^skos:topConceptOf", $parent, $orderBy, $score, $JSON);
            $JSON['children'] = $orderBy === null ? $children : collect($children)->sortBy($orderBy)->values()->toArray();
        }

        /*
         * create JSON file
         */
        $name = implode("_", ["project", $project->id, $dump, $file->id, $orderBy]);
        $filename = 'json_serializer/' . $name . ".json";
        Storage::disk('public')->put($filename, json_encode($JSON));
        //$_SESSION[$dump . "_json"] = $filename;
        return $filename;
    }

    function find_children(\EasyRdf_Graph $graph, $hierarchic_link, $parent_url, $orderBy = null, $score = null) {

        $children = $graph->allResources($parent_url, $hierarchic_link);
        $counter = 0;
        $myJSON = [];
        
        foreach ($children as $child) {
            $name = $this->label($graph, $child);
            $myJSON[]["name"] = "$name";
            if($score !== null){
                $suggestions = count($score->resourcesMatching("http://knowledgeweb.semanticweb.org/heterogeneity/alignment#entity1", $child));
            }
            else{
                $suggestions = 0;
            }
            
            $myJSON[$counter]['suggestions'] = $suggestions;
            $myJSON[$counter]['url'] = urlencode($child);
            $children = $this->find_children($graph, "skos:narrower", $child, $orderBy, $score, $myJSON);
            if (sizeOf($children) == 0){
                $children = $this->find_children($graph, "^skos:broader", $child, $orderBy, $score, $myJSON);
            }

            $myJSON[$counter]['children'] = $orderBy === null ? $children : collect($children)->sortBy($orderBy)->values()->toArray();
            $counter++;
        }
        return $myJSON;
    }
}