<?php

namespace App\DataTables;

use App\Helpers\DataTableConfig;
use App\Models\DetailFinance;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DetailFinanceDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return DataTableConfig::configTable("detail_finance", datatables(), $query, true)->editColumn("status", function ($data) {
            return $data->status ? "Lunas" : "Belum Lunas";
        })->addColumn("second-action", function ($data) {
            return ' 
                <div class="d-flex">
                    <a href="' . asset("assets/bukti-pembayaran") . "/" . $data->image . '" class="btn btn-sm btn-primary" target="__blank">
                        <i class="fas fa-download"></i>
                    </a>
                  
                </div>
            ';
        })->addColumn("third-action", function ($data) {
            return $data->status ? "Lunas" : '
                        <div class="ml-2">
                            <form action="' . route("dashboard.admin.detail_finance.update", $data->id) . "?action=confirmation" . '" method="POST">
                                ' . csrf_field() . '
                                ' . method_field("PUT") . '
                                <button type="submit" class="btn btn-sm btn-primary">Konfirmasi</button>
                            </form>
                        </div>
            ';
        })->editColumn("cash", function ($data) {
            return number_format($data->cash);
        })->editColumn("penalty", function ($data) {
            return number_format($data->penalty);
        })->rawColumns(array("action", "second-action", "third-action"));
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\DetailFinance $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(DetailFinance $model)
    {
        return $model
            ->query()
            ->where("detail_finance.finance_id", "=", $this->id)
            ->join("member", "member.id", "=", "detail_finance.member_id")
            ->join("receipt", "receipt.id", "=", "detail_finance.receipt_id")
            ->select("member.name", "member.nim", "detail_finance.createdAt", "detail_finance.paymentMethod", "detail_finance.status",  "detail_finance.cash", "detail_finance.id", "receipt.image");
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return DataTableConfig::configHTML("detail_finance", $this->builder(), $this->getColumns());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = array(
            Column::make('name')->title("Nama Anggota")->orderable(false),
            Column::make('nim')->title("NIM Anggota")->orderable(false),
            Column::make('cash')->title("Jumlah Bayar")->orderable(false)->searchable(false),
            Column::make('status')->title("Status Pelunasan")->orderable(false)->searchable(false),
            Column::make('createdAt')->title("Waktu Pembayaran")->orderable(false)->searchable(false),
            Column::make('second-action')->title("Preview Bukti")->orderable(false)->searchable(false),
            Column::make('third-action')->title("Action Pembayaran")->orderable(false)->searchable(false),
        );

        if (auth()->user()->member->occupation != "ketua") {
            $columns[] =   Column::make('action')->orderable(false)->searchable(false);
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
        return 'DetailFinance_' . date('YmdHis');
    }
}
