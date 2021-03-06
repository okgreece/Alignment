<?php

namespace App\Jobs;

use App\Project;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;

class RunSilk implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Dispatchable, Queueable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $project;
    protected $user;
    protected $configFileName;

    public function __construct(Project $project, User $user)
    {
        $this->project = $project;
        $this->user = $user->id;
        $this->configFileName = storage_path().'/app/projects/project'.$project->id.'/project'.$project->id.'_config.xml';
        $this->checkExistingFile($project->id);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->runSiLK($this->project);
    }

    private function getConfig($filename)
    {
        $config = array_merge(
                ['java'],
                config('alignment.silk.config', []),
                [
                    '-DconfigFile='.$filename,
                    '-jar',
                    config('alignment.silk.jar'),
                ]);

        return $config;
    }

    public function runSiLK(Project $project)
    {
        \App\Notification::create([
            'message' => 'Started Job...',
            'user_id' => $this->user,
            'project_id' => $project->id,
            'status' => 2,
        ]);
        $config = $this->getConfig($this->configFileName);
        $process = new Process($config);
        $process->setTimeout(3600);
        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                echo 'ERR > '.$buffer;
            } else {
                echo 'OUT > '.$buffer;
            }
        });
        \App\Notification::create([
            'message' => 'Finished SiLK similarities Calculations...',
            'user_id' => $this->user,
            'project_id' => $project->id,
            'status' => 2,
        ]);
    }

    private function checkExistingFile($id)
    {
        if (\Storage::disk('projects')->exists('/project'.$id.'/score_project'.$id.'.nt')) {
            \Storage::disk('projects')->delete('/project'.$id.'/score_project'.$id.'.nt');
        }
    }
}
