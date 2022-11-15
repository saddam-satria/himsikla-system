@error($field)
<div class="alert alert-danger ml-2 text-capitalize" role="alert">
    {{$message}}
</div>
@enderror

@push('scripts')
    <script>
        setTimeout(() => {
          document.querySelector('.alert') && document.querySelector('.alert').remove();
        }, 5000);
    </script>
@endpush