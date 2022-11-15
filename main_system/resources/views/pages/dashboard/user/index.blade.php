@extends('layouts.dashboard')

@section('dashboard-content')

    <div class="container-fluid">
        <section class="px-2">
            @include('components.alert')
            <div class="row">
                <div class="col-sm-12 col-md-6">
                        <div class="my-3">
                            <h3>Informasi Akun</h3>
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
    
                                    <div class="form-group">
                                        <label >Email</label>
                                        <input  type="text"  class="form-control" disabled value="{{auth()->user()->email}}">
                                    </div>
    
                                    @if (!is_null(auth()->user()->member))
                                        <div class="form-group">
                                            <label >No Telepon</label>
                                            <input  type="text"  class="form-control" disabled value="{{auth()->user()->member->phoneNumber}}">
                                        </div>
                                    @endif
    
                                    <div class="form-group">
                                        <label >Jenis Kelamin</label>
                                        <input  type="text"  class="form-control" disabled value="{{auth()->user()->gender}}">
                                    </div>
    
                                    <div class="form-group">
                                        <label >Universitas</label>
                                        <input  type="text"  class="form-control" disabled value="{{auth()->user()->university}}">
                                    </div>
                                    
                                    <div class="my-2 d-flex">
                                        <div class="ml-auto">
                                            <a href="{{route("dashboard.user.profile.edit")}}" class="btn btn-sm btn-primary">Ubah Data</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                          
                        </div>

                        <div class="my-5">
                             <h3>Ubah Password</h3>
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <form action="{{route("dashboard.user.profile.update") . "?action=password"}}" method="POST">
                                        @csrf
                                        @method("POST")
                                        <div class="form-group">
                                            <label for="password">Password Lama</label>
                                            <input name="password" id="password" class="form-control" placeholder="********" type="password">
                                        </div>
                                        @include('components.form_validation', ["field" => "password"])

        
                                        <div class="form-group">
                                            <label for="new_password">Password Baru </label>
                                            <input name="new_password" id="new_password"  class="form-control" placeholder="********"  type="password">
                                        </div>
                                        @include('components.form_validation', ["field" => "new_password"])

        
                                        <div class="form-group">
                                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                                            <input name="password_confirmation" id="password_confirmation"  class="form-control" placeholder="********"  type="password">
                                        </div>
                                        @include('components.form_validation', ["field" => "password_confirmation"])


                                        <div class="my-2 d-flex">
                                            <div class="ml-auto">
                                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
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