@extends('layouts.pdf')

@section('content')
    <table class="table table-striped">
        <thead class="text-white text-capitalize" style="background-color: #101248;">
            <tr style="font-size: 12px">
                <th>Nama Anggota</th>
                <th>Email Anggota</th>
                <th>NIM Anggota</th>
                <th>Jabatan Anggota</th>
                <th>Periode Anggota</th>
                <th>No HP Anggota</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
                <tr style="font-size: 11px">
                    <td>{{$member->name}}</td>
                    <td>{{$member->email}}</td>
                    <td>{{$member->nim}}</td>
                    <td>{{$member->occupation}}</td>
                    <td>{{$member->periode}}</td>
                    <td>{{$member->phoneNumber}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection