<?php

namespace App\Http\Controllers;

use DB;
use Cache;
use Storage;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
            dd($ex);
        }
        return (new Response($jsonfile, 200))
                        ->header('Content-Type', 'application/json');
    }

    public function infobox(Request $request) {
        $project = Project::find($request->project_id);
        $dump = $request->dump;
        $file = $project->$dump;        
        $graph = $file->cacheGraph();
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
        $candidates = [];                   
        try {
            if($scores){
                $results = $scores->resourcesMatching("http://knowledgeweb.semanticweb.org/heterogeneity/alignment#entity1", new \EasyRdf_Resource($iri));
            }
            else{
                return view('createlinks.partials.comparison', ["candidates"=>$candidates]);
            }
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
        } catch (\Exception $ex) {
            logger("empty candidates: " . $ex);
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
}