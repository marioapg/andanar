<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('budget_id')->unsigned();
            $table->string('part');
            $table->string('material');
            $table->integer('small');
            $table->integer('medium');
            $table->integer('big');
            $table->integer('paint');
            $table->integer('small_vds');
            $table->integer('medium_vds');
            $table->integer('big_vds');
            $table->integer('paint_vds');
            $table->integer('total_vds');
            $table->foreign('budget_id')->references('id')->on('budgets');
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
        Schema::dropIfExists('budget_items');
    }
}
