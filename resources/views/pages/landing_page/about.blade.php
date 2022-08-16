
@extends('layouts.landing_page')

@push('head')
    <style>
        html{
            scroll-behavior: smooth;
        }

    </style>
@endpush

@section('landing_page-content')



<div style="height: 90vh;">
    <div style='height: 100%; background-attachment: fixed; background-position: bottom center; background-repeat: no-repeat; background-size: cover; background-image: url("{{asset("assets/img/bph.JPG")}}")'>
        <div style="height: 100%; width: 100%; background-color: rgba(0, 0, 0, 0.37);" >
             <div class="d-flex flex-column justify-content-center align-items-center text-center" style="height: 100%;">
                 <h4 class="text-xl text-white text-bold text-uppercase">himpunan mahasiswa universitas bina sarana informatika kaliabang</h4>
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
                    <p>
                        Terbentuknya HIMSI adalah sebagai salah satu wadah organisasi yang sangat dibutuhkan oleh seluruh mahasiswa Sistem Informasi Universitas Bina Sarana Informatika untuk mencurahkan ide-ide brilian dan mengembangkan kemampuan mereka dalam menguasai materi-materi informatika,  dan mengembangkan kreativitas yang tidak hanya bersifat teoritis, sehingga mereka menjadi akademisi yang profesional dan patut diteladani... <a class="text-primary" data-toggle="modal" data-target="#history" style="cursor: pointer">Selengkapnya</a>
                    </p>
                    <div class="py-2">
                        <a href="mailto:himsi.ubsikaliabang@gmail.com" class="btn btn-sm btn-primary"><i class="fas fa-envelope mr-2"></i>Email HIMSI</a>
                    </div>
                   <!-- Modal -->
                    <div class="modal fade" id="history" tabindex="-1" role="dialog" aria-labelledby="history" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="history">Tentang Himpunan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                            <div class="my-2">
                                <span class="text-md text-bold text-uppercase">Sejarah Terbentuk HIMSI</span>
                            </div>
                            <p class="text-justify">
                                Himpunan Mahasiswa Sistem Informasi (HIMSI) adalah metamorfosa dari Himpunan Mahasiswa Manajemen Informatika (HIMMI)  yang sebelumnya sudah terbentuk pada tanggal 23 Juli 2006 bertempat di Fatmawati dan diikuti oleh cabang lainnya seperti Cengkareng pada tanggal 24 Oktober 2012, Cikarang pada tanggal 26 Oktober 2011 dan beberapa cabang lainnya didalam dan  diluar Jabodetabek. Himpunan Mahasiswa Manajemen Informatika atau yang sekarang bisa kita sebut Himpunan Mahasiswa Sistem Informasi terbentuk dengan dilatar belakangi oleh kebutuhan mahasiswa program studi Manajemen Informatika/Sistem Informasi untuk terciptanya lingkungan yang mendukung pengembangan skill mahasiswa pada program studi tersebut sebagai calon teknisi dan akademisi aktif yang akan turun ke tengah-tengah masyarakat. 
                            </p>
                            <div class="my-2">
                                <span class="text-md text-bold text-uppercase">Gagasan Terbentuk HIMSI</span>
                            </div>
                            <p class="text-jusitify">
                                Terbentuknya HIMSI adalah sebagai salah satu wadah organisasi yang sangat dibutuhkan oleh seluruh mahasiswa Sistem Informasi Universitas Bina Sarana Informatika untuk mencurahkan ide-ide brilian dan mengembangkan kemampuan mereka dalam menguasai materi-materi informatika,  dan mengembangkan kreativitas yang tidak hanya bersifat teoritis, sehingga mereka menjadi akademisi yang profesional dan patut diteladani.

                            </p>
                            <div class="my-2">
                                <span class="text-md text-bold text-uppercase">Cabang HIMSI</span>
                            </div>
                            <p class="text-justify">
                                Saat ini HIMSI UBSI sudah ada dibeberapa kampus pusat diantaranya kampus UBSI wilayah BSD, Cengkareng, Cimone, Cikarang, Cutmutia, Salemba, dan Kaliabang.
                            </p>
                            </div>
                        </div>
                        </div>
                    </div>
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
            <div class="col-6 col-sm-6 col-lg-3 mb-3">
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

        <div class="my-5">
            <p>
                <a class="btn btn-primary" data-toggle="collapse" href="#visi" role="button" aria-expanded="false" aria-controls="visi">Visi</a>
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#misi" aria-expanded="false" aria-controls="misi">Misi</button>
              </p>
              <div class="row">
                <div class="col">
                  <div class="collapse multi-collapse" id="visi">
                    <div class="card card-body">
                        Mewujudkan insan Mahasiswa yang aktif,solutif dan responsive guna mengembangkan sinergitas civitas akademika Universitas
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="collapse multi-collapse" id="misi">
                    <div class="card card-body">
                        <ul>
                            <li>
                                Meningkatkan kinerja Himpunan Mahasiswa yang bisa menjembatani perbedaan mahasiswa tanpa kesenjangan sosial
                            </li>
                            <li>
                                Melaksanakan kegiatan mahasiswa yang kreatif, inovatif dan produktif mengembangkan prestasi bersama.
                            </li>
                            <li>
                                Mampu meningkatkan kualitas dan pribadi mahasiswa yang lebih unggul di bidang akademik
                            </li>
                            <li>
                                Mempererat kekeluargaan yang harmonis dan rukun di internal
                            </li>
                        </ul>
                    </div>
                  </div>
                </div>
              </div>
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

