@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Edit Data Anggota</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form method="POST" action="{{route("dashboard.admin.member.update", ["member" => $member->id])}}">
                    @csrf
                    @method("PUT")
                    <div class="card-body">
                      <div class="form-group">
                        <label for="name">Nama Anggota</label><span class="text-danger">*</span>
                        <input value="{{$member->name}}" type="text" name="name" id="name" class="form-control"  placeholder="Masukkan Nama Anggota">
                      </div>
                      @include('components.form_validation', ["field" => "name"])

                      <div class="form-group">
                        <label for="nim">NIM Anggota</label><span class="text-danger">*</span>
                        <input value="{{$member->nim}}" type="text" name="nim" id="nim" class="form-control"  placeholder="Masukkan NIM">
                      </div>
                      @include('components.form_validation', ["field" => "nim"])

                      
                      <div class="form-group">
                        <label for="phoneNumber">Whatsapp / No HP</label><span class="text-danger">*</span>
                        <input value="{{$member->phoneNumber}}" type="text" name="phoneNumber" id="phoneNumber" class="form-control"  placeholder="Masukkan No HP">
                      </div>
                      @include('components.form_validation', ["field" => "phoneNumber"])

                      <div class="form-group">
                        <label for="periode">Periode Jabatan</label><span class="text-danger">*</span>
                        <input value="{{$member->periode}}" type="text" name="periode" id="periode" class="form-control" placeholder="YYYY - YYYY" >
                      </div>
                      @include('components.form_validation', ["field" => "periode"])

                      <div class="form-group">
                        <label>Alamat Anggota</label><span class="text-danger">*</span>
                        <textarea
                          class="form-control"
                          rows="3"
                          placeholder="Alamat"
                          cols="3"
                          style="resize: none;"
                          name="address"
                        >{{$member->address}}</textarea>
                      </div>
                      @include('components.form_validation', ["field" => "address"])


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

