<?php

namespace App\Imports;

use App\Models\Produit;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProduitsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * Transforme chaque ligne de l'Excel en instance de Produit
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Traitement de la date d'expiration (gestion des entiers Excel ou chaînes de caractères)
        $dateExpiration = null;
        if (!empty($row['date_expiration'])) {
            if (is_numeric($row['date_expiration'])) {
                
                $dateExpiration = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_expiration'])->format('Y-m-d');
            } else {
                $dateExpiration = Carbon::parse($row['date_expiration'])->format('Y-m-d');
            }
        }

        return new Produit([
            'name'            => $row['name'],
            'category'        => $row['category'],
            'quantite'        => (int) $row['quantite'],
            'price'           => (float) $row['price'],
            'emplacement'     => $row['emplacement'],
            'date_expiration' => $dateExpiration,
        ]);
    }

    /**
     * Règles de validation pour chaque ligne du fichier Excel
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.name'            => 'required|string|max:255',
            '*.category'        => 'required|string|max:255',
            '*.quantite'        => 'required|integer|min:0',
            '*.price'           => 'required|numeric|min:0',
            '*.emplacement'     => 'required|string|max:255',
            '*.date_expiration' => 'nullable',
        ];
    }

    /**
     * Personnalisation des noms d'attributs pour les messages d'erreur
     *
     * @return array
     */
    public function customValidationAttributes(): array
    {
        return [
            '*.name'            => 'nom du produit',
            '*.category'        => 'catégorie',
            '*.quantite'        => 'quantité',
            '*.price'           => 'prix',
            '*.emplacement'     => 'emplacement',
            '*.date_expiration' => 'date d\'expiration',
        ];
    }
}