
@extends('layouts.landing_page')

@section('landing_page-content')

   <div class="container">
    @if (count($galleries) > 0)
        <div class="row">
            @foreach ($galleries as $gallery)
            <div class="col-12 col-md-6 col-lg-3 mt-3">
                <img src="{{asset("assets/gallery". "/" . $gallery->image)}}" class="img-fluid rounded" style="object-fit: cover; height: 100%;" alt="" />
            </div>  
            @endforeach
        </div>
    @else
        
    <div class="d-flex flex-column py-5 justify-content-center align-items-center">
        <img src="{{asset("assets/img/biro-blue-camera-with-flash-on-orange-strap-1.png")}}" style="height: 100%; object-fit: contain;" width="330" alt="" />
        <span class="py-2 text-lg text-dark text-bold">Belum Ada Album</span>
    </div>
    @endif
    
   </div>

@endsection