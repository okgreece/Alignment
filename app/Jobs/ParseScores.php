<?php

namespace App\Jobs;

use App\Notification;
use App\Project;
use Cache;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseScores implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Dispatchable, Queueable;

    protected $project;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Project $project, $user)
    {
        $this->project = $project;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->parseScore($this->project, $this->user);
    }

    private function parseScore(Project $project, $user_id)
    {
        $old_score = storage_path().'/app/projects/project'.$project->id.'/'.'score.nt';
        $score_filepath = storage_path().'/app/projects/project'.$project->id.'/'.'score_project'.$project->id.'.nt';
        try {
            $command = 'rapper -i rdfxml -o ntriples '.$old_score.' > '.$score_filepath;
            $out = [];
            logger($command);
            exec($command, $out);
            logger(var_dump($out));
            Notification::create([
                'message' => 'Converted Score Graph...',
                'user_id' => $user_id,
                'project_id' => $project->id,
                'status' => 2,
            ]);
        } catch (\Exception $ex) {
            logger($ex);
        }
        try {
            $scores = new \EasyRdf_Graph;
            $scores->parseFile($score_filepath, 'ntriples');

            Notification::create([
                'message' => 'Parsed and Stored Graphs!!!',
                'user_id' => $user_id,
                'project_id' => $project->id,
                'status' => 2,
            ]);
        } catch (\Exception $ex) {
            logger($ex);
        }
        logger('converting files');
        Cache::forever('scores_graph_project'.$project->id, $scores);
    }
}
