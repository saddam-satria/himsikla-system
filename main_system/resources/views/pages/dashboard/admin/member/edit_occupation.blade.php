@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Edit Jabatan</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                   
                  <form method="POST" action="{{url("dashboard/admin/member/". $member->id . "?edit=occupation")}}">
                    @csrf
                    @method("PUT")
                    <div class="card-body">

                    <div class="form-group">
                        <label>Jabatan Sebelumnya</label>
                        <input  type="text"  class="form-control bg-indigo text-capitalize" disabled value="{{$member->occupation ? $member->occupation : "-"}}">
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


                    </div>
                    <!-- /.card-body -->
    
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Ganti</button>
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

