@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Tambah Acara Baru</h3>
                  </div>
                
                  <form method="POST" action="{{route("dashboard.admin.gallery.store")}}" enctype="multipart/form-data">
                    @csrf
                    @method("POST")
                    <div class="card-body">

                      @include('components.input_image', ["field" => "image"])
      

               

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