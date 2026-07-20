<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Pharmacien;


class PharmacienController extends Controller
{
    /**
     * Liste avec pagination (5)
     */
    public function index()
    {
       return response()->json([
    'data' => Pharmacien::all()
]);
}
  

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Name' => 'required|string|max:255',
            'First_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'gender' => 'required|in:M,F',
            'age' => 'required|integer|min:18',
            'user_id' => 'nullable|exists:users,id'
        ]);

        if (empty($validated['user_id'])) {

            $firstUser = User::first();

            if (!$firstUser) {
                return response()->json([
                    'message' => 'Aucun utilisateur trouvé en base'
                ], 422);
            }

            $validated['user_id'] = $firstUser->id;
        }

        $pharmacien = Pharmacien::create($validated);

        return response()->json([
            'message' => 'Pharmacien créé avec succès',
            'data' => $pharmacien
        ], 201);
    }
    
    public function show($id)
    {
        $pharmacien = Pharmacien::with('user')->find($id);

        if (!$pharmacien) {
            return response()->json([
                'message' => 'Pharmacien non trouvé'
            ], 404);
        }

        return response()->json($pharmacien);
    }

    
    public function update(Request $request, $id)
    {
        $pharmacien = Pharmacien::find($id);

        if (!$pharmacien) {
            return response()->json([
                'message' => 'Pharmacien non trouvé'
            ], 404);
        }

        $validated = $request->validate([
            'Name' => 'sometimes|string|max:255',
            'First_name' => 'sometimes|string|max:255',
            'phone_number' => 'nullable|string|max:10',
            'gender' => 'sometimes|in:M,F',
            'age' => 'sometimes|integer|min:18',
            'user_id' => 'sometimes|exists:users,id'
        ]);

        $pharmacien->update($validated);

        return response()->json([
            'message' => 'Pharmacien mis à jour',
            'data' => $pharmacien
        ]);
    }

    
    public function destroy($id)
    {
        $pharmacien = Pharmacien::find($id);

        if (!$pharmacien) {
            return response()->json([
                'message' => 'Pharmacien non trouvé'
            ], 404);
        }

        $pharmacien->delete();

        return response()->json([
            'message' => 'Pharmacien supprimé avec succès'
        ]);
    }
}