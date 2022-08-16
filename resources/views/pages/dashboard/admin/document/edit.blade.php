@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Edit Dokumen</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form method="POST" action="{{route("dashboard.admin.document.update", $document->id)}}" >
                    @csrf
                    @method("PUT")

                    <div class="card-body">
                        
                      <div class="form-group">
                        <label for="name">Nama Dokumen</label><span class="text-danger">*</span>
                        <input value="{{$document->documentName}}" type="text" name="name" id="name" class="form-control"  placeholder="Masukkan Nama Dokumen">
                      </div>
                      @include('components.form_validation', ["field" => "name"])

                     
                    </div>
                    <!-- /.card-body -->
    
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                  </form>
                </div>
                <!-- /.card -->
    
        
            </div>
        </div>
    </div>
@endsection
