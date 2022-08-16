
@extends('layouts.dashboard')

@section('dashboard-content')

        <div class="container-fluid">
          @include('components.alert')

            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                              
                                <div class="form-group">
                                  <label class="text-bold">ID Peserta</label>
                                  <input  type="text"  class="form-control" disabled value="{{$event->absence_id ? $event->absence_id : "-"}}">
                                </div>
                              
                                <div class="form-group">
                                  <label class="text-bold">Email</label>
                                  <input  type="text"  class="form-control" disabled value="{{$event->email ? $event->email : "-"}}">
                                </div>

                                <div class="form-group">
                                  <label class="text-bold">NIM</label>
                                  <input  type="text"  class="form-control" disabled value="{{$event->nim ? $event->nim : "-"}}">
                                </div>

                                <div class="form-group">
                                  <label class="text-bold">University</label>
                                  <input  type="text"  class="form-control" disabled value="{{$event->university ? $event->university : "-"}}">
                                </div>
                                
                                <div class="form-group">
                                  <label >ID Acara</label>
                                  <input  type="text"  class="form-control" disabled value="{{$event->id ? $event->id : "-"}}">
                                  <span class="text-danger" style="font-size: 12px; font-weight: 400;">*ID dibutuhkan untuk proses absensi</span>
                                </div>


                                <div class="form-group">
                                  <label >Lokasi Acara</label>
                                  <input  type="text"  class="form-control" disabled value="{{$event->location ? $event->location : "-"}}">
                                </div>

                                <div class="form-group">
                                  <label >Status Absensi Acara</label>
                                  <input  type="text"  class="form-control" disabled value="{{$event->status ? $event->status : "-"}}">
                                </div>

                                <div class="form-group">
                                  <label >Status Pembayaran Acara</label>
                                  <input  type="text"  class="form-control" disabled value="{{$event->isPaidOff ? "Lunas" : "Belum Lunas"}}">
                                </div>

                                <div class="form-group">
                                  <label >Jam Absen</label>
                                  <input  type="text"  class="form-control" disabled value="{{$event->createdAt}}">
                                </div>

                            </div>
                        </div>
                </div>
            </div>
        </div>

@endsection