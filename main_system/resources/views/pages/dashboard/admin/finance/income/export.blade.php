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
            @foreach ($incomes as $income)
                <tr style="font-size: 11px">
                    <td>{{$income->date}}</td>
                    <td>Rp. {{number_format($income->total)}}</td>
                    <td>{{$income->description}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection