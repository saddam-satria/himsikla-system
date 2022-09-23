<?php

namespace App\DataTables;

use App\Helpers\DataTableConfig;
use App\Repositories\MemberRepository;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MemberDataTable extends DataTable
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
        return DataTableConfig::configTable("member", datatables(), $query);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Member $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MemberRepository $model)
    {
        return $model->joinUser()->select("member.id", "member.name", "member.nim", "member.phoneNumber", "member.occupation", "member.periode", "user.email");
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return DataTableConfig::configHTML("member", $this->builder(), $this->getColumns());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('name')->title("Nama Anggota")->orderable(false),
            Column::make('email')->title("Email")->orderable(false)->searchable(false),
            Column::make('nim')->title("NIM")->orderable(false),
            Column::make('phoneNumber')->title("No Handphone")->orderable(false),
            Column::make('occupation')->title("Jabatan")->searchable(false)->orderable(false),
            Column::make('periode')->title("Masa Jabatan")->orderable(false)->searchable(false),
            Column::make('action')->title("Aksi")->orderable(false)->searchable(false),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return DataTableConfig::configFileName("anggota-himsi-kla");
    }
}
