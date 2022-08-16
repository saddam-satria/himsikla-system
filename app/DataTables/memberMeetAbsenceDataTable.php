<?php

namespace App\DataTables;

use App\Helpers\DataTableConfig;
use App\Repositories\MeetAbsenceRepository;
use App\Repositories\MemberRepository;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;


class memberMeetAbsenceDataTable extends DataTable
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
     * @param \App\Models\memberMeetAbsence $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MeetAbsenceRepository $model)
    {
        return $model->query()->join("meet", "meet.id", "=", "meet_absence.meet_id")->where("meet_absence.member_id", "=", auth()->user()->member->id)->select("meet.id", "meetName", "meet_absence.createdAt", "meet_absence.status");
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
            Column::make("id")->title("ID Pertemuan")->orderable(false),
            Column::make("meetName")->title("Nama Pertemuan")->orderable(false),
            Column::make("status")->title("Status Absensi")->orderable(false)->searchable(false),
            Column::make("createdAt")->title("Waktu Absensi")->orderable(false)->searchable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'memberMeetAbsence_' . date('YmdHis');
    }
}
