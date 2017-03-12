<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Link;

class HomeController extends Controller
{
    public function welcome(){
        return view('welcome');
    }
    
    public function about(){
        
        return view('about');
    }
}
