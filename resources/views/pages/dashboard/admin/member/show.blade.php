
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
                                        src={{asset("assets/member/profile" . "/" . $member->image)}}
                                        alt="{{!is_null($member->image) ? null : substr($member->name, 0, 2)}}" width="260px"  />
                                </div>
                                <h3 class="profile-username text-center text-capitalize">{{$member->name ? $member->name : "-"}}</h3>
                                <p class="text-muted text-center text-uppercase" >{{$member->occupation ? $member->occupation : "-"}}</p>

                                <div class="form-group">
                                  <label >NIM Anggota</label>
                                  <input  type="text"  class="form-control" disabled value="{{$member->nim ? $member->nim : "-"}}">
                                </div>
                                <div class="form-group">
                                  <label >Email</label>
                                  <input  type="text"  class="form-control" disabled value="{{$member->email ? $member->email : "-"}}">
                                </div>
                                <div class="form-group">
                                  <label >No Handphone</label>
                                  <input  type="text"  class="form-control" disabled value="{{$member->phoneNumber ? $member->phoneNumber : "-"}}">
                                </div>
                                <div class="form-group">
                                  <label >Universitas</label>
                                  <input  type="text"  class="form-control" disabled value="{{$member->university ? $member->university : "-"}}">
                                </div>
                                <div class="form-group">
                                  <label >Jenis Kelamin</label>
                                  <input type="text"  class="form-control" disabled value="{{$member->gender ? $member->gender : "-"}}">
                                </div>
                                <div class="form-group">
                                  <label >Masa Jabatan</label>
                                  <input type="text"  class="form-control" disabled value="{{$member->periode ? $member->periode : "-"}}">
                                </div>
                                <div class="form-group">
                                  <label >Token Anggota</label>
                                  <input type="text"  class="form-control" disabled value="{{$member->token ? $member->token : "-"}}">
                                </div>
                                <div class="form-group">
                                  <label>Alamat Anggota</label>
                                  <textarea
                                    class="form-control"
                                    rows="3"
                                    cols="3"
                                    style="resize: none;"
                                    disabled
                                  >{{$member->address ? $member->address : "-"}}</textarea>
                                </div>

                                <div>
                                  <a href="{{url("dashboard/admin/member/" . $member->id . "?" . "edit=occupation" )}}" class="btn btn-md btn-primary">ubah jabatan</a>
                                  <a href="{{url("dashboard/admin/member/" . $member->id . "?" . "edit=user" )}}" class="btn btn-md btn-primary">ubah user</a>
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