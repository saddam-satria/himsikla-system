
@extends('layouts.dashboard')

@section('dashboard-content')
        <div class="container-fluid">
            @include('components.alert')
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                               
                                <div class="form-group">
                                  <label >Nama Acara</label>
                                  <input  type="text"  class="form-control" disabled value="{{$event->name}}">
                                </div>
                                
                                <div class="form-group">
                                  <label>Notulensi</label>
                                  <textarea
                                    class="form-control"
                                    rows="7"
                                    cols="3"
                                    style="resize: none;"
                                    disabled 
                                  >{{$event->note}}</textarea>
                                </div>

                            </div>
                        </div>
                </div>
            </div>
        </div>

@endsection