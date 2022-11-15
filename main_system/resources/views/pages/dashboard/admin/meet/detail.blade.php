
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
                                        src="{{is_null($meet->banner) ? "https://ui-avatars.com/api/?name=img&size=280" : asset("assets/banner/" . $meet->banner)}}"
                                        alt="Poster Acara" width="520"/>
                                </div>
                                <h3 class="profile-username text-center text-capitalize text-xl">{{$meet->meetName ? $meet->meetName : "-"}}</h3>

                                <div class="form-group">
                                  <label >ID Pertemuan</label>
                                  <input  type="text"  class="form-control" disabled value="{{$meet->id ? $meet->id : "-"}}">
                                  <span class="text-danger" style="font-size: 12px; font-weight: 400;">*ID dibutuhkan untuk proses absensi</span>
                                </div>

                                <div class="form-group">
                                  <label >Pembahasan Pertemuan</label>
                                  <input  type="text"  class="form-control" disabled value="{{$meet->material ? $meet->material : "-"}}">
                                </div>

                                <div class="form-group">
                                  <label >Jam Mulai Pertemuan</label>
                                  <input  type="text"  class="form-control" disabled value="{{$meet->startAt ? $meet->startAt : "-"}}">
                                </div>

                                <div class="form-group">
                                  <label >Jam Berakhir Pertemuan</label>
                                  <input  type="text"  class="form-control" disabled value="{{$meet->endAt ? $meet->endAt : "-"}}">
                                </div>

                                <div class="form-group">
                                  <label >Online / Offline</label>
                                  <input  type="text"  class="form-control" disabled value="{{$meet->isOnline ? "online" : "offline"}}">
                                </div>
                                <div class="form-group">
                                  <label >Lokasi Pertemuan</label>
                                  <input  type="text"  class="form-control" disabled value="{{$meet->location ? $meet->location : "-"}}">
                                </div>

                                <div class="form-group">
                                  <label >Status Pertemuan</label>
                                  <input  type="text"  class="form-control" disabled value="{{$meet->status ? "selesai" : "belum selesai"}}">
                                </div>

                                <div class="form-group">
                                  <label >HTM</label>
                                  <input  type="text"  class="form-control" disabled value="{{is_null($meet->price) ? 0 : number_format($meet->price)}}">
                                </div>

                                <div class="form-group">
                                    <label>Detail Location</label>
                                    <textarea
                                      class="form-control"
                                      rows="3"
                                      cols="3"
                                      style="resize: none;"
                                      disabled
                                    >{{!is_null($meet->detailLocation) ? $meet->detailLocation : "-"}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Deskripsi Acara</label>
                                    <textarea
                                      class="form-control"
                                      rows="3"
                                      cols="3"
                                      style="resize: none;"
                                      disabled
                                    >{{$meet->description ? $meet->description : "-"}}</textarea>
                                </div>                              
                            </div>
                        </div>
                </div>
            </div>
        </div>

@endsection