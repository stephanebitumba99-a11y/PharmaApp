<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProduitResource;
use Illuminate\Http\Request;
use App\Models\Produit;
use App\Imports\ProduitsImport;
use Maatwebsite\Excel\Facades\Excel;
class ProduitController extends Controller
{

    public function index(Request $request)
{
    $query = Produit::query();

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('category', 'like', "%{$search}%")
              ->orWhere('emplacement', 'like', "%{$search}%");
        });
    }

    $produits = $query->paginate(10);

    return response()->json([
        'data' => ProduitResource::collection($produits->items()),
        'meta' => [
            'current_page' => $produits->currentPage(),
            'last_page' => $produits->lastPage(),
            'per_page' => $produits->perPage(),
            'total' => $produits->total(),
        ]
    ]);
}

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new ProduitsImport, $request->file('file'));

            return response()->json([
                'message' => 'Produits importés avec succès !'
            ], 200);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            
            return response()->json([
                'message' => 'Erreur de validation lors de l\'importation',
                'errors'  => $failures
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de l\'importation',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantite' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'emplacement' => 'required|string|max:255',
            'date_expiration' => 'nullable|date'
        ]);

        $produit = Produit::create($validated);

        return response()->json([
            'message' => 'Produit créé avec succès',
            'data' => $produit
        ], 201);
    }

    public function show($id)
    {
        $produit = Produit::find($id);

        if (!$produit) {
            return response()->json([
                'message' => 'Produit non trouvé'
            ], 404);
        }

        return response()->json([
            'data' => $produit  
        ]);
    }

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