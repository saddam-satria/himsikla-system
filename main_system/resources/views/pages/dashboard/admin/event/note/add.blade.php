@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Tambah Notulensi Acara</h3>
                  </div>
                
                  <form method="POST" action="{{route("dashboard.admin.event_note.store")}}" >
                    @csrf
                    @method("POST")
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
                          >{{old("note")}}</textarea>
                      </div>
                      @include('components.form_validation', ["field" => "note"])

                      <div class="form-group" >
                        <label for="event_id">Acara</label>
                        @if (count($events) > 0)
                          <select id="event_id" name="event_id" class="custom-select">
                                @foreach ($events as $event)
                                  <option class="text-lowercase" value="{{$event->id}}">{{$event->eventName}}</option>
                                @endforeach  
                          </select>
                        @else
                          <input type="text" name="event_id" class="form-control bg-transparent text-capitalize" disabled placeholder="Acara Tidak Di temukan">
                        @endif
                      </div>
                      @include('components.form_validation', ["field" => "event_id"])

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


