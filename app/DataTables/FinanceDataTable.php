<?php

namespace App\DataTables;

use App\Helpers\DataTableConfig;
use App\Repositories\FinanceRepository;
use Illuminate\Support\Facades\Request;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class FinanceDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return DataTableConfig::configTable("finance", datatables(), $query, !str_contains(Request::path(), "member"))->editColumn("month", function ($data) {
            return date_format(date_create($data->month), "F Y");
        })->editColumn("price", function ($data) {
            return number_format($data->price);
        })->editColumn("penalty", function ($data) {
            return number_format($data->penalty);
        })->addColumn("leader", function ($data) {
            return '  <div class="px-2">
            <a href="' . route("dashboard" . ".admin." . "finance" . "." . "show", $data->id) . '" class="btn btn-sm btn-primary">
                <i class="fa-solid fa-eye"></i>        
            </a>
        </div>';
        })->rawColumns(array("leader", "action"));
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Finance $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(FinanceRepository $model)
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
        return DataTableConfig::configHTML("finance", $this->builder(), $this->getColumns());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = [
            Column::make('month')->title("Kas Bulan")->orderable(false)->searchable(false),
            Column::make('description')->title("Deskripsi Kas")->orderable(false)->searchable(false),
            Column::make('payment')->title("Metode Pembayaran")->orderable(false)->searchable(false),
            Column::make('price')->title("Nominal Pembayaran")->orderable(false)->searchable(false),
            Column::make('penalty')->title("Denda")->orderable(false)->searchable(false),
        ];

        if (auth()->user()->member->occupation == "ketua") {
            $columns[] = Column::make("leader")->title("Pembayaran Anggota")->searchable(false)->orderable(false);
        };

        if (!str_contains(Request::path(), "member") && auth()->user()->member->occupation != "ketua") {
            $columns[] =   Column::make('id')->orderable(false);
            $columns[] = Column::make('action')->orderable(false)->searchable(false);
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
        return 'Finance_' . date('YmdHis');
    }
}
