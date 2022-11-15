@extends('layouts.dashboard')

@section('dashboard-content')

    @include('components.alert')
    <div class="container-fluid">
        <div class="mb-3">
            <div class="row py-3" style="background-color: #101248;">

                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <h5 class="description-header text-white">{{$detailAbsence->present}}</h5>
                    <span class="description-text text-white">Jumlah Kehadiran</span>
                  </div>
                </div>
              
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <h5 class="description-header text-white">{{$detailAbsence->sick}}</h5>
                    <span class="description-text text-white">Jumlah Sakit</span>
                  </div>
                </div>
               
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <h5 class="description-header text-white">{{$detailAbsence->absence}}</h5>
                    <span class="description-text text-white">Alpha</span>
                  </div>
                </div>

                <div class="col-sm-3 col-6">
                  <div class="description-block ">
                    <h5 class="description-header text-white">{{$detailAbsence->permit}}</h5>
                    <span class="description-text text-white">Jumlah Izin</span>
                  </div>
                </div>

              </div>
       
        </div>

        <h1 class="text-xl text-capitalize">Daftar Peserta Acara {{$event->eventName . "-" . explode(" ", $event->createdAt)[0]}}</h1>
        @include('components.export_button', array("pdf" => route("dashboard.admin.event_absence.export", $event->id)))
        @include('components.table')
    </div>
@endsection