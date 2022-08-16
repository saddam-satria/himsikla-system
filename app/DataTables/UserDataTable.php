<?php

namespace App\DataTables;

use App\Helpers\DataTableConfig;
use App\Repositories\UserRepository;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    protected $excludeFromPrint = ["action"];
    protected $excludeFromExport = ["action"];
    protected $printColumns = ["username"];
    protected $exportColumns = ["username"];
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return DataTableConfig::configTable("user", datatables(), $query)->editColumn("isGuest", function ($data) {
            return $data->isGuest ? "tamu" : "anggota";
        })->editColumn("second-action", function ($data) {
            return '
                <a href="' . route("dashboard.admin.user.edit", $data->id) . "?action=reset-password" . '" class="btn btn-sm btn-secondary">
                    <i class="fa-solid fa-recycle"></i>
                </a>
            ';
        })->rawColumns(array("action", "second-action"));
    }


    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(UserRepository $model)
    {
        return $model->userAll();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return DataTableConfig::configHTML("user", $this->builder(), $this->getColumns());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('email')->title("Email")->orderable(false),
            Column::make('university')->title("Universitas / Instansi")->orderable(false),
            Column::make('isGuest')->title("Posisi")->searchable(false)->orderable(false),
            Column::make('gender')->title("Jenis Kelamin")->orderable(false)->searchable(false),
            Column::make('action')->orderable(false)->searchable(false),
            Column::make('second-action')->title("Reset Password")->orderable(false)->searchable(false),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return DataTableConfig::configFileName("user-himsi-kla");
    }
}
