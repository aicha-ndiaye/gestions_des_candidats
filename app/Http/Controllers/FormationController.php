<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormationController extends Controller
{
    public function create(Request $request)
{
    // Vérifions si l'utilisateur est connecté
     if (!auth()->check()) {
        return response()->json(['message' => 'Non autorisé , vous devez vous connecté'], 401);
    }

    // Vérifier si l'utilisateur a le rôle admin
    $user = auth()->user();
    // dd($user);
    if (!auth()->user()->role_id===2) {
        return response()->json(['message' => 'Non autorisé. Seuls les administrateurs peuvent ajouter des formations.'], 403);
    }
    // Validation des données de la requête
    $validator = Validator::make($request->all(), [
        'nomFormation' => 'required|string',
        'description' => 'required|string',
        'lieuFormation' => 'required|string',
        'dateDebut' => 'required|date',
        'dateFin' => 'required|date',

    ]);

    // Vérifions s'il ya pas derreur de validation
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $formation = Formation::create([
        'nomFormation' => $request->nomFormation,
        'description' => $request->description,
        'lieuFormation' => $request->lieuFormation,
        'dateDebut' => $request->dateDebut,
        'dateFin' => $request->dateFin,
        // 'user_id'=>$request->user()->id

    ]);

    return response()->json(['message' => 'Formation ajoutée avec succès', 'formation' => $formation], 201);
}

    public function index_Formation()
{
    $formations = Formation::all();
    return response()->json($formations, 200);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Non autorisé , vous devez vous connecté'], 401);
        }
        $user = auth()->user();

        if (!auth()->user()->role_id===2) {
            return response()->json(['message' => 'Non autorisé. Seuls les administrateurs peuvent ajouter des formations.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'nomFormation' => 'required|string',
            'description' => 'required|string',
            'lieuFormation' => 'required|string',
            'dateDebut' => 'required|date',
            'dateFin' => 'required|date',
        ]);

        // Vérifier s'il y a des erreurs de validation
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $formation = Formation::find($id);

        // Vérifier si la formation existe
        if (!$formation) {
            return response()->json(['message' => 'Formation non trouvée'], 404);
        }

        // Mettre à jour la formation
        $formation->update([
            'nomFormation' => $request->nomFormation,
            'description' => $request->description,
            'lieuFormation' => $request->lieuFormation,
            'dateDebut' => $request->dateDebut,
            'dateFin' => $request->dateFin,
        ]);

        return response()->json(['message' => 'Formation modifiée avec succès', 'formation' => $formation], 200);
    }


    public function destroy($id)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Non autorisé , vous devez vous connecté'], 401);
        }
        $user = auth()->user();

        if (!auth()->user()->role_id===2) {
            return response()->json(['message' => 'Non autorisé. Seuls les administrateurs peuvent supprimer des formations.'], 403);
        }

        $formation = Formation::findOrFail($id);

        if (!$formation) {
            return response()->json(['message' => 'formation non trouvé'], 404);
        }

        $formation->delete();

        return response()->json(['message' => 'formation supprime avec succès'], 200);
    }
}
