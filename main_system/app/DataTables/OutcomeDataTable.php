<?php

namespace App\DataTables;

use App\Helpers\DataTableConfig;
use App\Repositories\OutcomeRepository;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OutcomeDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return DataTableConfig::configTable("outcome", datatables(), $query)->editColumn("total", function ($data) {
            return number_format($data->total);
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Outcome $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(OutcomeRepository $model)
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
        return DataTableConfig::configHTML("outcome", $this->builder(), $this->getColumns());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = array(
            Column::make('date')->title("Tanggal Pengeluaran")->searchable(false),
            Column::make('total')->title("Total Pengeluaran")->searchable(false),
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
        return 'Outcome_' . date('YmdHis');
    }
}
