
@extends('layouts.dashboard')

@section('dashboard-content')

        <div class="container-fluid">
          @include('components.alert')

            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                              
                                <div class="form-group">
                                  <label class="text-bold">Nama Anggota</label>
                                  <input  type="text"  class="form-control" disabled value="{{$meet->name ? $meet->name : "-"}}">
                                </div>

                                <div class="form-group">
                                  <label class="text-bold">NIM Anggota</label>
                                  <input  type="text"  class="form-control" disabled value="{{$meet->nim ? $meet->nim : "-"}}">
                                </div>
                                
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
                                  <label >Lokasi Pertemuan</label>
                                  <input  type="text"  class="form-control" disabled value="{{$meet->location ? $meet->location : "-"}}">
                                </div>

                                <div class="form-group">
                                  <label >Status Absensi Pertemuan</label>
                                  <input  type="text"  class="form-control" disabled value="{{$meet->status ? $meet->status : "-"}}">
                                </div>

                                <div class="form-group">
                                  <label >Jam Absen</label>
                                  <input  type="text"  class="form-control" disabled value="{{$meet->createdAt}}">
                                </div>

                            </div>
                        </div>
                </div>
            </div>
        </div>

@endsection