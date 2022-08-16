@extends('layouts.dashboard')

@section('dashboard-content')

    @include('components.alert')
    <div class="container-fluid">
      <div class="row"> 

      @if (count($meets)> 0)
          @foreach ($meets as $meet)
          
              <div class="col-sm-12 col-md-6 mt-3">
                <div class="card" style="height: 100%;">
                  <div class="position-relative">
                    <img style="object-fit: cover; height: 380px;" width="100%" src="{{asset("assets/banner/" . $meet->banner)}}" alt="{{!is_null($meet->banner) ? null : substr($meet->meetName, 0, 2)}}" class="img-fluid image-cover" />
                    <div class="ribbon-wrapper ribbon-lg">
                      <div class="ribbon {{$meet->status  ? "bg-success" : "bg-primary"}} text-lg">
                        {{$meet->status ? "selesai" : "belum selesai"}}
                      </div>
                    </div>
                  </div>
                  <div class="card-body">

                    <div class="my-1 d-flex">
                      <div>
                        <i class="fa-solid fa-location-dot text-success"></i>
                        <span>{{$meet->isOnline ? "Online" : "Offline"}}</span>
                      </div>
                      <div class="ml-auto">
                        <h6 class="currency" style="color: red">{{$meet->price ?  $meet->price : "gratis"}}</h6>
                      </div>
                    </div>

                    <div class="my-2">
                      <i class="fa-solid fa-calendar-check text-primary"></i>
                      <span class="date text-primary">{{date("D, d M Y", strtotime($meet->startAt)) . ", " . explode(" ",$meet->startAt)[1]}}</span>
                    </div>

                    

                    <a href="{{route("dashboard.user.member.meet.show", ["meet" => $meet->id])}}" >
                      <h4>{{$meet->meetName}}</h4>
                    </a>

                    <div class="my-3">
                      <h6>{{$meet->material}}</h6>
                    </div>

                    <div class="my-3">
                      @foreach ($meet->absence as $member)
                        <img src="{{is_null($member->image) ? "https://ui-avatars.com/api/?name=" . $member->name . "&size=280": asset("assets/member/profile" . "/" . $member->image)}}" class="rounded-circle mr-2" alt="avatar" width="35" style="height: 35px; object-fit: cover;"/>
                      @endforeach
                    </div>

                    <div style="word-break: break-all">
                      <p style="color: rgb(100, 100, 100)">{{strlen($meet->description) > 30 ? substr($meet->description, 0, 200) . "..." : $meet->description}}</p>
                    </div>

                  </div>
                </div>   
              </div>
              @endforeach
            </div>
      @else
        <div class="d-flex flex-column align-items-center justify-content-center" style="height: 80vh; width: 100%;">
          <img src="{{asset("assets/img/empty-meeting.svg")}}" alt="data-not-found" class="img-fluid" width="480"/>
          <div class="py-5">
            <h5 class="text-capitalize">Tidak Ada Pertemuan</h5>
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