@extends('layouts.dashboard')

@section('dashboard-content')

    @include('components.alert')
    <div class="container-fluid">
        <section class="px-2">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                        <div class="my-3">
                            <div class="my-3">
                                <img src="{{is_null(auth()->user()->member->image) ? "https://ui-avatars.com/api/?name=" . auth()->user()->member->name . "&size=280" : asset("assets/member/profile". "/" . auth()->user()->member->image ) }}" class="img-thumbnail" width="240" alt="profile account">
                            </div>
                          
                            <h3>Informasi Profile Anggota</h3>
                     
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    

                                    <div class="form-group">
                                        <label >Nama Anggota</label>
                                        <input  type="text"  class="form-control" disabled value="{{auth()->user()->member->name}}">
                                    </div>

                                    <div class="form-group">
                                        <label >No Telepon</label>
                                        <input  type="text"  class="form-control" disabled value="{{auth()->user()->member->phoneNumber}}">
                                    </div>
    
                                    <div class="form-group">
                                        <label >Jenis Kelamin</label>
                                        <input  type="text"  class="form-control" disabled value="{{auth()->user()->gender}}">
                                    </div>
    
                                    <div class="form-group">
                                        <label >NIM </label>
                                        <input  type="text"  class="form-control" disabled value="{{auth()->user()->member->nim}}">
                                    </div>
    
                                    <div class="form-group">
                                        <label >Masa Jabatan </label>
                                        <input  type="text"  class="form-control" disabled value="{{auth()->user()->member->periode}}">
                                    </div>
    
                                    <div class="form-group">
                                        <label >Jabatan</label>
                                        <input  type="text"  class="form-control" disabled value="{{auth()->user()->member->occupation}}">
                                    </div>
    
                                    <div class="form-group">
                                        <label >Token </label>
                                        <input  type="text"  class="form-control" disabled value="{{auth()->user()->member->token}}">
                                    </div>

                                    <div class="form-group">
                                        <label >Alamat </label>
                                        <textarea  type="text"  class="form-control" disabled rows="3" cols="3" style="resize: none">{{auth()->user()->member->address}}</textarea>
                                    </div>
    
                                    
                                    <div class="my-2 d-flex">
                                        <div class="ml-auto">
                                            <a href="{{route("dashboard.user.member.profile.edit")}}" class="btn btn-sm btn-primary">Ubah Data</a>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                          
                        </div>

                    </div>
                </div>
        </section>
    </div>
@endsection