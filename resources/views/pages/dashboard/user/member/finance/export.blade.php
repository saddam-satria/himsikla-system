@extends('layouts.pdf')

@section('content')
    <table class="table table-striped">
        <thead class="text-white text-capitalize" style="background-color: #101248;">
            <tr style="font-size: 12px">
                <th>Bulan</th>
                <th>Status Pembayaran</th>
                <th>Waktu Pembayaran</th>
                <th>Metode Pembayaran</th>
                <th>Nominal Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
                <tr style="font-size: 11px">
                    <td>{{$member->month}}</td>
                    <td>{{$member->status ? "Lunas" : "Belum Lunas"}}</td>
                    <td>{{$member->createdAt}}</td>
                    <td>{{$member->paymentMethod}}</td>
                    <td>{{number_format($member->cash)}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection