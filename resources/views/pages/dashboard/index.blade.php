@extends('layouts.dashboard')

@section('dashboard-content')
  

   
 
      <div class="container-fluid">
        
        <div class="mb-3 shadow p-4" style="background-color: #552792; border-radius: 15px">
          <div class="row">
            <div class="col-sm-12 col-md-8">
              <div class="d-flex flex-column px-2 py-3">
                <h4 class="text-bold text-xl text-uppercase text-white" >Selamat Datang, {{explode(" ", auth()->user()->member->name)[0]}}</h4>
                <h5 class="text-uppercase text-md text-white" style="letter-spacing: 2px; color: #3a393f;">himsi smart system</h5>
                <div class="py-2">
                  <p class="text-justify text-sm text-lowercase" style="color: #eeeeee">
                    Dashboard Himsi KLA smart system dapat membantu tiap anggota untuk melakukan proses absensi pertemuan atau acara, pembayaran uang kas. sistem ini merupakan versi pertama, jika terdapat kendala, silahkan hubungi divisi pendidikan atau litbang. diharapkan setiap anggota dapat membantu mengembangkan sistem ini menjadi lebih baik lagi.
                  </p>
                </div>
              </div>
            </div>
            <div class="col-sm-12 col-md-4">
              <div class="ml-auto d-flex justify-content-center">
                <img src="{{asset("assets/img/community.png")}}" class="img-fluid" width="320" style="object-fit: cover; height: 220px;" alt="Background" />
              </div>
            </div>
          </div>
        </div>  

        <div class="row">
         
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-comments"></i></span>

              <div class="info-box-content">
                <span class="info-box-text text-md text-capitalize" style="font-weight: 600; color: #101248;">Pertemuan</span>
                <span class="info-box-number" style="font-weight: 700">{{$meet}}</span>
              </div>
             
            </div>
           
          </div>
         

         
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fa-solid fa-calendar"></i></span>
              <div class="info-box-content">
                <span class="info-box-text text-md text-capitalize" style="font-weight: 600; color: #101248;">Acara</span>
                <span class="info-box-number"  style="font-weight: 700">{{$event}}</span>
              </div>
             
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text text-md text-capitalize" style="font-weight: 600; color: #101248;">Anggota</span>
                <span class="info-box-number"  style="font-weight: 700">{{$member}}</span>
              </div>
            
            </div>
          
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text text-md text-capitalize" style="font-weight: 600; color: #101248;">Dokumen</span>
                <span class="info-box-number"  style="font-weight: 700">{{$document}}</span>
              </div>
            
            </div>
          
          </div>
        
        </div>
        
        <div class="my-3">
          <div class="row">
            <div class="col-sm-12 col-md-8">
              <div class="card" style="height: 100%; ">
                <div class="card-header" style="background-color: #101248;">
                  <h3 class="card-title text-white">Data Alumni</h3>
                </div>
                <div class="card-body">
                  @if (count($alumnis) > 0)
                    <div class="chart">
                      <canvas id="barChart" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
                    </div>
                  @else 
                    <div class="d-flex justify-content-center align-items-center">
                      <span class="text-danger">Belum Ada Data</span>
                    </div>
                  @endif

                 

                </div>
              </div>
            </div>
            <div class="col-sm-12 col-md-4">
              <div class="card card-success" style="height: 100%;">
                <div class="card-header" style="background-color: #101248;">
                  <h3 class="card-title text-white">Anggota Terbaru</h3>
                </div>
                <div class="card-body">

                  @if (count($members) > 0)

                    @foreach ($members as $member)
                      <div class="d-flex align-items-center px-3 mt-3">
                        <img src="{{is_null($member->image) ?  "https://ui-avatars.com/api/?name=" . $member->name . "&size=280"  : asset("assets/member/profile") . "/" . $member->image }}" class="img-fluid rounded-circle shadow" alt="Avatar" width="50" style="object-fit: cover; height: 50px;">
                        <div class="d-flex flex-column ml-2 px-3">
                          <span class="text-uppercase text-bold text-md" style="color: #4449ae">{{explode(" ", $member->name)[0]}}</span>
                          <span class="text-lowercase text-sm" style="color: rgba(94, 94, 94, 0.856);">{{$member->occupation}}</span>
                        </div>
                      </div>
                    @endforeach
                   
                  @else 

                    <div class="d-flex justify-content-center align-items-center">
                      <span class="text-danger">Belum Ada Data</span>
                    </div>

                  @endif
                </div>
              </div>
          </div>
        </div>

        <div class="my-3">
          <div class="row">

            <div class="col-12 col-md-8">
              <div class="card card-success">
                <div class="card-header" style="background-color: #101248;">
                  <h3 class="card-title text-white">Neraca Kas</h3>
                </div>
                <div class="card-body">
                  @if (count($balanceSheets) > 0)
                    <div class="chart">
                      <canvas id="lineChart" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
                    </div>
                  @else
                    <div class="d-flex justify-content-center align-items-center">
                      <span class="text-danger">Belum Ada Data</span>
                    </div>
                  @endif
                 
                </div>
              </div>
           
              @if (!is_null(auth()->user()->member))
              <div class="card">

                <div class="card-header border-transparent">
                  <h3 class="card-title">Riwayat Pembayaran Terbaru</h3>
                </div>
              
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table m-0">
                      <thead style="font-size: 14px;">
                        <tr>
                          <th scope="col">Bulan</th>
                          <th scope="col">Nominal Bayar</th>
                          <th scope="col">Metode Pembayaran</th>
                          <th scope="col">Status Pembayaran</th>
                        </tr>
                      </thead>
                      <tbody style="font-size: 12px;">
                        @if (count($histories) <=0 )
                        <tr class="text-center">
                          <td colspan="4">Belum Ada Pembayaran</td>
                        </tr>
                        @endif
                        @foreach ($histories as $history)
                          <tr>
                            <td>{{$history->month}}</td>
                            <td>Rp. {{number_format($history->cash)}}</td>
                            <td>{{$history->paymentMethod}}</td>
                            <td>{{$history->status ? "Lunas" : "Belum Lunas"}}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                 
                </div>
                <div class="card-footer"  style="background-color: #101248;">

                  <div class="row py-3" style="background-color: #101248;">
  
                    <div class="col-sm-4 col-12">
                      <div class="description-block">
                     
                        <h5 class="description-header text-white">{{$notPaid}}</h5>
                        <span class="description-text text-white text-sm">Tagihan</span>
                      </div>
                    
                    </div>
                  
                    <div class="col-sm-4 col-12">
                      <div class="description-block">
                        <h5 class="description-header text-white">Rp. {{number_format($totalPayment)}}</h5>
                        <span class="description-text text-white text-sm">Total Pembayaran Kas</span>
                      </div>
                    
                    </div>
                   
                    <div class="col-sm-4 col-12">
                      <div class="description-block ">
                        
                        <h5 class="description-header text-white">{{$totalPaidBill}}</h5>
                        <span class="description-text text-white text-sm">Tagihan Lunas</span>
                      </div>
                    
                    </div>
                  </div>
                </div>
              
              </div>
              @endif

            </div>
            <div class="col-12 col-md-4 ">
             
              <div class="info-box mb-3 bg-warning">
                <span class="info-box-icon"><i class="fas fa-cart-arrow-down"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text text-sm">Pemasukan Bulan Ini</span>
                  <span class="info-box-number">Rp. {{number_format($income->total)}}</span>
                </div>
              </div>
      
              <div class="info-box mb-3 bg-success">
                <span class="info-box-icon"><i class="fas fa-cart-plus"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text text-sm">Pengeluaran Bulan Ini</span>
                  <span class="info-box-number">Rp. {{number_format($outcome->total)}}</span>
                </div>
             
              </div>
           
              <div class="info-box mb-3 bg-danger">
                <span class="info-box-icon"><i class="fas fa-money-bill"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text text-sm">Jumlah Anggota Lunas</span>
                  <span class="info-box-number">{{is_null($memberPaid) ? 0 : $memberPaid->total_member}}</span>
                </div>
              </div>

              <div class="card">
                  <div class="card-body">

                    @if (count($documents) > 0)
                      @foreach ($documents as $document)
                        <div class="px-3 rounded mb-3" style="background-color: rgb(213, 247, 213);">
                          <div class="d-flex align-items-center">
                            <div class="bg-transparent rounded p-3 mr-2">
                              <i class="fas fa-file"></i>
                            </div>
                            <span>{{$document->documentName}}</span>
                            @if (!is_null(auth()->user()->member))
                              <div class="ml-auto">
                                <form action="{{route("dashboard.user.member.document.download", str_replace("/", "_", $document->document))}}" method="POST">
                                  @csrf
                                  @method("POST")
                                  <button type="submit" class="btn btn-sm">
                                    <i class="fas fa-download text-lg text-primary"></i>
                                  </button>
                                </form>
                              </div>
                            @endif
                          </div>
                        </div>
                      @endforeach
                    @else 
                      <div class="d-flex justify-content-center align-items-center">
                        <span class="text-danger">Belum Ada Dokumen</span>
                      </div>
                    @endif

                   

                  </div>
              </div>

              
      
            </div>
            
          </div>
        </div>

      </div>
   
 



