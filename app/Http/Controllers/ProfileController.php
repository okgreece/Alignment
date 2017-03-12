<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index($id)
    {
        $user = \App\User::find($id);
        if($user == null){
            abort(404);
        }
        $upvotes = $this->user_upvotes($user);
        $downvotes = $this->user_downvotes($user);
        return view('profile', 
                [
                    'user_profile'=>$user,
                    'upvotes' => $upvotes,
                    'downvotes' => $downvotes,
            ]);
    }
    
    public function user_upvotes(\App\User $user){
        $votes = \App\Vote::where('user_id', '=', $user->id)
                ->where('vote', '=', '1')
                ->get();
        return sizeof($votes);
    }
    
    public function user_downvotes(\App\User $user){
        $votes = \App\Vote::where('user_id', '=', $user->id)
                ->where('vote', '=', '-1')
                ->get();
        return sizeof($votes);
    }
}