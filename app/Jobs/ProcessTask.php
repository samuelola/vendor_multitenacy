<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\TaskMail;
use Mail;

class ProcessTask implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $task_name;
    public $project_name;
    public $email;
    public function __construct($task)
    {
        $this->task_name = $task->name;
        $this->project_name = $task->project->name;
        $this->email = $task->project->user->email;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mailData = [
            'title' => $this->task_name,
            'body' => $this->project_name .' was created based on the task: '. $this->task_name,
        ];
        Mail::to($this->email)->send(new TaskMail($mailData));
    }
}
