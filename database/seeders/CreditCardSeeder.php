<?php

namespace Database\Seeders;

use App\Models\CreditCard;
use Illuminate\Database\Seeder;

class CreditCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*CreditCard::create([
            'name'=>'null',
            'credit_card_type'=>null,
            'credit_card_numbers'=>null,
            'credit_card_expiration_date'=>null,
            'code'=>null,
            'savings_account'=>0,
            'current_account'=>0,
            'user_id'=>1,
        ]);*/
        CreditCard::factory(21)->create();
    }
}
