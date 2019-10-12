<?php

namespace App\Listeners;

use App\Modification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\NovaButtonEventsButtonClick;
use Illuminate\Contracts\Queue\ShouldQueue;

class ButtonClicked
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
     * @param  NovaButtonEventsButtonClick  $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->key == 'approve-modification') {
            Auth::user()->approve($event->resource);
        }
        if ($event->key == 'disapprove-modification') {
            Auth::user()->disapprove($event->resource);
        }
    }
}
