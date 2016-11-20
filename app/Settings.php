<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'name',
        'prefix1_id',
        'namespace1_id',
        'prefix2_id',
        'namespace2_id',
        'aggregate',
        'filter_limit',
        'thre1',
        'path1a',
        'path1b',
        'trans1a',
        'trans1b',
        'trans1c',
        'trans1d',
        'thre2',
        'path2a',
        'path2b',
        'trans2a',
        'trans2b',
        'trans2c',
        'trans2d',
        'thre3',
        'path3a',
        'path3b',
        'trans3a',
        'trans3b',
        'trans3c',
        'trans3d',
        'thre4',
        'path4a',
        'path4b',
        'trans4a',
        'trans4b',
        'trans4c',
        'trans4d',
        'thre5',
        'path5a',
        'path5b',
        'trans5a',
        'trans5b',
        'trans5c',
        'trans5d',
        'thre6',
        'path6a',
        'path6b',
        'trans6a',
        'trans6b',
        'trans6c',
        'trans6d',
        'checkMinC1',
        'minC1',
        'checkMaxC1',
        'maxC1',
        'checkMinC2',
        'minC2',
        'checkMaxC2',
        'maxC2',
    ];
    
    public function projects(){
        return $this->belongsToMany(App\Project, 'projects', 'settings_id');
    }
}
