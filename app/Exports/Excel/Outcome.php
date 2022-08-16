<?php

namespace App\Exports\Excel;

use App\Models\Outcome as ModelsOutcome;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Outcome implements FromArray, WithHeadings
{
    public function array(): array
    {

        $data =  ModelsOutcome::query()->get(array("date", "total", "description"));
        return array($data);
    }
    public function headings(): array
    {
        return array("Tanggal", "Total", "Deskripsi");
    }
}
