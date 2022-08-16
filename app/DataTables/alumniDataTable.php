<?php

namespace App\DataTables;

use App\Helpers\DataTableConfig;
use App\Models\Alumni;
use App\Models\alumnus;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class alumniDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return DataTableConfig::configTable("alumni", datatables(), $query,  true);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\alumnus $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Alumni $model)
    {
        return $model->query();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return DataTableConfig::configHTML("alumni", $this->builder(), $this->getColumns());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('name')->title("Nama Alumi")->searchable(false)->orderable(false),
            Column::make('periode')->title("Masa Jabatan")->searchable(false)->orderable(false),
            Column::make('occupation')->title("Jabatan")->searchable(false)->orderable(false),
            Column::make('action')->searchable(false)->orderable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'alumni_' . date('YmdHis');
    }
}
