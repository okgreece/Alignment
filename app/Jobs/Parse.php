<?php

namespace App\Jobs;

use App\File;
use App\User;
use Cache;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Parse implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;

    protected $user;

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
        $this->invalidate();
        Rapper::withChain([
            new Skosify($this->file, $this->user),
            new CacheGraph($this->file, $this->user),
        ])->dispatch($this->file, $this->user);
    }

    //this function will invalidate previous
    //cached graph, in order to get a fresh parsed graph always
    public function invalidate()
    {
        $this->file->parsed = false;
        $this->file->save();
        if (Cache::has($this->file->id.'_graph')) {
            Cache::forget($this->file->id.'_graph');
        }
    }
}
