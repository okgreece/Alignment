<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class Import extends Model implements StaplerableInterface
{
    use EloquentTrait;
    
    protected $fillable = ['resource', 'filetype', 'project_id', 'user_id'];
    
    public function __construct(array $attributes = array()) {
        $this->hasAttachedFile('resource', [
            
        ]);

        parent::__construct($attributes);
    }
    
    public function user(){
        return $this->belongsTo("App\User");
    }
    
    public function project()
    {
        return $this->belongsTo("App\Project");
    }
    
    public function getDirty() {
        $dirty = parent::getDirty();

        return array_filter($dirty, function ($var) {
            return !($var instanceof \Codesleeve\Stapler\Attachment);
        });
    }
}
