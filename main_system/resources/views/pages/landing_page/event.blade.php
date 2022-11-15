
@extends('layouts.landing_page')

@section('landing_page-content')

    <div style="margin: 2rem 0px 10rem 0px">
        <div class="container"> 
            <div class="d-flex">
                <div class="ml-auto">
                    <span class="text-sm text-lowercase" style="color: rgb(141, 141, 141);">dibuat {{date_format(date_create($event->createdAt), "d-m-Y H:s A")}}</span>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <span class="text-uppercase">acara himsi</span> 
                </div>
               <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-8 mb-4">
                            <img class="img-fluid shadow" data-target="#banner" data-toggle="modal" style="width: 100%;object-fit: cover; height: 100%;" src="{{is_null($event->banner) ? "https://ui-avatars.com/api/?name=" . $event->eventName . "&size=280": asset("assets/banner" . "/" . $event->banner)}}"  alt="{{$event->eventName}}">
                            <div class="modal fade" id="banner" tabindex="-1" role="dialog" aria-labelledby="bannerPreview" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <img src="{{is_null($event->banner) ? "https://ui-avatars.com/api/?name=" . $event->eventName . "&size=280": asset("assets/banner" . "/" . $event->banner)}}" alt="{{$event->eventName}}" class="img-fluid image-cover rounded" />
                                  </div>
                                </div>
                              </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="d-flex flex-column justify-content-between py-4" style="height: 100%;">
                                <div class="d-flex flex-column">
                                    <span class="text-md text-lowercase" style="color: rgb(199, 199, 199);">{{$event->isOnline ? "online" : "offline"}}</span>
                                    <span class="text-md text-bold" style="color: rgb(199, 199, 199);">{{date_format(date_create($event->startAt), "d-m-Y"). " - " . date_format(date_create($event->endAt), "d-m-Y") }}</span>
                                    <span class="text-md text-bold" style="color: rgb(199, 199, 199);">{{date_format(date_create($event->startAt), "H:s") . " - " . date_format(date_create($event->endAt), "H:i")}}</span>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-xl text-bold text-uppercase">{{$event->eventName}}</span>
                                    <div class="d-flex flex-column py-3">
                                        <p class="text-md">{{is_null($event->detailLocation) ? "-" : $event->detailLocation }}</p>
                                    </div>
                                </div>
                                <span class="text-lg">Rp. {{number_format($event->price)}}</span>
                                   
                                @if ($event->status || date("Y-m-d H:i:s") >= $event->startAt  )
                                    <span class="btn btn-md btn-danger text-uppercase">pendaftaran ditutup</span>
                                @else
                                    <a href="{{route("event.register.email", $event->id)}}" class="btn btn-md btn-success text-uppercase">register</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-12 col-lg-8 mb-4">
                            <div class="card-header rounded">
                                <span>Deskripsi Acara</span>
                            </div>
                            <div class="py-5 px-1">
                                <p class="text-md text-justify">{{$event->description}}</p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="d-flex flex-column justify-content-center " style="height: 100%;">

                                <div class="py-2 d-flex flex-column">
                                    <span class="text-md text-bold text-uppercase">panduan <i class="fas fa-question-circle ml-1 text-primary" data-toggle="modal" data-target="#tutorial" style="cursor: pointer"></i></span>
                                </div>
                              
                                <div class="py-2 d-flex flex-column">
                                    <span class="text-md text-bold text-uppercase">Contact Person</span>
                                    <span class="text-md" style="color:rgb(199, 199, 199); ">{{$contactPerson}}</span>
                                </div>

                                <div class="py-2 d-flex flex-column">
                                    <span class="text-md text-bold text-uppercase">Tautan Lokasi</span>
                                    <a href="{{$event->location}}" target="__blank" class="text-md" style="color:rgb(199, 199, 199); ">{{$event->location}}</a>
                                </div>
                              
                                <div class="py-2 d-flex flex-column">
                                    <div>
                                        <span class="text-md text-bold text-uppercase">Pembayaran</span>
                                    </div>
                                    <span class="text-md" style="color:rgb(199, 199, 199); ">{{$event->payment}}</span>

                                    <div class="modal fade" id="tutorial" tabindex="-1" role="dialog" aria-labelledby="tutorialPayment" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header card-header">
                                              <h5 class="modal-title" id="exampleModalLongTitle">Tata Cara Pendaftaran</h5>
                                              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                                <ul class="list-group">
                                                    <li class="list-group-item text-capitalize">Registrasi Acara Yang Ingin Diikuti</li>
                                                    <li class="list-group-item text-capitalize">pengisian form acara</li>
                                                    <li class="list-group-item text-capitalize">Lakukan Pembayaran</li>
                                                    <li class="list-group-item text-capitalize">Admin Akan Mengkonfirmasi</li>
                                                    <li class="list-group-item text-capitalize">Absensi Dapat Dilakukan Jika Anda Sudah Membayar</li>
                                                    <li class="list-group-item text-capitalize">Setelah Acara Selesai, Isi form feedback</li>
                                                  </ul>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
            </div>
        </div>
    </div>

@endsection