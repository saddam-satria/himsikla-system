@extends('layouts.pdf')

@section('content')
    <table class="table table-striped">
        <thead class="text-white text-capitalize" style="background-color: #101248;">
            <tr style="font-size: 12px">
                <th>Bulan</th>
                <th>Debit</th>
                <th>Kredit</th>
                <th>{{is_null($filter) ? "Deskripsi" : "Total"}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($balanceSheets as $balanceSheet)
                <tr style="font-size: 11px">
                    <td>{{$balanceSheet->month}}</td>
                    <td>Rp. {{number_format($balanceSheet->debit)}}</td>
                    <td>Rp. {{number_format($balanceSheet->kredit)}}</td>
                    <td>{{is_null($filter) ? $balanceSheet->note: "Rp. " . number_format($balanceSheet->total)}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection