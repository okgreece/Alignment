<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;
use Cache;

class File extends Model implements StaplerableInterface {

    use EloquentTrait;

    protected $appends = ["tooltip"];
    protected $fillable = ['resource', 'filetype', 'public', 'user_id'];

    public function __construct(array $attributes = array()) {
        $this->hasAttachedFile('resource', [
        ]);

        parent::__construct($attributes);
    }

    public function user() {
        return $this->belongsTo("App\User");
    }

    public function projects() {
        return $this->belongsToMany('App\Project', 'file_project', 'file_id', 'project_id');
    }

    public function getTooltipAttribute() {
        $ids = $this->projects->pluck("id")->toArray();
        if ($this->user_id != auth()->user()->id) {
            return "You are not autorized to delete this file. Only the owner of the file can delete it.";
        }
        return count($ids) > 0 ? "File in use in project(s) " . implode(", ", $ids) . ". Please, remove project(s) first!" : "";
    }

    public function download($format) {
        $graph = $this->cacheGraph();
        $export = $graph->serialise($format);
        return response()->downloadFromCache($export, $format, $this->resource_file_name);
    }
    
    //this function get the graph from the cache if it exists or parses the file and stores it in cache
    //in any case it returns an EasyRdf Graph object
    public function cacheGraph() {
        if (Cache::has($this->id . "_graph")) {
            $graph = Cache::get($this->id . "_graph");
        } else {
            $graph = new \EasyRdf_Graph;
            $suffix = ($this->filetype != 'ntriples' ) ? '.nt' : '';
            $graph->parseFile($this->resource->path() . $suffix, 'ntriples');
            $this->parsed = true;
            $this->save();
            Cache::forever($this->id . "_graph", $graph);
        }
        return $graph;
    }

    public function getDirty() {
        $dirty = parent::getDirty();

        return array_filter($dirty, function ($var) {
            return !($var instanceof \Codesleeve\Stapler\Attachment);
        });
    }

}
