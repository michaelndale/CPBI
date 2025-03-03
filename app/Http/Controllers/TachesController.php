<?php

namespace App\Http\Controllers;

use App\Models\responsabilite;
use App\Models\taches;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TachesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $title = 'Responsabilite';

        $responsabilite = responsabilite::findOrFail($id);
      

        return view(
            'taches.index',
            [
                'title'     => $title,
                'responsabilite'  => $responsabilite
            ]
        );
    }

    public function liste($id)
    {
        try {
            // Récupère toutes les responsabilités associées à la fonction ayant l'ID $id
            $taches = taches::join('users', 'taches.user_id', '=', 'users.id')
                ->join('personnels', 'users.personnelid', '=', 'personnels.id')
                ->select('taches.*', 'personnels.prenom as user_prenom', 'personnels.nom as user_nom')
                ->where('responsabilite_id', $id)
                ->get();

            // Retourne les données au format JSON
            return response()->json([
                'success' => true,
                'html' => view('taches.liste', compact('taches'))->render(), // Génère le HTML de la vue partielle
            ]);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse d'erreur
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors du chargement des taches.',
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {

            $responsabilite = taches::where('titre', $request->titre)
                ->where('responsabilite_id', $request->responsabilite_id)
                ->first();
            if ($responsabilite) {
                return response()->json(['status' => 201, 'message' => 'La tâche existe déjà!']);
            }

            // Création du responsabilite
            $responsabilite = new taches();

            $responsabilite->responsabilite_id  =  $request->responsabilite_id;
            $responsabilite->titre        =  $request->titre;
            $responsabilite->user_id      =  Auth::id();

            $responsabilite->save();

            // Retourner une réponse JSON
            return response()->json([
                'message' => 'Tâche ajouté avec succès',
                'status' => 200,
            ]);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner un message d'erreur
            return response()->json(['message' => 'Une erreur est survenue. Veuillez réessayer.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        try {

            $emp = taches::findOrFail($request->id);
            if ($emp->user_id == Auth::id()) {
                
                $id = $request->id;
                taches::destroy($id);

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
