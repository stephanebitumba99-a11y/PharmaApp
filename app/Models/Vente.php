<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    protected $fillable = [
        'total'
    ];

    public function details()
    {
        return $this->hasMany(VenteDetail::class);
    }
}