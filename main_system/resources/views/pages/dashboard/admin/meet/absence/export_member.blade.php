@extends('layouts.pdf')

@section('content')
    <table class="table table-striped">
        <thead class="text-white text-capitalize" style="background-color: #101248;">
            <tr style="font-size: 12px">
                <th>Nama Anggota</th>
                <th>NIM Anggota</th>
                <th>Sakit</th>
                <th>Izin</th>
                <th>Hadir</th>
                <th>Tanpa Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
                <tr style="font-size: 11px">
                    <td>{{$member->name}}</td>
                    <td>{{$member->nim}}</td>
                    <td>{{$member->sick}}</td>
                    <td>{{$member->permitted}}</td>
                    <td>{{$member->present}}</td>
                    <td>{{$member->absence}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection