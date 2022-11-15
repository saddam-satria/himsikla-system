
@extends('layouts.dashboard')

@section('dashboard-content')

        <div class="container-fluid">
          @include('components.alert')

            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                                           
                                <div class="form-group">
                                  <label >NIM Anggota</label>
                                  <input  type="text"  class="form-control" disabled value="{{$finance->nim ? $finance->nim : "-"}}">
                                </div>
                           
                                <div class="form-group">
                                  <label >Nama Anggota</label>
                                  <input  type="text"  class="form-control" disabled value="{{$finance->name ? $finance->name : "-"}}">
                                </div>
                           
                                <div class="form-group">
                                  <label >No HP Anggota</label>
                                  <input  type="text"  class="form-control" disabled value="{{$finance->phoneNumber ? $finance->phoneNumber : "-"}}">
                                </div>
                           
                                <div class="form-group">
                                  <label >Jumlah Yang Dibayarkan</label>
                                  <input  type="text"  class="form-control" disabled value="{{$finance->cash ? number_format($finance->cash) : "-"}}">
                                </div>
                           
                                <div class="form-group">
                                  <label >Status</label>
                                  <input  type="text"  class="form-control" disabled value="{{$finance->cash >= $finance->price + $finance->penalty && $finance->status? "Lunas" : "Belum Lunas"}}">
                                </div>
                           
                                <div class="form-group">
                                  <label >Denda</label>
                                  <input  type="text"  class="form-control" disabled value="{{$finance->penalty ? number_format($finance->penalty) : "-"}}">
                                </div>
                           
                                <div class="form-group">
                                  <label >Metode Pembayaran</label>
                                  <input  type="text"  class="form-control" disabled value="{{$finance->paymentMethod ? $finance->paymentMethod : "-"}}">
                                </div>
                           
                                <div class="form-group">
                                  <label >Bulan</label>
                                  <input  type="text"  class="form-control" disabled value="{{$finance->month ? $finance->month : "-"}}">
                                </div>
                           
                                <div class="form-group">
                                  <label >Jumlah Yang Harus Dibayarkan</label>
                                  <input  type="text"  class="form-control" disabled value="{{$finance->price ? number_format($finance->price) : "-"}}">
                                </div>
                           
                                <div class="form-group">
                                  <label >Rekening Tujuan</label>
                                  <input  type="text"  class="form-control" disabled value="{{$finance->payment ? $finance->payment : "-"}}">
                                </div>
                           
                                <div class="form-group">
                                  <label >Waktu Pembayaran</label>
                                  <input  type="text"  class="form-control" disabled value="{{$finance->createdAt ? $finance->createdAt : "-"}}">
                                </div>

                                <div class="my-2">
                                  <label>Bukti Pembayaran</label>
                                </div>
                                <div class="text-center">
                                  <img class="img-fluid rounded"
                                  src="{{asset("assets/bukti-pembayaran/" . $finance->image)}}"
                                  alt="Bukti Pembayaran Kas" width="520"/>
                                </div>
                           
                            </div>
                        </div>
                </div>
                </div>
            </div>
        </div>

@endsection