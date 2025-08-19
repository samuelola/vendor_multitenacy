<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Task;
use App\Http\Requests\TaskRequest;
use App\Services\TaskService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\TaskNotFoundException;
use App\Jobs\ProcessTask;
use Illuminate\Support\Facades\Gate;
use App\Repositories\TaskRepository;
// use Illuminate\Auth\Access\Response;
use App\Mail\TaskMail;
use Mail;

class TaskController extends Controller
{
   public function addTask(Task $task){
        if(Gate::denies('create',$task)){
            return abort(403,'forbidden for this action');
           //return  Response::deny('You do not have permission for this');
        };
        $allprojects = Project::orderByDesc("id")->get();
          return view('addtask',compact('allprojects'));
        
        
   }

   public function storeTask(TaskRequest $request,TaskRepository $taskRepository){
        $data = $request->validated();
        //$task = Task::create($data); 
        /**
         * observing dependency Invertion principle
         */
        $task = $taskRepository->createTask($data); 
        // ProcessTask::dispatch($task); 
        $mailData = [
            'title' => $task->name,
            'body' => $task->project->name .' was created based on the task: '. $task->name,
        ];    
        Mail::to($task->project->user->email)->send(new TaskMail($mailData)); 
        return redirect()->route('dashboard');
   }

   public function edit_task($id,TaskService $taskService){
        
        try{
          //$get_task = (new TaskService())->findByTaskId($id);
          $get_task = $taskService->findByTaskId($id);
        }

           //laravel default exception
     //    catch(ModelNotFoundException $exception){
     //      return view('tasknotfound', ['error' => $exception->getMessage()]);
     //    }

        catch(TaskNotFoundException $exception){
          return view('tasknotfound', ['error' => $exception->getMessage()]);
        }

        
        
        return view('edit_task',compact('get_task'));
   }

   public function delete_task($id,Task $task){
          if(Gate::denies('delete',$task)){
            return abort(403,'forbidden for this action');
          };
          $get_task = Task::where('id',$id)->first(); 
          $get_task->delete();
          return redirect()->route('dashboard');
   }

   public function ddd(){
      
       #this show an important optimazation feature

//        Sending Bulk Emails (without killing memory)
//        If you try to load all users at once, you’ll run out of memory. Instead, use chunkById():
//        use App\Models\User;
//        use Illuminate\Support\Facades\Mail;

      // User::where('newsletter', true)
      //     ->chunkById(200, function ($users) {
      //         foreach ($users as $user) {
      //             Mail::to($user->email)->queue(new \App\Mail\NewsletterMail($user));
      //         }
      //     });

      // This way, only 200 users are loaded at a time, and queued emails won’t exhaust memory.

//       Cleaning Up Old Posts

// Let’s say you want to delete old archived posts:

// use App\Models\Post;

// Post::where('status', 'archived')
//     ->where('created_at', '<', now()->subYear())
//     ->chunkById(100, function ($posts) {
//         foreach ($posts as $post) {
//             $post->delete();
//         }
//     });


// ✅ Safe and efficient — processes in batches of 100.

// 3. Updating Slugs for SEO

// Imagine you added slugs later, and you want to update them for all posts:

// use Illuminate\Support\Str;
// use App\Models\Post;

// Post::whereNull('slug')
//     ->chunkById(100, function ($posts) {
//         foreach ($posts as $post) {
//             $post->slug = Str::slug($post->title);
//             $post->save();
//         }
//     });

// 4. Exporting Data to CSV

// Sometimes you want to export a huge dataset without loading it all into memory:

// use App\Models\Order;

// $handle = fopen(storage_path('orders_export.csv'), 'w');
// fputcsv($handle, ['ID', 'Customer', 'Total', 'Created At']);

// Order::chunkById(500, function ($orders) use ($handle) {
//     foreach ($orders as $order) {
//         fputcsv($handle, [
//             $order->id,
//             $order->customer_name,
//             $order->total,
//             $order->created_at
//         ]);
//     }
// });

// fclose($handle);


// 👉 Exports all orders in 500-row chunks, memory safe!

// 5. Data Migration / Reprocessing

// For example, if you changed how you store post content and need to reformat it:

// Post::chunkById(100, function ($posts) {
//     foreach ($posts as $post) {
//         $post->content = strip_tags($post->content); // Clean HTML
//         $post->save();
//     }
// });


// 🔥 Rule of thumb:

// Use chunkById() anytime you’re dealing with thousands or millions of records.

// It keeps memory low and prevents skipping/duplicating rows compared to chunk().

// 👉 Do you want me to also show you the difference between chunk() and chunkById() (and when to use each)?
    
   }
}
