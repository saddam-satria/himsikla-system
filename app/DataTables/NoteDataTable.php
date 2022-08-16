<?php

namespace App\DataTables;

use App\Helpers\DataTableConfig;
use App\Repositories\NoteRepository;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class NoteDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return DataTableConfig::configTable("event_note", datatables(), $query)->editColumn("note",  function ($data) {
            return strlen($data->note) > 300 ? substr($data->note, 0, 150) . " ..." : $data->note;
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Note $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(NoteRepository $model)
    {
        return $model->getAll()->select("note.note", "event.eventName as event", "note.id as id", "note.createdAt");
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return DataTableConfig::configHTML("event_note", $this->builder(), $this->getColumns());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = array(
            Column::make("event")->title("Nama Acara")->orderable(false),
            Column::make("note")->title("Notulensi")->searchable(false)->orderable(false),
            Column::make("createdAt")->title("Tanggal Dibuat")->searchable(false)->orderable(false),
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
        return DataTableConfig::configFileName("notulensi-himsi-kla");
    }
}
