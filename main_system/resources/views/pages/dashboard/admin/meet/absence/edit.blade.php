@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title text-capitalize">Edit Absensi Pertemuan {{$meet->meetName ."-" . explode(" ", $meet->createdAt)[0]}}</h3>
                  </div>

                  <form method="POST" action="{{route("dashboard.admin.meet_absence.update", ["meet_absence" => $meet->id])}}">
                    @csrf
                    @method("PUT")
                    <div class="card-body">
                      
                      <div class="form-group">
                        <label >Nama Anggota - NIM Anggota</label>
                        <input type="text"  class="form-control" disabled value="{{$meet->name . "-" . $meet->nim}}">
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
                    <!-- /.card-body -->
    
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
                <!-- /.card -->
    
        
            </div>
        </div>
    </div>
@endsection


