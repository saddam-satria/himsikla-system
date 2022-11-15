@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
      @include('components.alert')

        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Tambah Data Pembayaran Kas</h3>
                  </div>
                
                  <form method="POST" action="{{route("dashboard.member.finance.store")}}" enctype="multipart/form-data">
                    @csrf
                    @method("POST")
                    <div class="card-body">

                     
                        <div class="form-group">
                          <label for="finance_id">Kode Kas</label><span class="text-danger">*</span>
                          <input value="{{old("finance_id")}}" type="text" name="finance_id" id="finance_id" class="form-control"  placeholder="Masukkan Kode Kas">
                        </div>
                        @include('components.form_validation', ["field" => "finance_id"])

                        <div class="form-group">
                            <label for="cash">Nominal Pembayaran</label><span class="text-danger">*</span>
                            <input value="{{old("cash")}}" type="text" name="cash" id="cash"  class="form-control field-number" placeholder="Nominal Pembayaran (1000)">
                        </div>
                        @include('components.form_validation', ["field" =>"cash"])

                        <div class="form-group">
                            <label for="paymentMethod">Metode Pembayaran</label><span class="text-danger">*</span>
                                <select id="paymentMethod" name="paymentMethod" class="custom-select">
                                    @foreach ($paymentMethods as $paymentMethod)
                                      <option class="text-uppercase" value="{{$paymentMethod}}">{{$paymentMethod}}</option>
                                    @endforeach  
                                </select>
                        </div>
                        @include('components.form_validation', ["field" => "paymentMethod"])

                        <div class="my-2">
                            <Label for="image">
                                Foto Bukti Pembayaran
                            </Label>
                            @include('components.input_image', ["field" => "image"])
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

