@extends('layouts.pdf')

@section('content')
    <table class="table table-striped">
        <thead class="text-white text-capitalize" style="background-color: #101248;">
            <tr style="font-size: 12px">
                <th>Name</th>
                <th>NIM</th>
                <th>Jabatan</th>
                <th>Status</th>
                <th>Waktu Absensi</th>
              
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
                <tr style="font-size: 11px">
                    <td>{{$member->name}}</td>
                    <td>{{$member->nim}}</td>
                    <td>{{$member->occupation}}</td>
                    <td>{{$member->status}}</td>
                    <td>{{$member->createdAt}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection