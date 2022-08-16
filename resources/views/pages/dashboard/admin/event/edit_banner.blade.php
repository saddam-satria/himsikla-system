@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Edit Poster Acara</h3>
                  </div>
                
                  <form method="POST" action="{{route("dashboard.admin.event.update" , ["event" => $event->id]). "?action=banner"}}" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="card-body">

                      @include('components.input_image', ["field" => "banner", "defaultImage" => is_null($event->banner) ? null :  asset("assets/banner/" . $event->banner)])
                      @include('components.form_validation', ["field" => "banner"])

                    </div>
                    
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Edit Poster</button>
                    </div>
                    
                  </form>
                </div>
          
    
        
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
 

      const inputBanner= document.querySelector('#banner');
      const bannerPreview = document.querySelector("#banner-preview");
      const defaultBanner = bannerPreview.src;
      const labelBanner = document.querySelector(".label-input-file");
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



    </script>
@endpush