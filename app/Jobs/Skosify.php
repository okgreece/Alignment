<?php

namespace App\Jobs;

use App\File;
use App\User;
use Illuminate\Bus\Queueable;
use Symfony\Component\Process\Process;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Skosify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $file, $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(File $file, User $user)
    {
        $this->file = $file;
        $this->user = $user;        
    }
    
    protected function config(){
        return [
            "skosify",
            "-f",
            "turtle",
            "-F",
            "nt",
            $this->file->filenameRapper(),
            "-o",
            $this->file->filenameSkosify(),
            "-c",
            storage_path("app/projects/owl2skos.cfg")
        ];
    }
       
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {                
        $process = new Process($this->config());
        $process->setTimeout(3600);
        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                echo 'ERR > '.$buffer;
            } else {
                echo 'OUT > '.$buffer;
            }
        });
    }
}
