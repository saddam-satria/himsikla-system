@extends('layouts.dashboard')

@section('dashboard-content')

    @include('components.alert')
    <div class="container-fluid">
        <section class="px-2">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <form action="{{route("dashboard.user.member.profile.update")}}" method="POST" enctype="multipart/form-data">
                        <div class="my-3">

                            <div class="mb-3">
                                <Label for="image">
                                    Foto Profile
                                  </Label>
                                  @include('components.input_image', ["field" => "image", "defaultImage" => !is_null(auth()->user()->member->image) ? asset("assets/member/profile") . "/" . auth()->user()->member->image : null])
                            </div>

                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    
                                        @csrf
                                        @method("POST")


                                        <div class="form-group">
                                            <label for="name">Nama Anggota</label>
                                            <input value="{{auth()->user()->member->name}}" type="text" name="name" id="name" class="form-control"  placeholder="masukan nama">
                                        </div>
                                        @include('components.form_validation', ["field" => "name"])

    
                                        <div class="form-group">
                                            <label for="phoneNumber">No Telepon</label>
                                            <input value="{{auth()->user()->member->phoneNumber}}" name="phoneNumber" id="phoneNumber"  type="text"  class="form-control">
                                        </div>
                                        @include('components.form_validation', ["field" => "phoneNumber"])

        
                                        <div class="form-group">
                                            <label for="nim">NIM </label>
                                            <input value="{{auth()->user()->member->nim}}" name="nim" id="nim"  type="text"  class="form-control">
                                        </div>
                                        @include('components.form_validation', ["field" => "nim"])

        
    
                                        <div class="form-group">
                                            <label for="address">Alamat </label>
                                            <textarea value="{{auth()->user()->member->address}}" name="address" id="address"  type="text"  class="form-control"  rows="3" cols="3" style="resize: none">alamat</textarea>
                                        </div>
                                        @include('components.form_validation', ["field" => "address"])


                                        <div class="my-2 d-flex">
                                            <div class="ml-auto">
                                                <button type="submit" class="btn btn-md btn-primary">Update</button>
                                            </div>
                                        </div>
                                    
                                </div>
                            </div>

                          
                        </div>
                     </form>
                    </div>
                </div>
        </section>
    </div>
@endsection