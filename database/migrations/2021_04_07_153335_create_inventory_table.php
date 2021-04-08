<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->integer('item_code')->unsigned()->unique();
            $table->string('item_desc', 255);
            $table->integer('qty')->unsigned();
            $table->string('unit_of_measure');
            $table->integer('type');
            $table->double('price', 7, 4);
            $table->string('location', 255);
            $table->string('serial');
            $table->string('model');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory');
    }
}
