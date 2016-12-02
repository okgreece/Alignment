<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HomeController extends Controller
{
    public function welcome(){
        return view('welcome');
    }
    
    public function about(){
        return view('about');
    }
}
