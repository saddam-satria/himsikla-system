<?php

namespace App\Helpers;


class DataTableConfig
{
    public static function configHTML($tableName, $ctx, $column)
    {
        return $ctx
            ->setTableId($tableName)
            ->columns($column)
            ->processing(true)
            ->language([
                "emptyTable" => "Data Kosong",
                "infoFiltered" => "",
                "processing" => '<i class="fa-solid fa-spinner"></i>'
            ])
            ->minifiedAjax()
            ->dom('Bfrltip')
            ->searchDelay(500)
            ->orderBy(0)->scrollY("400px")->scrollCollapse(true)->scroller(["loadingIndicator" => true])->responsive();
    }
    public static function configTable($fieldName, $ctx, $query, $isNeedAction = true)
    {
        $context = $ctx
            ->eloquent($query)
            ->smart(true);

        if ($isNeedAction) {
            $context->addColumn('action', function ($data) use ($fieldName) {
                $field = $fieldName;
                $id = $data->id;
                return view("components.table_action", compact("field", "id"))->render();
            });
        }

        return $context;
    }
    public static function configFileName(string $fileName): string
    {
        return $fileName . " " . date('Y-m-d');
    }
}
