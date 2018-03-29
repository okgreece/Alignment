<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class File extends Model implements StaplerableInterface {
    use EloquentTrait;

    protected $appends = ["tooltip"];
    protected $fillable = ['resource', 'filetype', 'public','user_id'];

    public function __construct(array $attributes = array()) {
        $this->hasAttachedFile('resource', [            
        ]);

        parent::__construct($attributes);
    }
    
    public function user(){
        return $this->belongsTo("App\User");
    }
    
    public function projects()
    {
        return $this->belongsToMany('App\Project', 'file_project','file_id','project_id');
    }
    
    public function getTooltipAttribute(){
        $ids = $this->projects->pluck("id")->toArray();
        return count($ids) > 0 ? "File in use in project(s) " . implode(", ", $ids) . ". Please, remove them first!" : "";
    }
}