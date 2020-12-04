<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('technical_id')->nullable()->unsigned();
            $table->bigInteger('responsable_id')->nullable()->unsigned();
            $table->bigInteger('perito_id')->nullable()->unsigned();
            $table->bigInteger('car_id')->nullable()->unsigned();
            $table->date('date');
            $table->text('public_comment')->nullable();
            $table->text('private_comment')->nullable();
            $table->string('status')->default('presupuestado');
            $table->string('cia_sure')->nullable()->default(null);
            $table->double('iva_rate')->default(21);
            $table->double('total');
            $table->double('iva');
            $table->double('grand_total');
            $table->double('tarifa_pdr');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('technical_id')->references('id')->on('users');
            $table->foreign('responsable_id')->references('id')->on('users');
            $table->foreign('perito_id')->references('id')->on('users');
            $table->foreign('car_id')->references('id')->on('cars');
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
        Schema::dropIfExists('budgets');
    }
}
