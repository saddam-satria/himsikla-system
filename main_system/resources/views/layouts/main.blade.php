<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title class="text-capitalize">HIMSI KLA  {{isset($title) ? " | " .  $title : ""}}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400&display=swap" rel="stylesheet">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/css/OverlayScrollbars.min.css" integrity="sha512-jN4O0AUkRmE6Jwc8la2I5iBmS+tCDcfUd1eq8nrZIBnDKTmCp5YxxNN1/aetnAH32qT+dDbk1aGhhoaw5cJNlw==" crossorigin="anonymous" referrerpolicy="no-referrer" />  <!-- Theme style -->
  {{-- ADMIN LTE --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
  {{-- Data Table --}}
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
  
  <link rel="shortcut icon" href="{{asset("favicon.ico")}}" type="image/x-icon">
  <link rel="apple-touch-icon" href="{{asset("apple-touch-icon.png")}}">
  <link rel="manifest" href="{{asset('manifest.json')}}">

  <style>
    .active , .card-header{
      background-color: #101248 !important;
      color: white !important;
    }
    .btn-primary{
      background-color: #4449ae !important;
      
    }
  
  </style>

  @stack('head')
</head>

<body class="hold-transition  sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

 

  @yield('content')
  
  
</div>



<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

{{-- Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

{{-- Overlay Scrollbar --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/js/OverlayScrollbars.min.js" integrity="sha512-B1xv1CqZlvaOobTbSiJWbRO2iM0iii3wQ/LWnXWJJxKfvIRRJa910sVmyZeOrvI854sLDsFCuFHh4urASj+qgw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script><!-- AdminLTE App -->

{{-- ADMIN LTE --}}
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>

{{-- Jquery mouse wheel --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js" integrity="sha512-rCjfoab9CVKOH/w/T6GbBxnAH5Azhy4+q1EXW5XEURefHbIkRbQ++ZR+GBClo3/d3q583X/gO4FKmOFuhkKrdA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- jQuery Mapael -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mapael/2.2.0/js/jquery.mapael.min.js" integrity="sha512-+iXNzFArGbqxdmbClb1f6MKIiZASR7H8ep6rS1ZFn2I7tRX400ApvS0nsG8/v1+F7RoGU2shMDTl/gZ5lZF1iw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- Chart JS  --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js" integrity="sha512-ttHne44lbbucAUVjyStgbDTTqvNVQdIGN9gqZeai69i4OXSDNjlBd1tyCVXI/a/DqITpj9gXi84dcyG2vz4jhw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- Datatable --}}
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
@stack('scripts')
</body>
</html>
