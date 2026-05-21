<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;

class ProduitController extends Controller
{

public function index()
{
    $produits = Produit::all();

    return response()->json([
        'data' => $produits
    ], 200);
}

    /**
     * Création
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantite' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',  
            'emplacement'=>'required|string|max:255',
            'date_expiration' => 'nullable|date'
        ]);

        $produit = Produit::create($validated);

        return response()->json([
            'message' => 'Produit créé avec succès',
            'data' => $produit
        ], 201);
    }

    /**
     * Afficher un produit
     */
    public function show($id)
    {
        $produit = Produit::find($id);

        if (!$produit) {
            return response()->json([
                'message' => 'Produit non trouvé'
            ], 404);
        }

        return response()->json($produit);
    }

    /**
     * Mise à jour
     */
    public function update(Request $request, $id)
    {
        $produit = Produit::find($id);

        if (!$produit) {
            return response()->json([
                'message' => 'Produit non trouvé'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'category' => 'sometimes|string|max:255',
            'quantite' => 'sometimes|integer|min:0',
            'price' => 'sometimes|numeric|min:0',
            'emplacement' => 'sometimes|string|max:255',
            'date_expiration' => 'nullable|date'
        ]);

        $produit->update($validated);

        return response()->json([
            'message' => 'Produit mis à jour',
            'data' => $produit
        ]);
    }

    /**
     * Suppression
     */
    public function destroy($id)
    {
        $produit = Produit::find($id);

        if (!$produit) {
            return response()->json([
                'message' => 'Produit non trouvé'
            ], 404);
        }

        $produit->delete();

        return response()->json([
            'message' => 'Produit supprimé avec succès'
        ]);
    }
}