<?php

namespace App\DataTables;

use App\Helpers\DataTableConfig;
use App\Models\MeetAbsence;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MeetAbsenceDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return DataTableConfig::configTable("meet_absence", datatables(), $query,  true);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Absence $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MeetAbsence $meetAbsence)
    {
        return $meetAbsence->query()->join("member", "member.id", "=", "meet_absence.member_id")->where("meet_absence.meet_id", "=", $this->id)->select("member.name", "meet_absence.status", "meet_absence.id", "meet_absence.status");
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return DataTableConfig::configHTML("meet_absence", $this->builder(), $this->getColumns());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = array(
            Column::make("name")->searchable(false)->orderable(false),
            Column::make("status")->searchable(false),
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
        return 'Absence_' . date('YmdHis');
    }
}
