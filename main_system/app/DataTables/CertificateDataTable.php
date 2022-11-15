<?php

namespace App\DataTables;

use App\Helpers\DataTableConfig;
use App\Models\Certificate;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CertificateDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return DataTableConfig::configTable("certificate", datatables(), $query, false)->editColumn("isGeneral", function ($data) {
            return $data->isGeneral ? "Umum" : "Anggota";
        })->editColumn('action', function ($data) {
            return  '<div class="d-flex">
                <a href="' . route("dashboard.admin.event.edit", ["event" => $data->id]) . "?action=certificate" . '" class="btn btn-sm btn-primary mx-1"><span class="fas fa-pen"></span></a>
                <form method="POST" action="' . route("dashboard.admin.event.certificate.destroy", ["certificate" => $data->id]) . '">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-sm btn-danger"><span class="fas fa-trash"></span></button>
                </form>
            </div>';
        })->editColumn("link", function ($data) {
            return  '<div class="d-flex">
            <a href="' . $data->link . '" class="text-decoration-none">' . $data->link . '</a>
        </div>';
        })->rawColumns(["link", "action"]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Event $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Certificate $model)
    {
        return $model->query()->join("event", "event.id", "=", "certificate.event_id")->select("certificate.link", "certificate.id", "certificate.createdAt", "eventName");
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return DataTableConfig::configHTML("certificate", $this->builder(), $this->getColumns());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = array(
            Column::make("id")->title("ID sertifikat")->orderable(false),
            Column::make("link")->title("Link Sertifikat")->orderable(false)->searchable(false),
            Column::make("createdAt")->title("Pembuatan Sertifikat")->searchable(false),
            Column::make("eventName")->title("Nama Acara")->orderable(false),
        );
        if (auth()->user()->member->occupation != "ketua") {
            $columns[] = Column::make("action")->searchable(false)->orderable(false);
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
        return DataTableConfig::configFileName("acara-himsi-kla");
    }
}
