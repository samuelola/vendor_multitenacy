<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}"/>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        @guest
        <li class="nav-item">
          <a class="nav-link" href="{{route('signinform')}}">Signin</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('signupform')}}">Signup</a>
        </li>
        @else
            <form method="post" action="{{route('logout')}}">
              @csrf
                <button type="submit" class="btn btn-outline-info">Logout</button>
            </form>

            <li class="nav-item dropdown" style="float:right">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{Auth::user()->name}}
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        @endguest
        
      </ul>
      
    </div>
  </div>
</nav>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">

                <!--start here-->

                <nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Projects</button>
    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Tasks</button>
    @if(Auth::user()->id == 1)
        <button class="nav-link" id="nav-notification-tab" data-bs-toggle="tab" data-bs-target="#nav-notification" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Notifications

        <span class="badge badge-light bg-success badge-xs">
          @php
            $notify_count = [];
            foreach($users as $user){
                foreach($user->unreadNotifications as $notification){

                    $notify_count[] = $user->notification;
                }
            }
            echo count($notify_count);
          @endphp 
          
        
          </span>
        </button>
    @endif
   
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active mt-4" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
         <!-- @can('project_create')
            <a href="{{route('addproject')}}" class="btn btn-outline-primary " style="float:left">Add New Project</a>
         @endcan -->

         <a href="{{route('addproject')}}" class="btn btn-outline-primary " style="float:left">Add New Project</a>
         
        <table class="table table-striped">
            <thead>
                <tr>
                
                <th scope="col">Project Name</th>
                <th scope="col">Action</th>
                
                </tr>
            </thead>
            <tbody>

              @forelse($allprojects as $allproject)
                <tr>
                
                <td>{{$allproject->name}}</td>
                <td>
                    <a class="btn btn-info btn-sm" href="{{route('edit_project',$allproject->id)}}">Edit</a> | <a class="btn btn-danger btn-sm" href="{{route('delete_project',$allproject->id)}}">Delete</a>
                </td>
                
                </tr>
               @empty 
                 <tr>
                    <td>
                          <p>No Project Available</p>
                    </td>
                    
                 </tr>
                  

               @endforelse
                
            </tbody>
        </table>

  </div>
  <div class="tab-pane fade mt-4" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
        <a href="{{route('addtask')}}" class="btn btn-outline-primary " style="float:left">Add New Task</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                    
                    <th scope="col">Task</th>
                    <th scope="col">Project</th>
                    <th scope="col">Action</th>
                    
                    </tr>
                </thead>
                <tbody>
                   @foreach($alltasks as $alltask)
                    <tr>
                    
                    <td>{{$alltask->name}}</td>
                    <td>{{$alltask->project->name}}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{route('edit_task',$alltask->id)}}">Edit</a> | <a class="btn btn-danger btn-sm" href="{{route('delete_task',$alltask->id)}}">Delete</a>
                    </td>
                    
                    </tr>

                  @endforeach  
                    
                    
                </tbody>
        </table>

  </div>

  <div class="tab-pane fade mt-4" id="nav-notification" role="tabpanel" aria-labelledby="nav-notification-tab" tabindex="0">
        
  <a class="btn btn-sm btn-info" href="{{route('mark-as-read')}}">Mark as Read</a> |

  <a class="btn btn-sm btn-danger" href="{{route('delete_notification')}}">Delete Notifications</a>

  
  <p><br/></p>
   
  @php
    
    @endphp
    <table class="table table-striped">
       <thead>
           <tr>
               <th>Notifications</th>
           </tr>
       </thead>
       <tbody>

          
            @php
               foreach($users as $user){
                foreach($user->unreadNotifications as $notification){
                    @endphp
                    <tr>
                      <td>
                          @php
                          echo "- ". trim(json_encode($notification->data['data']),'"');
                          @endphp
                      </td>
                    </tr>
                    @php
                }
            }
            @endphp
          
       </tbody>

    </table>
     @php
  @endphp  
        

  </div>
  
</div>

       
                
                        <!--endtask-->
                    </div>
                  </div>
            </div>
        </div>
    </div>
      <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
</body>
</html>