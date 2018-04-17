<?php

namespace App\Http\Controllers;

use App\Link;
use App\Project;
use Auth;
use Cache;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class LinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();

        return view('mylinks', [
            'user' => $user,
            'projects' => $user->userAccessibleProjects(),

        ]);
    }

    public function export(Request $request)
    {
        $user = Auth::user();
        $project_id = $request->project_id;
        $graph = Link::linkGraph($user, $project_id);
        $format = $request->format;
        Link::exportFile($graph, $format, $project_id);
    }

    public function export_voted(Request $request)
    {
        $project_id = $request->project_id;
        $graph = Link::createGraph(Link::votedLinks($request));
        $format = $request->filetype;
        Link::exportFile($graph, $format, $project_id);
    }

    public function project_links(Request $request)
    {
        $project = Project::find($request->project_id);

        return view('links.link_table', ['project' => $project]);
    }

    public function connected(Request $request)
    {
        $project = Project::find($request->project_id);
        $type = $request->type;
        $links = $project->links;
        $connected = [];
        $entity = $type.'_entity';
        foreach ($links as $link) {
            array_push($connected, $link->$entity);
        }
        array_unique($connected, SORT_REGULAR);

        return json_encode($connected);
    }

    public function create(Request $request)
    {
        if (Link::existing($request) == null) {
            Link::create($request, request()->all());

            return 1;
        } else {
            return 0;
        }
    }

    public function import()
    {
        $import = \App\Import::create(request()->all());
        $result = $this->import_links($import);
        if ($import->imported) {
            return \Illuminate\Support\Facades\Redirect::back()->with('notification', 'Links Imported!!!');
        } else {
            return \Illuminate\Support\Facades\Redirect::back()->with('error', 'An error Occured. Could not import Links!!!'.$result);
        }
    }

    public function convert(\App\Import $import)
    {
        $command = 'rapper -i '.$import->filetype.' -o rdfxml-abbrev '.$import->resource->path().' > '.$import->resource->path().'.rdf';
        $out = [];
        logger($command);
        exec($command, $out);
        logger(var_dump($out));
    }

    public function import_links(\App\Import $import)
    {
        $graph = new \EasyRdf_Graph();
        try {
            if ($import->filetype != 'rdfxml') {
                $this->convert($import);
                $graph->parseFile($import->resource->path().'.rdf', 'rdfxml');
            } else {
                $graph->parseFile($import->resource->path(), 'rdfxml');
            }
            $import->parsed = true;
            $import->save();
        } catch (\Exception $ex) {
            $import->parsed = false;
            $import->save();

            return 'Fail to parse file. Check filetype or valid syntax. Error:'.$ex;
        }
        $resources = $graph->resources();
        foreach ($resources as $resource) {
            $properties = $resource->propertyUris();
            foreach ($properties as $property) {
                $links = $resource->allResources(new \EasyRdf_Resource($property));
                foreach ($links as $link) {
                    $data = [
                        'source' => $resource->getUri(),
                        'target' => $link->getUri(),
                        'link_type' => $property,
                        'project_id' => $import->project_id,
                    ];
                    $request = \Illuminate\Support\Facades\Request::create('/', 'GET', $data);
                    echo $this->create($request);
                }
            }
        }
        $import->imported = true;
        $import->save();
    }

    public function destroy(Request $request)
    {
        $link = \App\Link::find($request->id);
        try {
            $this->authorize('destroy', $link);
            $link->delete();
            $data = [
                'priority' => 'success',
                'title' => 'Success',
                'message' => 'Link Deleted!!!',
            ];

            return response()->json($data);
        } catch (\Exception $ex) {
            $data = [
                'priority' => 'error',
                'title' => 'Error',
                'message' => 'You are not authorized to delete this link!',
            ];

            return response()->json($data);
        }
    }

    public function delete_all(Request $request)
    {
        $project = Project::find($request->project_id);
        //dd($project);
        $links = $project->links;
        foreach ($links as $link) {
            // $this->authorize('destroy', $link);
            $link->delete();
        }

        return Redirect()->back()->with('notification', 'All Links Deleted!!!');
    }

    public function ajax()
    {
        $prefixes = \App\Prefix::all();
        foreach ($prefixes as $prefix) {
            \EasyRdf_Namespace::set($prefix->prefix, $prefix->namespace);
        }
        $project = \App\Project::find(request()->project);
        if (request()->route == 'mylinks') {
            $links = Link::where('project_id', '=', $project->id)
                    ->where('user_id', '=', auth()->user()->id)
                    ->orderBy('created_at', 'desc')->get();
        } else {
            $links = Link::where('project_id', '=', $project->id)->orderBy('created_at', 'desc')->get();
        }
        $source_graph = $project->source->cacheGraph();
        $target_graph = $project->target->cacheGraph();
        $ontologies_graph = Cache::get('ontologies_graph');

        return Datatables::of($links)
                        ->addColumn('source', function ($link) use ($source_graph) {
                            return view('links.resource', [
                                'resource' => $link->source_entity,
                                'graph' => $source_graph,
                            ]);
                        })
                        ->addColumn('target', function ($link) use ($target_graph) {
                            return view('links.resource', [
                                'resource' => $link->target_entity,
                                'graph' => $target_graph,
                            ]);
                        })
                        ->addColumn('link', function ($link) use ($ontologies_graph) {
                            return view('links.resource', [
                                'resource' => $link->link_type,
                                'graph' => $ontologies_graph,
                            ]);
                        })
                        ->addColumn('action', function ($link) {
                            if ($link->user_id == auth()->user()->id || $link->project->user->id == auth()->user()->id) {
                                $class = 'btn';
                            } else {
                                $class = 'btn disabled';
                            }

                            return  '<button onclick="delete_link('.$link->id.')" class="'.$class.'" title="Delete this Link"><span class="glyphicon glyphicon-remove text-red"></span></button>';
                        })
                        ->addColumn('project', function ($link) {
                            return $link->project->name;
                        })
                        ->rawColumns(['source', 'target', 'link', 'action'])
                        ->make(true);
    }
}
