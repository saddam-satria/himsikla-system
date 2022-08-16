@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Tambah Data Pemasukan</h3>
                  </div>
                
                  <form method="POST" action="{{route("dashboard.admin.income.store")}}">
                    @csrf
                    @method("POST")
                    <div class="card-body">

                      <div class="form-group">
                        <label for="date">Tanggal Pemasukan</label><span class="text-danger">*</span>
                        <input value="{{old("date")}}" type="date" name="date" id="date" class="form-control">
                      </div>
                      @include('components.form_validation', ["field" => "date"])

                      @include('components.input_number', ["field" => "total", "placeholder" => "Nominal Angka(10200)" , "label" => "Total Pemasukan"])
                      
                      <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea
                          class="form-control"
                          rows="3"
                          placeholder="Deskripsi"
                          cols="3"
                          style="resize: none;"
                          name="description"
                        >{{old("description")}}</textarea>
                      </div>
                      @include('components.form_validation', ["field" => "description"])

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
