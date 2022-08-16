@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Edit Notulensi Pertemuan</h3>
                  </div>
                
                  <form method="POST" action="{{route("dashboard.admin.meet_note.update", $meet->id) . "?edit=meet"}}" >
                    @csrf
                    @method("PUT")
                    <div class="card-body">


                        <div class="form-group">
                            <label>Notulensi Pertemuan</label>
                            <textarea
                              class="form-control"
                              rows="3"
                              cols="3"
                              style="resize: none;"
                              disabled
                            >{{!is_null($meet->note) ? $meet->note : "-"}}</textarea>
                        </div>

                      <div class="form-group" >
                        <label for="meet_id">Pertemuan</label>
                        @if (count($meets) > 0)
                          <select id="meet_id" name="meet_id" class="custom-select">
                                @foreach ($meets as $meet)
                                  <option class="text-lowercase" value="{{$meet->id}}">{{$meet->meetName}}</option>
                                @endforeach  
                          </select>
                        @else
                          <input type="text" name="meet_id" class="form-control bg-transparent text-capitalize" disabled placeholder="Acara Tidak Di temukan">
                        @endif
                      </div>
                      @include('components.form_validation', ["field" => "meet_id"])

                    </div>

                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                  </form>
              </div>
          
    
        
            </div>
        </div>
    </div>
@endsection


