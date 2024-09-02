<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use App\Events\ProjectProccessed;
use App\Models\User;
use App\Notifications\ProjectCreation;


class SendNewProjectNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    //public $delay = 60;

    /**
     * Handle the event.
     */
    public function handle(ProjectProccessed $event): void
    {
        User::find($event->project->user_id)->notify(new ProjectCreation($event->project));
    }
}
