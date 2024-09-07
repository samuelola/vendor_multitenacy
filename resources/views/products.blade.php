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
              @if(Auth::user()->is_admin)
              <a href="{{route('createproduct')}}" class="btn btn-xs btn-outline-success">Add new Product</a>

              @endif
                    <table class="table table-striped">
            <thead>
                <tr>
                
                <th scope="col">Product Name</th>
                <th scope="col">Price (usd)</th>
                <th scope="col">Price (eur)</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

              @forelse($allproducts as $allproduct)
                <tr>
                
                <td>{{$allproduct->name}}</td>
                <td>
                    {{number_format($allproduct->price,2)}}
                </td>
                <td>
                    {{$allproduct->price_eur}}
                </td>

                <td>
                    <a class="btn btn-info btn-sm" href="{{route('product.edit',$allproduct->id)}}">Edit</a> 
                </td>

                <td>
                   <form method="post" action="{{route('product.delete',$allproduct->id)}}">
                    @csrf
                    @method('DELETE')
                        <button type="submit"  class="btn btn-danger btn-sm">Delete</button> 
                   </form>
                    
                </td>
                
                </tr>
               @empty 
                 <tr>
                    <td>
                          <p>No Products Available</p>
                    </td>
                    
                 </tr>
                  

               @endforelse
                
            </tbody>
        </table>
       
                
                        <!--endtask-->
                    </div>
                  </div>
            </div>
        </div>
    </div>
      <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
</body>
</html>