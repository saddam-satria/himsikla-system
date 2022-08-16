@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Edit Link Sertifikat</h3>
                  </div>
                  <form method="POST" action="{{route("dashboard.admin.event.update", ["event" => $certificate->id]) . "?action=certificate"}}">
                    @csrf
                    @method("PUT")
                    <div class="card-body">
                        <div class="form-group">
                            <label for="link">Link Sertifikat</label><span class="text-danger">*</span>
                            <input value="{{$certificate->link}}" type="text" name="link" id="link" class="form-control" placeholder="Link gdrive sertifikat">
                        </div>
                        @include('components.form_validation', ["field" => "link"])

                        
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Ubah</button>
                      <a href="{{route("dashboard.admin.event.edit", ["event" => $certificate->id]) . "?action=certificate&edit=event"}}" class="btn btn-md btn-primary">ubah acara</a>
                    </div>
                  </form>
                </div>
          
    
        
            </div>
        </div>
    </div>
@endsection
