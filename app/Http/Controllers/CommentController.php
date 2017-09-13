<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function show(Request $request)
    {
        $link = \App\Link::find($request->link_id);
        
        $comments = $link->comments;
        
        $response = array();
        foreach($comments as $comment){
            $user = $comment->user->name;
            $avatar = $comment->user->avatar?:asset('/img/avatar04.png');
            $text = $comment->body;
            $date = $comment->created_at;
            array_push($response, ["user" => $user,
                                    "avatar" => $avatar,
                                   "text" => $text,
                                   "date" => $date]);
        }
        
        return response()->json($response);   
    }
    
    public function create()
    {
        $input = request()->all();
       
	    $comment = \App\Comment::create( $input );
        
        $comment->save();

        $link = $comment->link;

        $count = $link->comments()->count();

        return response()->json(
            [
                "message" => 'Comment posted succesfully!',
                "count" => $count
            ]);
    }
}
