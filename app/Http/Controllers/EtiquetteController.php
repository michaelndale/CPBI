<?php

namespace App\Http\Controllers;

use App\Models\Classeur;
use App\Models\Etiquette;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Builder\Class_;

class EtiquetteController extends Controller
{
    public function index()
    {
      $title = 'Etiquette';
      $active = 'Archivage';
      $classeur = Classeur::all();
      $etiquette = Etiquette::all();
      return view(
        'etiquette.index',
        [
          'title' => $title,
          'active' => $active,
          'etiquette' =>  $etiquette,
          'classeur'  => $classeur
        ]
      );
    }
  
    public function fetchAll()
{
    $classeurs = Etiquette::join('users', 'etiquettes.userid', '=', 'users.id')
    ->join('personnels', 'users.personnelid', '=', 'personnels.id')
    ->leftJoin('classeurs', 'etiquettes.classeur_id', '=', 'classeurs.id')
    ->select('etiquettes.*', 'personnels.nom as user_nom', 'personnels.prenom as user_prenom', 'classeurs.libellec as libelle')
    ->get();


    $output = '';

    if ($classeurs->count() > 0) {
        $nombre = 1;

        foreach ($classeurs as $classeur) {
            // Utilisation de la méthode value() pour obtenir uniquement la valeur de libellec
          
            //$libelleAffichage = $libelle ? $libelle . ' / ' . $classeur->libellec : $classeur->libellec;

            $output .= '<tr>
                <td class="align-middle ps-3 name">' . $nombre . '</td>
                <td>' . ucfirst($classeur->libelle) . '</td>
                <td>' . ucfirst($classeur->nom_e) . '</td>
                <td>' . ucfirst($classeur->info_bulle).'</td>
                <td>' . ucfirst($classeur->user_nom) . ' ' . ucfirst($classeur->user_prenom) . '</td>
                <td>' . date('d.m.Y H:i:s', strtotime($classeur->created_at)) . '</td>
                <td>
                   
                        <a href="#" id="' . $classeur->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editModal" title="Modifier" ><i class="far fa-edit"></i> </a>
                        <a href="#" id="' . $classeur->id . '" class="text-danger mx-1 deleteIco" title="Supprimer"><i class="far fa-trash-alt"></i></a>
                    
                </td>
            </tr>';

            $nombre++;
        }

        echo $output;
    } else {
        echo '<tr>
            <td colspan="7">
                <center>
                    <h6 style="margin-top:1% ;color:#c0c0c0"> 
                        <center><font size="50px"><i class="fa fa-info-circle"></i> </font><br><br>
                        Ceci est vide  !
                        </center>
                    </h6>
                </center>
            </td>
        </tr>';
    }
}

  
    // insert a new employee ajax request
    public function store(Etiquette $Etiquette, Request $request)
{
    try {
        $nomEtiquette = $request->nom;

        // Vérifier si l'étiquette existe déjà
        $check = Etiquette::where('nom_e', $nomEtiquette)->first();

        if ($check) {
            // Si l'étiquette existe déjà, retourner un statut 201
            return response()->json([
                'status' => 201,
                'message' => 'L\'étiquette existe déjà.'
            ]);
        } else {
            // Sinon, créer une nouvelle étiquette
            $Etiquette->classeur_id = $request->parent;
            $Etiquette->nom_e = $nomEtiquette;
            $Etiquette->info_bulle = $request->info_bull;
            $Etiquette->userid = auth()->user()->id;
            $Etiquette->save();

            return response()->json([
                'status' => 200,
                'message' => 'Étiquette créée avec succès.'
            ]);
        }
    } catch (Exception $e) {
        // En cas d'exception, retourner le message d'erreur
        return response()->json([
            'status' => 202,
            'message' => 'Échec ! ' . $e->getMessage()
        ]);
    }
}

public function getEtiquettesByClasseur($classeurId)
{
    $etiquettes = Etiquette::where('classeur_id', $classeurId)->get();
    return response()->json($etiquettes);
}


}
