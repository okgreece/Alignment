<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class Settings extends Model implements StaplerableInterface

{
    use EloquentTrait;
    protected $fillable = [
        'name', 'user_id', 'public', 'valid', 'resource', 'suggestion_provider_id'
    ];
    
    public function __construct(array $attributes = array()) {
        $this->hasAttachedFile('resource', [
            
        ]);

        parent::__construct($attributes);
    }
    
    public function projects(){
        return $this->belongsToMany("App\Project", 'projects', 'settings_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function provider(){
        return $this->belongsTo("\App\Models\SuggestionProvider", "suggestion_provider_id" );
    }

    public function user(){
        return $this->belongsTo("App\User");
    }
}
