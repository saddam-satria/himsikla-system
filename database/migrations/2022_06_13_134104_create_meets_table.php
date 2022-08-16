<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMeetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meet', function (Blueprint $table) {
            $uuid = DB::raw("(UUID())");
            $table->uuid('id')->default($uuid)->primary();
            $table->string("meetName", 150);
            $table->string("material", 200);
            $table->dateTime("startAt");
            $table->dateTime("endAt");
            $table->string("location");
            $table->boolean("status")->default(false);
            $table->boolean("isOnline")->default(false);
            $table->longText("description")->nullable();
            $table->string("banner")->nullable();
            $table->double("price")->nullable();
            $table->longText("detailLocation")->nullable();
            $table->foreignUuid("member_id")->nullable()->references("id")->on("member")->cascadeOnUpdate()->nullOnDelete();
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
        Schema::dropIfExists('meet');
    }
}
