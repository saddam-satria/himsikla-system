@extends('layouts.dashboard')

@section('dashboard-content')

    @include('components.alert')
    <div class="container-fluid mb-5">
        <div class="container"> 
            <img class="img-fluid rounded-lg shadow-lg image-cover" width="100%"  style="object-fit: cover; height: 568px;" src="{{is_null($event->banner) ? "https://ui-avatars.com/api/?name=" . $event->eventName . "&size=280" : asset("assets/banner/" . $event->banner)}}" alt="{{$event->meetName}}"  />
            
            <div class="my-5">
                <h4 class="text-uppercase mb-5">{{$event->eventName}}</h4>
                <div class="d-flex flex-column my-2">

                    @if (!is_null($event->certificate))
                        <span><a target="__blank" class="text-decoration-none" href="{{$event->certificate->link}}">Link Sertifikat</a></span>
                    @endif

                    @if (!is_null($event->note))
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
                                    {{$event->note->event->note->note->note}}
                                    </p> 
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="mb-2">
                        <div class="d-flex">
                            <div>
                                <i class="fas fa-users mr-2"></i>
                                <span>{{$event->absence_count}}</span>
                            </div>
                            <div class="ml-4">
                                <i class="fas fa-heart text-danger mr-2"></i>
                                <span>{{$event->likes}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="text-capitalize">tentang acara</h6>
                            </div>
                            <div class="card-body">
                                <p class="text-justify">{{$event->description}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="d-flex flex-column">
                            <div class="d-flex flex-column mb-3">
                                <span class="text-md text-bold text-capitalize">Tanggal Acara</span>
                                <span>{{date_format(date_create($event->startAt) , "d-m-Y H:s")}} sd {{date_format(date_create($event->endAt) , "d-m-Y H:s")}}</span>
                            </div>
                            <div class="d-flex flex-column mb-3">
                                <span class="text-md text-bold text-capitalize">Lokasi Acara</span>
                                <span>{{$event->isOnline ? "Online" : "Offline"}} {{is_null($event->detailLocation) ? "" : "-" . $event->detailLocation}}</span>
                                <a href="{{$event->location}}" class="text-decoration-none">Cek Lokasi</a>
                            </div>
                            <div class="d-flex flex-column mb-3">
                                <span class="text-md text-bold text-capitalize">HTM Acara</span>
                                <span>Rp. {{number_format($event->price)}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

       
        </div>
    </div>
@endsection
