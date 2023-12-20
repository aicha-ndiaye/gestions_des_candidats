<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CandidatureController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }



    public function enregistrerCandidature(Request $request)
    {
        // Vérifier si l'utilisateur est authentifié
        if (!auth()->check()) {
            return response()->json(['message' => 'Non autorisé, vous devez vous connecter'], 401);
        }
        // dd( $user = auth()->user());
        $user = auth()->user();
        // dd(auth()->user());

        // Vérifier si l'utilisateur a le rôle "candidat"
        if ($user->role_id==2) {
            return response()->json(['message' => 'Non autorisé. Seuls les candidats peuvent candidater.'], 403);
        }
        // Créer une candidature
        $candidature = Candidature::create([
            'user_id' => $user->id,
            'formation_id' => $request->formation_id,
            'status' => 'en_attente',
        ]);

        return response()->json(['message' => 'Candidature enregistrée avec succès', 'candidature' => $candidature], 201);
    }


    public function accepterCandidature(Request $request, $id)
    {
        // Vérifier si l'utilisateur est authentifié
        if (!auth()->check()) {
            return response()->json(['message' => 'Non autorisé, vous devez vous connecter'], 401);
        }

        // Récupérer l'utilisateur actuel
        $user = auth()->user();

        if ($user->role_id==1) {
            return response()->json(['message' => 'Non autorisé. Seuls les admin peuvent faire cette action.'], 403);
        }

        // Trouver la candidature par son ID
        $candidature = Candidature::find($id);

        // Vérifier si la candidature existe
        if (!$candidature) {
            return response()->json(['message' => 'Candidature non trouvée'], 404);
        }

        // Mettre à jour le statut de la candidature pour l'accepter
        $candidature->update(['status' => 'accepte']);

        // Retourner une réponse JSON
        return response()->json(['message' => 'Candidature acceptée avec succès', 'candidature' => $candidature], 200);
    }

    public function refuserCandidature(Request $request, $id)
    {
        $user = auth()->user();

        if ($user->role_id==1) {
            return response()->json(['message' => 'Non autorisé. Seuls les admin peuvent faire cette action.'], 403);
        }
        // Trouver la candidature par son ID
        $candidature = Candidature::find($id);

        // Vérifier si la candidature existe
        if (!$candidature) {
            return response()->json(['message' => 'Candidature non trouvée'], 404);
        }

        // Mettre à jour le statut de la candidature pour la refuser
        $candidature->update(['status' => 'refuse']);

        // Retourner une réponse JSON
        return response()->json(['message' => 'Candidature refusée avec succès', 'candidature' => $candidature], 200);
    }

    public function indexCandidature()
    {
        $formations = Candidature::all();
        return response()->json($formations, 200);
    }

    public function candidatsAcceptes()
    {
        $user = auth()->user();

        // Vérifier si l'utilisateur est admin
        if ($user->role_id == 1) {
            return response()->json(['message' => 'Non autorisé. Seuls les admins peuvent faire cette action.'], 403);
        }

        // Récupérer les candidats acceptés
        $candidatsAcceptes = Candidature::where('status', 'accepte')->get();

        // Vérifier si des candidats acceptés ont été trouvés
        if ($candidatsAcceptes->isEmpty()) {
            return response()->json(['message' => 'Aucune candidature acceptée trouvée'], 404);
        }

        // Retourner la liste des candidats acceptés en JSON
        return response()->json($candidatsAcceptes, 200);
    }

    public function candidatsRefuses()
    {
        $user = auth()->user();

        // Vérifier si l'utilisateur est admin
        if ($user->role_id == 1) {
            return response()->json(['message' => 'Non autorisé. Seuls les admins peuvent faire cette action.'], 403);
        }

        // Récupérer les candidats acceptés
        $candidatsRefuses = Candidature::where('status', 'refusee')->get();

        // Vérifier si des candidats acceptés ont été trouvés
        if ($candidatsRefuses->isEmpty()) {
            return response()->json(['message' => 'Aucune candidature refusée trouvée'], 404);
        }

        // Retourner la liste des candidats acceptés en JSON
        return response()->json($candidatsRefuses, 200);
    }

}
