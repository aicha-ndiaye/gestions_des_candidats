<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function ajouterCandidat(Request $request)
    {
         $request->validate([
            'nom' => 'required|string|min:4|regex:/^[a-zA-Z]+$/',
             'prenom' => 'required|string|min:4|regex:/^[a-zA-Z]+$/',
             'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'competence'=>'required',
            'motivation'=>'required',
        ]);

        $rolecandidat = Role::where('nomRole', 'candidat')->first();
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'motivation' => $request->motivation,
            'competences' => $request->competences
        ]);

        $user->roles()->attach($rolecandidat);

        return response()->json(['message' => 'candidat ajouté avec succès'], 201);

}


public function ajouterAdmin(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|min:4|regex:/^[a-zA-Z]+$/',
            'prenom' => 'required|string|min:4|regex:/^[a-zA-Z]+$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'competence'=>'required',
            'motivation'=>'required',
        ]);
        if ($request->fails()) {
            return response()->json($request->errors(), 400);

        $roleadmin = Role::where('nomRole', 'admin')->first();
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,

        ]);

        $user->roles()->attach($roleadmin);

        return response()->json(['message' => 'admin ajouté avec succès'], 201);
    }
}

public function login(Request $request)
{

    // data validation
    $request->validate([
        "email" => "required|email",
        "password" => "required"
    ]);

    // JWTAuth
    $token = JWTAuth::attempt([
        "email" => $request->email,
        "password" => $request->password
    ]);

    if (!empty($token)) {

        return response()->json([
            "status" => true,
            "message" => "utilisateur connecter avec succe",
            "token" => $token
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
    public function index($id)
    {
        $user=User::FindOrFail($id);
        return response()->json($user, 200);

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
