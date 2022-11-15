@extends('layouts.dashboard')

@section('dashboard-content')
    @include('components.alert')
    <div class="container-fluid">
        <div class="row">
            @foreach ($members as $member)
            <div class="col-sm-12 col-md-4 mt-2">
                <div class="card px-3 py-4 rounded shadow" style="width: 100%; height: 100%;">
                    <div class="card-header my-3" style=" height: 30vh; background-repeat: no-repeat; background-size: cover; background-position: center; background-image: url({{asset("assets/img"). "/" .  $image }})">

                    </div>
                    <div class="d-flex">
                        <div class="d-flex flex-column">
                            <h4 class="text-uppercase">{{$member->name}}</h4>
                            <span style="color: rgb(204, 204, 204);" class="text-uppercase">{{$member->occupation . " / " . $member->periode}}</span>
                            <div class="my-2">
                                <span>{{$member->nim}}</span>
                            </div>
                            <div class="d-flex flex-column">
                                <div>
                                    <span class="btn btn-sm btn-success" style="font-size: 1em; cursor: default;">{{$member->phoneNumber}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="ml-auto">                    
                            <img style="height: 120px; object-fit: cover" src="{{is_null($member->image) ? "https://ui-avatars.com/api/?name=" . $member->name . "&size=120" : asset("assets/member/profile/" . $member->image ) }}" width="120" class="img-fluid rounded-circle image-cover"  alt="{{$member->name}}">
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection


