<?php

namespace App\Jobs;


use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Project;

class Convert extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $project,$user;
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
        \App\Notification::create([
            "message" => 'Converting Graphs...',
            "user_id" => $this->user,
            "project_id" => $this->project->id,
            "status" => 2,
        ]);
        $controller = new \App\Http\Controllers\CreatelinksController();
        $controller->D3_convert($this->project, 'source');
        $controller->D3_convert($this->project, 'target');
        
        \App\Notification::create([
            "message" => 'Project Ready!',
            "user_id" => $this->user,
            "project_id" => $this->project->id,
            "status" => 3,
        ]);
        
        $this->project->processed = 1;
        $this->project->save();
    }
}
