<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produit;
use Carbon\Carbon;
class ProduitSeeder extends Seeder
{
    public function run(): void
    {
        $produits = [
            [
                'name' => 'Doliprane 500mg',
                'category' => 'Antalgique',
                'quantite' => 100,
                'price' => 0.8,
                'emplacement' => 'A1',
                'date_expiration' => Carbon::now()->addMonths(12),
            ],
            [
                'name' => 'Amoxicilline 500mg',
                'category' => 'Antibiotique',
                'quantite' => 50,
                'price' => 0.6,
                'emplacement' => 'A2',
                'date_expiration' => Carbon::now()->addMonths(18),
            ],

            [
                'name' => 'Vitamine C',
                'category' => 'Complément',
                'quantite' => 80,
                'price' => 0.6,
                'emplacement' => 'B1',
                'date_expiration' => Carbon::now()->addMonths(24),
            ],
            [
                'name' => 'Sirop Toux Enfant',
                'category' => 'Sirop',
                'quantite' => 30,
                'price' => 0.3,
                'emplacement' => 'B2',
                'date_expiration' => Carbon::now()->addMonths(10),
            ],
            [
                'name' => 'Ibuprofène 400mg',
                'category' => 'Anti-inflammatoire',
                'quantite' => 60,
                'price' => 1,
                'emplacement' => 'C1',
                'date_expiration' => Carbon::now()->addMonths(15),
            ],
            [
                'name' => 'Sérum physiologique',
                'category' => 'Soin',
                'quantite' => 120,
                'price' => 0.2,
                'emplacement' => 'C2',
                'date_expiration' => Carbon::now()->addMonths(20),
            ],
        ];

        foreach($produits as $produit){
            Produit::create($produit);
        }
    }
}