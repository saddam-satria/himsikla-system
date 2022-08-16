<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDetailFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_finance', function (Blueprint $table) {
            $uuid = DB::raw("(UUID())");
            $table->uuid('id')->default($uuid)->primary();
            $table->foreignUuid("member_id")->nullable()->references("id")->on("member")->nullOnDelete()->cascadeOnUpdate();
            $table->foreignUuid("finance_id")->nullable()->references("id")->on("finance")->nullOnDelete()->cascadeOnUpdate();
            $table->foreignUuid("receipt_id")->nullable()->references("id")->on("receipt")->nullOnDelete()->cascadeOnUpdate();
            $table->enum("paymentMethod", array("DANA", "BANK", "OVO", "GOPAY"));
            $table->double("cash");
            $table->boolean("status")->default(false);
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
        Schema::dropIfExists('detail_finance');
    }
}
