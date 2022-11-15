<?php

namespace App\DataTables;

use App\Helpers\DataTableConfig;
use App\Repositories\MeetRepository;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MeetDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return DataTableConfig::configTable("meet", datatables(), $query)->addColumn("second-action", function ($data) {
            return $data->status ? "Selesai" : '
                <div class="d-flex">  
                        <form action="' . route("dashboard.admin.meet.update", ["meet" => $data->id]) . "?finished=true" . '" method="POST">
                            ' . csrf_field() . '
                            ' . method_field("PUT") . '
                            <button type="submit" class="btn btn-sm btn-secondary">
                                <i class="fa-solid fa-clipboard-check mr-2"></i>Selesai
                            </button>
                        </form>
                </div>
            ';
        })->addColumn("third-action", function ($data) {
            $payload = route("dashboard.user.member.present", Crypt::encrypt($data->id));
            return view("components.qrcode", compact("payload"));
        })->addColumn("fourth-action", function ($data) {
            return '
                    <a href="' . route("dashboard.admin.meet_absence.index") . "?meet=" . $data->id . '" class="btn btn-sm btn-primary"><i class="fa-solid fa-user-group"></i></a>
                ';
        })->rawColumns(["action", 'second-action', "third-action", "fourth-action"]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Meet $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MeetRepository $model)
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
        return DataTableConfig::configHTML("meet", $this->builder(), $this->getColumns());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = array(
            Column::make("id")->title("id pertemuan")->searchable(false)->orderable(false),
            Column::make("meetName")->title("Nama Pertemuan")->orderable(false),
            Column::make("material")->title("Pembahasan")->searchable(false)->orderable(false),
            Column::make("startAt")->title("Jam Mulai")->searchable(false),
            Column::make("fourth-action")->title("Absensi")->orderable(false)->searchable(false),

        );


        if (auth()->user()->member->occupation != "ketua") {
            $columns[] = Column::make("action")->orderable(false)->searchable(false);
            $columns[] = Column::make("second-action")->title("Action Pertemuan")->orderable(false)->searchable(false);
            $columns[] = Column::make("third-action")->title("QR Code")->orderable(false)->searchable(false);
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
        return 'Meet_' . date('YmdHis');
    }
}
