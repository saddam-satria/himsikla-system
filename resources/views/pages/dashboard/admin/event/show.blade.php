
@extends('layouts.dashboard')

@section('dashboard-content')

        <div class="container-fluid">
          @include('components.alert')

            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                  <img class="img-fluid rounded"
                                  src="{{is_null($event->banner) ? "https://ui-avatars.com/api/?name=img&size=280" : asset("assets/banner/" . $event->banner)}}"
                                  alt="Poster Acara" width="520"/>
                                </div>
                                <h3 class="profile-username text-center text-capitalize text-xl">{{$event->eventName ? $event->eventName : "-"}}</h3>
                                <div class="form-group">
                                  <label >ID acara</label>
                                  <input  type="text"  class="form-control" disabled value="{{$event->id ? $event->id : "-"}}">
                                  <span class="text-danger" style="font-size: 12px; font-weight: 400;">*ID dibutuhkan untuk proses absensi</span>
                                </div>
                                <div class="form-group">
                                  <label >Acara Mulai</label>
                                  <input  type="text"  class="form-control" disabled value="{{$event->startAt ? $event->startAt : "-"}}">
                                </div>
                                <div class="form-group">
                                  <label >Acara Selesai</label>
                                  <input  type="text"  class="form-control" disabled value="{{$event->endAt ? $event->endAt : "-"}}">
                                </div>
                                <div class="form-group">
                                  <label >Status Acara Saat ini</label>
                                  <input  type="text"  class="form-control" disabled value="{{$event->status ? "Selesai" : "Belum Selesai"}}">
                                </div>
                                <div class="form-group">
                                  <label >Kategori Acara</label>
                                  <input  type="text"  class="form-control" disabled value="{{$event->isGeneral ? "Umum" : "Anggota"}}">
                                </div>
                                <div class="form-group">
                                  <label >Jenis Acara</label>
                                  <input type="text"  class="form-control" disabled value="{{$event->price > 0 ? "Berbayar" : "Gratis"}}">
                                </div>
                                <div class="form-group">
                                  <label >HTM</label>
                                  <input type="text"  class="form-control" disabled value="{{is_null($event->price) ? "Gratis" : number_format($event->price)}}">
                                </div>
                                <div class="form-group">
                                  <label >Pembayaran</label>
                                  <input type="text"  class="form-control" disabled value="{{is_null($event->payment) ? "-": $event->payment }}">
                                </div>
                                <div class="form-group">
                                    <label >Online / Offline</label>
                                    <input type="text"  class="form-control" disabled value="{{$event->isOnline ? "Online" : "Offline"}}">
                                </div>

                                <div class="form-group">
                                  <label > Link Lokasi / Tempat Acara Berlangsung</label>
                                  <input type="text"  class="form-control" disabled value="{{$event->location ? $event->location : "-"}}">
                                </div>
                              
                                <div class="form-group">
                                  <label > Link Feedback</label>
                                  <input type="text"  class="form-control" disabled value="{{$event->feedback ? $event->feedback : "-"}}">
                                </div>
                              
                                <div class="form-group">
                                  <label >Detail Lokasi / Tempat Acara Berlangsung</label>
                                  <input type="text"  class="form-control" disabled value="{{$event->detailLocation ? $event->detailLocation : "Online"}}">
                                </div>
                              
                                <div class="form-group">
                                  <label >Penanggung Jawab</label>
                                  <input type="text"  class="form-control" disabled value="{{$event->contactPerson ? $event->contactPerson : "-"}}">
                                </div>
                              
                                <div class="form-group">
                                  <label>Deskripsi Acara</label>
                                  <textarea
                                    class="form-control"
                                    rows="3"
                                    cols="3"
                                    style="resize: none;"
                                    disabled
                                  >{{$event->description ? $event->description : "-"}}</textarea>
                                </div>

                                @if ($certificate)
                                <div class="form-group">
                                  <label>Link Sertifikat</label>
                                  <input type="text"  class="form-control" disabled value="{{$certificate->link}}">
                                </div>
                                @endif

                             
                                <a href="{{route("dashboard.admin.event.edit", ["event" => $event->id]) . "?action=banner"}}" class="btn btn-md btn-primary">Edit Poster</a>
                            </div>
                        </div>
                </div>
                </div>
            </div>
        </div>

@endsection