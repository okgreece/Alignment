<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Link extends Model
{
    use SoftDeletes;
    protected $fillable = ['source_id', 'target_id','source_entity','target_entity'];
    
    protected $dates = ['deleted_at'];
    
    public function project(){
        return $this->belongsTo("App\Project");
    }
    
    public function source()
    {
        return $this->hasOne('App\File','id','source_id');
    }
    
    
    public function target()
    {
        return $this->hasOne('App\File','id','target_id');
    }
    
    public function votes()
    {
        return $this->hasMany('App\Vote');
    }
    
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    
    
}
