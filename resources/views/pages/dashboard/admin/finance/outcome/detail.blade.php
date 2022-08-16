
@extends('layouts.dashboard')

@section('dashboard-content')

        <div class="container-fluid">
          @include('components.alert')

            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                               
                                <div class="form-group">
                                  <label >Tanggal Pemasukan</label>
                                  <input  type="text"  class="form-control" disabled value="{{$outcome->date}}">
                                </div>

                                <div class="form-group">
                                  <label >Total Pemasukan</label>
                                  <input  type="text"  class="form-control" disabled value="{{number_format($outcome->total)}}">
                                </div>

                                <div class="form-group">
                                  <label>Deskripsi</label>
                                  <textarea
                                    class="form-control"
                                    rows="3"
                                    cols="3"
                                    style="resize: none;"
                                    disabled
                                  >{{$outcome->description ? $outcome->description : "-"}}</textarea>
                                </div>
        
                            </div>
                        </div>
                </div>
                </div>
            </div>
        </div>

@endsection