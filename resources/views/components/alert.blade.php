@if (session()->get("error"))
    <div class="alert alert-danger" role="alert">
        <span class="text-capitalize">{{session()->get("error")}}</span>
    </div>
@endif
@if (session()->get("success"))
    <div class="alert alert-success" role="alert">
        <span class="text-capitalize">{{session()->get("success")}}</span>
    </div>
@endif



@push('scripts')
    <script>
        setTimeout(() => {
          document.querySelector('.alert') && document.querySelector('.alert').remove();
        }, 3000);
    </script>
@endpush