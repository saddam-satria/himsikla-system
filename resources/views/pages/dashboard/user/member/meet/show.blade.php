@extends('layouts.dashboard')

@section('dashboard-content')

    @include('components.alert')
    <div class="container-fluid mb-5">
        <div class="container"> 
            <img class="img-fluid rounded-lg shadow-lg image-cover" width="100%"  style="object-fit: cover; height: 568px;" src="{{is_null($meet->banner) ? "https://ui-avatars.com/api/?name=" . $meet->meetName . "&size=280" : asset("assets/banner/" . $meet->banner)}}" alt="{{$meet->meetName}}"  />
            
            <div class="my-5">
                <h4 class="text-uppercase mb-5">{{$meet->meetName}}</h4>
                <div class="d-flex flex-column my-2">

                    @if (!is_null($meet->note))
                    <div class="py-2">
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#notulensi">
                           notulensi
                        </button>
                        <div class="modal fade" id="notulensi" tabindex="-1" role="dialog" aria-labelledby="notulensiTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="notulensiTitle">Notulensi Acara</h5>
                                </div>
                                <div class="modal-body">
                                   <p>
                                   {{$meet->note->note}}
                                    </p> 
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="mb-2">
                        <i class="fas fa-users mr-2"></i>
                        <span>{{$meet->absence_count}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="text-capitalize">tentang acara</h6>
                            </div>
                            <div class="card-body">
                                <p class="text-justify">{{$meet->description}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="d-flex flex-column">
                            <div class="d-flex flex-column mb-3">
                                <span class="text-md text-bold text-capitalize">Tanggal Acara</span>
                                <span>{{date_format(date_create($meet->startAt) , "d-m-Y H:s")}} sd {{date_format(date_create($meet->endAt) , "d-m-Y H:s")}}</span>
                            </div>
                            <div class="d-flex flex-column mb-3">
                                <span class="text-md text-bold text-capitalize">Lokasi Acara</span>
                                <span>{{$meet->isOnline ? "Online" : "Offline"}} {{is_null($meet->detailLocation) ? "" : "-" . $meet->detailLocation}}</span>
                                <a href="{{$meet->location}}" class="text-decoration-none">Cek Lokasi</a>
                            </div>
                            <div class="d-flex flex-column mb-3">
                                <span class="text-md text-bold text-capitalize">HTM Acara</span>
                                <span>Rp. {{number_format($meet->price)}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

       
        </div>
    </div>

    {{-- <div class="container-fluid mb-5">
        <div class="container"> 
            <img class="img-fluid rounded-lg shadow-lg image-cover" width="100%"  style="object-fit: cover; height: 568px;" src="{{asset("assets/banner/" . $meet->banner)}}" alt="{{!is_null($meet->banner) ? null : substr($meet->meetName, 0, 2)}}"   />

            <div class="my-5">
                
                <div class="py-2 d-flex justify-content-between text-success">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-location-dot mr-2"></i>
                        <a target="__blank" href="{{$meet->location}}" class="text-decoration-none  text-success">{{$meet->isOnline ? "online" : "offline"}}</a>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-hourglass-start mr-2"></i>  
                        <span>{{explode(" ", $meet->startAt)[1]}}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-hourglass-end mr-2"></i>           
                        <span>{{explode(" ", $meet->endAt)[1]}}</span>
                    </div>
                </div>
                
                <div class="text-danger d-flex align-items-center">
                    <i class="fas fa-coins mr-2"></i>
                    <span class="currency">{{$meet->price == 0 || is_null($meet->price) ? "Gratis" : $meet->price}}</span>
                </div>

                <div class="badge badge-lg p-2 my-2 badge-primary">
                    <i class="fas fa-users"></i>
                    <span>{{$meet->absence_count}}</span>
                </div>

              

                <div class="my-3">
                    <h4 class="text-medium text-capitalize" style="font-size: 1.1em; color: black">{{$meet->meetName}}</h4>
                </div>

                <div class="row my-2">
                    <div class="col-sm-12 col-md-6">
                        <div>
                            <i class="fa-solid fa-calendar-check text-primary mr-2"></i>
                            <span class="date text-primary">{{date_format(date_create($meet->startAt), "D, d-M-Y")}}</span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div>
                            <i class="fa-solid fa-calendar-check text-primary mr-2"></i>
                            <span class="date text-primary">{{date_format(date_create($meet->endAt), "D, d-M-Y")}}</span>
                        </div>
                    </div>
                </div>

                <div class="my-5">
                    <div class="p-3 my-2 rounded-lg shadow text-white text-uppercase" style="background-color: rgb(0,123,255)">
                        <h6>Deskripsi Acara</h6>
                    </div>
                    <p class="text-justify">{{$meet->description}}</p>
                </div>

                @if (!is_null($meet->note))
                    <div class="my-5">
                        <div class="p-3 my-2 rounded-lg shadow text-white text-uppercase" style="background-color: rgb(0,123,255)">
                            <h6>Notulensi Acara</h6>
                        </div>
                        <p class="text-justify">{{$meet->note->note}}</p>
                    </div>
                @endif
               
            </div>
        </div>
    </div> --}}
@endsection
