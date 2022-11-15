<?php

namespace App\Exports\Excel;

use App\Models\Income as ModelsIncome;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Income implements FromArray, WithHeadings
{
    public function array(): array
    {

        $data =  ModelsIncome::query()->get(array("date", "total", "description"));

        return array($data);
    }
    public function headings(): array
    {
        return array("Tanggal", "Total", "Deskripsi");
    }
}
