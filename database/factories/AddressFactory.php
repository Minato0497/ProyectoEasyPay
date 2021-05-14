<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name(),
            'addressPrimary'=>$this->faker->streetAddress,
            'addressSecundary'=>$this->faker->streetAddress,
            'postal_code'=>$this->faker->postcode,
            'city'=>$this->faker->city,
            'state'=>$this->faker->state,
            'country_id'=>$this->faker->numberBetween(2, 195),
            //'user_id'=>$this->faker->unique()->numberBetween(1, 20),
        ];
    }
}
