<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOtherColumnsToNullableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
            $table->string('specs')->nullable()->change();
            $table->string('memo')->nullable()->change();
            $table->string('pcs_per_carton')->nullable()->change();
            $table->string('weight')->nullable()->change();
            $table->string('qty')->nullable()->change();
            $table->string('date_arrived')->nullable()->change();
            $table->string('expiry_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
            $table->string('specs')->nullable()->change();
            $table->string('memo')->nullable()->change();
            $table->string('pcs_per_carton')->nullable()->change();
            $table->string('weight')->nullable()->change();
            $table->string('qty')->nullable()->change();
            $table->string('date_arrived')->nullable()->change();
            $table->string('expiry_date')->nullable()->change();
        });
    }
}
