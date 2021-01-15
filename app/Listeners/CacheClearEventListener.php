<?php

namespace App\Listeners;


use App\CachedRequest;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CacheClearEventListener
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
     * @param  CommandFinished  $event
     * @return void
     */
    public function handle(CommandFinished $event)
    {
        if ( $event->command == 'cache:clear') {
            CachedRequest::truncate();
        }
    }
}
