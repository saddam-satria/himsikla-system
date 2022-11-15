<?php

namespace App\DataTables;

use App\Helpers\DataTableConfig;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Column;
use App\Repositories\DocumentRepository;

class DocumentDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return DataTableConfig::configTable("document", datatables(), $query)->addColumn("second-action", function ($data) {
            return '
                <div class="d-flex">
                    <a target="__blank" href="' . asset("assets/document/" . $data->document) . '" class="btn btn-sm btn-primary"><i class="fa-solid fa-download"></i></a>
                </div>
            ';
        })->rawColumns(array("action", "second-action"));
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Document $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(DocumentRepository $model)
    {
        return $model->query()->select("documentName", "id", "createdAt", "document");
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return DataTableConfig::configHTML("document", $this->builder(), $this->getColumns());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->orderable(false)->searchable(false),
            Column::make('documentName')->title("Nama Dokumen")->orderable(false),
            Column::make('action')->orderable(false)->searchable(false),
            Column::make('second-action')->title("Action Dokumen")->orderable(false)->searchable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Document_' . date('YmdHis');
    }
}
