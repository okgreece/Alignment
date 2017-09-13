<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;


class Link extends Model
{
    use SoftDeletes;
    protected $fillable = ['source_id', 'target_id','source_entity','target_entity', 'user_id'];
    
    protected $dates = ['deleted_at'];
    
    public function project(){
        return $this->belongsTo("App\Project");
    }
    
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
    
    public function votes()
    {
        return $this->hasMany('App\Vote');
    }
    public function myVote(){
        try{
            $vote = \App\Vote::where("user_id", "=", auth()->user()->id)->where("link_id", "=", $this->id)->firstOrFail();
        }
        catch (ModelNotFoundException $ex){
            $vote = null;
        }
        return $vote;
    }
    
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    
    public function humanize(){
        $project = \App\Project::find($this->attributes["project_id"]);
        $file = new Http\Controllers\FileController;
        $file->cacheGraph(\App\File::find($project->source_id));
        $file->cacheGraph(\App\File::find($project->target_id));
        $source_graph = \Illuminate\Support\Facades\Cache::get($project->source_id . "_graph");
        $target_graph = \Illuminate\Support\Facades\Cache::get($project->target_id . "_graph");
        $ontologies_graph = \Illuminate\Support\Facades\Cache::get('ontologies_graph');
        $source_label = \App\RDFTrait::label($source_graph, $this->source_entity)? : EasyRdf_Namespace::shorten($this->source_entity, true);
        $this->source_label = $source_label;
        $target_label = \App\RDFTrait::label($target_graph, $this->target_entity)? : EasyRdf_Namespace::shorten($this->target_entity, true);
        $this->target_label = $target_label;
        $link_label = \App\RDFTrait::label($ontologies_graph, $this->link_type)? : EasyRdf_Namespace::shorten($this->link_type, true);
        $this->link_label = $link_label;
        $vote = $this->myVote();
        $this->myvote = $vote != null ? $vote->vote : null;
        return $this;
    }
}
