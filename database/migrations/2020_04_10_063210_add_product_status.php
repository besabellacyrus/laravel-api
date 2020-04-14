<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('status', array('In-Stock', 'None', 'Pre-Order', 'New', 'Coming Soon', 'Sold Out'))->default('None');
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
            $table->enum('status', array('In-Stock', 'None', 'Pre-Order', 'New', 'Coming Soon', 'Sold Out'))->default('None');
        });
    }
}
