<?php

namespace Database\Seeders;

use App\Models\OperationType;
use App\Models\User;
use Illuminate\Database\Seeder;

class OperationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OperationType::create([
            'operation_type' => 'ingreso'
        ]);
        OperationType::create([
            'operation_type' => 'retiro'
        ]);
        OperationType::create([
            'operation_type' => 'transferencia'
        ]);
    }
}
