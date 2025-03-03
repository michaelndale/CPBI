<?php

namespace App\Http\Controllers;

use App\Models\Fonction;
use App\Models\responsabilite;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResponsabiliteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $title = 'Responsabilite';

        $fonction = Fonction::findOrFail($id);

        return view(
            'responsabilites.index',
            [
                'title'     => $title,
                'fonction'  => $fonction
            ]
        );
    }

    public function liste($id)
    {
        try {
            // Récupère toutes les responsabilités associées à la fonction ayant l'ID $id
            $responsabilites = Responsabilite::join('users', 'responsabilites.user_id', '=', 'users.id')
                ->join('personnels', 'users.personnelid', '=', 'personnels.id')
                ->select('responsabilites.*', 'personnels.prenom as user_prenom', 'personnels.nom as user_nom')
                ->where('fonction_id', $id)->get();

            // Retourne les données au format JSON
            return response()->json([
                'success' => true,
                'html' => view('responsabilites.liste', compact('responsabilites'))->render(), // Génère le HTML de la vue partielle
            ]);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse d'erreur
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors du chargement des responsabilités.',
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $responsabilite = Responsabilite::where('titre', $request->titre)
                ->where('fonction_id', $request->fonction_id)
                ->first();
            if ($responsabilite) {
                return response()->json(['status' => 201, 'message' => 'Le Bailleur existe déjà!']);
            }

            // Création du responsabilite
            $responsabilite = new Responsabilite();

            $responsabilite->fonction_id  =  $request->fonction_id;
            $responsabilite->titre        =  $request->titre;
            $responsabilite->user_id      =  Auth::id();

            $responsabilite->save();

            // Retourner une réponse JSON
            return response()->json([
                'message' => 'Responsabilité ajouté avec succès',
                'status' => 200,
            ]);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner un message d'erreur
            return response()->json(['message' => 'Une erreur est survenue. Veuillez réessayer.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(responsabilite $responsabilite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(responsabilite $responsabilite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, responsabilite $responsabilite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        try {

            $emp = responsabilite::findOrFail($request->id);
            if ($emp->user_id == Auth::id()) {
                
                $id = $request->id;
                responsabilite::destroy($id);

                return response()->json([
                    'status' => 200,
                ]);
            } else {
                return response()->json([
                    'status' => 205,
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 202,
            ]);
        }
    }
}
