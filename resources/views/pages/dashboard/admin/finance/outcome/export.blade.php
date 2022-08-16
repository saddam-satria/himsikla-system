@extends('layouts.pdf')

@section('content')
    <table class="table table-striped">
        <thead class="text-white text-capitalize" style="background-color: #101248;">
            <tr style="font-size: 12px">
                <th>Tanggal</th>
                <th>Total</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($outcomes as $outcome)
                <tr style="font-size: 11px">
                    <td>{{$outcome->date}}</td>
                    <td>Rp. {{number_format($outcome->total)}}</td>
                    <td>{{$outcome->description}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection