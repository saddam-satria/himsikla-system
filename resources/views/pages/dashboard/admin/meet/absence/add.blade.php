@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Tambah Absensi Pertemuan</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form method="POST" action="{{route("dashboard.admin.meet_absence.store")}}">
                    @csrf
                    @method("POST")
                    <div class="card-body">
                      
                      <div class="form-group">
                        <label for="meet_id">Pertemuan</label>
                        @if (count($meets) > 0)
                          <select id="meet_id" name="meet_id" class="custom-select">
                              @foreach ($meets as $meet)
                              <option class="text-lowercase" value="{{$meet->id}}">{{$meet->meetName . "-" . $meet->id}}</option>
                              @endforeach
                          </select>
                          @else
                            <input type="text" name="meet_id"  class="form-control" disabled placeholder="Pertemuan Kosong">
                          @endif
                      </div>
                      @include('components.form_validation', ["field" => "meet_id"])


                      <div class="form-group">
                          <label for="member_id">Anggota</label>
                          @if (count($members) > 0)
                            <select id="member_id" name="member_id" class="custom-select">
                                  @foreach ($members as $member)
                                  <option class="text-lowercase" value="{{$member->id}}">{{$member->name . "-" . $member->nim}}</option>
                                  @endforeach
                                    
                            </select>
                            <span class="text-sm text-bold">nama member-nim member</span>
                            @else
                              <input type="text" name="member_id"  class="form-control" disabled placeholder="Member Kosong">
                            @endif
                      </div>
                      @include('components.form_validation', ["field" => "member_id"])

                      
                      <div class="form-group">
                        <label for="status">Alasan Absen</label>
                        <select id="status" name="status" class="custom-select">
                             @foreach ($reasons as $reason)
                              <option class="text-lowercase" value="{{$reason}}">{{$reason}}</option>
                             @endforeach
                          </select>
                      </div>
                      @include('components.form_validation', ["field" => "status"])


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


