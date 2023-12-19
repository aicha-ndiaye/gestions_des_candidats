<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{


    public function create(Request $request)
    {
        $formation = $request->validate([
            'nomFormation' => 'required',
            'description' => 'required',
            'dateDebut' => 'required',
            'dateFin' => 'required'
        ]);

        $formations = new Formation($formation);
        $formations->save();

        return response()->json(['message' => 'formation ajouté avec succès', 'formation' => $formation], 200);
    }


    public function index_Formation($id)
    {
        $formation = Formation::findOrFail($id);
        return response()->json($formation, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $formation = Formation::find($id);
        $formation->nomFormation = $request->nomFormation;
        $formation->description = $request->description;
        $formation->dateDebut = $request->dateDebut;
        $formation->dateFin = $request->dateFin;
        $formation->save();

        return response()->json(['message' => 'formation modifié avec succès', 'formation' => $formation], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function archiver_formation(Request $request, int $id)
    {
        $formation = Formation::find($id);
        $formation->is_deleted = true;
        $formation->save();

        return response()->json(['message' => 'formation archivé avec succès', 'formation' => $formation], 200);
    }

    public function accepter($id){

        $formation=Formation::Find($id);
        $formation->accepte=true;
        $formation->save();
        return response()->json(['message'=>'formation accepter','formation'=>$formation],200);

    }

    public function refuser($id){
        $formation= new Formation();
        $formation=Formation::Find($id);
        $formation->est_accepte=false;
        $formation->save();
        return response()->json(['message'=>'formation refuser','formation'=>$formation],200);

    }
}
