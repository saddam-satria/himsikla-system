@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Tambah Data Pembayaran Kas</h3>
                  </div>
                
                  <form method="POST" action="{{route("dashboard.admin.detail_finance.store")}}" enctype="multipart/form-data">
                    @csrf
                    @method("POST")
                    <div class="card-body">

                        <div class="my-2">
                            <Label for="image">
                                Foto Bukti Pembayaran
                            </Label>
                            @include('components.input_image', ["field" => "image"])
                        </div>


                        <div class="form-group">
                            <label for="member_id">Anggota</label><span class="text-danger">*</span>
                            @if (count($members) > 0) 
                                <select id="member_id" name="member_id" class="custom-select">
                                    @foreach ($members as $member)
                                    <option class="text-uppercase" value="{{$member->id}}">{{$member->name . " - " . $member->nim}}</option>
                                    @endforeach  
                                </select>
                            @else
                                <input type="text" name="member_id" class="form-control bg-transparent text-capitalize" disabled placeholder="Member Tidak Di temukan">
                            @endif
                               
                                
                        </div>
                        @include('components.form_validation', ["field" => "member_id"])


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

                        <div class="form-group">
                            <label for="status">Status Pembayaran</label><span class="text-danger">*</span>
                            <select id="status" name="status" class="custom-select">
                                    <option class="text-capitalize" value="{{1}}">Lunas</option>
                                    <option class="text-capitalize" value="{{2}}">Belum Lunas</option>
                            </select>
                        </div>
                        @include('components.form_validation', ["field" => "status"])

                        <div class="form-group">
                            <label for="finance_id">Kas</label><span class="text-danger">*</span>
                            @if (count($finances) > 0) 
                                <select id="finance_id" name="finance_id" class="custom-select">
                                    @foreach ($finances as $finance)
                                    <option class="text-uppercase" value="{{$finance->id}}">{{date_format(date_create($finance->month), "F Y") . " - " . $finance->price}}</option>
                                    @endforeach  
                                </select>
                            @else
                                <input type="text" name="finance_id" class="form-control bg-transparent text-capitalize" disabled placeholder="Kas Tidak Di temukan">
                            @endif
                               
                                
                        </div>
                        @include('components.form_validation', ["field" => "finance_id"])


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
