@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Tambah Anggota</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form method="POST" action="{{route("dashboard.admin.member.store")}}" enctype="multipart/form-data">
                    @csrf
                    @method("POST")


                    
                    <div class="card-body">
                      <Label for="image">
                        Foto Profile
                      </Label>
                      @include('components.input_image', ["field" => "image"])

                      <div class="form-group">
                        <label for="name">Nama Anggota</label><span class="text-danger">*</span>
                        <input value="{{old("name")}}" type="text" name="name" id="name" class="form-control"  placeholder="Masukkan Nama Anggota">
                      </div>
                      @include('components.form_validation', ["field" => "name"])

                      <div class="form-group">
                        <label for="nim">NIM Anggota</label><span class="text-danger">*</span>
                        <input value="{{old("nim")}}" type="text" name="nim" id="nim" class="form-control"  placeholder="Masukkan NIM">
                      </div>
                      @include('components.form_validation', ["field" => "nim"])

                      
                      <div class="form-group">
                        <label for="phoneNumber">Whatsapp / No HP</label><span class="text-danger">*</span>
                        <input value="{{old("phoneNumber")}}" type="text" name="phoneNumber" id="phoneNumber" class="form-control"  placeholder="Masukkan No HP">
                      </div>
                      @include('components.form_validation', ["field" => "phoneNumber"])

                      <div class="form-group">
                        <label for="periode">Periode Jabatan</label><span class="text-danger">*</span>
                        <input value="{{old("periode")}}" type="text" name="periode" id="periode" class="form-control" placeholder="YYYY - YYYY" >
                      </div>
                      @include('components.form_validation', ["field" => "periode"])



                      <div class="form-group">
                        <label for="status">Status Keaktifan</label>
                        <select id="status" name="status" class="custom-select">
                              <option class="text-capitalize" value="{{true}}">Aktif</option>
                              <option class="text-capitalize" value="{{false}}">Non Aktif</option>
                          </select>
                      </div>



                      <div class="form-group">
                        <label for="occupation">Jabatan / Posisi</label>
                        <select id="occupation" name="occupation" class="custom-select">
                              <option class="text-capitalize" value="{{"ketua"}}">Ketua</option>
                              <option class="text-capitalize" value="{{"wakil ketua"}}">Wakil Ketua</option>
                              <option class="text-capitalize" value="{{"bendahara"}}">Bendahara</option>
                              <option class="text-capitalize" value="{{"sekretaris"}}">Sekretaris</option>
                              <option class="text-capitalize" value="{{"ketua koordinator"}}">Ketua Koordinator</option>
                              <option class="text-capitalize" value="{{"anggota"}}">Anggota</option>
                          </select>
                      </div>

                      <div class="form-group division" hidden>
                        <label for="division">Divisi</label>
                        <select id="division" name="division" class="custom-select">
                              <option class="text-capitalize" value="{{"rsdm"}}">RSDM</option>
                              <option class="text-capitalize" value="{{"kominfo"}}">KOMINFO</option>
                              <option class="text-capitalize" value="{{"pendidikan"}}">PENDIDIKAN</option>
                              <option class="text-capitalize" value="{{"litbang"}}">LITBANG</option>
                          </select>
                      </div>

                      <div class="form-group">
                        <label for="token">Token Anggota</label>
                        <input readonly type="text" name="token" value="{{strtoupper(Str::random(8))}}" id="token" class="form-control"  placeholder="">
                      </div>

                      <div class="form-group">
                        <label for="user">User</label>
                        @if (count($users) > 0)
                            <select id="user" name="user" class="custom-select">
                                  @foreach ($users as $user)
                                    <option class="text-lowercase" value="{{$user->id}}">{{$user->email}}</option>
                                  @endforeach  
                            </select>
                        @else
                          <input type="text" name="user" class="form-control bg-transparent text-capitalize" disabled placeholder="User Tidak Di temukan">
                        @endif
                    </div>

                      <div class="form-group">
                        <label>Alamat Anggota</label><span class="text-danger">*</span>
                        <textarea
                          class="form-control"
                          rows="3"
                          placeholder="Alamat"
                          cols="3"
                          style="resize: none;"
                          name="address"
                        >{{old("address")}}</textarea>
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

@push('scripts')
    <script>
      const occupationSelected = document.querySelector("#occupation");
      const division  = document.querySelector(".division");
      occupationSelected.addEventListener('click', (e) => {
          if(e.target.value.includes("ketua koordinator") || e.target.value.includes("anggota")){
            division.hidden = false;
            return;
          }
          division.hidden = true;
          return
      })
    </script>
    
@endpush

