<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeForeignKeysToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('brand_id')->unsigned()->nullable()->change();
            $table->bigInteger('category_id')->unsigned()->nullable()->change();
            $table->bigInteger('type_id')->unsigned()->nullable()->change();
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
            $table->bigInteger('brand_id')->unsigned()->nullable()->change();
            $table->bigInteger('category_id')->unsigned()->nullable()->change();
            $table->bigInteger('type_id')->unsigned()->nullable()->change();
        });
    }
}
