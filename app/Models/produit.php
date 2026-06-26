<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'category',
        'quantite',
        'price',
        'emplacement',
        'date_expiration',
    ];

    public function venteDetails()
    {
        return $this->hasMany(VenteDetail::class);
    }
}