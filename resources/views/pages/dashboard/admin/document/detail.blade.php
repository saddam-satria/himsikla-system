div
@extends('layouts.dashboard')

@section('dashboard-content')

        <div class="container-fluid">
          @include('components.alert')

            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                              
                                <div class="form-group">
                                    <label >ID Document</label>
                                    <input  type="text"  class="form-control" disabled value="{{$document->id ? $document->id : "-"}}">
                                </div>

                                <div class="form-group">
                                  <label >Nama Dokumen</label>
                                  <input  type="text"  class="form-control" disabled value="{{$document->documentName ? $document->documentName : "-"}}">
                                </div>

                                <div class="form-group">
                                    <label >Dokumen Di Buat</label>
                                    <input  type="text"  class="form-control" disabled value="{{$document->createdAt ? $document->createdAt : "-"}}">
                                </div>
                                
                                <a target="__blank" href="{{asset("assets/document/" . $document->document)}}" class="btn btn-md btn-primary">Download</a>
                               
                            </div>
                        </div>
                </div>
                </div>
            </div>
        </div>

@endsection