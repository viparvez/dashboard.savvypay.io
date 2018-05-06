<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettlementdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settlementdetails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invCode')->unsigned();
            $table->foreign('invCode')->references('invCode')->on('settlements');
            $table->integer('methodtype_id')->unsigned();
            $table->foreign('methodtype_id')->references('id')->on('methodtypes');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->double('TotalAmount','15','2');
            $table->double('Charge','15','2');
            $table->double('CreditableAmount','15','2');
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
        Schema::dropIfExists('settlementdetails');
    }
}
