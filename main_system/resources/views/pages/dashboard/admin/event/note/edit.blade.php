@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Edit Notulensi</h3>
                  </div>
                
                  <form method="POST" action="{{route("dashboard.admin.event_note.update", ["event_note" => $event_note->id])}}" >
                    @csrf
                    @method("PUT")
                    <div class="card-body">
                      <div class="form-group">
                          <label>Notulensi</label><span class="text-danger">*</span>
                          <textarea
                            class="form-control"
                            rows="7"
                            placeholder="Notulensi"
                            cols="3"
                            style="resize: none;"
                            name="note"
                          >{{$event_note->note}}</textarea>
                      </div>
                      @include('components.form_validation', ["field" => "note"])

                    </div>

                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                  </form>
              </div>
          
    
        
            </div>
        </div>
    </div>
@endsection


