<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Setting;

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

    protected $appends = [
        'price_cdf',
    ];

    public function venteDetails()
    {
        return $this->hasMany(VenteDetail::class);
    }

    public function getPriceCdfAttribute()
    {
        $setting = Setting::first();

        $taux = $setting ? $setting->usd_to_cdf : 2300;

        return round($this->price * $taux, 2);
    }
}
