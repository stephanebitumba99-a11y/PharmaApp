<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenteDetail extends Model
{
    protected $fillable = [
        'vente_id',
        'produit_id',
        'quantite',
        'price'
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function vente()
    {
        return $this->belongsTo(Vente::class);
    }
}