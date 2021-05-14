<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'asmir',
            'email'=>'asmir@gmail.com',
            'password'=>bcrypt('123456789'),
            'phoneNumber'=>'+34-653-929-066',
            'address_id'=>1,
        ]);
        User::create([
            'name'=>'joao',
            'email'=>'joao@gmail.com',
            'password'=>bcrypt('123456789'),
            'phoneNumber'=>'+34-618-164-949',
            'address_id'=>1,
        ]);
        User::factory(18)->create();
    }
}
