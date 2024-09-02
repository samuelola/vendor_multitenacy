<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Events\RegistrationProcessed;
use Illuminate\Support\Facades\Auth;
use App\Notifications\UserRegistration;

class SendNewUserNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RegistrationProcessed $event): void
    {
        User::find($event->user->id)->notify(new UserRegistration($event->user)); 
    }
}
