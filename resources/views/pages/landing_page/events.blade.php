
@extends('layouts.landing_page')

@section('landing_page-content')

   <div style="margin: 3rem 0px 10rem 0px">
    <div class="container">

    
        @if (count($eventsToday) > 0 && is_null(Request::get("query")))
            <div class="mb-5">
                <div class="py-3">
                    <span class="text-lg text-bold text-uppercase">Acara Hari Ini</span>
                </div>
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="3000">
                    <div class="carousel-inner">
                    @foreach ($eventsToday as $key => $slideShow)
                       <a href="{{route("event", $slideShow->id)}}">
                        <div class="carousel-item {{$key == 0 ? "active" : ""}}" style="height: 60vh">
                            <div style=" overflow: hidden;
                            background-size: cover;
                            background-position: center;
                            height: 100%;
                            background-image: url('{{is_null($slideShow->banner) ? "https://ui-avatars.com/api/?name=" . $slideShow->eventName . "&size=280": asset("assets/banner" . "/" . $slideShow->banner)}}');">
                            </div>
                        </div>
                       </a>
                    @endforeach
                    </div>
                </div>
            </div>
        @endif
    
    
        @if (count($events) > 0)
          <div class="row">
            <div class="col-12 col-md-3">
                <div class="form-inline py-3">
                    <form action="{{route("events")}}" method="GET">
                        <div class="input-group">
                            <input name="query" class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div> 
            </div>
            <div class="col-12 col-md-9">
                
                <div class="row">
                    @foreach ($events as $event)
                        <div class="col-12 col-md-6 col-lg-4 mb-3">
                            <div class="card" style="height: 100%;">
                                <div>
                                    <img style="object-fit: cover; height: 220px;" width="100%" src="{{is_null($event->banner) ? "https://ui-avatars.com/api/?name=" . $event->eventName . "&size=280": asset("assets/banner" . "/" . $event->banner)}}" class="img-fluid image-cover rounded" />
                                </div>
                                <div class="card-body">
                                    
                                    <div style="color: rgba(94, 94, 94, 0.856)">
                                        <span class="text-md">{{date_format(date_create($event->startAt), "d-m-Y")}}</span> ||  <span class="text-md"> {{date_format(date_create($event->startAt), "H:i A")}}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="text-lg text-bold text-capitalize">
                                            {{$event->eventName}}
                                        </span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="text-capitalize" style="font-weight: 500; color: #4449ae;">{{$event->isOnline ? "Online" : "Offline"}}</span>
                                        <span class="text-danger">Rp. {{number_format($event->price)}}</span>
                                        <span class="py-2"><a target="__blank"  class="text-lowercase text-sm" href="{{$event->location}}" class="text-decoration-none">tampilkan lokasi</a></span>
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{route("event", $event->id)}}" class="btn btn-sm btn-success">lihat detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
          </div>
        @else
            <div class="d-flex flex-column py-5 justify-content-center align-items-center">
                <img src="{{asset("assets/img/biro-blue-camera-with-flash-on-orange-strap-1.png")}}" style="height: 100%; object-fit: contain;" width="330" alt="" />
                <span class="py-2 text-lg text-dark text-bold text-capitalize">{{!is_null(Request::get("query")) ? "acara tidak ditemukan" : "belum ada acara"}}</span>
                @if (Request::get("query"))
                    <a href="{{route("events")}}" class="btn btn-sm btn-success">Kembali</a>
                @endif
            </div>
            
        @endif
    
            
    
       </div>
   </div>

@endsection