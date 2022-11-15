<div class="table-responsive my-3">
    {!! $dataTable->table(['class' => "table table-bordered table-striped shadow rounded" ]) !!}
</div>

@push('scripts')
    {{$dataTable->scripts()}}
@endpush