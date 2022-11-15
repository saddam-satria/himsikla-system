 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-dark" style="background-color: #101248;">
  
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>


    <ul class="navbar-nav ml-auto ">

      {{-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"
            >15 Notifications</span
          >
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer"
            >See All Notifications</a
          >
        </div>
      </li> --}}

   
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">

          @if (!is_null(auth()->user()->member))
            <img src="{{is_null(auth()->user()->member->image) ? asset("assets/img/default-150x150.png") : asset("assets/member/profile" . '/' . auth()->user()->member->image)}}" class="user-image img-circle elevation-2" alt="User Image">
          @else 
            <img src="{{asset("assets/img/default-150x150.png")}}" class="user-image img-circle elevation-2" alt="User Image">
          @endif

          <span class="d-none d-md-inline">
            {{auth()->user()->email}}
          </span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        
          @if (!is_null(auth()->user()->member))
          <li class="user-header" style="background-color: #101248; color: white;">

              <img src="{{is_null(auth()->user()->member->image) ? asset("assets/img/default-150x150.png") : asset("assets/member/profile" . '/' . auth()->user()->member->image)}}" class="img-circle elevation-2" alt="User Image">
              <p>
                {{auth()->user()->email}}
              </p>
            </li>
          @endif
         
          <li class="user-footer">
            <div class="d-flex">
              <a href="{{route("dashboard.user.profile")}}" class="btn btn-default btn-flat">Profile</a>
              <div class="ml-auto">
                <form action="{{route("auth.logout")}}" method="POST">
                  @csrf
                  @method("POST")
                  <button type="submit" class="btn btn-default btn-flat float-right">Logout</button>
                </form>
              </div>
            </div>
          </li>
        </ul>
      </li>
     
      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> --}}
    </ul>
  </nav>
