<?php

namespace App\DataTables;

use App\Helpers\DataTableConfig;
use App\Repositories\EventRepository;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

use function PHPUnit\Framework\isNull;

class EventDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return DataTableConfig::configTable("event", datatables(), $query)->editColumn("isGeneral", function ($data) {
            return $data->isGeneral ? "Umum" : "Anggota";
        })->editColumn("price", function ($data) {
            return is_null($data->price) ? "Gratis" :  number_format($data->price);
        })->editColumn("second-action", function ($data) {
            return $data->status ? "Selesai" : '
            <form action="' . route("dashboard.admin.event.update", ["event" => $data->id]) . "?finished=true" . '" method="POST">
                ' . csrf_field() . '
                ' . method_field("PUT") . '
                <button type="submit" class="btn btn-sm btn-secondary">
                    <i class="fa-solid fa-clipboard-check mr-2"></i>Selesai
                </button>
            </form>            
            ';
        })->editColumn("third-action", function ($data) {
            return '
                <a href="' . route("dashboard.admin.event_absence.index") . "?event=" . $data->id . '" class="btn btn-sm btn-primary"><i class="fa-solid fa-user-group"></i></a>
            ';
        })->editColumn("fourth-action", function ($data) {
            $payload = route("dashboard.user.member.event_present", Crypt::encrypt($data->id));
            return view("components.qrcode", compact("payload"));
        })->rawColumns(["action", 'second-action', 'third-action', 'fourth-action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Event $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EventRepository $model)
    {
        return $model->query()->select("event.id", "event.eventName", "event.startAt", "event.endAt", "event.status", "event.isGeneral", "event.price");
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return DataTableConfig::configHTML("event", $this->builder(), $this->getColumns());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = array(
            Column::make("eventName")->title("Nama Acara")->orderable(false),
            Column::make("startAt")->title("Tanggal Mulai Acara")->searchable(false),
            Column::make("isGeneral")->title("Tipe Acara")->searchable(false)->orderable(false),
            Column::make("price")->title("HTM")->searchable(false),
            Column::make("third-action")->title("Peserta Acara")->searchable(false)->orderable(false),
        );
        if (auth()->user()->member->occupation != "ketua") {
            $columns[] = Column::make("action")->orderable(false)->searchable(false);
            $columns[] = Column::make("second-action")->title("Action Pertemuan")->orderable(false)->searchable(false);
            $columns[] = Column::make("fourth-action")->title("QR Code Acara")->searchable(false)->orderable(false);
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
        return DataTableConfig::configFileName("acara-himsi-kla");
    }
}
