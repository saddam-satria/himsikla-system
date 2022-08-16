<?php

namespace App\Exports\Excel;

use App\Models\MeetAbsence;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DetailAbsenceMember implements FromArray, WithHeadings
{
    public function array(): array
    {

        $data =  MeetAbsence::query()->join("member", "member.id", "=", "meet_absence.member_id")->groupBy("member.nim", "member.name")->select("member.name", "member.nim",   DB::raw('count(IF(meet_absence.status = "hadir", 1, null)) AS kehadiran, count(IF(meet_absence.status = "sakit", 1, null)) AS sakit, count(IF(meet_absence.status = "absen", 1, null)) AS absen, count(IF(meet_absence.status = "ijin", 1, null)) AS izin'))->get();

        return array($data);
    }
    public function headings(): array
    {
        return array("NIM Anggota", "Nama Anggota", "Jumlah Kehadiran", "Jumlah Sakit", "Jumlah Tanpa Keterangan", "Jumlah Izin");
    }
}
