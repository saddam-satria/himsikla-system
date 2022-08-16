@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Edit Data Pembayaran Kas</h3>
                  </div>
                
                  <form method="POST" action="{{route("dashboard.admin.detail_finance.update", $finance->id)}}">
                    @csrf
                    @method("PUT")
                    <div class="card-body">

                        <div class="form-group">
                            <label >Nama Anggota</label>
                            <input  type="text"  class="form-control" disabled value="{{$finance->name ? $finance->name : "-"}}">
                        </div>


                        <div class="form-group">
                            <label for="cash">Jumlah Yang Dibayarkan</label><span class="text-danger">*</span>
                            <input value="{{$finance->cash}}" type="text" name="cash" id="cash"  class="form-control field-number" placeholder="Nominal Pembayaran (1000)">
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

                        <div class="form-group">
                            <label for="status">Status Pembayaran</label><span class="text-danger">*</span>
                                <select id="status" name="status" class="custom-select">
                                    <option class="text-capitalize" value="{{1}}">Lunas</option>
                                    <option class="text-capitalize" value="{{2}}">Belum Lunas</option>
                                </select>
                        </div>
                        @include('components.form_validation', ["field" => "status"])


                        <div class="form-group">
                            <label >Tagihan Kas</label>
                            <input  type="text"  class="form-control" disabled value="{{$finance->finance_id ? $finance->finance_id : "-"}}">
                        </div>

                    </div>
                    
                    
                  
    
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <a href="{{route("dashboard.admin.detail_finance.edit",$id) . "?edit=receipt"}}" class="btn btn-md btn-primary">Edit Bukti</a>
                    </div>
                    
                  </form>
                </div>
          
    
        
            </div>
        </div>
    </div>
@endsection
