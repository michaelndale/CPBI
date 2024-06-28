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
    
  public function getFullPath($classeur)
    {
        $path = $classeur->libellec;
        while ($classeur->parent != null) {
            $classeur = Classeur::find($classeur->parent);
            if ($classeur) {
                $path = $classeur->libellec . '/' . $path;
            }
        }
        return $path;
    }

    public function index()
    {
        $title = 'Archivage';
        $active = 'Archivage';
        $classeurADD = Classeur::all();
        $classeur = Classeur::whereNull('parent')->get();

        // Utiliser la fonction getFullPath pour chaque classeur
        foreach ($classeur as $c) {
            $fullPath = $this->getFullPath($c);
            // Utilisez $fullPath comme nécessaire
        }

        return view(
            'archive.index',
            [
                'title' => $title,
                'active' => $active,
                'classeur' => $classeur,
                'classeurADD' => $classeurADD
            ]
        );
    }

    public function getArchive(Request $request)
    {
        $id = $request->id;
        $results = Archive::where('classeur_id', $id)->orderBy('id', 'ASC')->get();
        $classeurs = Classeur::where('parent', $id)->orderBy('id', 'ASC')->get();
        $classeur = Classeur::where('id', $id)->first();
    
        // Fonction récursive pour obtenir le chemin complet
        function getFullPath($classeur) {
            $path = $classeur->libellec;
            while ($classeur->parent != null) {
                $classeur = Classeur::find($classeur->parent);
                if ($classeur) {
                    $path = $classeur->libellec . ' / ' . $path;
                }
            }
            return $path;
        }
    
        // Fonction pour formater la taille du fichier
        function formatSize($size) {
            $units = array('o', 'Ko', 'Mo', 'Go', 'To');
            $unit = 0;
            while ($size >= 1024 && $unit < count($units) - 1) {
                $size /= 1024;
                $unit++;
            }
            return round($size, 2) . ' ' . $units[$unit];
        }
        
        $output = '';
    
        // Afficher les informations du classeur si disponible
        if ($classeur) {
            $fullPath = getFullPath($classeur);
            
            // Lien pour retourner au dossier parent
            if ($classeur->parent) {
                $parentClasseur = Classeur::find($classeur->parent);
                if ($parentClasseur) {
                   /* $output .= '
                        <a class="btn btn-secondary mb-3" href="javascript:void(0);" onclick="loadArchive(' . $parentClasseur->id . ')">
                            <i class="fa fa-arrow-left" ></i> Retour à ' . $parentClasseur->libellec . '
                        </a>'; */
                }
            }
            
            $output .= '
                <table class="table table-striped table-sm fs--1 mb-0">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Type</th>
                            <th>Attache</th>
                            <th>Taille</th>
                            <th>Statut</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <a class="recupreclasseur open-folder" aria-current="page" href="javascript:void(0);" id="' . $classeur->id . '">
                                    <span class="me-2 nav-icons fa fa-folder-open"></span>
                                    <span class="flex-1">' . $fullPath . '</span>
                                </a>
                            </td>
                            <td>Dossier</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>' . date('d-m-Y', strtotime($classeur->created_at)) . '</td>
                        </tr>
                   ';
        } else {
            $output .= '<h4 class="text-center text-secondary my-5">Classeur introuvable!</h4>';
        }
    
        $emptyFolder = true;
    
        // Afficher les sous-dossiers
        if ($classeurs->count() > 0) {
            $emptyFolder = false;
            foreach ($classeurs as $sub_classeur) {
                $openClass = $sub_classeur->id == $id ? 'open-folder' : '';
                $output .= '
                    <tr>
                        <td>
                            <a class="nav-link border-end text-start outline-none recupreclasseur ' . $openClass . '" aria-current="page" href="javascript:void(0);" id="' . $sub_classeur->id . '">
                                <font color="#FFD700"><span class="me-2 nav-icons fa fa-folder"></span></font>
                                <span class="flex-1">' . $sub_classeur->libellec . '</span>
                            </a>
                        </td>
                        <td>Dossier</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>' . date('d-m-Y', strtotime($sub_classeur->created_at)) . '</td>
                    </tr>';
            }
        }
    
        // Afficher les résultats des archives
        if ($results->count() > 0) {
            $emptyFolder = false;
            foreach ($results as $result) {
                $filePath = storage_path('app/public/document/' . basename($result->document_path));
                $fileSize = file_exists($filePath) ? formatSize(filesize($filePath)) : 'N/A';
                $output .= '
                    <tr>
                        <td style="width:50%">' . ucfirst($result->title) . '</td>
                        <td>' . strtoupper(pathinfo($result->document_path, PATHINFO_EXTENSION)) . '</td>
                        <td><center><a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="' . asset('storage/document/' . basename($result->document_path)) . '" title="Ouvrir le document"><i class="fas fa-file-export"></i></a></center></td>
                        <td>' . $fileSize . '</td>
                        <td>' . $result->type . '</td>
                        <td>' . date('d-m-Y', strtotime($result->created_at)) . '</td>
                    </tr>';
            }
        }
    
        if ($emptyFolder) {
            $output .= '<tr><td colspan="6" class="text-center text-secondary">Ce dossier est vide!</td></tr>';
        }
    
        $output .= '</tbody></table>';
        echo $output;
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            
            'description' => 'nullable|string',
        ]);
    
        try {
            // Création du dossier de destination s'il n'existe pas
            $destinationFolder = 'document';
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

