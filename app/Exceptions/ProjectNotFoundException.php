<?php

namespace App\Exceptions;

use Exception;

class ProjectNotFoundException extends Exception
{
    public function report(): void
    {
        // ...
    }

    public function render(Request $request): Response
    {
        return view("notfound");
    }
}
