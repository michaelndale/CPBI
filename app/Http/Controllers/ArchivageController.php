<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Classeur;
use App\Models\Lettreexpediction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArchivageController extends Controller
{
    public function index()
    {
      $title = 'Archivage';
      $active = 'Archivage';
      $classeur = Classeur::all();
      return view(
        'archive.index',
        [
          'title' => $title,
          'active' => $active,
          'classeur' => $classeur
        ]
      );
    }
    public function getArchive(Request $request)
    {
        $id = $request->id;
        $results = Archive::where('classeur_id', $id)->orderBy('id', 'DESC')->get();
        $output = '';
        if ($results->count() > 0) {
            $output .= '
                <table class="table table-striped table-sm fs--1 mb-0">
                    <thead>
                        <tr>
                            <th class="align-middle ps-3 name">#</th>
                            <th >Titre</th>
                            <th>Attache</th>
                            <th>Format</th> <!-- Nouvelle colonne pour le format -->
                            <th>Statut</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody class="list">';
            $nombre = 1;
            foreach ($results as $result) {
                $output .= '
                    <tr>
                        <td class="align-middle ps-3 name">' . $nombre . '</td>
                        <td style="width:50%">' . ucfirst($result->title) . '</td>
                        <td><center><a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="' . asset('storage/document/' . basename($result->document_path)) . '" title="Ouvrir le document"><i class="fas fa-file-export"></i></a></center></td>
                        <td>' . strtoupper(pathinfo($result->document_path, PATHINFO_EXTENSION)). '</td> <!-- Affiche le format du fichier -->
                        <td>' . $result->type . '</td>
                        <td>' . date('d-m-Y', strtotime($result->created_at)) . '</td>
                    </tr>';
                $nombre++;
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h4 class="text-center text-secondary my-5">Aucune donnée pour ce classeur !</h4>';
        }
    }
    
    

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            
            'description' => 'nullable|string',
        ]);
    
        try {
            // Création du dossier de destination s'il n'existe pas
            $destinationFolder = 'public/document';
            if (!Storage::exists($destinationFolder)) {
                Storage::makeDirectory($destinationFolder);
            }
    
            // Déplacer le fichier téléchargé dans le stockage
            $documentPath = $request->file('file_archive')->storeAs(
                $destinationFolder, // dossier de destination
                $request->file('file_archive')->getClientOriginalName() // nom de fichier
            );
    
            // Début de la transaction
            DB::beginTransaction();
    
            // Création de l'archive
            $archive = new Archive();
            $archive->title = $request->titre;
            $archive->type = $request->type;
            $archive->classeur_id = $request->classeur;
            $archive->etiquette_id = $request->etiquette;
            $archive->document_path = $documentPath;
            $archive->description = $request->description;
            $archive->userid = Auth::id();
            $archive->save();
    
            // Valider la transaction
            DB::commit();
    
            return response()->json(['message' => 'Données enregistrées avec succès !']);
        } catch (\Exception $e) {
            // Annuler la transaction en cas d'erreur
            DB::rollBack();
    
            // Supprimer le fichier en cas d'erreur
            if (isset($documentPath)) {
                Storage::delete($documentPath);
            }
    
            // Gérer l'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de l\'enregistrement des données : ' . $e->getMessage()], 500);
        }
    }
    


    public function storeUpload(Request $request)
    {
  
      try {
        
        $title = $request->numerolettre;
        $check = Lettreexpediction::where('numeolettre',$title)->first();
  
        if($check){
          return response()->json([
            'status' => 201,
          ]);
        }else{
          $lettre = new Lettreexpediction();
          $lettre->classeurid= $request->classeur;
          $lettre->numerogenerale= $request->numerogenerale;
          $lettre->numeolettre= $request->numerolettre;
          $lettre->datelettre= $request->datelettre;
          $lettre->dateexpedition= $request->dateexpiration;
          $lettre->destinateur= $request->destinateur;
          $lettre->note= $request->note;
          $lettre->userid = Auth()->user()->id;

          $lettre->save();
          return response()->json([
            'status' => 200,
          ]);
        }
      } catch (Exception $e) {
        return response()->json([
          'status' => 202,
        ]);
      }
    }


   
    
}

//<a href="{{ asset('storage/documents/' . basename($archive->document_path)) }}" download="{{ basename($archive->document_path) }}" title="Télécharger le document">Télécharger

