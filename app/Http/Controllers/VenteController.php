<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Vente;
use App\Models\VenteDetail;
use Illuminate\Http\Request;

class VenteController extends Controller
{
    /**
     *  LISTE DES VENTES
     */
    public function index()
    {
        $ventes = Vente::with('details.produit')->orderBy('id', 'desc')->get();

        return response()->json($ventes);
    }

    /**
     *  CRÉER UNE VENTE
     */
    public function store(Request $request)
    {
        $request->validate([
            'produits' => 'required|array'
        ]);

        $total = 0;

        // 1️ Vérifier stock + calcul total
        foreach ($request->produits as $item) {

            $produit = Produit::findOrFail($item['id']);

            if ($produit->quantite < $item['quantite']) {
                return response()->json([
                    'message' => 'Stock insuffisant pour ' . $produit->name
                ], 400);
            }

            $total += $produit->price * $item['quantite'];
        }

        // 2️ Créer vente
        $vente = Vente::create([
            'total' => $total
        ]);

        //  Créer détails + update stock
        foreach ($request->produits as $item) {

            $produit = Produit::findOrFail($item['id']);

            VenteDetail::create([
                'vente_id' => $vente->id,
                'produit_id' => $produit->id,
                'quantite' => $item['quantite'],
                'price' => $produit->price
            ]);

            // mise à jour stock
            $produit->quantite -= $item['quantite'];
            $produit->save();
        }

        return response()->json([
            'message' => 'Vente créée avec succès',
            'data' => $vente
        ]);
    }

    /**
     *  AFFICHER UNE VENTE
     */
    public function show($id)
    {
        $vente = Vente::with('details.produit')->findOrFail($id);

        return response()->json($vente);
    }

    /**
     *  UPDATE VENTE (simple - total uniquement)
     */
    public function update(Request $request, $id)
    {
        $vente = Vente::findOrFail($id);

        $vente->update([
            'total' => $request->total
        ]);

        return response()->json([
            'message' => 'Vente mise à jour',
            'data' => $vente
        ]);
    }

    /**
     *  SUPPRIMER UNE VENTE
     */
    public function destroy($id)
    {
        $vente = Vente::findOrFail($id);

        //  restaurer stock si suppression
        foreach ($vente->details as $detail) {
            $produit = Produit::find($detail->produit_id);

            if ($produit) {
                $produit->quantite += $detail->quantite;
                $produit->save();
            }
        }

        $vente->delete();

        return response()->json([
            'message' => 'Vente supprimée avec succès'
        ]);
    }
}