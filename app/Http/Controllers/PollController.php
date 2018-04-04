<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

class PollController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $projects = \App\Project::where('public', '=', '1')->get();
        return view('voteApp.index', ["projects" => $projects]);
    }
    
    public function projects(){
        return \App\Project::all();
    }
    
    public function project($id){
        return \App\Project::find($id);
    }
    
    public function getAvailableLinks(){
        
        //get all users votes
        $userVotes = \App\Vote::where("user_id", "=", request()->user)->get();
        
        //filter invalid votes
        $validVotes = $userVotes->reject(function( $value, $key){
            return \App\Link::find($value->link_id) == null ;
        });
        
        //filter votes on the particular project
        $projectVotes = $validVotes->reject(function($value, $key){
           return \App\Link::find($value->link_id)->project->id != request()->project; 
        });
        
        $votedLinks = $projectVotes->map(function($value, $key){
           return $value->link_id; 
        });
        
        $links = \App\Link::where("project_id", "=", request()->project)
                ->whereNotIn("id", $votedLinks)->get();
        
        return $links;
    }
    
    public function createPoll(){
        $available = $this->getAvailableLinks();
        if ($available->count() != 0){
            $pool = $available->shuffle();
            return $pool->chunk(50)[0];
        }
        else{
            return null;
        }
        
    }
        
    public function getPoll(){
        $project = \App\Project::find(request()->project);
        $candidates = $this->createPoll();
        if($candidates != null){            
            $project->source->cacheGraph();
            $project->target->cacheGraph();
        }
        return view('voteApp.partials.poll', 
                [
                    "candidates" => $candidates,
                    "project" => $project
                ]);        
    }
    
}
