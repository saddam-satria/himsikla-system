@extends('layouts.dashboard')

@section('dashboard-content')

    <div class="container-fluid">
        @include('components.alert')

        @if (count($documents)  > 0)
        <div class="row">
            @foreach ($documents as $document)
            <div class="col-12 col-md-6 col-lg-2 mt-2">
                <div class="card p-3 shadow" style="height: 100%; background-color: rgb(255, 255, 255); border-radius: 20px">
                    <div class="d-flex justify-content-center mb-4">
                        <div class="p-4 rounded shadow-sm" style="background-color: rgb(232, 232, 255)">
                            <i class="fas fa-file-pdf" style="font-size: 2em"></i>
                        </div>
                    </div>
                    <div class="px-3 d-flex align-items-center">
                        <div class="d-flex flex-column">
                            <h5 style="color: #2f338c;" class="text-md text-bold text-capitalize"><a  target="__blank" href="{{asset("assets/document" . "/" . $document->document)}}">{{strlen($document->documentName) > 10 ? substr($document->documentName, 0, 10) : $document->documentName}}</a></h5>
                            <span class="text-sm" style="color: rgb(151, 151, 151);">{{ Carbon\Carbon::parse($document->createdAt)->diffForHumans()}}</span>
                        </div>
                        <div class="ml-auto">
                            <div class="dropdown">
                            <button class="btn btn-sm type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <div class="d-flex flex-column">
                                <div class="rounded-circle bg-dark" style="padding: 2px; margin-bottom: 3px;"></div>
                                <div class="rounded-circle bg-dark" style="padding: 2px; margin-bottom: 3px;"></div>
                                <div class="rounded-circle bg-dark" style="padding: 2px; margin-bottom: 3px;"></div>
                               </div>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <form action="{{route("dashboard.user.member.document.download", str_replace("/", "_", $document->document))}}" method="POST">
                                    @csrf
                                    @method("POST")
                                    <button type="submit" class="btn btn-sm">Download</button>
                                </form>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
            <div class="d-flex flex-column align-items-center justify-content-center" style="height: 80vh">
                <img src="{{asset("assets/img/clip-library-1.png")}}" alt="data-not-found" class="img-fluid" width="480"/>
                <div class="py-5">
                    <h5 class="text-capitalize">Tidak Ada Dokumen</h5>
                </div>
            </div>
        @endif
    </div>
@endsection


