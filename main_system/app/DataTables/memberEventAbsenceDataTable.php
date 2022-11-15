<?php

namespace App\DataTables;

use App\Helpers\DataTableConfig;
use App\Repositories\EventAbsenceRepository;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;


class memberEventAbsenceDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return DataTableConfig::configTable("event_absence", datatables(), $query,  false);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\memberMeetAbsence $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EventAbsenceRepository $model)
    {
        return $model->query()->join("event", "event.id", "=", "event_absence.event_id")->where("event_absence.email", "=", auth()->user()->email)->where("event_absence.status", "=", "hadir")->where("event_absence.nim", "=", auth()->user()->member->nim)->select("event.id", "eventName", "event_absence.createdAt", "event_absence.status", "event_absence.id as absence_id");
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return DataTableConfig::configHTML("event_absence", $this->builder(), $this->getColumns());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make("id")->title("ID Acara")->orderable(false),
            Column::make("absence_id")->title("ID Peserta")->orderable(false),
            Column::make("eventName")->title("Nama Acara")->orderable(false),
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
        return 'memberEventAbsence_' . date('YmdHis');
    }
}
