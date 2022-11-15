<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income', function (Blueprint $table) {
            $uuid = DB::raw("(UUID())");
            $table->uuid('id')->default($uuid)->primary();
            $table->date("date");
            $table->double("total");
            $table->longText("description")->nullable();
            $table->timestamp("createdAt")->useCurrent();
            $table->timestamp("updatedAt")->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('income');
    }
}
