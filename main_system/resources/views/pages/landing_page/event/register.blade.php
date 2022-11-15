@extends('layouts.landing_page')

@section('landing_page-content')
    <div style="margin: 5rem 0px">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-3">
                </div>
                <div class="col-12 col-md-6">
                   
                    <div class="d-flex flex-column align-items-center">
                        <div class="mb-5 d-flex flex-column align-items-center">
                            <img src="{{asset("android-chrome-192x192.png")}}" width="120" alt="">
                            <div class="pt-3">
                                <span class="text-lg text-bold text-capitalize">Pendaftaran Acara {{$event->eventName}}</span>
                            </div>
                        </div>
                        <form action="{{route("event.register", $event->id)}}" method="POST" style="width: 100%;">

                            <div class="card card-body">
                                @csrf
                                @method("POST")

                                <div class="form-group">
                                    <label for="email">Email Anda</label><span class="text-danger">*</span>
                                    <input style="width: 100%;" value="{{$email}}" readonly type="text" id="email" name="email" class="form-control rounded"  placeholder="Masukkan Email Anda...">
                                </div>
                               
                                <div class="form-group">
                                    <label for="nim">NIM</label><span class="text-danger">*</span>
                                    <input value="{{old("nim")}}" type="text" name="nim" id="nim" class="form-control" placeholder="NIM Peserta">
                                </div>
                                @include('components.form_validation', ["field" => "nim"])
        
                                <div class="form-group">
                                    <label for="university">Universitas</label><span class="text-danger">*</span>
                                    <input value="{{old("university")}}" type="text" name="university" id="university" class="form-control" placeholder="Universitas Peserta">
                                </div>
                                @include('components.form_validation', ["field" => "university"])

                                <div style="width: 100%;">
                                    <button type="submit" style="width: 100%;" class="btn btn-primary btn-md">Submit</button>
                                </div>

                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
