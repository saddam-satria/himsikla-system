@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Edit Data Kas</h3>
                  </div>
                
                  <form method="POST" action="{{route("dashboard.admin.finance.update", $finance->id)}}">
                    @csrf
                    @method("PUT")
                    <div class="card-body">

                      <div class="form-group">
                        <label for="month">Kas Bulan</label><span class="text-danger">*</span>
                        <input value="{{$finance->month}}" type="month" name="month" id="month" class="form-control">
                      </div>
                      @include('components.form_validation', ["field" => "month"])

                      <div class="form-group">
                        <label for="payment">Metode Pembayaran</label><span class="text-danger">*</span>
                        <input value="{{$finance->payment}}" type="text" name="payment" id="payment" class="form-control" placeholder="089999999 - OVO">
                        <span class="text-medium" style="font-size: 0.7em">No Rek / DANA / OVO / DLL - Nama Merchantnya (Bank Mandiri)</span>
                      </div>
                      @include('components.form_validation', ["field" => "payment"])
                      
                      <div class="form-group">
                        <label for="penalty">Nominal Denda (optional)</label>
                        <input value="{{$finance->penalty}}" type="text" name="penalty" id="penalty"  class="form-control field-number" placeholder="Nominal Pembayaran (1000)">
                        <span style="font-size: 0.8em">Isi 0, jika tidak ada denda</span>
                      </div>
                      @include('components.form_validation', ["field" =>"penalty"])


                      @include('components.input_number', ["field" => "price", "placeholder" => "Nominal Angka(10200)" , "label" => "Nominal Kas", "updated" => $finance->price])
                      
                      <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea
                          class="form-control"
                          rows="3"
                          placeholder="Deskripsi"
                          cols="3"
                          style="resize: none;"
                          name="description"
                        >{{$finance->description}}</textarea>
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
