<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\SilkConfig;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Project;
use App\User;

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
        $this->project = $project->id;
        $this->user = $user->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $score = new SilkConfig();
        $score->runSiLK($this->project, $this->user);
    }
}
