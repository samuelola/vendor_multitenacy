<?php

namespace App\Exceptions;

use Exception;

class TaskNotFoundException extends Exception
{
    public function report(): void
    {
        // ...
    }

    public function render(Request $request): Response
    {
        return view("tasknotfound");
    }
}
