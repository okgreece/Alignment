<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['user_id', 'project_id', 'message', 'status', 'read'];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo("App\User");
    }
}
