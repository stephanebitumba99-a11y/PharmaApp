<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Vente;

class DashboardController extends Controller
{
public function stats()
{
    $stock = Produit::where('quantite', '<', 5);

    return response()->json([
        'produits' => Produit::toBase()->count(),
        'ventes' => Vente::toBase()->count(),
        'stock_faible' => $stock->toBase()->count(),
        'stock_faible_list' => $stock
            ->select('id','name','category','quantite','emplacement','price')
            ->limit(10)
            ->get(),
        'ca' => Vente::toBase()->sum('total') ?? 0
    ]);
}
}