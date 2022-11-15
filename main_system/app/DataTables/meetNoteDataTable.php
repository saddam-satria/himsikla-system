<?php

namespace App\DataTables;

use App\Helpers\DataTableConfig;
use App\Repositories\MeetNoteRepository;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class meetNoteDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return DataTableConfig::configTable("meet_note", datatables(), $query)->editColumn("note",  function ($data) {
            return strlen($data->note) > 300 ? substr($data->note, 0, 150) . " ..." : $data->note;
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\meetNote $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MeetNoteRepository $model)
    {
        return $model->query()->join("meet", "meet.id", "=", "meet_note.meet_id")->select("meet.meetName AS meet", "meet_note.*");
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return DataTableConfig::configHTML("meet_note", $this->builder(), $this->getColumns());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = array(
            Column::make("meet")->title("Nama Pertemuan")->orderable(false),
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
        return 'meetNote_' . date('YmdHis');
    }
}
