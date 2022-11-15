<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMeetAbsencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meet_absence', function (Blueprint $table) {
            $uuid = DB::raw("(UUID())");
            $table->uuid('id')->default($uuid)->primary();
            $table->foreignUuid("meet_id")->nullable()->references("id")->on("meet")->nullOnDelete()->cascadeOnUpdate();
            $table->foreignUuid("member_id")->nullable()->references("id")->on("member")->nullOnDelete()->cascadeOnUpdate();
            $table->enum("status", array("sakit", "ijin", "absen", "hadir"))->default("absen");
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
        Schema::dropIfExists('meet_absence');
    }
}
