@extends('layouts.landing_page')

@section('landing_page-content')
    <div style="margin: 5rem 0px">
        <div class="container">
            <div class="mb-5 d-flex flex-column align-items-center">
                <div style="height: 25vh">
                    <img src="{{asset("assets/img/undraw_super_thank_you_re_f8bo.svg")}}" style="height: 100%; object-fit: cover" alt="">
                </div>
                <div class="py-5">
                    <div class="text-center d-flex flex-column">
                        @if ($absenceEvent->status == "absen")
                            <span class="text-lg text-capitalize">Terima Kasih Sudah Daftar Acara {{$absenceEvent->eventName}}</span>
                            
                            @if ($absenceEvent->price > 0)
                                <span class="text-md text-capitalize {{$absenceEvent->isPaidOff ? "text-success" : "text-danger"}}">{{$absenceEvent->isPaidOff ?  "Pembayaran Anda Sudah Di Konfirmasi" : "konfirmasi pembayaran ke PJ acara ("  . $contactPerson . ")"}}</span>
                            @endif
                            
                            @if ($absenceEvent->isPaidOff && !$absenceEvent->eventStatus && !($absenceEvent->startAt >= date("Y-m-d H:i:s")))
                            <div class="py-3">
                                    <form action="{{route("event.absence") . "?id=" . $absenceEvent->id}}" method="POST">
                                    @csrf
                                    @method("POST")
                                        <button type="submit" class="btn btn-md btn-primary" style="width: 100%;">Absen Hadir</button>
                                    </form>
                                </div>
                            @endif
                        @else
                            <span class="text-md text-success p-2 text-capitalize">terima kasih sudah menghadiri acara, isi feedback <a target="__blank" href="{{$absenceEvent->feedback}}">disini</a></span>
                            @if (!is_null($certificate))
                                <a href="{{$certificate->link}}" class="btn btn-md btn-primary" target="__blank">Sertifikat Acara</a>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
            <div class=" py-2">
              
                @if (count($events) > 0)

                    <div class="d-flex">
                        <span class="text-lg text-bold text-uppercase">acara yang anda ikuti</span>
                        <div class="ml-auto">
                        <a href="{{route("events")}}" class="text-decoration-none"> <i class="fas fa-arrow-right text-sm"></i></a>
                        </div>
                    </div>

                    <div id="scrollbar" style="overflow: auto; white-space: nowrap">
                        @foreach ($events as $event)
                        <div class="d-inline-block pr-2">
                            <div class="card rounded" id="event-card">
                                <div class="position-relative">
                                    <img style="object-fit: cover; height: 220px;" width="100%" src="{{is_null($event->banner) ? "https://ui-avatars.com/api/?name=" . $event->eventName . "&size=280": asset("assets/banner" . "/" . $event->banner)}}" class="img-fluid image-cover rounded" />
                                    <div class="ribbon-wrapper ribbon-lg">
                                    <div class="ribbon {{$event->status  ? "bg-success" : "bg-primary"}} text-sm">
                                        {{$event->status ? "selesai" : "belum selesai"}}
                                    </div>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div style="color: rgba(94, 94, 94, 0.856)">
                                        <span class="text-md">{{date_format(date_create($event->startAt), "d-m-Y")}}</span> ||  <span class="text-md"> {{date_format(date_create($event->startAt), "H:i A")}}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="text-lg text-bold text-capitalize">
                                            <a class="text-dark">
                                            {{$event->eventName}}
                                            </a>
                                        </span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="text-capitalize" style="font-weight: 500; color: #4449ae;">{{$event->isOnline ? "Online" : "Offline"}}</span>
                                        <span class="text-danger">Rp. {{number_format($event->price)}}</span>
                                        <span class="py-2"><a target="__blank"  class="text-lowercase text-sm" href="{{$event->location}}" class="text-decoration-none">tampilkan lokasi</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                @endif
               
            
            </div>
        </div>
    </div>
@endsection

