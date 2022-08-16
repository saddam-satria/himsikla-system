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
                        <span class="text-lg text-capitalize">Terima Kasih Sudah Mendaftar Acara {{$event->eventName}} berikut ID pendaftaran anda</span>

                        @if ($event->price > 0)
                            <span class="text-md text-capitalize {{$absence->isPaidOff ? "text-success" : "text-danger"}}">{{$absence->isPaidOff ?  "Pembayaran Anda Sudah Di Konfirmasi" : "konfirmasi pembayaran ke PJ acara ("  . $contactPerson . ")"}}</span>
                        @endif

                        <span id="copy" class="text-md text-bold text-capitalize p-2 bg-success rounded mt-3 mb-1" style="cursor: pointer;">{{$absence->id}}</span>
                        <span class="text-sm text-danger text-bold text-capitalize">*Simpan ID pendaftaran Anda <span class="text-lowercase">(penting)</span></span>
                        <span class="text-sm text-success text-capitalize d-none" id="notification">Berhasil Disimpan Di Clipboard</span>
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



@push('scripts')
    <script>
        const copy = document.querySelector("#copy");
        const successToCopy = document.querySelector("#notification");
        copy.addEventListener("click", (e) => {
           const value = e.target.innerText;
           navigator.clipboard.writeText(value).then(() => successToCopy.classList.remove("d-none"))

           setTimeout(() => {
                successToCopy.classList.add("d-none");
           }, 2000);
        });
    </script>

@endpush