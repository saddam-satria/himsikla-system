<?php

namespace App\DataTables;

use App\Helpers\DataTableConfig;
use App\Models\MeetAbsence;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AttendenceRecapMeetDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return DataTableConfig::configTable("meet_absence", datatables(), $query,  false);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\AttendenceRecap $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MeetAbsence $model)
    {
        return $model->query()->join("member", "member.id", "=", "meet_absence.member_id")->groupBy("meet_absence.member_id", "member.name")->select("meet_absence.member_id", "member.name", DB::raw('count(IF(meet_absence.status = "hadir", 1, null)) AS present, count(IF(meet_absence.status = "sakit", 1, null)) AS sick, count(IF(meet_absence.status = "absen", 1, null)) AS absence, count(IF(meet_absence.status = "ijin", 1, null)) AS permitted'));
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return DataTableConfig::configHTML("meet_absence", $this->builder(), $this->getColumns());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('name')->title("Nama Anggota")->orderable(false)->searchable(false),
            Column::make('present')->title("Jumlah Hadir")->orderable(false)->searchable(false),
            Column::make('sick')->title("Jumlah Sakit")->searchable(false)->orderable(false),
            Column::make('absence')->title("Jumlah Absen")->searchable(false)->orderable(false),
            Column::make('permitted')->title("Jumlah Izin")->orderable(false)->searchable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'AttendenceRecap_' . date('YmdHis');
    }
}
