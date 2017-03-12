<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\Response;
use App\Project;
use App\File;
use App\User;
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
        $source = $project->source;
        $target = $project->target;
        
        $graph1 = new \EasyRdf_Graph;
        $graph1->parseFile(storage_path('app/ontologies/owl.rdf'));
        
        $graph2 = new \EasyRdf_Graph;
        $graph2->parseFile(storage_path('app/ontologies/rdfs.rdf'));
        
        $graph3 = new \EasyRdf_Graph;
        $graph3->parseFile(storage_path('app/ontologies/skos.rdf'));
        
        $graph1_2 = $this->mergeGraphs($graph1, $graph2);
        $merged_graph = $this->mergeGraphs($graph1_2, $graph3);
        
        Cache::forever( 'ontologies_graph', $merged_graph);
        
        $this->D3_convert($source, 'source');
        $this->D3_convert($target, 'target');
        $groups = $this->getGroups();
        
        return view('createlinks', ['project' => $project,
                                    'groups'=>$groups,
                ]);
    }

    public function json_serializer($file) {

        $jsonfile = Storage::disk('public')->get('json_serializer/' . $file);

        return (new Response($jsonfile, 200))
                        ->header('Content-Type', 'application/json');
    }

    public function infobox(Request $request) {
        $graph_name = $request["dump"] . "_graph";
        $graph = Cache::get($graph_name);
        $url = urldecode($request["url"]);
        $result =  $graph->dumpResource($url, "html");
        return $result;
    }
    public function short_infobox(Request $request) {
        $graph_name = $request["dump"] . "_graph";
        $graph = Cache::get($graph_name);
        $url = urldecode($request["url"]);
        $prefLabel = $this->label($graph, $url);
        $details = CreatelinksController::infobox($request);        
        return view('createlinks.partials.info',['header'=> $prefLabel, 'dump'=>$request["dump"], "details"=>$details]);        
    }

    public function comparison(Request $request, Project $project) {
        $iri = urldecode($request['url']);
        $graph_name = "target_graph";
        $graph = Cache::get($graph_name);
        $scores = Cache::get("scores_graph_project" . $project->id);
        $results = $scores->resourcesMatching("http://knowledgeweb.semanticweb.org/heterogeneity/alignment#entity1", new \EasyRdf_Resource($iri));
        $candidates =  array();
        foreach ($results as $result) {            
            $target = $scores->get($result, new \EasyRdf_Resource("http://knowledgeweb.semanticweb.org/heterogeneity/alignment#entity2"));
            $score = $scores->get($result, new \EasyRdf_Resource("http://knowledgeweb.semanticweb.org/heterogeneity/alignment#measure"))->getValue();
            $label = $this->label($graph, $target);
            $candidate = [
                "target" => $target,
                "score"  => $score,
                "label"  => $label,
            ];
            array_push($candidates, $candidate);
        }
        return view('createlinks.partials.comparison', ["candidates"=>$candidates]);
    }

    public function createSourceSubgraph($source_iri, Project $project) {
        $graph = new \EasyRdf_Graph;
        $graph->parseFile($project->source->resource->path(), 'rdfxml');

        //echo $graph -> dumpResource($source_iri,"html");
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

    public function D3_convert(File $file, $dump) {

        $graph = new \EasyRdf_Graph;
        /*
         * Read the graph
         */

        try {
            $suffix = ($file->filetype != 'rdfxml' ) ? '.rdf' : '';
            $graph->parseFile($file->resource->path() . $suffix, 'rdfxml');
            Cache::forever($dump . "_graph", $graph);
        } catch (Exception $ex) {
            error_log($ex);
        }
        /*
         * Get the parent node
         */
        $type = 'http://www.w3.org/2004/02/skos/core#ConceptScheme';
        $parents = $graph->allOfType($type);
        /*
         * Iterate through all parents 
         */
        foreach ($parents as $parent) {
            /*
             * Create Root Entry
             */
            $name = $this->label($graph, $parent);
            $toJSON['name'] = "$name";
            $toJSON['url'] = urlencode($parent);
            $JSON2['name'] = "$name";
            $JSON2['url'] = urlencode($parent);
            $JSON2['children'] = $this->find_children($graph, "^skos:topConceptOf", $parent, $JSON2);
        }

        /*
         * create JSON file
         */
        $filename = 'json_serializer/' . $dump . $file->id . ".json";
        Storage::disk('public')->put('json_serializer/' . $dump . $file->id . ".json", json_encode($JSON2));
        Cache::forever($dump, $filename);
        $_SESSION[$dump . "_graph"] = $graph;
        $_SESSION[$dump . "_json"] = 'json_serializer/' . $dump . $file->id . ".json";
    }

    function find_children(\EasyRdf_Graph $graph, $hierarchic_link, $parent_url) {

        $childrens = $graph->allResources($parent_url, $hierarchic_link);
        $counter = 0;
        $myJSON = array();

        foreach ($childrens as $children) {
            $name = $this->label($graph, $children);
            $myJSON[]["name"] = "$name";
            $myJSON[$counter]['url'] = urlencode($children);
            $myJSON[$counter]['children'] = $this->find_children($graph, "skos:narrower", $children, $myJSON);
            if (sizeOf($myJSON[$counter]['children']) == 0){
                $myJSON[$counter]['children'] = $this->find_children($graph, "^skos:broader", $children, $myJSON);
            }
            $counter++;
        }
        return $myJSON;
    }

}
