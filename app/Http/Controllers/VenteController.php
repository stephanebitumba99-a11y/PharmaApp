<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Vente;
use App\Models\VenteDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VenteController extends Controller
{
    public function index()
    {
        $ventes = Vente::with('details.produit')
            ->orderBy('id', 'desc')
            ->take(200) 
            ->get();

        return response()->json($ventes, 200, [], JSON_UNESCAPED_UNICODE);
    }
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'client_name' => 'required|string|max:255',
                'produits' => 'required|array|min:1',
                'produits.*.id' => 'required|exists:produits,id',
                'produits.*.quantite' => 'required|integer|min:1'
            ], [
                'client_name.required' => 'Le nom du client est obligatoire',
                'produits.required' => 'Au moins un produit est requis',
                'produits.*.id.exists' => 'Le produit sélectionné n\'existe pas',
                'produits.*.quantite.min' => 'La quantité doit être au moins 1',
            ]);

            DB::beginTransaction();

            $total = 0;
            $produitsData = [];

            foreach ($validated['produits'] as $item) {
                $produit = Produit::findOrFail($item['id']);
                
                if ($produit->quantite < $item['quantite']) {
                    DB::rollBack();
                    return response()->json([
                        'message' => 'Stock insuffisant',
                        'error' => "Stock insuffisant pour le produit: {$produit->name} (Disponible: {$produit->quantite}, Demandé: {$item['quantite']})",
                        'produit' => $produit->name,
                        'disponible' => $produit->quantite,
                        'demande' => $item['quantite']
                    ], 400);
                }
                
                $prix = $produit->price;
                $sousTotal = $prix * $item['quantite'];
                $total += $sousTotal;
                
                $produitsData[] = [
                    'produit' => $produit,
                    'quantite' => $item['quantite'],
                    'prix' => $prix
                ];
            }

            $date = date('Ymd');
            $count = Vente::whereDate('created_at', today())->count() + 1;
            $numeroFacture = 'FAC-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

            $vente = Vente::create([
                'client_name' => $validated['client_name'],
                'facture_numero' => $numeroFacture,
                'total' => $total
            ]);

            foreach ($produitsData as $data) {
                $produit = $data['produit'];
                
                VenteDetail::create([
                    'vente_id' => $vente->id,
                    'produit_id' => $produit->id,
                    'quantite' => $data['quantite'],
                    'price' => $data['prix']
                ]);
                
                $produit->quantite -= $data['quantite'];
                $produit->save();
            }

            DB::commit();

            $vente->load('details.produit');

            return response()->json([
                'message' => 'Vente créée avec succès',
                'data' => $vente,
                'facture_numero' => $numeroFacture,
                'client_name' => $validated['client_name'],
                'total' => $total
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de la création de la vente',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $vente = Vente::with('details.produit')
                ->findOrFail($id);
            return response()->json($vente);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Vente non trouvée',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $vente = Vente::findOrFail($id);
            
            $validated = $request->validate([
                'client_name' => 'sometimes|string|max:255',
                'total' => 'sometimes|numeric|min:0'
            ]);

            $vente->update($validated);

            return response()->json([
                'message' => 'Vente mise à jour avec succès',
                'data' => $vente
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la mise à jour',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $vente = Vente::with('details')->findOrFail($id);

            
            foreach ($vente->details as $detail) {
                $produit = Produit::find($detail->produit_id);
                if ($produit) {
                    $produit->quantite += $detail->quantite;
                    $produit->save();
                }
            }

           
            $vente->details()->delete();
            $vente->delete();

            DB::commit();

            return response()->json([
                'message' => 'Vente supprimée avec succès',
                'deleted_id' => $id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de la suppression',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function today()
    {
        $ventes = Vente::with('details.produit')
            ->whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'data' => $ventes,
            'count' => $ventes->count(), 
            'total' => $ventes->sum('total')
        ]);
    }

    
    public function stats()
    {
        $totalVentes = Vente::count();
        $totalCa = Vente::sum('total');
        $ventesAujourdHui = Vente::whereDate('created_at', today())->count();
        $caAujourdHui = Vente::whereDate('created_at', today())->sum('total');

        return response()->json([
            'total_ventes' => $totalVentes,
            'total_ca' => $totalCa,
            'ventes_aujourdhui' => $ventesAujourdHui,
            'ca_aujourdhui' => $caAujourdHui
        ]);
    }
}