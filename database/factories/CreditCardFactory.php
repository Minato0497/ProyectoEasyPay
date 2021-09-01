<?php

namespace Database\Factories;

use App\Models\CreditCard;
use Illuminate\Database\Eloquent\Factories\Factory;

class CreditCardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CreditCard::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name(),
            'credit_card_type'=>$this->faker->creditCardType,
            'credit_card_numbers'=>$this->faker->creditCardNumber,
            'credit_card_expiration_date'=>$this->faker->creditCardExpirationDateString,
            'code'=>$this->faker->numberBetween(100, 9999),
            'savings_account'=>$this->faker->randomFloat(2, 0, 10000000),
            'current_account'=>$this->faker->randomFloat(2, 0, 10000000),
            'codUser'=>$this->faker->numberBetween(1, 20),
        ];
    }
}
