<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];    
   
    public function links(){
        return $this->hasMany("App\Link");
    }

    public function projects(){
        return $this->hasMany("App\Project");
    }
    
    public function files(){
        return $this->hasMany("App\File");
    }
    
    public function votes(){
        return $this->hasMany("App\Vote");
    }
    
    public function comments(){
        return $this->hasMany("App\Comment");
    }
    
    public function social(){
        return $this->hasMany("App\SocialAccount");
    }
    
    public function userGraphs(){
        return $this->ownGraphs()->merge($this->publicGraphs());        
    }
    
    public function ownGraphs(){
        return File::where("user_id", $this->id)->withCount("projects")->with("projects")->get();        
    }
    
    public function publicGraphs(){
        return File::where("public", true)->where("user_id", "!=", $this->id)->withCount("projects")->with("projects")->get();        
    }
    
}
