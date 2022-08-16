@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Edit Notulensi Pertemuan</h3>
                  </div>
                
                  <form method="POST" action="{{route("dashboard.admin.meet_note.update", $meet->id)}}" >
                    @csrf
                    @method("PUT")
                    <div class="card-body">

                      <div class="form-group">
                          <label>Notulensi</label><span class="text-danger">*</span>
                          <textarea
                            class="form-control"
                            rows="3"
                            placeholder="Notulensi"
                            cols="3"
                            style="resize: none;"
                            name="note"
                          >{{$meet->note}}</textarea>
                      </div>
                      @include('components.form_validation', ["field" => "note"])

                    </div>

                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <a class="btn btn-md btn-primary" href="{{route("dashboard.admin.meet_note.edit", $meet->id) . "?edit=meet"}}">Edit Pertemuan</a>
                    </div>
                  </form>
              </div>
          
    
        
            </div>
        </div>
    </div>
@endsection


