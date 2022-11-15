@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Edit Absensi Acara</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form method="POST" action="{{route("dashboard.admin.event_absence.update", ["event_absence" => $event->id])}}">
                    @csrf
                    @method("PUT")
                    <div class="card-body">

                        <div class="form-group">
                          <label for="email">Email</label><span class="text-danger">*</span>
                          <input value="{{$event->email}}" type="text" name="email" id="email" class="form-control" placeholder="Email Peserta">
                        </div>
                        @include('components.form_validation', ["field" => "email"])
                        
                        <div class="form-group">
                          <label for="nim">NIM</label><span class="text-danger">*</span>
                          <input value="{{$event->nim}}" type="text" name="nim" id="nim" class="form-control" placeholder="NIM Peserta">
                        </div>
                        @include('components.form_validation', ["field" => "nim"])

                        <div class="form-group">
                          <label for="university">Universitas</label><span class="text-danger">*</span>
                          <input value="{{$event->university}}" type="text" name="university" id="university" class="form-control" placeholder="Universitas Peserta">
                        </div>
                        @include('components.form_validation', ["field" => "university"])                

                        
                        <div class="form-group">
                          <div class="form-check">
                              <input
                              type="checkbox"
                              class="form-check-input"
                              id="paid"
                              name="paid"
                              {{$event->isPaidOff ? "checked" : ""}}
                              />
                              <label class="form-check-label" for="paid">Lunas Pembayaran</label>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="status">Alasan Absen</label>
                          <select id="status" name="status" class="custom-select">
                              @foreach ($reasons as $reason)
                                <option class="text-lowercase" value="{{$reason}}">{{$reason}}</option>
                              @endforeach
                            </select>
                        </div>


                    </div>
                
    
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                  </form>
                </div>
          
    
        
            </div>
        </div>
    </div>
@endsection
