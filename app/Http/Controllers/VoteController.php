<?php

namespace App\Http\Controllers;

use DB;

//use Illuminate\Http\Request;

class VoteController extends Controller
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
        return view('myvotes');
    }
    
    public function mylinks()
    {
        return view('votes.wrapper');
    }
    
    public function project_vote()
    {   
        $id = request()->project_id;
        $project = \App\Project::find($id);
        $links = $project->links()->paginate(10);
        foreach($links as $link){
            $link->humanize();
        }

        return view('votes.project-overview', [
            'links'=> $links,
            'project'=> $project,                            
            ]);
    }
    
    
    //a function to vote
    public function vote()
    {
        $input = request()->all();
        if(VoteController::novote( $input["user_id"], $input["link_id"])){
            $vote = \App\Vote::create( $input );
            $link = $vote->link;
            if( $vote->vote == 1 ){
                $link->up_votes = $link->up_votes + 1;
            }
            else{
                $link->down_votes = $link->down_votes + 1;
            }        
            $link->score = $link->up_votes - $link->down_votes;
            $link->save();
            $up_votes = $link->up_votes;
            $down_votes = $link->down_votes;
            $message = "Vote counted!!!";
            return  response()->json(["message" => trans('alignment/votes.vote-valid'),
                                      "valid" => true,
                                      "up_votes" => $up_votes, 
                                      "down_votes" => $down_votes,
                                ]);
        }
        else{
            return $this->changevote($input["user_id"], $input["link_id"], $input["vote"]);
        }
    }
    
    
    //a function to preview an entity
    public function preview()
    {
        $input = request()->all();
        $uri = $input["uri"];
        $graph = \EasyRdf_Graph::newAndLoad($uri);
        $message = $graph->dump('html');
        return  response()->json(["message" => $message,
                                      "valid" => true,
                                ]);
        
    }
    
    
    //a function to check if user has already voted    
    public function novote( $user, $link)
    {
        $votes = DB::table('votes')->where([
            ['user_id', '=', $user],
            ['link_id', '=', $link],
        ])->first();
        //dd($votes);
        if ($votes != null){
            return false;
        }
        else{
            return true;
        }
    }
    
    //a function to check if user has already voted    
    public function changevote($user, $link, $current)
    {   
        
        $vote = \App\Vote::where([
            ['user_id', '=', $user],
            ['link_id', '=', $link],
        ])->first();
        //dd($vote);
        if($vote->vote != $current){
            
        
        $link = $vote->link;
        
            if( $current == 1 ){
                $link->up_votes = $link->up_votes + 1;
                $link->down_votes = $link->down_votes - 1;
                
            }
            else{
                $link->down_votes = $link->down_votes + 1;
                $link->up_votes = $link->up_votes - 1;
            }        
            $link->score = $link->up_votes - $link->down_votes;
            $link->save();
            $vote->vote = $current;
            $vote->save();
            $up_votes = $link->up_votes;
            $down_votes = $link->down_votes;
        $message = "You had already Voted. Vote changed";            
        return  response()->json(["message" => trans('alignment/votes.vote-changed'),
                                      "valid" => true,
                                      "up_votes" => $up_votes, 
                                      "down_votes" => $down_votes,
                                ]);
        }
        else{
            $message = "You have already Voted";    
            return  response()->json(["message" => trans('alignment/votes.vote-invalid'),
                                      "valid" => false,
                                      
                                ]);
        }
    }
    
    
}
