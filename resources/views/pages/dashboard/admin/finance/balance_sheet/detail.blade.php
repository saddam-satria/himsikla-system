
@extends('layouts.dashboard')

@section('dashboard-content')

        <div class="container-fluid">
          @include('components.alert')

            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                               
                                <div class="form-group">
                                  <label >Bulan</label>
                                  <input  type="text"  class="form-control" disabled value="{{$balance->month}}">
                                </div>

                                <div class="form-group">
                                  <label >Total Debit</label>
                                  <input  type="text"  class="form-control" disabled value="{{$balance->debit}}">
                                </div>

                                <div class="form-group">
                                  <label >Total Kredit</label>
                                  <input  type="text"  class="form-control" disabled value="{{$balance->kredit}}">
                                </div>

                                <div class="form-group">
                                  <label>Catatan</label>
                                  <textarea
                                    class="form-control"
                                    rows="3"
                                    cols="3"
                                    style="resize: none;"
                                    disabled
                                  >{{$balance->note ? $balance->note : "-"}}</textarea>
                                </div>
        
                            </div>
                        </div>
                </div>
                </div>
            </div>
        </div>

@endsection