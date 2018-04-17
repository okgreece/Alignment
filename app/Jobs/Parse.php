<?php

namespace App\Jobs;

use App\File;
use App\User;
use App\Jobs\Rapper;
use App\Jobs\Skosify;
use App\Jobs\CacheGraph;
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
        //$this->parse($this->file);
        $this->file->parsed = false;
        $this->file->save();
        Rapper::withChain([
            new Skosify($this->file, $this->user),
            new CacheGraph($this->file, $this->user)
        ])->dispatch($this->file, $this->user);
    }
    
    public function parse(File $file)
    {        
        /*
         * Read the graph
         */
        try{            
            $this->rapper($file);
            $this->skosify($file);
            $file->cacheGraph();            
        } catch (\Exception $ex) {
            $file->parsed = false;
            $file->save();
            error_log($ex);
        }        
    }
    
    public function skosify(File $file){
        $config = [
            "skosify",
            "-f",
            "turtle",
            "-F",
            "nt",
            $file->filenameRapper(),
            "-o",
            $file->filenameSkosify()
        ];        
        $process = new Process($config);
        $process->setTimeout(3600);
        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                echo 'ERR > '.$buffer;
            } else {
                echo 'OUT > '.$buffer;
            }
        });
    }
    
    public function rapper(File $file){
        $command = 'rapper -i ' . $file->filetype. ' -o turtle ' . $file->resource->path() . ' > ' . $file->filenameRapper();
        $process = new Process($command);        
        $process->setTimeout(3600);
        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                echo 'ERR > '.$buffer;
            } else {
                echo 'OUT > '.$buffer;
            }
        });
        return;
    }
}
