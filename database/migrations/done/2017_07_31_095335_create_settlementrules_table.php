<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettlementrulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settlementrules', function (Blueprint $table) {
            $table->increments('id');
            $table->String('name');
            $table->integer('methodtype_id')->unsigned();
            $table->foreign('methodtype_id')->references('id')->on('methodtypes');
            $table->double('bill_policy',5,2);
            $table->double('amount', 10,2);
            $table->enum('deleted',['0','1']);
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
        Schema::dropIfExists('settlementrules');
    }
}
