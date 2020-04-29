<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoices_id')->unsigned();
            $table->string('name');
            $table->string('description');
            $table->string('quantity');
            $table->string('price');
            $table->double('tax_rate');
            $table->double('total');
            $table->double('tax');
            $table->double('grand_total');
            $table->foreign('invoices_id')->references('id')->on('invoices');
            $table->softDeletes();
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
        Schema::dropIfExists('items');
    }
}
