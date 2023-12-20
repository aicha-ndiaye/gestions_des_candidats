<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\User_role;
use Illuminate\Support\Facades\Validator;
use App\Models\Formation;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */


     public function ajouterCandidat(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'nom' => ['required', 'string', 'min:4', 'regex:/^[a-zA-Z]+$/'],
             'prenom' => ['required', 'string', 'min:4', 'regex:/^[a-zA-Z ]+$/'],
             'email' => ['required', 'email', 'unique:users,email'],
             'password' => Rules\Password::defaults(),
             'motivation' => ['required'],
             'competences' => ['required'],
         ]);

         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()], 422);
         }

         $roleCandidat = Role::where('nomRole', 'candidat')->first();

         $user = User::create([
             'nom' => $request->nom,
             'prenom' => $request->prenom,
             'email' => $request->email,
             'password' => Hash::make($request->password),
             'role_id' => $roleCandidat->id,
             'motivation' => $request->motivation,
             'competences' => $request->competences,
         ]);

         return response()->json(['message' => 'Candidat ajouté avec succès'], 201);
     }


     public function ajouterAdmin(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'nom' => ['required', 'string', 'min:4', 'regex:/^[a-zA-Z]+$/'],
             'prenom' => ['required', 'string', 'min:4', 'regex:/^[a-zA-Z ]+$/'],
             'email' => ['required', 'email', 'unique:users,email'],
             'password' => Rules\Password::defaults(),

         ]);

         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()], 422);
         }

         $roleAdmin = Role::where('nomRole', 'admin')->first();



         $user = User::create([
             'nom' => $request->nom,
             'prenom' => $request->prenom,
             'email' => $request->email,
             'password' => Hash::make($request->password),
             'role_id' => $roleAdmin->id,

         ]);

         return response()->json(['message' => 'Admin ajouté avec succès'], 201);
     }

     public function login(Request $request)
     {
         $validator = Validator::make($request->all(), [
             "email" => "required|email",
             "password" => Rules\Password::defaults()
         ]);
         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()], 422);
         }

         // JWTAuth
         $token = JWTAuth::attempt([
             "email" => $request->email,
             "password" => $request->password
         ]);

         if (!empty($token)) {

             return response()->json([
                 "status" => true,
                 "message" => "utilisateur connecté avec succe",
                 "token" => $token,
                 "user"=>auth()->user()
             ]);
         }

         return response()->json([
             "status" => false,
             "message" => "details invalide"
         ]);
     }

    /**
     * Store a newly created resource in storage.
     */
    public function index()
    {
        $user=User::all();
        return response()->json($user, 200);

    }

    public function listeCandidats()
{

    if (!auth()->check()) {
        return response()->json(['message' => 'Non autorisé , vous devez vous connecté'], 401);
    }
    $user = auth()->user();

    if (!auth()->user()->role_id===2) {
        return response()->json(['message' => 'Non autorisé. Seuls les administrateurs peuvent ajouter des formations.'], 403);
    }
    // Récupérer le rôle "candidat"
    $roleCandidat = Role::where('nomRole', 'candidat')->first();

    // Vérifier si le rôle "candidat" existe
    if (!$roleCandidat) {
        return response()->json(['message' => 'Rôle "candidat" non trouvé'], 404);
    }

    // Récupérer tous les utilisateurs ayant le rôle "candidat"
    $candidats =User::where('role_id',1)->get();

    // Retourner la liste des candidats
    return response()->json($candidats, 200);
}




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
