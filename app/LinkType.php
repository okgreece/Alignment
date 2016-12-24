<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkType extends Model
{
    protected $fillable = [ 'user_id', 'group', 'value', 'inner', 'public'];
    
    public function user(){
        return $this->belongsTo("App\User");
    }
}