@endsection

@push('scripts')

  


<script>

  (()=> {
   
    const data = {
      labels: [
        @foreach ($balanceSheets as $balanceSheet)
          '{{$balanceSheet->month}}',
        @endforeach
      ],
      datasets: [
        {
          label: "Pengeluaran",
          backgroundColor: "#E8DAEF",
          borderColor: "rgba(232, 218, 239,0.8)",
          pointRadius: false,
          pointColor: "#3b8bba",
          pointStrokeColor: "rgba(60,141,188,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(60,141,188,1)",
          data: [
            @foreach ($balanceSheets as $balanceSheet)
              '{{$balanceSheet->kredit}}',
            @endforeach
          ],
        },
        {
          label: "Pemasukan",
          backgroundColor: "#A9CCE3",
          borderColor: "rgba(210, 214, 222, 1)",
          pointRadius: false,
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [
            @foreach($balanceSheets as $balanceSheet)
              '{{$balanceSheet->debit}}',
            @endforeach
          ],
        },
      ],
    };


    const options  = {
      maintainAspectRatio: false,
      responsive: true,
      legend: {
        display: true,
      },
      scales: {
        xAxes: [
          {
            gridLines: {
              display: false,
            },
          },
        ],
        yAxes: [
          {
            gridLines: {
              display: false,
            },
          },
        ],
      },
    };
   
    const lineChartCanvas = $("#lineChart").get(0).getContext("2d");
    const lineChartOptions = $.extend(true, {}, options );
    const lineChartData = $.extend(true, {}, data);
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false;

    const lineChart =  new Chart(lineChartCanvas, {
          type: "line",
          data,
          options,
        });
   
  })()

