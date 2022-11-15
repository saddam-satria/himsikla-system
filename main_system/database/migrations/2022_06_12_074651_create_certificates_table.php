<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificate', function (Blueprint $table) {
            $uuid = DB::raw("(UUID())");
            $table->uuid('id')->default($uuid)->primary();
            $table->string("link");
            $table->foreignUuid("event_id")->nullable()->references("id")->on("event")->nullOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('certificate');
    }
}
