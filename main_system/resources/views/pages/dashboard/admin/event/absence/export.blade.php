@extends('layouts.pdf')

@section('content')
    <table class="table table-striped">
        <thead class="text-white text-capitalize" style="background-color: #101248;">
            <tr style="font-size: 12px">
                <th>Email</th>
                <th>NIM</th>
                <th>University</th>
                <th>Status</th>
                <th>Waktu Pendaftaran</th>
                <th>Waktu Absensi</th>
              
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
                <tr style="font-size: 11px">
                    <td>{{$member->email}}</td>
                    <td>{{$member->nim}}</td>
                    <td>{{$member->university}}</td>
                    <td>{{$member->status}}</td>
                    <td>{{$member->createdAt}}</td>
                    <td>{{$member->updatedAt}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection