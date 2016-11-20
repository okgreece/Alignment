<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Project;

class RunSilk extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $project,$id;
    
    public function __construct(Project $project)
    {
        
        $this->id = $project->id;
       
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $score = new \App\Http\Controllers\SettingsController();
        $score->runSiLK($this->id);
        //
    }
}
