<?php

namespace App\DataTables;

use App\Helpers\DataTableConfig;
use App\Repositories\EventAbsenceRepository;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EventAbsenceDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return DataTableConfig::configTable("event_absence", datatables(), $query,  true)->editColumn("isPaidOff", function ($data) {
            return $data->isPaidOff ? "Lunas" : "Belum Lunas";
        })->addColumn("paid", function ($data) {
            return $data->isPaidOff ? "Lunas" : ' <form action="' . route("dashboard.admin.event_absence.paid", $data->id) . "?finished=true" . '" method="POST">
            ' . csrf_field() . '
            ' . method_field("POST") . '
            <button type="submit" class="btn btn-sm btn-secondary">
                <i class="fa-solid fa-clipboard-check mr-2"></i>Lunas
            </button>
        </form>';
        })->rawColumns(array("action", "paid"));
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\EventAbsence $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EventAbsenceRepository $model)
    {
        return $model->query()->where("event_id", "=", $this->id)->join("event", "event.id", "=", "event_absence.event_id")->select("event_absence.id", "event_absence.email", "event_absence.nim", "event_absence.university", "event_absence.createdAt", "event_absence.status", "event_absence.isPaidOff");
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
        $columns = array(
            Column::make('id')->title("ID Peserta")->orderable(false),
            Column::make('email')->title("Email Peserta")->orderable(false),
            Column::make('nim')->title("NIM")->orderable(false),
            Column::make('university')->title("Perguruan Tinggi")->orderable(false)->searchable(false),
            Column::make('isPaidOff')->title("Status Pembayaran")->orderable(false)->searchable(false),
            Column::make('createdAt')->title("Waktu Pendaftaran")->orderable(false)->searchable(false),
        );

        if (auth()->user()->member->occupation != "ketua") {
            $columns[] =  Column::make("paid")->title("Konfirmasi Pembayaran")->searchable(false)->orderable(false);
            $columns[] =  Column::make("action")->title("Action")->searchable(false)->orderable(false);
        };

        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'EventAbsence_' . date('YmdHis');
    }
}
