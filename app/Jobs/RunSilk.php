<?php

namespace App\Jobs;

use App\User;
use App\Project;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Symfony\Component\Process\Exception\ProcessFailedException;


class RunSilk extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $project,$user;
    
    public function __construct(Project $project, User $user)
    {
        $this->project = $project;
        $this->user = $user->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {        
        $this->runSiLK($this->project, $this->user);        
    }
    
    public function runSiLK(Project $project, $user_id) {
        $id = $project->id;
        $filename = storage_path() . "/app/projects/project" . $id . "/project" . $id . "_config.xml";
        \App\Notification::create([
            "message" => 'Started Job...',
            "user_id" => $user_id,
            "project_id" => $project->id,
            "status" => 2,
        ]);
        $config = [
            'java',
            '-d64',
            '-Xms2G',
            '-Xmx4G',
            '-DconfigFile=' . $filename,
            '-Dreload=true',
            '-Dthreads=4',
            '-jar',
            app_path() . '/functions/silk/silk.jar'            
        ];
        
        $process = new Process($config);
        $process->run();
        \App\Notification::create([
            "message" => 'Finished SiLK similarities Calculations...',
            "user_id" => $user_id,
            "project_id" => $project->id,
            "status" => 2,
        ]);
        
//        if (\Storage::disk("projects")->exists("/project" . $project->id . "/score_project" . $project->id . ".nt")) {
//            \Storage::disk("projects")->delete("/project" . $project->id . "/score_project" . $project->id . ".nt");
//        }        
        dispatch(new \App\Jobs\ParseScores($project, $user_id));
    }
}
