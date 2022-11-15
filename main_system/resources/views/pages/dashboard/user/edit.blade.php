@extends('layouts.dashboard')

@section('dashboard-content')

    @include('components.alert')
    <div class="container-fluid">
        <section class="px-2">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                        <div class="my-3">
                            <h3>Ubah Informasi Akun</h3>
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <form action="{{route("dashboard.user.profile.update")}}" method="POST">
                                    @csrf
                                    @method("POST")

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input value="{{auth()->user()->email}}" type="text" name="email" id="email" class="form-control" placeholder="masukan email">
                                    </div>
                                    @include('components.form_validation', ["field" => "email"])
                                  
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <select id="gender" name="gender" class="custom-select">
                                            @foreach ($gender as $gender)
                                                <option class="text-capitalize" value="{{$gender}}">{{$gender}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                         
                                    <div class="form-group">
                                        <label for="university">universitas/instansi/perusahaan</label><span class="text-danger">*</span>
                                        <input value="{{is_null(auth()->user()->member) ? auth()->user()->university : "kaliabang"}}"  type="text" name="university" value="kaliabang" id="university" class="form-control" placeholder="University" {{!is_null(auth()->user()->member) ? "readonly" : ""}}>
                                    </div>
                                    @include('components.form_validation', ["field" => "university"])
                                
                                    
                                    <div class="my-2 d-flex">
                                        <div class="ml-auto">
                                           <button type="submit" class="btn btn-md btn-primary">Update</button>
                                        </div>
                                    </div>

                                    </form>        
                                </div>
                            </div>

                          
                        </div>

                    </div>
                </div>
        </section>
    </div>
@endsection