</script>

<script>
  (()=> {
   
   const data = {
     labels: [
       @foreach ($alumnis as $alumni)
         '{{$alumni->periode}}',
       @endforeach
     ],
     datasets: [
       {
         label: "Total Alumni",
         backgroundColor: "#D6EAF8",
         borderColor: "rgba(60,141,188,0.8)",
         pointRadius: false,
         pointColor: "#3b8bba",
         pointStrokeColor: "rgba(60,141,188,1)",
         pointHighlightFill: "#fff",
         pointHighlightStroke: "rgba(60,141,188,1)",
         data: [
           @foreach ($alumnis as $alumni)
             '{{$alumni->total_alumni}}',
           @endforeach
         ],
       }
     ],
   };


   const options  = {
     maintainAspectRatio: false,
     responsive: true,
     legend: {
       display: false,
     },
     scales: {
       xAxes: [
         {
           gridLines: {
             display: false,
           },
         },
       ],
       yAxes: [
         {
           gridLines: {
             display: false,
           },
         },
       ],
     },
   };
  
   const barChart = $("#barChart").get(0).getContext("2d");
   const barChartOptions = $.extend(true, {}, options );
   const barChartData = $.extend(true, {}, data);
   barChartData.datasets[0].fill = false;
   barChartOptions.datasetFill = false;

   const lineChart = new Chart(barChart, {
     type: "bar",
     data: barChartData,
     options: barChartOptions,
   });
  
 })()

</script>

@endpush