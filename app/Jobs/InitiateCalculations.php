<?php

namespace App\Jobs;

use App\User;
use App\Project;
use Illuminate\Bus\Queueable;
use App\Models\SuggestionProvider;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class InitiateCalculations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $project, $provider, $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Project $project, SuggestionProvider $provider, User $user)
    {
        $this->project = $project;
        $this->provider = $provider;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->project->processed = 0;
        $this->project->save();
        $this->provider->prepare($this->project);
        \App\Notification::create([
            "message" => $this->provider->name . ' Config File Created succesfully.',
            "user_id" => $this->user->id,
            "project_id" => $this->project->id,
            "status" => 1,
        ]);
    }
}
