<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
            $uuid = DB::raw("(UUID())");
            $table->uuid('id')->default($uuid)->primary();
            $table->string("eventName", 150);
            $table->dateTime("startAt");
            $table->dateTime("endAt");
            $table->longText("description");
            $table->boolean("status")->default(false);
            $table->string("banner", 150)->nullable();
            $table->boolean("isGeneral")->default(false);
            $table->foreignUuid("member_id")->nullable()->references("id")->on("member")->nullOnDelete()->cascadeOnUpdate();
            $table->boolean("isFree")->default(false);
            $table->double("price")->nullable();
            $table->boolean("isOnline")->default(false);
            $table->string("location");
            $table->string("feedback")->nullable();
            $table->string("payment")->nullable();
            $table->string("contactPerson")->nullable();
            $table->longText("detailLocation")->nullable();
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
        Schema::dropIfExists('event');
    }
}
