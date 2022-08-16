<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #101248;">
  <div class="container">
    <div class="d-flex align-items-center">
      <img class="mr-3" src="{{asset("apple-touch-icon.png")}}" alt="HIMSI KLA" width="30" style="height: 30px; object-fit: contain;">
      <a class="navbar-brand" href="{{url("/")}}">HIMSI KLA</a>
    </div>
    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item {{Request::path() == "/" ?  "active" : ""}}">
          <a class="nav-link bg-transparent" href="{{url("/")}}">Beranda <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item {{Request::path() == "about" ?  "active" : ""}}">
          <a class="nav-link bg-transparent" href="{{route("about")}}">Tentang <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item {{Request::path() == "gallery" ?  "active" : ""}}">
          <a class="nav-link bg-transparent" href="{{route("gallery")}}">Galeri <span class="sr-only">(current)</span></a>
        </li>
        
        @if (!auth()->user())
          <li class="nav-item">
              <a style="background-color: #ccdac8;" class="nav-link btn btn-sm text-md text-dark text-bold" href="{{route("auth.login")}}">Login <span class="sr-only">(current)</span></a>
          </li>
          @else 
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
          
        @endif
      </ul>

    </div>
  </div>
</nav>