@extends('layouts.dashboard')

@section('dashboard-content')
    @include('components.alert')
    <div class="container-fluid">
        <h1>Data Neraca</h1>
        <div class="d-flex mt-3">

            @if (auth()->user()->member->occupation != "ketua")
                
                <div>
                    <a href="{{route("dashboard.admin.balance_sheet.create")}}" class="btn btn-sm btn-primary">Tambah Data</a>
                </div>
            @endif

            <div class="mx-2">
                <button type="button" class="btn btn-sm btn-primary btn-data" data-toggle="modal" data-target="#filter-tanggal">Filter Bulan</button>
            </div>
            
            @include('components.export_button', array("pdf" => is_null($filter) ? route("dashboard.admin.balance_sheet.export") : route("dashboard.admin.balance_sheet.export") . "?filter=" . $filter))


           @if (Request::get("filter"))
            <div class="ml-2">
                <a href="{{route("dashboard.admin.balance_sheet.index")}}" class="btn btn-sm btn-warning">Reset</a>
            </div>
           @endif
           

            <div class="modal fade modal-data" id="filter-tanggal" tabindex="-1" role="dialog" aria-labelledby="filter-tanggal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Pilih Bulan</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route("dashboard.admin.balance_sheet.index")}}" method="GET">
                            <div class="form-group">
                                <select id="filter" name="filter" class="custom-select">
                                    @foreach ($months as $month)
                                      <option class="text-uppercase" value="{{strtolower($month)}}">{{$month}}</option>
                                      @endforeach
                                </select>
                            </div>

                            <div class="d-flex">
                                <div class="ml-auto">
                                    <button type="submit" class="btn btn-md btn-primary">Filter</button>
                                </div>
                            </div>

                        </form>
                    </div>
                  </div>
                </div>
              </div>

        </div>
        @include('components.table')
    </div>
@endsection