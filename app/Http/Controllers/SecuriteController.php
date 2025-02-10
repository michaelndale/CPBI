<?php

namespace App\Http\Controllers;

use App\Models\ExerciceProjet;
use App\Models\Project;
use App\Models\Securite;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SecuriteController extends Controller
{
    public function index()
    {
      $title = 'Securite';

      $Project = Project::all();

      $lastExercice = Securite::latest('id')->first();

      return view(
        'securite.index',
        [
          'title'   => $title,
          'project' => $Project,
          'lastExercice'    => $lastExercice
        ]
      );
    }

    public function store(Request $request)
    {
        try {
            // Validation des données
            $validatedData = $request->validate([
                'code' => 'required|string|max:255',
                'project_id' => 'required|array',
                'project_id.*' => 'integer|exists:exercice_projets,project_id',
                'exercice_id' => 'required|array',
                'exercice_id.*' => 'integer|exists:exercice_projets,id',
                'status_exe' => 'required|array',
                'status_exe.*' => 'boolean', // Valeurs possibles : true (1) ou false (0)
            ]);
    
            $hasUpdates = false; // Indicateur pour les mises à jour
            $hasCreations = false; // Indicateur pour les créations
    
            foreach ($validatedData['project_id'] as $key => $projectId) {
                $exerciceId = $validatedData['exercice_id'][$key];
                $status = $validatedData['status_exe'][$key] ? 1 : 0;
    
                // Vérifier si l'enregistrement existe déjà
                $existingRecord = Securite::where('project_id', $projectId)
                    ->where('exercice_id', $exerciceId)
                    ->first();
    
                if ($existingRecord) {
                    // Mettre à jour l'enregistrement existant
                    $existingRecord->update([
                        'code' => $validatedData['code'],
                        'statut' => $status,
                    ]);
                    $hasUpdates = true;
                } else {
                    // Créer un nouvel enregistrement
                    Securite::create([
                        'project_id' => $projectId,
                        'exercice_id' => $exerciceId,
                        'code' => $validatedData['code'],
                        'statut' => $status,
                    ]);
                    $hasCreations = true;
                }
            }
    
            // Déterminer le message final en fonction des actions effectuées
            if ($hasUpdates && $hasCreations) {
                $message = "Mise à jour et création d'enregistrements réussies.";
            } elseif ($hasUpdates) {
                $message = "Mise à jour des enregistrements réussie.";
            } elseif ($hasCreations) {
                $message = "Création des enregistrements réussie.";
            } else {
                $message = "Aucune modification n'a été effectuée.";
            }
    
            // Retourner la réponse JSON avec le message final
            return response()->json([
                'success' => true,
                'message' => $message,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la sauvegarde des données',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
