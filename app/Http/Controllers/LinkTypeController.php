<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

Use DB;




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
        $instances = $this->getInstances($group);
        return view('createlinks.partials.linkinput',["instances" => $instances]);
    }
    

}

