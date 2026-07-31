<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pharmacien;

class PharmacienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pharmacien::create([
            'Name' => 'Jule',
            'First_name' => 'Jule',
            'phone_number' => '0022200222',
            'gender' => 'Masculin',
            'age' => 30,
            'user_id' => 1, 
        ]);
    }
}
