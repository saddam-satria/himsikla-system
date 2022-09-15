@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Tambah Pertemuan</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form method="POST" action="{{route("dashboard.admin.meet.store")}}" enctype="multipart/form-data">
                    @csrf
                    @method("POST")
                    <div class="card-body">
                      @include('components.input_image', ["field" => "banner"])

                      <div class="form-group">
                        <label for="name">Nama Pertemuan</label><span class="text-danger">*</span>
                        <input value="{{old("name")}}" type="text" name="name" id="name" class="form-control"  placeholder="Masukkan Nama Pertemuan">
                      </div>
                      @include('components.form_validation', ["field" => "name"])

                      <div class="form-group">
                        <label for="material">Pembahasan</label><span class="text-danger">*</span>
                        <input value="{{old("material")}}" type="text" name="material" id="material" class="form-control"  placeholder="Masukkan Pembahasan">
                      </div>
                      @include('components.form_validation', ["field" => "material"])

                      
                      <div class="form-group">
                        <label for="startAt">Jam Mulai Pertemuan</label><span class="text-danger">*</span> 
                        <input value="{{old("startAt")}}" type="datetime-local" name="startAt" id="startAt" class="form-control" placeholder="YYYY - YYYY">
                      </div>
                      @include('components.form_validation', ["field" => "startAt"])

                      <div class="form-group">
                        <label for="endAt">Jam Berakhir Pertemuan</label><span class="text-danger">*</span>
                        <input value="{{old("endAt")}}" type="datetime-local" name="endAt" id="endAt" class="form-control" placeholder="YYYY - YYYY" >
                      </div>
                      @include('components.form_validation', ["field" => "endAt"])

                      <div class="form-group">
                        <div class="form-check">
                            <input
                            type="checkbox"
                            class="form-check-input"
                            id="isOnline"
                            name="isOnline"
                            />
                            <label class="form-check-label" for="isOnline">Online Atau Tidak</label>
                        </div>
                      </div>


                      <div class="form-group">
                        <label for="location">Lokasi / Tempat</label><span class="text-danger">*</span>
                        <input value="{{old("location")}}" type="text" name="location" id="location" class="form-control" placeholder="Link Google Maps (https://)">
                      </div>
                      @include('components.form_validation', ["field" => "location"])

                      @include('components.input_number', ["field" => "price", "placeholder" => "Nominal Angka(10200)" ])

                      
                      <div class="form-group" id="detail-location">
                        <label>Detail Lokasi Acara</label><span class="text-danger">*</span>
                        <textarea
                          class="form-control"
                          rows="3"
                          placeholder="Detail Lokasi Acara"
                          cols="3"
                          style="resize: none;"
                          name="detailLocation"
                        >{{old("detailLocation")}}</textarea>
                      </div>
                      @include('components.form_validation', ["field" => "detailLocation"])

                      <div class="form-group">
                        <label>Deskripsi Pertemuan</label><span class="text-danger">*</span>
                        <textarea
                          class="form-control"
                          rows="3"
                          placeholder="Deskripsi"
                          cols="3"
                          style="resize: none;"
                          name="description"
                        >{{old("description")}}</textarea>
                      </div>
                      @include('components.form_validation', ["field" => "description"])
                      


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
     const eventLocation = document.querySelector("#location");
     const isOnline = document.querySelector("#isOnline");
     const inputBanner= document.querySelector('#banner');
     const bannerPreview = document.querySelector("#banner-preview");
     const defaultBanner = bannerPreview.src;
     const labelBanner = document.querySelector(".label-input-file");
     const detailLocation = document.querySelector("#detail-location");

      labelBanner.innerText = "Pilih Gambar Banner";
      
      inputBanner.addEventListener("input", (e) => {
        inputBanner.addEventListener("change", (e) => {
          const file = e.target.files[0];

          labelBanner.classList.remove('text-danger');
          if(!file) {
            labelBanner.innerText = "Pilih Gambar Banner";
            return;
          }


          if(file && !file.type.match(/^[image\/{jpg,png,jpeg}]+$/)){
            labelBanner.innerText = "Format File Salah";
            labelBanner.classList.add("text-danger");
            bannerPreview.src = defaultBanner;
            return
          }
        })
      })

     isOnline.addEventListener("click", (e) => {
        e.target.addEventListener("change", (e) => {
           if(e.target.checked) 
           {
             eventLocation.placeholder = "Link Google Meet / Zoom (https://)"
             detailLocation.hidden = true;
             return
           }

           eventLocation.placeholder = "Link Google Maps (https://)"
           detailLocation.hidden = false;
           return 
        })
      })
    </script>
    
@endpush

