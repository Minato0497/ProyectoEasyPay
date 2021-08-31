<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordMoneyTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_money_transfers', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('id_envia')->constrained('users');
            //$table->foreignId('id_recibe')->constrained('users');
            $table->string('email_envia');
            $table->string('email_recibe');
            $table->float('monto', 9, 2);
            $table->foreignId('envia_id')->constrained('users');
            //$table->foreignId('recibe_id')->constrained('users');
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
        Schema::drop('record_money_transfers');
    }
}
