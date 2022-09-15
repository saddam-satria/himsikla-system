@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Tambah Acara Baru</h3>
                  </div>
                
                  <form method="POST" action="{{route("dashboard.admin.event.store")}}" enctype="multipart/form-data">
                    @csrf
                    @method("POST")
                    <div class="card-body">

                      @include('components.input_image', ["field" => "banner"])
      

                      <div class="form-group">
                        <label for="name">Nama Acara</label><span class="text-danger">*</span>
                        <input value="{{old("name")}}" type="text" name="name" id="name" class="form-control"  placeholder="Masukkan Nama Acara">
                      </div>
                      @include('components.form_validation', ["field" => "name"])

                      <div class="form-group">
                        <label for="startAt">Acara Dimulai</label><span class="text-danger">*</span>
                        <input value="{{old("startAt")}}" type="datetime-local" name="startAt" id="startAt" class="form-control">
                      </div>
                      @include('components.form_validation', ["field" => "startAt"])

                      <div class="form-group">
                        <label for="endAt">Acara Berakhir</label><span class="text-danger">*</span>
                        <input value="{{old("endAt")}}" type="datetime-local" name="endAt" id="endAt" class="form-control">
                      </div>
                      @include('components.form_validation', ["field" => "endAt"])

                      <div class="form-group">
                        <label for="isGeneral">Kategori Acara</label>
                        <select id="isGeneral" name="isGeneral" class="custom-select">
                              <option class="text-capitalize" value="{{true}}">Umum</option>
                              <option class="text-capitalize" value="{{false}}">Hanya Anggota</option>
                          </select>
                      </div>

                      <div class="form-group">
                        <label for="isFree">Jenis Acara</label>
                        <select id="isFree" name="isFree" class="custom-select">
                              <option class="text-capitalize" value="{{1}}">Berbayar</option>
                              <option class="text-capitalize" value="{{0}}">Gratis</option>
                          </select>
                      </div>

                        @include('components.input_number', ["field" => "price", "placeholder" => "Nominal Angka(10200)" ])
                  
                        
                        <div class="form-group">
                          <label for="payment">Pembayaran</label>
                          <input value="{{old("payment")}}" type="text" name="payment" id="payment" class="form-control" placeholder="Rekening Pembayaran">
                          <span class="text-medium" style="font-size: 0.7em">XXXXXXXXXX - Bank Mandiri</span>
                        </div>
                        @include('components.form_validation', ["field" => "payment"])
                        
                        <div class="form-group">
                          <label for="contact">Penanggung Jawab</label>
                          <input value="{{old("contact")}}" type="text" name="contact" id="contact" class="form-control" placeholder="Penanggung Jawab">
                          <span class="text-medium" style="font-size: 0.7em">No Telepon - Nama</span>
                        </div>
                        @include('components.form_validation', ["field" => "contact"])

                      
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
                        <label for="location">Link Lokasi / Tempat</label><span class="text-danger">*</span>
                        <input value="{{old("location")}}" type="text" name="location" id="location" class="form-control" placeholder="Link Google Maps (https://)">
                      </div>
                      @include('components.form_validation', ["field" => "location"])

                      <div class="form-group">
                        <label for="feedback">Link Feedback</label>
                        <input value="{{old("feedback")}}" type="text" name="feedback" id="feedback" class="form-control" placeholder="Link Google Form (https://)">
                      </div>
                      @include('components.form_validation', ["field" => "feedback"])


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
                        <label>Deskripsi Acara</label><span class="text-danger">*</span>
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
      const isFree = document.querySelector("#isFree");
      const price = document.querySelector("#price");
      const isOnline = document.querySelector("#isOnline");
      const eventLocation = document.querySelector("#location");
      const detailLocation = document.querySelector("#detail-location");

      const inputBanner= document.querySelector('#banner');
      const bannerPreview = document.querySelector("#banner-preview");
      const defaultBanner = bannerPreview.src;
      const labelBanner = document.querySelector(".label-input-file");
      labelBanner.innerText = "Pilih Gambar Banner";

      const payment = document.querySelector("#payment");
      
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


      isFree.addEventListener("change", (e) => {
        const {value} = e.target;

        if(value ==  0) 
        {
          price.disabled= true;
          price.value = "";
          price.placeholder = "Gratis"
          payment.disabled = true;
          return;
        }

        price.placeholder = "Nominal Angka(10200)"
        price.disabled = false;
        payment.disabled = false;

        return;

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