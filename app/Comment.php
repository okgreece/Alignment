<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [ 'user_id' , 'link_id', 'body'];
    
    
    public function user(){
        return $this->belongsTo("App\User");
    }
    public function link(){
        return $this->hasOne("App\Link", 'id', 'link_id');
    }
    
    
}


