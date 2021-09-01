<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Address::create([
            'address'=>null,
            'postal_code'=>null,
            'city'=>null,
            'state'=>null,
            'codCountry'=>1,
        ]);*/
        Address::factory(20)->create();
    }
}
