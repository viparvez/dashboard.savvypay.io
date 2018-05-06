<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('trxnnum', 32);
            $table->string('clientunique_id')->unique();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->double('amount',9,2);
            $table->mediumtext('callback_url');
            $table->integer('gateway_id')->unsigned();
            $table->foreign('gateway_id')->references('id')->on('gateways')->onDelete('restrict');
            $table->timestamps();
            $table->string('gatewaytrxn_id');
            $table->enum('trxndeleted', array('0', '1'))->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
