<?php

namespace App\Jobs;

use App\Models\OntologyTypeDriver;
use App\Project;
use Cache;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Storage;

class Convert implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Queueable, Dispatchable;
    use \App\RDFTrait;

    protected $project;
    protected $user;
    protected $dump;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Project $project, $user, $dump)
    {
        $this->project = $project;
        $this->user = $user;
        $this->dump = $dump;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \App\Notification::create([
            'message' => 'Converting Graphs...'.$this->dump,
            'user_id' => $this->user,
            'project_id' => $this->project->id,
            'status' => 2,
        ]);
        $this->D3_convert($this->project, $this->dump);
    }

    public function D3_convert(Project $project, $dump, $orderBy = null)
    {
        $type = 'SKOS';
        $file = $project->$dump;
        /*
         * Get the parent node
         */
        $driver = OntologyTypeDriver::Factory($type);
        /*
         * Read the graph
         */
        $graph = $file->cacheGraph();

        $parents = $graph->allOfType($driver::root);
        /*
         * Iterate through all parents
         */
        if ($dump === 'source') {
            $score = Cache::get('scores_graph_project'.$project->id);
        } else {
            $score = null;
        }
        foreach ($parents as $parent) {
            /*
             * Create Root Entry
             */
            $name = $this->label($graph, $parent);
            $JSON['name'] = "$name";
            $JSON['url'] = urlencode($parent);
            $children = $this->find_children($graph, $driver::firstLevelPath, $parent, $orderBy, $score, $JSON, $type);
            if (count($children) == 0) {
                $children = $this->find_children($graph, $driver::inverseFirstLevelPath, $parent, $orderBy, $score, $JSON, $type);
            }
            $JSON['children'] = $orderBy === null ? $children : collect($children)->sortBy($orderBy)->values()->toArray();
        }

        /*
         * create JSON file
         */
        $name = implode('_', ['project', $project->id, $dump, $file->id, $orderBy]);
        $filename = 'json_serializer/'.$name.'.json';
        Storage::disk('public')->put($filename, json_encode($JSON));
    }

    public function find_children(\EasyRdf_Graph $graph, $hierarchic_link, $parent_url, $orderBy, $score, $type)
    {
        $driver = OntologyTypeDriver::Factory($type);
        $children = $graph->allResources($parent_url, $hierarchic_link);
        $counter = 0;
        $myJSON = [];

        foreach ($children as $child) {
            $name = $this->label($graph, $child);
            $myJSON[]['name'] = "$name";
            if ($score !== null) {
                $suggestions = count($score->resourcesMatching('http://knowledgeweb.semanticweb.org/heterogeneity/alignment#entity1', $child));
            } else {
                $suggestions = 0;
            }
            $myJSON[$counter]['suggestions'] = $suggestions;
            $myJSON[$counter]['url'] = urlencode($child);
            $children = $this->find_children($graph, $driver::secondLevelPath, $child, $orderBy, $score, $myJSON, $type);
            if (count($children) == 0) {
                $children = $this->find_children($graph, $driver::inverseSecondLevelPath, $child, $orderBy, $score, $myJSON, $type);
            }
            $myJSON[$counter]['children'] = $orderBy === null ? $children : collect($children)->sortBy($orderBy)->values()->toArray();
            $counter++;
        }

        return $myJSON;
    }
}
