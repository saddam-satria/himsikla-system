@extends('layouts.dashboard')

@section('dashboard-content')
    @include('components.alert')
    <div class="container-fluid">
        @if (count($galleries) > 0)
                <div class="row">
                @foreach ($galleries as $gallery)
                <div class="col-12 col-md-6 col-lg-4 mt-3">
                    <div class="card">
                        <img src="{{asset("assets/gallery" . "/" . $gallery->image)}}" style="object-fit: cover; height: 100%;" class="img-fluid rounded shadow" alt="">
                        <div class="card-footer d-flex">
                            <div class="ml-auto">
                               <form method="POST" action="{{route("dashboard.admin.gallery.destroy", $gallery->id)}}">
                                @csrf
                                @method("DELETE")
                                    <button type="submit" class="btn btn-sm">
                                        <i class="fas fa-trash text-danger text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="d-flex flex-column py-5 justify-content-center align-items-center">
                <img src="{{asset("assets/img/biro-blue-camera-with-flash-on-orange-strap-1.png")}}" style="height: 100%; object-fit: contain;" width="330" alt="" />
                <span class="py-2 text-lg text-dark text-bold">Belum Ada Album</span>
            </div>
        @endif

    </div>
@endsection