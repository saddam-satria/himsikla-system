@push('head')
    <link rel="stylesheet" href="{{asset("assets/css/styles.css")}}">
@endpush

@extends('layouts.dashboard')

@section('dashboard-content')

    @include('components.alert')
    <div class="container-fluid mb-5">
    
        @if (count($events) > 0)
          <div class="row"> 
            @foreach ($events as $event)
            <div class="col-sm-12 col-md-6 col-lg-4 mt-3">
              <a href="{{route("dashboard.user.member.event.show", ["event" => $event->id])}}" class="unlink">
                <div class="card shadow rounded card-hover" style="cursor: pointer; height : 100%">
                  <div class="position-relative">
                      <img style="object-fit: cover; height: 280px;" width="100%" src="{{asset("assets/banner/" . $event->banner)}}" alt="{{!is_null($event->banner) ? null : substr($event->eventName, 0, 2)}}" class="img-fluid image-cover" />
                    <div class="ribbon-wrapper ribbon-lg">
                      <div class="ribbon {{$event->status  ? "bg-success" : "bg-primary"}} text-lg">
                        {{$event->status ? "selesai" : "belum selesai"}}
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex mb-3 align-items-center">
                    </div>
                    <h4 class="text-medium text-capitalize" style="font-size: 1.1em; color: black">{{$event->eventName}}</h4>
                    <div>
                      <i class="fa-solid fa-calendar-check text-primary"></i>
                      <span class="date text-primary">{{date("D, d M Y", strtotime($event->startAt)) . ", " . explode(" ",$event->startAt)[1]}}</span>
                    </div>
                    <div class="py-2">
                      <i class="fa-solid fa-location-dot text-success"></i>
                      <span>{{is_null($event->detailLocation ) ? "Online" : $event->detailLocation}}</span>
                    </div>
                      <div class="my-3 d-flex">
                        <h6 class="currency" style="color: red">{{$event->price ?  $event->price : "gratis"}}</h6>
                        <div class="ml-auto">
                          <i class="fa-solid fa-location-dot text-success"></i>
                          <span>{{$event->isOnline ? "Online" : "Offline"}}</span>
                        </div>
                      </div>
                      <div style="word-break: break-all">
                        <p style="color: rgb(100, 100, 100)">{{strlen($event->description) > 30 ? substr($event->description, 0, 200) . "..." : $event->description}}</p>
                      </div>
                    </div>
                  </div>   
                </a>
              </div>
            @endforeach
          </div>
        @else
        <div class="d-flex flex-column align-items-center justify-content-center" style="height: 80vh">
          <img src="{{asset("assets/img/empty-event.svg")}}" alt="data-not-found" class="img-fluid" width="480"/>
          <div class="py-5">
            <h5 class="text-capitalize">Tidak Ada Acara</h5>
          </div>
        </div>
        @endif
    
   
    </div>
@endsection

@push('scripts')
    <script>  
    
      const currencies = document.querySelectorAll(".currency");
      for(let i = 0; i <= currencies.length; i ++){
          currencies[i].innerText = currencies[i].innerText !== "gratis" ? Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" }).format(currencies[i].innerText) : "Gratis"; 
      }
    </script>
  <script>
      const images = document.querySelectorAll(".image-cover");
      
      for (let i = 0; i < images.length; i++) {
        const eventName = images[i].alt;
        const element = images[i];

        if(eventName) {
          element.src = `https://ui-avatars.com/api/?name=${eventName}&size=280`
        }

        
      }


  
  </script>
@endpush