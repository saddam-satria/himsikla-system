@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Edit Data Neraca</h3>
                  </div>
                
                  <form method="POST" action="{{route("dashboard.admin.balance_sheet.update", $balance->id)}}">
                    @csrf
                    @method("PUT")
                    <div class="card-body">

                      <div class="form-group">
                        <label for="month">Bulan</label><span class="text-danger">*</span>
                          <select id="month" name="month" class="custom-select">
                                @foreach ($months as $month)
                                  <option class="text-uppercase" value="{{$month}}">{{$month}}</option>
                                @endforeach  
                          </select>
                      </div>
                      @include('components.form_validation', ["field" => "month"])
                     
                 
                      <div class="form-group">
                        <label for="debit">Debit</label><span class="text-danger">*</span>
                        <input value="{{is_null($balance->debit) ? 0 : $balance->debit}}" type="text" name="debit" id="debit"  class="form-control field-number" placeholder="Nominal Debit (1000)">
                      </div>
                      @include('components.form_validation', ["field" =>"debit"])

                      
                      <div class="mb-3">
                        <button type="button" class="btn btn-sm btn-primary btn-data" data-toggle="modal" data-target="#pemasukan">Ambil Data Pemasukan</button>
                      </div>

                      @include('components.input_number', ["field" => "kredit", "placeholder" => "Nominal Kredit (1000)", "label" => "Kredit", "updated" => is_null($balance->kredit) ? 0 :$balance->kredit ])

                      <div class="mb-3">
                        <button type="button" class="btn btn-sm btn-primary btn-data" data-toggle="modal" data-target="#pengeluaran">Ambil Data Pengeluaran</button>
                      </div>

                      <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea
                          class="form-control"
                          rows="3"
                          placeholder="Catatan"
                          cols="3"
                          style="resize: none;"
                          name="note"
                        >{{$balance->note}}</textarea>
                      </div>
                      @include('components.form_validation', ["field" => "note"])

                    </div>
                    
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    
                  </form>
                </div>
          
    
                <div class="modal fade modal-data" id="pemasukan" tabindex="-1" role="dialog" aria-labelledby="pemasukan" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Data Pemasukan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group">
                          @if (count($incomes) > 0)
                            <select id="income" class="custom-select">
                                @foreach ($incomes as $income)
                                  <option class="text-lowercase" value="{{$income->total}}">{{$income->date . " - " . $income->total . " - " . $income->description}}</option>
                                  @endforeach
                            </select>
                          @else
                            <input type="text"  class="form-control" disabled placeholder="Data Pemasukan Kosong">
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
        
                <div class="modal fade modal-data" id="pengeluaran" tabindex="-1" role="dialog" aria-labelledby="pengeluaran" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Data Pengeluaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group">
                          @if (count($outcomes) > 0)
                            <select id="outcome" class="custom-select">
                                @foreach ($outcomes as $outcome)
                                  <option class="text-lowercase" value="{{$outcome->total}}">{{$outcome->date . " - " . $outcome->total . " - " . $outcome->description}}</option>
                                  @endforeach
                            </select>
                          @else
                            <input type="text"  class="form-control" disabled placeholder="Data Pengeluaran Kosong">
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
        
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
      const debit = document.querySelector("#debit");
      const kredit = document.querySelector("#kredit");
      const income = document.querySelector("#income");
      const outcome = document.querySelector("#outcome");
      
      income && income.addEventListener("change", function(e){
        debit.value = e.target.value;
      })

      outcome && outcome.addEventListener("change", function(e){
        kredit.value = e.target.value;
      })
      
    </script>
@endpush