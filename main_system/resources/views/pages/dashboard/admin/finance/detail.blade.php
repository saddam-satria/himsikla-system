@extends('layouts.dashboard')

@section('dashboard-content')
    @include('components.alert')
    <div class="container-fluid">
        <div class="mb-3">
            <div class="row py-3" style="background-color: #101248;">

                <div class="col-sm-4 col-6">
                  <div class="description-block border-right">
                 
                    <h5 class="description-header text-white">{{$member}}</h5>
                    <span class="description-text text-white">Jumlah Anggota</span>
                  </div>
                
                </div>
              
                <div class="col-sm-4 col-6">
                  <div class="description-block border-right">
                  
                    <h5 class="description-header text-white">{{$total->total_member}}</h5>
                    <span class="description-text text-white">Jumlah Anggota Yang Sudah Bayar</span>
                  </div>
                
                </div>
               
                <div class="col-sm-4 col-6">
                  <div class="description-block ">
                    
                    <h5 class="description-header text-white">Rp. {{number_format($total->cash)}}</h5>
                    <span class="description-text text-white">Total Uang Kas</span>
                  </div>
                
                </div>
              </div>
       
        </div>

        <h1 class="text-xl text-capitalize">Pembayaran Kas {{date_format(date_create($month->month) ,"F Y")}}</h1>
        @if (auth()->user()->member->occupation != "ketua")
        <div class="d-flex my-2">
            <a href="{{route("dashboard.admin.detail_finance.create")}}" class="btn btn-sm btn-primary mr-2">Tambah Data</a>
            @include('components.export_button', array("pdf" => route("dashboard.admin.finance.export", $id)))
        </div>
        @endif
        @include('components.table')
    </div>
@endsection