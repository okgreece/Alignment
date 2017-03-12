<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = ['source_id', 'target_id','project_id', 'user_id', 'links'];
    
    public function project(){
        return $this->belongsTo("App\Project");
    }
    
    public function source(){
        return $this->hasOne("App\File", 'id', 'id_source');
    }
    
    public function target(){
        return $this->hasOne("App\File", 'id', 'id_target');
    }
    
}
