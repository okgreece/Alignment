<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ValidationError extends Model
{
    protected $fillable = ['setting_id', 'bag'];

    public function setting()
    {
        return $this->belongsTo("App\Setting");
    }
}
