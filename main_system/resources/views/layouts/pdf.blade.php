<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export {{$title}}</title>
    @include('layouts.bootstrap_style')
</head>
<body>
    <div class="container">
       <div class="my-3">
           
            <center>
                <img src="{{asset("android-chrome-192x192.png")}}" alt="Logo HIMSI" class="img-fluid" width="120" />
                <h4 class="ml-3 text-uppercase" style="font-weight: 600; font-size: 20px">HIMSI Kaliabang Smart System</h4>
            </center>
          
       </div>
       <div style="padding: 1px 0px; background-color: rgb(187, 187, 187); margin: 30px 0px"></div>

       <div class="py-3">
        <h5 class="text-uppercase" style="font-size: 18px">{{$title}}</h5>
       </div>
       @yield('content')
    </div>
</body>
</html>