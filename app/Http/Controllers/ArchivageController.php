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
    public function getarchive(Request $request)
    {
      $id = $request->id;
      $resul =  Archive::where('classeur_id',$id)->orderBy('id', 'DESC')->get(); 
      $output = '';
      if ($resul->count() > 0) {
        $output .= '
     
        <table class="table table-striped table-sm fs--1 mb-0">
            <thead>
            <tr>
              <th class="align-middle ps-3 name">#</th>
              <th >Titre</th>
              <th >Statut</th>
              <th >Attache</th>
              <th >Date</th>
              <th><center>Action</center></th>
            </tr>
          </thead>
          <tbody class="list">
           ';
        $nombre = 1;
        foreach ($resul as $rs) {
          $output .= '<tr>
              <td class="align-middle ps-3 name">' . $nombre . '</td>
              <td>' . ucfirst($rs->title). '</td>
              <td>' . ucfirst($rs->type). '</td>
              <td><a href="' . $rs->document_path. '" ><i class="fa fa-file"></i></a></td>
              <td>' . ucfirst($rs->created_at). '</td>
              <td>
              <center>
              <a href="#" id="' . $rs->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editModal" title="Modifier" ><i class="far fa-edit"></i> </a>
              <a href="#" id="' . $rs->id . '" class="text-danger mx-1 deleteIcon" title="Supprimer"><i class="far fa-trash-alt"></i></a>
            </center>
               
              </td>
            </tr>';
          $nombre++;
        }
        $output .= '</tbody></table>';
        echo $output;
      } else {
        echo '<h4 class="text-center text-secondery my-5" > Aucun données pour cette classeur ! </h4>';
      }

      
      //return response()->json($fon);
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

