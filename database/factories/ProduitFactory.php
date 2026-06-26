<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProduitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Paracétamol', 'Amoxicilline', 'Ibuprofène', 'Doliprane', 'Vitamine C',
                'Insuline', 'Aspirine', 'Sirop toux', 'Antipaludéen', 'Antibiotique'
            ]) . ' ' . $this->faker->numberBetween(100, 10000) . 'mg',

            'category' => $this->faker->randomElement([
                'Antalgique',
                'Antibiotique',
                'Anti-inflammatoire',
                'Complément',
                'Sirop',
                'Injection'
            ]),

            'quantite' => $this->faker->numberBetween(0, 5000),

            'price' => $this->faker->randomFloat(2, 1, 1000),

            'emplacement' => strtoupper($this->faker->randomLetter()) . $this->faker->numberBetween(1, 10),

            'date_expiration' => $this->faker->dateTimeBetween('-1 year', '+2 years'),
        ];
    }
}