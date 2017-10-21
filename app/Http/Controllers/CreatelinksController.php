<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Project;
use App\File;
use Cache;
use Storage;
use DB;
use App\Notification;

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
        $uri = urldecode($request["uri"]);
        $result =  $graph->dumpResource($uri, "html");
        return $result;
    }

    public function short_infobox(Request $request) {
        $project = Project::find($request->project_id);
        $dump = $request->dump;
        $file = $project->$dump;
        $graph_name =  $file->id . "_graph";
        $graph = Cache::get($graph_name);
        $uri = urldecode($request["uri"]);
        $prefLabel = $this->label($graph, $uri);
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
            $suffix = ($file->filetype != 'ntriples' ) ? '.nt' : '';
            $graph->parseFile($file->resource->path() . $suffix, 'ntriples');
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
        $root = 'http://www.w3.org/2004/02/skos/core#ConceptScheme';
        $firstLevelPath = "^skos:topConceptOf";
        $inverseFirstLevelPath = "skos:hasTopConcept";
        $parents = $graph->allOfType($root);
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
            $children = $this->find_children($graph, $firstLevelPath, $parent, $orderBy, $score, $JSON);
            if (sizeOf($children) == 0){
                $children = $this->find_children($graph, $inverseFirstLevelPath, $parent, $orderBy, $score, $JSON);
            }
            $JSON['children'] = $orderBy === null ? $children : collect($children)->sortBy($orderBy)->values()->toArray();
        }

        /*
         * create JSON file
         */
        $name = implode("_", ["project", $project->id, $dump, $file->id, $orderBy]);
        $filename = 'json_serializer/' . $name . ".json";
        Storage::disk('public')->put($filename, json_encode($JSON));
        return $filename;
    }

    function find_children(\EasyRdf_Graph $graph, $hierarchic_link, $parent_url, $orderBy = null, $score = null) {

        $children = $graph->allResources($parent_url, $hierarchic_link);
        $counter = 0;
        $myJSON = [];
        $link = "skos:narrower";
        $inverseLink = "^skos:broader";
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
            $children = $this->find_children($graph, $link, $child, $orderBy, $score, $myJSON);
            if (sizeOf($children) == 0){
                $children = $this->find_children($graph, $inverseLink, $child, $orderBy, $score, $myJSON);
            }

            $myJSON[$counter]['children'] = $orderBy === null ? $children : collect($children)->sortBy($orderBy)->values()->toArray();
            $counter++;
        }
        return $myJSON;
    }

    public function parseScore(Project $project, $user_id){
        $old_score = storage_path() . "/app/projects/project" . $project->id . "/" . "score.nt";
        $score_filepath = storage_path() . "/app/projects/project" . $project->id . "/" . "score_project" . $project->id . ".nt";
        try{
            $command = 'rapper -i rdfxml -o ntriples ' . $old_score . ' > ' . $score_filepath;
            $out = [];
            logger($command);
            exec( $command, $out);
            logger(var_dump($out));
            Notification::create([
                "message" => 'Converted Score Graph...',
                "user_id" => $user_id,
                "project_id" => $project->id,
                "status" => 2,
            ]);
        }
        catch(\Exception $ex){
            logger($ex);
        }
        try{
            $scores = new \EasyRdf_Graph;
            $scores->parseFile($score_filepath, "ntriples");

            Notification::create([
                "message" => 'Parsed and Stored Graphs!!!',
                "user_id" => $user_id,
                "project_id" => $project->id,
                "status" => 2,
            ]);
        } catch (\Exception $ex) {
            logger($ex);
        }
        logger("converting files");
        Cache::forever("scores_graph_project" . $project->id, $scores);
    }
}