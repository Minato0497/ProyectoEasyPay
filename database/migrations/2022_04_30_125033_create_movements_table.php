<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->id('codMovement');
            $table->dateTime('date_movement');
            $table->unsignedBigInteger('codOperationType')->nullable();
            $table->foreign('codOperationType')->references('codOperationType')->on('operation_types');

            $table->unsignedBigInteger('codEmisor')->nullable();
            $table->foreign('codEmisor')->references('id')->on('users');

            $table->unsignedBigInteger('codReceptor')->nullable();
            $table->foreign('codReceptor')->references('id')->on('users');

            $table->float('amount', 13, 2);

            $table->boolean('success')->default(0);

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
        Schema::dropIfExists('movements');
    }
}
