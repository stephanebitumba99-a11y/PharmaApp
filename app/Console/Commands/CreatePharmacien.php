<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Pharmacien;
use Illuminate\Support\Facades\Hash;

class CreatePharmacien extends Command
{
    protected $signature = 'pharmacien:create
                            {name}
                            {first_name}
                            {phone_number}
                            {gender}
                            {age}';

    protected $description = 'Créer un pharmacien avec son compte utilisateur';

    public function handle()
    {
        $user = User::create([
            'name' => $this->argument('name'),
            'email' => strtolower($this->argument('name')) . '@pharma.com',
            'password' => Hash::make('password123'),
        ]);

        $pharmacien = Pharmacien::create([
            'Name' => $this->argument('name'),
            'First_name' => $this->argument('first_name'),
            'phone_number' => $this->argument('phone_number'),
            'gender' => $this->argument('gender'),
            'age' => $this->argument('age'),
            'user_id' => $user->id,
        ]);

        $this->info("Pharmacien créé avec succès !");
        $this->info("ID Pharmacien : {$pharmacien->id}");
        $this->info("Email : {$user->email}");
        $this->info("Mot de passe : password123");

        return Command::SUCCESS;
    }
}