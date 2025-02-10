<?php

namespace App\Http\Controllers;

use App\Models\ExerciceProjet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ExerciceController extends Controller
{
    // Afficher la liste des exercices d'un projet
    public function index()
    {
        // Récupérer l'ID de la session
        $projectId = session()->get('id');
        $title = "Exercice du projet";
       
        // Vérifier si l'ID de la session n'est pas défini
        
        if (!$projectId ) {
            // Gérer le cas où l'ID du projet et exercice est invalide
            return redirect()->back()->with('error', "La session du projet et de l'exercice est terminée. Vous allez être redirigé...");
        }

        $exercices = ExerciceProjet::where('project_id', $projectId)->orderBy('id', 'Desc')->get();

        return view('exercices.index', compact('exercices','title'));
    }

    // Afficher les détails d'un exercice spécifique
    public function show($exerciceId)
    {
        $title = "Modifier le projet";

        $exerciceId = Crypt::decrypt($exerciceId);

        $exercice = ExerciceProjet::find($exerciceId);

        return view('exercices.show', compact('exercice', 'title'));
    }

    public function Updateexe(Request $request)
    {
        // Validation des données avec des messages personnalisés
        $request->validate([
          
            'montant' => 'required|string', // Accepter le montant comme une chaîne pour permettre les espaces
            'datedebut' => 'required|date',
            'datefin' => 'required|date|after_or_equal:datedebut',
            'periode' => 'required|string',
            'pexercice' => 'nullable|string',
            'exe_id'    => 'required|integer'
        ], [
            // Messages pour chaque champ
            'pid.required' => 'Le champ Projet est obligatoire.',
            'pid.integer' => 'Le champ Projet doit être un entier valide.',
            
            'montant.required' => 'Le champ Montant est obligatoire.',
            'montant.string' => 'Le champ Montant doit être une chaîne de caractères.',
            
            'datedebut.required' => 'La date de début est obligatoire.',
            'datedebut.date' => 'La date de début doit être une date valide.',
            
            'datefin.required' => 'La date de fin est obligatoire.',
            'datefin.date' => 'La date de fin doit être une date valide.',
            'datefin.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.',
            
            'periode.required' => 'Le champ Période est obligatoire.',
            'periode.string' => 'Le champ Période doit être une chaîne de caractères.',
            
            'pexercice.string' => 'Le champ Exercice doit être une chaîne de caractères.',
        ]);
  
        // Supprimer les espaces dans le champ montant avant de l'utiliser
        $montant = str_replace(' ', '', $request->montant);
  
        // Vérifier si le montant est un nombre valide après suppression des espaces
        if (!is_numeric($montant)) {
            return back()->withErrors(['montant' => 'Le champ Montant doit être un nombre valide.']);
        }

        $exerciceId = $request->exe_id;
  
        // Mettre tous les autres projets ayant le même project_id en statut "Inactif"
        $project = ExerciceProjet::find($exerciceId);
        // Création du projet
      
        $project->budget = $montant; // Enregistrer le montant sans espaces
        $project->estart_date = $request->datedebut;
        $project->edeadline = $request->datefin;
        $project->eperiode = $request->periode;
        $project->pexercice = $request->pexercice; // Peut être null

        $project->update();
  
        // Rediriger vers la liste des projets avec un message de succès
        return back()->with('success', 'Exercice mises ajours avec succès.');

    }
}
