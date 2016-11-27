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

class CreatelinksController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index(Project $project) {
        $source = $project->source;
        $target = $project->target;
        $this->D3_convert($source, 'source');
        $this->D3_convert($target, 'target');
        
        return view('createlinks', ['project' => $project]);
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
        $prefLabel = $graph->get($url, new \EasyRdf_Resource("http://www.w3.org/2004/02/skos/core#prefLabel"));
        $details = CreatelinksController::infobox($request);        
        return view('createlinks.partials.info',['header'=> $prefLabel, 'dump'=>$request["dump"], "details"=>$details]);        
    }

    public function comparison(Request $request, Project $project) {
        $iri = urldecode($request['url']);
        $graph_name = "target_graph";
        $graph = Cache::get($graph_name);
                
        $scores = Cache::get("scores_graph_project" . $project->id);
        $results = $scores->allOfType("http://knowledgeweb.semanticweb.org/heterogeneity/alignment#Cell");
        $found = false;
        foreach ($results as $result) {
            $source = $scores->get($result, new \EasyRdf_Resource("http://knowledgeweb.semanticweb.org/heterogeneity/alignment#entity1"));
            if (strcmp($source ,$iri)==0) {
                $link = $scores->get($result, new \EasyRdf_Resource("http://knowledgeweb.semanticweb.org/heterogeneity/alignment#entity2"));
                $score = $scores->get($result, new \EasyRdf_Resource("http://knowledgeweb.semanticweb.org/heterogeneity/alignment#measure"))->getValue();
                echo "<div class=\"SiLKscore\">";
                echo "<div class=\"SiLKscore-label\">";
                $url = $link;
                $prefLabel = $graph->get($url, new \EasyRdf_Resource("http://www.w3.org/2004/02/skos/core#prefLabel"));
                echo $prefLabel;
                echo "</div>";
                echo "<div class=\"SiLKscore-button\"><button class=\"btn-xs btn-primary\"onclick=\"click_button('" . $link . "')\">Pick</button></div>";
                echo "<div class=\"SiLKscore-progress progress\"><div class=\"progress-bar progress-bar-success progress-bar-striped active\" role=\"progressbar\"
  aria-valuenow=\"" . round((float)$score*100, 2) . "\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width:". round((float)$score*100,2) ."%\"></div>". round((float)$score*100,2) ."%</div>";
                
                echo "</div>";
                $found = true;
            }
            else{
                
            }
        }
        if(!$found){
            echo "Sorry...we couldn't help you this time. Use your Knowledge!!!";
        }
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

    public function D3_convert(File $file, $dump) {

        $graph = new \EasyRdf_Graph;
        /*
         * Read the graph
         */

        try {
            $suffix = ($file->resource->filetype != 'rdfxml' ) ? '.rdf' : '';
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
            $name = $graph->label($parent);
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
        $_SESSION[$dump . "_json"] = 'json_serializer/' . $dump . $file->id . ".json";
    }

    function find_children(\EasyRdf_Graph $graph, $hierarchic_link, $parent_url) {

        $childrens = $graph->allResources($parent_url, $hierarchic_link);
        $counter = 0;
        $myJSON = array();

        foreach ($childrens as $children) {
            $name = $graph->label($children);
            $myJSON[]["name"] = "$name";
            $myJSON[$counter]['url'] = urlencode($children);
            $myJSON[$counter]['children'] = $this->find_children($graph, "skos:narrower", $children, $myJSON);
            $counter++;
        }

        return $myJSON;
    }

}
