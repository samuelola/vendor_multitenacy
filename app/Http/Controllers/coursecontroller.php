<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Course;
use App\Models\User;
use App\Models\Ticket;
use App\Module\Message;
use App\Module\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Input;

class CourseController extends Controller
{
    
   public function enrolled()
    {
        $enrollments = Enrollment::where('user_id', Auth::id())->get();
        $recommendedCourses = Course::all();
        return view('landlord.frontend.user.dashboard.new_dashboardd.course.enrolled', compact('enrollments','recommendedCourses'));
    }
    
    public function showcourse($id)
    {
        $showCourses = Course::where('id'.$id)->orderBy('id','desc')->get();
        return view('landlord.frontend.user.dashboard.new_dashboardd.course.show_course',compact('showCourses'));
    }
    
    public function allcourses(Request $request)
    {
        $builder = Course::query();
        if ($request->has('search')) {
            $queryString = $request->get('search');
            $builder->where('title', 'LIKE', "%$queryString%");
        }
        if ($request->has('category')) {
            $queryString = $request->get('category');
            $builder->where('category', 'LIKE', "%$queryString%");
        }
        if ($request->has('skill_level')) {
            $queryString = $request->get('skill_level');
            $builder->where('skill_level', 'LIKE', "%$queryString%");
        }
        
        $courses = $builder->orderBy('title')->SimplePaginate(5);
        return view('landlord.frontend.user.dashboard.new_dashboardd.course.allcourses', compact('courses'));
    }
    
    public function enrol_course_form(Request $request)
    {
      return view ('landlord.frontend.user.dashboard.new_dashboardd.course.enrol_course'); 
    }
    
    public function enrol_course(Request $request)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'skill_level' => 'required',
            'category' => 'required',
            'content'  => 'required|mimes:pdf,mpeg,oog,mp4,wepeg,3gp,mov,flv,avi,wmv,ts|max:100040'
        ];

        $validator = Validator::make($request->all(),$rules);
        // $request->validate($rules, $messages);
        if ($validator->fails()) 
        { 
           return Redirect::back()->with('error','check your inputs');
        }
        
        if($request->hasFile('content')){
            $file= $request->file('content');
            $filename = time().$file->getClientOriginalName();
            $path = public_path().'/course_videos';
            $file->move($path, $filename);
        }
        
        $course = new Course();
        $course->title = $request->title;
        $course->description = $request->description;
        $course->skill_level = $request->skill_level;
        $course->category = $request->category;
        $course->price = $request->price;
        $course->content_path = 'course_videos/'.$path;
        $course->user_id = auth()->user()->id;
        
        //add to enrollment
        $enrollment = new Enrollment();
        $enrollment->user_id = auth()->user()->id;
        $enrollment->course_id = $course->id;
        $enrollment->progress = 1;
        
        return redirect()->back()->with('success','Course Enrollment Successful');
        
    }
    
    public function learning()
    {
         $learning = Course::all();
         return view ('landlord.frontend.user.dashboard.new_dashboardd.course.learning',compact('learning')); 
    }
    
    

}







