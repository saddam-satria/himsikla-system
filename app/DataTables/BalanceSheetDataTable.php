<?php

namespace App\DataTables;

use App\Helpers\DataTableConfig;
use App\Models\BalanceSheet;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BalanceSheetDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return DataTableConfig::configTable("balance_sheet", datatables(), $query,  is_null($this->filter))->editColumn("debit", function ($data) {
            return $data->debit ? number_format($data->debit, 0)  : 0;
        })->editColumn("kredit", function ($data) {
            return $data->kredit ? number_format($data->kredit, 0)  : 0;
        })->editColumn("total", function ($data) {
            return $data->total ? number_format($data->total, 0)  : 0;
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\BalanceSheet $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BalanceSheet $model)
    {
        if (!is_null($this->filter)) return BalanceSheet::Where("month", "=", $this->filter)
            ->select([DB::raw("SUM(debit) as debit"), DB::raw("SUM(kredit) as kredit"), DB::raw("SUM(debit - kredit) AS total")])
            ->groupBy("month");
        return $model->query();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return DataTableConfig::configHTML("balance_sheet", $this->builder(), $this->getColumns());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {

        $columns = array(
            Column::make('month')->searchable(false),
            Column::make('debit')->title("Debit")->searchable(false)->orderable(false),
            Column::make('kredit')->title("Kredit")->searchable(false)->orderable(false),
            Column::make('createdAt')->title("Tanggal")->searchable(false)->orderable(false),
        );

        if (auth()->user()->member->occupation != "ketua") {
            $columns[] =  Column::make("action")->title("Action")->searchable(false)->orderable(false);
        };

        if (!is_null($this->filter)) return [
            Column::make('debit')->title("Debit")->searchable(false)->orderable(false),
            Column::make('kredit')->title("Kredit")->searchable(false)->orderable(false),
            Column::make('total')->title("Total")->searchable(false)->orderable(false),
        ];
        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'BalanceSheet_' . date('YmdHis');
    }
}
