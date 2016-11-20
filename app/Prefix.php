<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prefix extends Model
{
    //Model to include new namespaces, mostly for beautification reasons.
    protected $fillable = ['prefix', 'namespace'];
}


