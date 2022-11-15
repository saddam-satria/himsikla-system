
@extends('layouts.dashboard')

@section('dashboard-content')
        <div class="container-fluid">
            @include('components.alert')
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                <img style="object-fit: cover;" class="profile-user-img img-fluid rounded-circle image-cover"
                                        src={{asset("assets/alumni/profiles". "/" . $alumni->image)}}
                                        alt="{{!is_null($alumni->image) ? null : substr($alumni->name, 0, 2)}}" width="260px"  />
                                </div>

                                <div class="form-group">
                                  <label >Nama Anggota</label>
                                  <input  type="text"  class="form-control" disabled value="{{$alumni->name ? $alumni->name : "-"}}">
                                </div>
                                <div class="form-group">
                                  <label >Periode</label>
                                  <input  type="text"  class="form-control" disabled value="{{$alumni->periode ? $alumni->periode : "-"}}">
                                </div>
                                <div class="form-group">
                                  <label >Jabatan</label>
                                  <input  type="text"  class="form-control" disabled value="{{$alumni->occupation ? $alumni->occupation : "-"}}">
                                </div>

                            </div>
                        </div>
                </div>
            </div>
        </div>

@endsection

@push('scripts')

<script>
  const images = document.querySelectorAll(".image-cover");
  
  for (let i = 0; i < images.length; i++) {
    const eventName = images[i].alt;
    const element = images[i];

    if(eventName) {
      element.src = `https://ui-avatars.com/api/?name=${eventName}&size=280`
    }

    
  }



</script>
@endpush