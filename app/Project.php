<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['user_id', 'source_id', 'target_id','name','settings_id', 'public'];
    
    public function user(){
        return $this->belongsTo("App\User");
    }
    
    public function source()
    {
        return $this->hasOne('App\File','id','source_id');
    }
    
    public function target()
    {
        return $this->hasOne('App\File','id','target_id');
    }
    
    public function links()
    {
        return $this->hasMany('App\Link');
    }
    
    public function settings()
    {
        return $this->hasOne('App\Settings','id','settings_id');
    }
    
}
