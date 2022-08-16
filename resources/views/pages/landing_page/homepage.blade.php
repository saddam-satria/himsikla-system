@push('head')
    <style>
        html{
            scroll-behavior: smooth;
        }
        #scrollbar::-webkit-scrollbar {
            width: 10px;
            height: 5px;
        }
        #scrollbar::-webkit-scrollbar:hover {
            width: 1px;
            height: 1px;
        }

      
        #scrollbar::-webkit-scrollbar-track {
        background: transparent;
        }

       
        #scrollbar::-webkit-scrollbar-thumb {
        background: transparent;
        }

       
        #scrollbar::-webkit-scrollbar-thumb:hover {
        background: #101248;
        }

        #event-card:hover {
            background-color: #fafafa;
        }


    </style>
@endpush


@extends('layouts.landing_page')

@section('landing_page-content')

   <div style="height: auto; background-size: cover; background-repeat: no-repeat; background-position: center; background-attachment: fixed;  background-image: url('{{asset("assets/img/team-ethnicity-group-hands.jpg")}}')">
        <div style="background-color: #00000099; width:100%; height:100%;" class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-6 mt-3">
                        <img src="{{asset("assets/img/lagom-people-discussing-the-idea-of-a-new-project-in-the-office.png")}}" width="320" style="object-fit: cover; height: 100%;" alt="Bubble Gum" />
                    </div>
                    <div class="col-12 col-sm-6 mt-3">
                        <div class="d-flex flex-column justify-content-center" style="height: 100%;">
                            <h2 class="text-xl text-uppercase" style="font-weight: 700; color: #ffffff;">himsi kaliabang smart system</h2>
                            <div class="py-3">
                                <span class="text-md text-uppercase" style="color: rgb(248, 248, 248); font-weight: 600">team penelitian & pengembangan HIMSI KLA</span>
                            </div>
                            <p class="text-white text-lowercase text-justify">
                                sistem ini dibuat oleh tim pengembangan dan penelitian dari himsi kla untuk membantu para anggota menjalankan kegiatan HIMSI Kaliabang baik offline maupun online dengan bantuan teknologi. terima kasih atas kontribusi dalam penggunaan sistem ini, anda dapat memberikan saran dan kritikan terkait sistem yang kami buat dengan cara melalui email HIMSI KLA
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </div>
  

    

    <div style="margin: 5rem 0px">
        <div class="container">
            <div class="text-center">
                <div class="py-5">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="text-center mb-3">
                                <h4><i class="fas fa-users" style="color: #101248; font-size: 2em;"></i></h4>
                                <div class="d-flex flex-column">
                                    <span class="text-md  text-capitalize" style="color: #4449ae;">
                                        Pengguna
                                    </span>
                                    
                                    <span class="text-bold text-lg">{{$total_user}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <div class="text-center">
                                <h4><i class="fas fa-calendar text-danger" style="font-size: 2em;"></i></h4>
                                <div class="d-flex flex-column">
                                    <span class="text-md  text-capitalize" style="color: #4449ae;">
                                        Acara Selesai
                                    </span>
                                   
                                    <span class="text-bold text-lg">{{$total_event}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <div class="text-center">
                                <h4><i class="fas fa-calendar-check text-success" style="font-size: 2em;"></i></h4>
                                <div class="d-flex flex-column">
                                    <span class="text-md  text-capitalize" style="color: #4449ae;">
                                        Pertemuan Selesai
                                    </span>
                                    <span class="text-bold text-lg">{{$total_meet}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
        </div>
    </div>

    <div style="margin: 5rem 0px">

        <div class="container my-3">
            <div class="d-flex">
                <span class="text-lg text-bold text-uppercase">acara terbaru</span>
                <div class="ml-auto">
                  <a href="{{route("events")}}" class="text-decoration-none"> <i class="fas fa-arrow-right text-sm"></i></a>
                </div>
            </div>
            <div class=" py-2">
                @if (count($events) > 0)
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
                                            <a href="{{route("event", $event->id)}}" class="text-dark">
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
                @else
                <div class="d-flex justify-content-center">
                    <span class="text-capitalize text-danger">Belum Ada Acara</span>
                </div>
                @endif
               
            
            </div>
        </div>
    
    </div>

    <div style="margin: 5rem 0px 15rem 0px">

        <div class="container my-3">
            <div class="row">
                <div class="col-12 col-sm-6 mt-3">
                    <img src="{{asset("assets/img/lagom-the-programmer-developes-code-at-his-laptop.png")}}" width="320" style="object-fit: cover; height: 100%;" alt="Bubble Gum" />
                </div>
                <div class="col-12 col-sm-6 mt-3">
                    <div class="d-flex flex-column justify-content-center" style="height: 100%;">
                        <h2 class="text-xl text-uppercase" style="font-weight: 700; color: #101248;">Sudah Pernah Mendaftar Acara?</h2>
                        <div class="py-3">
                            <span class="text-md text-uppercase" style="color: rgb(119, 118, 118)">HIMSI KLA SMART SYSTEM</span>
                        </div>
                        <p class="text-dark text-lowercase text-justify">
                            Untuk Para Pengunjung yang sudah pernah daftar acara yang diselenggarakan HIMSI KLA dipersilahkan untuk melakukan pengecekan status pembayaran ataupun absensi dengan cara menginputkan ID Pendaftaran yang tersedia saat pendaftaran
                        </p>
                        <div class="d-flex">
                            <form action="{{route("event.absence.create")}}" method="GET">
                                <div class="input-group">
                                    <input name="id" class="form-control form-control-sidebar" type="search" placeholder="Masukan ID Pendaftaran" aria-label="Masukan ID Pendaftaran">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-search fa-fw"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </div>

 

    <div class="my-5" style="height: 100vh;">
       <div style='height: 100%; background-attachment: fixed; background-position: bottom center; background-repeat: no-repeat; background-size: cover; background-image: url("{{asset("assets/img/himsi-sertijab.JPG")}}")'>
           <div style="height: 100%; width: 100%; background-color: rgba(0, 0, 0, 0.212);" >
                <div class="d-flex flex-column justify-content-center align-items-center text-center" style="height: 100%;">
                    <h4 class="text-xl text-white text-bold text-uppercase">Selamat Datang Di HIMSI Kaliabang</h4>
                    <div>
                        <a href="{{route("about")}}" class="btn btn-md btn-success">Tentang HIMSI</a>   
                    </div>
                </div>
           </div>
       </div>
    </div>

    <div style="margin: 5rem 0px">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 mt-3">
                    <div class="d-flex py-5">
                        <img width="280" style="height: 100%; object-fit: cover;" src="{{asset("android-chrome-512x512.png")}}" class="img-fluid" alt="HIMSI KALIABANG" />
                    </div>
                </div>
                <div class="col-12 col-md-6 mt-3">
                    <div class="d-flex flex-column justify-content-center" style="height: 100%;">
                        <h2 class="text-xl text-uppercase" style="font-weight: 700; color: #101248;">himsi kaliabang</h2>
                        <div class="py-2">
                            <span class="text-md text-uppercase" style="color: rgb(119, 118, 118)">Oraganisasi Mahasiswa UBSI Kaliabang</span>
                        </div>
                        <p>Terbentuknya HIMSI adalah sebagai salah satu wadah organisasi yang sangat dibutuhkan oleh seluruh mahasiswa Sistem Informasi Universitas Bina Sarana Informatika untuk mencurahkan ide-ide brilian dan mengembangkan kemampuan mereka dalam menguasai materi-materi informatika,  dan mengembangkan kreativitas yang tidak hanya bersifat teoritis, sehingga mereka menjadi akademisi yang profesional dan patut diteladani... <a class="text-primary" href="{{route("about")}}"  style="cursor: pointer">Selengkapnya</a></p>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="margin: 5rem 0px">
       <div class="container">
        <div class="text-center my-5">
            <span class="text-lg text-bold text-uppercase">Divisi HIMSI Kaliabang</span>
        </div>
        <div class="row">
            @foreach ($divisions as $division)
                <div class="col-6 col-sm-6 col-lg-3">
                    <div class="card">
                        <div style="height: 100%;">
                            <img class="img-fluid rounded" data-target="#{{$division}}" data-toggle="modal" data-backdrop="static" data-keyboard="false" src="{{asset("assets/img/" . $division . ".png")}}" style="height: 100%; object-fit: cover; width: 100%;" alt="">
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="{{$division}}" tabindex="-1" role="dialog" aria-labelledby="{{$division . "preview"}}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" onclick="stoppedVideo()" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <video controls autoplay muted preload="auto">
                                <source src="{{asset("assets/videos" . "/" . $division . ".mp4")}}" type="video/mp4"></source>
                            </video>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
       </div>
    </div>

    <div style="margin: 10rem 0px" id="members">
        <div class="container">
            <div class="my-5">
                <span class="text-lg text-bold text-uppercase">Periode {{date_format(date_create("now"), "Y") - 1}} - {{date_format(date_create("now"), "Y")}}</span>
            </div>
            <div class="row">
                @foreach ($members as $member)
                <div class="col-6 col-sm-6 col-lg-4 mb-3">
                    <div class="card rounded shadow" id="event-card" style="height: 100%;">
                        <img style="object-fit: cover; height: 220px;" width="100%" src="{{is_null($member->image) ? "https://ui-avatars.com/api/?name=" . $member->name . "&size=280": asset("assets/banner" . "/" . $member->image)}}" class="img-fluid image-cover rounded" />
                        <div class="card-body">
                            <div class="d-flex flex-column justify-content-center">
                                <span class="text-lg text-bold text-uppercase">
                                    <a href="#" class="text-dark">
                                    {{$member->name}}
                                    </a>
                                </span>
                                <span class="text-lowercase text-sm" style="color: rgba(94, 94, 94, 0.856);">{{$member->occupation}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
           
            <div class="py-5 text-center">
                <a href="{{url("/about#members")}}" class="btn btn-sm btn-primary">Lihat Anggota</a>
            </div>
           
        </div>
    </div>  

    <div style="margin: 5rem 0px">
        <div class="container">
            <div class="text-center my-5">
                <span class="text-lg text-bold text-uppercase">Foto Kegiatan Terbaru</span>
            </div>
            <div class="row">
                @foreach ($galleries as $gallery)
                    <div class="col-12 col-sm-6 col-lg-4 mb-3">
                        <img src="{{asset("assets/gallery". "/" . $gallery->image)}}" class="img-fluid rounded" style="object-fit: cover; height: 100%;" alt="" />
                    </div>
                @endforeach
            </div>
            <div class="py-5 text-center">
                <a href="{{route("gallery")}}" class="btn btn-sm btn-primary">Lihat Gallery</a>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        const stoppedVideo =() => {
            document.querySelectorAll('video').forEach(vid => vid.pause());
        }
    </script>
@endpush