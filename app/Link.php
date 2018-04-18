<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Link extends Model
{
    use SoftDeletes;

    protected $fillable = ['source_id', 'target_id', 'source_entity', 'target_entity', 'user_id'];
    protected $dates = ['deleted_at'];

    public function project()
    {
        return $this->belongsTo("App\Project");
    }

    public function user()
    {
        return $this->belongsTo("App\User");
    }

    public function source()
    {
        return $this->hasOne('App\File', 'id', 'source_id');
    }

    public function target()
    {
        return $this->hasOne('App\File', 'id', 'target_id');
    }

    public function votes()
    {
        return $this->hasMany('App\Vote');
    }

    public function myVote()
    {
        try {
            $vote = \App\Vote::where('user_id', '=', auth()->user()->id)->where('link_id', '=', $this->id)->firstOrFail();
        } catch (ModelNotFoundException $ex) {
            $vote = null;
        }

        return $vote;
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function humanize()
    {
        $project = \App\Project::find($this->attributes['project_id']);
        $source_graph = $project->source->cacheGraph();
        $target_graph = $project->target->cacheGraph();
        $ontologies_graph = \Illuminate\Support\Facades\Cache::get('ontologies_graph');
        $source_label = \App\RDFTrait::label($source_graph, $this->source_entity) ?: EasyRdf_Namespace::shorten($this->source_entity, true);
        $this->source_label = $source_label;
        $target_label = \App\RDFTrait::label($target_graph, $this->target_entity) ?: EasyRdf_Namespace::shorten($this->target_entity, true);
        $this->target_label = $target_label;
        $link_label = \App\RDFTrait::label($ontologies_graph, $this->link_type) ?: EasyRdf_Namespace::shorten($this->link_type, true);
        $this->link_label = $link_label;
        $vote = $this->myVote();
        $this->myvote = $vote != null ? $vote->vote : null;

        return $this;
    }

    public static function create(Request $request, array $attributes = [])
    {
        $link = static::query()->create($attributes);
        $project = Project::find($request->project_id);
        $link->project_id = $request->project_id;
        $link->source_entity = $request->source;
        $link->target_entity = $request->target;
        $link->link_type = $request->link_type;
        $link->source_id = $project->source_id;
        $link->target_id = $project->target_id;
        $link->user_id = isset(auth()->user()->id) ? auth()->user()->id : 1;
        $link->save();

        return $link;
    }

    public static function existing(Request $request)
    {
        return $link = self::where('project_id', '=', $request->project_id)
                ->where('source_entity', '=', $request->source)
                ->where('target_entity', '=', $request->target)
                ->where('link_type', '=', $request->link_type)
                ->first();
    }

    public function getConfidence(self $link)
    {
        $upVotes = $link->up_votes;
        $downVotes = $link->down_votes;
        $totalVotes = $upVotes + $downVotes;
        if ($totalVotes > 0) {
            return (float) $upVotes / $totalVotes;
        } else {
            return 0;
        }
    }

    public static function createGraph($links)
    {
        $graph = new \EasyRdf_Graph;
        foreach ($links as $link) {
            $graph->addResource($link->source_entity, $link->link_type, $link->target_entity);
        }

        return $graph;
    }

    public static function linkGraph(User $user, $project_id = null)
    {
        $project = Project::find($project_id);
        if ($project == null) {
            $links = $user->links;
        } else {
            $links = $project->links;
        }

        return self::createGraph($links);
    }

    public static function votedLinks(Request $request)
    {
        $links = self::where('project_id', '=', $request->project_id)
                ->when(isset($request->score), function ($query) use ($request) {
                    return $query->where('score', '>', $request->score);
                })
                ->get();
        $filtered_links = $links->filter(function ($link) use ($request) {
            return $link->confidence >= $request->threshold / 100;
        });

        return $filtered_links;
    }

    public static function filename($format, $project_id = null)
    {
        $project = Project::find($project_id);
        $File_Ext = \EasyRdf_Format::getFormat($format)->getDefaultExtension(); //get file extention
        $dt = Carbon::now();
        $time = str_slug($dt->format('Y m d His'));
        $filename = [];
        if ($project_id == null) {
            $filename['filename'] = 'Export'.$time.'.'.$File_Ext;
            $filename['path'] = storage_path().'/app/projects/'.$filename['filename'];
        } else {
            $filename['filename'] = 'Alignment_Export_'.str_slug($project->name).'_'.$time.'.'.$File_Ext;
            $filename['path'] = storage_path().'/app/projects/project'.$project_id.'/'.$filename['filename'];
        }

        return $filename;
    }

    public static function downloadFile($file, $name, $format)
    { // $file = include path
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename='.$name);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: '.filesize($file));
            header('Content-Type: '.$format);
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
            exit;
        }
    }

    public static function exportFile(\EasyRdf_Graph $graph, $format, $project_id)
    {
        $export = $graph->serialise($format);
        $file = self::filename($format, $project_id);
        file_put_contents($file['path'], $export);
        self::downLoadFile($file['path'], $file['filename'], $format);
    }
}
