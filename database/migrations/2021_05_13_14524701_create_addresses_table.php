<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id('codAddress');
            $table->string('name')->nullable();
            $table->string('addressPrimary')->nullable();
            $table->string('addressSecundary')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->unsignedBigInteger('codCountry')->nullable();
            $table->foreign('codCountry')->references('codCountry')->on('countries');
            $table->unsignedBigInteger('codUser')->nullable();
            $table->foreign('codUser')->references('id')->on('users');
            $table->softDeletes(); //Columna para soft delete
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
        Schema::dropIfExists('addresses');
    }
}
