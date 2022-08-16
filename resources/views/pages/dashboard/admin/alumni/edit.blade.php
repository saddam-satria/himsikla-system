@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Tambah Alumni</h3>
                  </div>
                
                  <form method="POST" action="{{route("dashboard.admin.alumni.update", $alumni->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")

                    <div class="card-body">
                      <Label for="image">
                        Foto Profile
                      </Label>
                      @include('components.input_image', ["field" => "image",  "defaultImage" => is_null($alumni->image) ? null : asset("assets/alumni/profiles/". $alumni->image)])

                      <div class="form-group">
                        <label for="name">Nama Anggota</label><span class="text-danger">*</span>
                        <input value="{{$alumni->name}}" type="text" name="name" id="name" class="form-control"  placeholder="Masukkan Nama Anggota">
                      </div>
                      @include('components.form_validation', ["field" => "name"])

                      <div class="form-group">
                        <label for="periode">Periode Jabatan</label><span class="text-danger">*</span>
                        <input value="{{$alumni->periode}}" type="text" name="periode" id="periode" class="form-control" placeholder="YYYY - YYYY" >
                      </div>
                      @include('components.form_validation', ["field" => "periode"])

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

