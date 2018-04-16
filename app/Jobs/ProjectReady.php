<?php

namespace App\Jobs;

use App\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProjectReady implements ShouldQueue {

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    protected $project, $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Project $project, $user) {
        $this->project = $project;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $this->project->processed = 1;
        $this->project->save();
        \App\Notification::create([
            "message" => 'Project Ready!',
            "user_id" => $this->user,
            "project_id" => $this->project->id,
            "status" => 3,
        ]);
    }

}
