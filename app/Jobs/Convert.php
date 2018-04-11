<?php

namespace App\Jobs;

use Cache;
use Storage;
use App\Project;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\OntologyTypeDriver;

class Convert extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    
    use \App\RDFTrait;

    protected $project,$user, $dump;
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
            "message" => 'Converting Graphs...' . $this->dump,
            "user_id" => $this->user,
            "project_id" => $this->project->id,
            "status" => 2,
        ]);        
        $this->D3_convert($this->project, $this->dump);

        if($this->dump === "target"){
            \App\Notification::create([
                "message" => 'Project Ready!',
                "user_id" => $this->user,
                "project_id" => $this->project->id,
                "status" => 3,
            ]);
            $this->project->processed = 1;
            $this->project->save();
        }
        else{
            dispatch(new Convert($this->project, $this->user, "target"));
        }
    }
    
    public function D3_convert(Project $project, $dump, $orderBy = null) {
        $type = "SKOS";
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
        if($dump === "source"){
            $score = Cache::get("scores_graph_project" . $project->id);
        }
        else{
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
            if (sizeOf($children) == 0){
                $children = $this->find_children($graph, $driver::inverseFirstLevelPath, $parent, $orderBy, $score, $JSON, $type);
            }
            $JSON['children'] = $orderBy === null ? $children : collect($children)->sortBy($orderBy)->values()->toArray();
        }

        /*
         * create JSON file
         */
        $name = implode("_", ["project", $project->id, $dump, $file->id, $orderBy]);
        $filename = 'json_serializer/' . $name . ".json";
        Storage::disk('public')->put($filename, json_encode($JSON));
        return $filename;
    }

    function find_children(\EasyRdf_Graph $graph, $hierarchic_link, $parent_url, $orderBy = null, $score = null, $type) {
        $driver = OntologyTypeDriver::Factory($type);
        $children = $graph->allResources($parent_url, $hierarchic_link);
        $counter = 0;
        $myJSON = [];

        foreach ($children as $child) {
            $name = $this->label($graph, $child);
            $myJSON[]["name"] = "$name";
            if($score !== null){
                $suggestions = count($score->resourcesMatching("http://knowledgeweb.semanticweb.org/heterogeneity/alignment#entity1", $child));
            }
            else{
                $suggestions = 0;
            }
            
            $myJSON[$counter]['suggestions'] = $suggestions;
            $myJSON[$counter]['url'] = urlencode($child);
            $children = $this->find_children($graph, $driver::secondLevelPath, $child, $orderBy, $score, $myJSON, $type);
            if (sizeOf($children) == 0){
                $children = $this->find_children($graph, $driver::inverseSecondLevelPath, $child, $orderBy, $score, $myJSON, $type);
            }

            $myJSON[$counter]['children'] = $orderBy === null ? $children : collect($children)->sortBy($orderBy)->values()->toArray();
            $counter++;
        }
        return $myJSON;
    }
}
