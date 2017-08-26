<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

Use DB;
use Illuminate\Support\Facades\Storage;


class LinkTypeController extends Controller
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
        
    }
    
    
    
    public function getInstances($group)
    {
        $inputs = \App\LinkType::where('group', '=', $group)
                ->where( function($query){
                    $user = auth()->user();
                    $query->where('public', '=', 'true')
                          ->orWhere('user_id', '=', $user);
                }
                )
                ->get();
        return $inputs;
    }
    
    public function updateForm(Request $request){
        $group = $request->group;
        if(!\Illuminate\Support\Facades\Cache::has($group. '.ontology')){
            $graph = new \EasyRdf_Graph();
            $graph->parseFile(storage_path() . "/app/ontologies/" . mb_strtolower($group) . '.rdf', 'rdfxml');
            \Illuminate\Support\Facades\Cache::put($group. '.ontology', $graph);
        }
        else{
            $graph = \Illuminate\Support\Facades\Cache::get($group. '.ontology');
        }
        $instances = $this->getInstances($group);
        return view('createlinks.partials.linkinput',["instances" => $instances, "graph" => $graph]);
    }
    

}

