<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Link;
use App\Project;
use Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;
use Cache;
use Carbon\Carbon;

class LinkController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index() {
        $user = Auth::user();
        
        
        $projects = \App\Project::where("user_id", "=", $user->id)
                ->orWhere("public", "=", TRUE)
                ->get();
        $select = [];
        foreach ($projects as $project) {
                        
                            $key = $project->id;
                            $value = $project->name;
                            $select = array_add($select, $key, $value);
                        
                    }
        
        return view('mylinks', [
            "user" => $user,
            "projects" => $projects,
            "select" => $select,
        ]);
    }

    public function project_links(Request $request) {
        session_start();
        $project = Project::find($request->project_id);
        return view('links.link_table', ["project" => $project]);
    }

    public function connected(Request $request) {
        session_start();
        $project = Project::find($request->project_id);
        $type = $request->type;
        $links = $project->links;
        $connected = array();
        $entity = $type . '_entity';
        foreach ($links as $link) {
            array_push($connected, $link->$entity);
        }
        array_unique($connected, SORT_REGULAR);
        return json_encode($connected);
    }

    public function create(Request $request) {
        $input = request()->all();
        $project = Project::find($request->project_id);
        $previous = Link::where('project_id', '=', $request->project_id)
                ->where('source_entity', '=', $request->source)
                ->where('target_entity', '=', $request->target)
                ->where('link_type', '=', $request->link_type)
                ->first();
        if ($previous == null) {
            $link = Link::create($input);
            $link->project_id = $request->project_id;
            $link->user_id = auth()->user()->id;
            $link->source_id = $project->source_id;
            $link->target_id = $project->target_id;
            $link->source_entity = $request->source;
            $link->target_entity = $request->target;
            $link->link_type = $request->link_type;
            $link->save();
            return 1;
        } else {

            return 0;
        }
    }
    
    public function import(){
        $import = \App\Import::create(request()->all());
        $result = $this->import_links($import);
        if($import->imported){
            return \Illuminate\Support\Facades\Redirect::back()->with('notification', 'Links Imported!!!');
        }
        else{
            return \Illuminate\Support\Facades\Redirect::back()->with('error', 'An error Occured. Could not import Links!!!' . $result);
        }
        
    }
    
    public function convert(\App\Import $import){
        $command = 'rapper -i ' . $import->filetype . ' -o rdfxml-abbrev ' . $import->resource->path() . ' > ' . $import->resource->path(). '.rdf';  
        $out = [];
        logger($command);
        exec( $command, $out);
        logger(var_dump($out));
        return;
    }

    public function import_links(\App\Import $import) {
        $graph = new \EasyRdf_Graph();
        try{
          if($import->filetype != 'rdfxml'){
              $this->convert($import);
              $graph->parseFile($import->resource->path() . '.rdf', 'rdfxml');
          }
          else{
              $graph->parseFile($import->resource->path(), 'rdfxml');
          }
          $import->parsed = true;
          $import->save();
        } catch (\Exception $ex) {
            $import->parsed = false;
            $import->save();
            return "Fail to parse file. Check filetype or valid syntax. Error:" . $ex;
        } 
        $resources = $graph->resources();
        foreach ($resources as $resource) {
            $properties = $resource->propertyUris();
            foreach ($properties as $property) {
                $links = $resource->allResources(new \EasyRdf_Resource($property));
                foreach ($links as $link) {
                    $data = [
                        "source" => $resource->getUri(),
                        "target" => $link->getUri(),
                        "link_type" => $property,
                        "project_id" => $import->project_id,
                    ];
                    $request = \Illuminate\Support\Facades\Request::create("/", "GET", $data);
                    echo $this->create($request);
                }
            }
        }
        $import->imported = true;
        $import->save();
    }

    public function destroy(Request $request) {
        $link = \App\Link::find($request->id);
        try{
            $this->authorize('destroy', $link);
            $link->delete();
            $data = [
                "priority" => "success",
                "title" => "Success",
                "message" => "Link Deleted!!!"
            ];
            return response()->json($data);
        } catch (\Exception $ex) {
            $data = [
                "priority" => "error",
                "title" => "Error",
                "message" => "You are not authorized to delete this link!"
            ];
            return response()->json($data);
        }
        
        
    }

    public function delete_all(Request $request) {

        $project = Project::find($request->project_id);
        //dd($project);
        $links = $project->links;
        foreach ($links as $link) {
            // $this->authorize('destroy', $link);
            $link->delete();
        }
        return \Illuminate\Support\Facades\Redirect::back()->with('notification', 'All Links Deleted!!!');
    }

    public function CreateRDFGraph(User $user, $project_id) {
        $myGraph = new \EasyRdf_Graph;
        $project = Project::find($project_id);
        //dd($project);
        if ($project == null) {
            foreach ($user->projects as $project) {
                $links = $project->links;
                foreach ($links as $link) {
                    $myGraph->addResource($link->source_entity, $link->link_type, $link->target_entity);
                }
            }
        } else {
            $links = $project->links;
            foreach ($links as $link) {
                $myGraph->addResource($link->source_entity, $link->link_type, $link->target_entity);
            }
        }
        return $myGraph;
    }

    public function CreateRDFGraph2($links) {
        $myGraph = new \EasyRdf_Graph;
        foreach ($links as $link) {
            $myGraph->addResource($link->source_entity, $link->link_type, $link->target_entity);
        }
        return $myGraph;
    }

    public function export(Request $request) {
        $user = \Illuminate\Support\Facades\Auth::user();
        $project_id = $request->project_id;
        if (!is_numeric($project_id) && !empty($project_id)) {
            $project = Project::where('name', '=', $project_id)->first();
            $project_id = $project->id;
        }
        $myGraph = LinkController::CreateRDFGraph($user, $project_id);
        $format = $request->format;
        LinkController::CreateRDFFile($myGraph, $format, $project_id);
    }

    public function export_voted(Request $request) {
        $project_id = $request->project_id;
        $links = \App\Link::where("project_id", "=", $request->project_id)
                ->when(isset($request->score), function($query) use ($request) {
                    return $query->where('score', '>', $request->score);
                })
                ->get();
        $links = $links->filter(function($link) {
            return $this->confidence($link) >= request("threshold") / 100;
        });
        $myGraph = $this->CreateRDFGraph2($links);
        $format = $request->filetype;
        $this->CreateRDFFile($myGraph, $format, $project_id);
    }

    public function confidence(Link $link) {
        $upVotes = $link->up_votes;
        $downVotes = $link->down_votes;
        $totalVotes = $upVotes + $downVotes;
        if ($totalVotes > 0) {
            return (double) $upVotes / $totalVotes;
        } else {
            return 0;
        }
    }

    function DownloadFile($file, $name, $format) { // $file = include path
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . $name);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            header('Content-Type: ' . $format);
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
            exit;
        }
    }

    function CreateRDFFile($myGraph, $format, $project_id) {
        $export = $myGraph->serialise($format);
        $project = Project::find($project_id);

        $File_Ext = \EasyRdf_Format::getFormat($format)->getDefaultExtension(); //get file extention
        if ($project_id == null) {
            $NewFileName = storage_path() . "/app/projects/" . "Export" . "." . $File_Ext;
            file_put_contents($NewFileName, $export);
        } else {
            $File_Name = "Alignment_Export_" . str_slug($project->name) . "." . $File_Ext;
            $NewFileName = storage_path() . "/app/projects/project" . $project_id . "/" . $File_Name;
            file_put_contents($NewFileName, $export);
        }
        LinkController::DownLoadFile($NewFileName, $File_Name, $format);
    }

    public function ajax() {
        $prefixes = \App\Prefix::all();
        foreach ($prefixes as $prefix) {
            \EasyRdf_Namespace::set($prefix->prefix, $prefix->namespace);
        }
        $project = \App\Project::find(request()->project);
        if(request()->route == "mylinks"){
            $links = Link::where("project_id", "=", $project->id)
                    ->where("user_id", "=", auth()->user()->id)
                    ->orderBy("created_at", "desc")->get();
        }
        else{
            $links = Link::where("project_id", "=", $project->id)->orderBy("created_at", "desc")->get();
        }
        
        $file = new FileController();
        $source_graph = Cache::get($project->source_id . '_graph') ? : $file->cacheGraph(\App\File::find($project->source_id));
        $target_graph = Cache::get($project->target_id . '_graph')? : $file->cacheGraph(\App\File::find($project->target_id));
        $ontologies_graph = Cache::get('ontologies_graph');
        return Datatables::of($links)
                        ->addColumn('source', function($link) use($source_graph) {
                            return view("links.resource", [
                                "resource" => $link->source_entity,
                                "graph" => $source_graph,
                            ]);
                        })
                        ->addColumn('target', function($link) use ($target_graph) {
                            return view("links.resource", [
                                "resource" => $link->target_entity,
                                "graph" => $target_graph,
                            ]);
                        })
                        ->addColumn('link', function($link) use ($ontologies_graph) {
                            return view("links.resource", [
                                "resource" => $link->link_type,
                                "graph" => $ontologies_graph,
                            ]);
                        })
                        ->addColumn('action', function($link) {
                            if($link->user_id == auth()->user()->id || $link->project->user->id == auth()->user()->id){
                                $class = "btn";
                            }
                            else{
                                $class = "btn disabled";
                            }
                            return  '<button onclick="delete_link('.$link->id.')" class="' . $class . '" title="Delete this Link"><span class="glyphicon glyphicon-remove text-red"></span></button>';
                                   
                        })
                        ->addColumn('project', function($link) {
                            return $link->project->name;
                        })
                        ->make(true);
    }

}
