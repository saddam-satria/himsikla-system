<?php

namespace App\DataTables;

use App\Helpers\DataTableConfig;
use App\Repositories\IncomeRepository;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class IncomeDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return DataTableConfig::configTable("income", datatables(), $query)->editColumn("total", function ($data) {
            return number_format($data->total);
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Income $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(IncomeRepository $model)
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
        return DataTableConfig::configHTML("income", $this->builder(), $this->getColumns());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {

        $columns = array(
            Column::make('date')->title("Tanggal Pemasukan")->searchable(false),
            Column::make('total')->title("Total Pemasukan")->searchable(false),
            Column::make('description')->title("Deskripsi")->searchable(false)->orderable(false),
        );
        if (auth()->user()->member->occupation != "ketua") {
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
        return 'Income_' . date('YmdHis');
    }
}
