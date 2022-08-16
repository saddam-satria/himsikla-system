@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Edit Bukti Pembayaran Kas</h3>
                  </div>
                
                  <form method="POST" action="{{route("dashboard.admin.detail_finance.update", $finance->id) . "?edit=receipt"}}" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="card-body">

                        <div class="my-2">
                            <Label for="image">
                                Foto Bukti Pembayaran
                            </Label>
                            @include('components.input_image', ["field" => "image", "defaultImage" => asset("assets/bukti-pembayaran/" . $finance->image)])
                        </div>

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
