@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="container-fluid">
        @include('components.alert')

          <div class="mb-3">
            <div class="row">
              <div class="col-sm-12 col-md-4">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-coins"></i></span>
    
                  <div class="info-box-content">
                    <span class="info-box-text">Total Pembayaran</span>
                    <span class="info-box-number">Rp. {{number_format($total)}}</span>
                  </div>
                 
                </div>
               
              </div>
              <div class="col-sm-12 col-md-4">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-coins"></i></span>
    
                  <div class="info-box-content">
                    <span class="info-box-text">Tagihan Lunas</span>
                    <span class="info-box-number">{{$paid}}</span>
                  </div>
                 
                </div>
               
              </div>
              <div class="col-sm-12 col-md-4">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-coins"></i></span>
    
                  <div class="info-box-content">
                    <span class="info-box-text">Total Tagihan</span>
                    <span class="info-box-number">{{$totalOfBill}}</span>
                  </div>
                 
                </div>
               
              </div>
            </div>
          </div>

          <div class="my-3">
            @include('components.export_button', array("pdf" => route("dashboard.member.finance.history.export")))
          </div>

          <div class="card">
            <div class="card-header" style="background-color: white !important; color: #101248 !important; ">
              <h3 class="card-title text-bold">Riwayat Pembayaran Uang Kas</h3>
            </div>
          
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead class="text-white" style="background-color: #101248;">
                  <tr>
                    <th scope="col">Bulan</th>
                    <th scope="col">Nominal Bayar</th>
                    <th scope="col">Status Pembayaran</th>
                    <th scope="col">Metode Pembayaran</th>
                    <th scope="col">Waktu Pembayaran</th>
                    <th scope="col">Bukti Pembayaran</th>
                  </tr>
                </thead>
                <tbody>
                  @if (count($histories) <=0 )
                  <tr class="text-center">
                    <td colspan="6">Belum Ada Pembayaran</td>
                  </tr>
                  @endif
                  @foreach ($histories as $history)
                    <tr>
                      <td>{{date_format(date_create($history->month), "F Y")}}</td>
                      <td>{{number_format($history->cash)}}</td>
                      <td>{{$history->status ? "Lunas" : "Belum Lunas"}}</td>
                      <td>{{$history->paymentMethod}}</td>
                      <td>{{$history->createdAt}}</td>
                      <td>
                        <a target="__blank" href="{{asset("assets/bukti-pembayaran/" . $history->image)}}" class="btn btn-sm btn-primary">Preview</a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
    </div>
@endsection