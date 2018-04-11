<?php

namespace App\Jobs;

use App\File;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Parse implements ShouldQueue
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

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->parse($this->file);
    }
    
    public function parse(File $file)
    {        
        /*
         * Read the graph
         */
        try{
          if($file->filetype != 'ntriples'){
              $this->reserialize($file);
          }
          $file->cacheGraph();
        } catch (\Exception $ex) {
            $file->parsed = false;
            $file->save();
            error_log($ex);          
        }       
    }
    
    public function reserialize(File $file){
        $command = [
            'rapper',
            '-i ',
            $file->filetype,
            '-o',
            'ntriples',
            $file->resource->path(),
            '>',
            $file->resource->path(). '.nt'
        ];

        $process = new Process($command);
        $process->run();
        return;
    }
}
