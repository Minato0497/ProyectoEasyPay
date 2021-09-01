<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->id('codCreditCard');
            $table->string('name')->nullable();
            $table->string('credit_card_type')->nullable();
            $table->string('credit_card_numbers')->unique()->nullable();
            $table->string('credit_card_expiration_date')->nullable();
            $table->integer('code')->unique()->nullable();
            $table->decimal('savings_account', 9, 2)->default(100);
            $table->decimal('current_account', 9, 2)->default(100);
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
        Schema::dropIfExists('credit_cards');
    }
}
