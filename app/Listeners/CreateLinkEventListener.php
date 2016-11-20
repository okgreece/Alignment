<?php

namespace App\Listeners;

use App\Events\CreateLinkEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateLinkEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CreateLinkEvent  $event
     * @return void
     */
    public function handle(CreateLinkEvent $event)
    {
        
        return view('utility.info.successnotofication')->with('Link created!!!');
    }
}
