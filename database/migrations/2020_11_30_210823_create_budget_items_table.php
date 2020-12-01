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
            $table->string('part')->nullable();
            $table->string('material')->default('Hierro');
            $table->integer('small')->default(0);
            $table->integer('medium')->default(0);
            $table->integer('big')->default(0);
            $table->integer('paint')->default(0);
            $table->integer('small_vds')->default(0);
            $table->integer('medium_vds')->default(0);
            $table->integer('big_vds')->default(0);
            $table->integer('paint_vds')->default(0);
            $table->integer('total_vds')->default(0);
            $table->integer('total_money')->default(0);
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
