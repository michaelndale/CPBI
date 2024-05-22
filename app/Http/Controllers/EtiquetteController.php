<?php

namespace App\Http\Controllers;

use App\Models\Etiquette;
use Exception;
use Illuminate\Http\Request;

class EtiquetteController extends Controller
{
    public function index()
    {
      $title = 'Etiquette';
      $active = 'Archivage';
      $etiquette = Etiquette::all();
      return view(
        'etiquette.index',
        [
          'title' => $title,
          'active' => $active,
          'etiquette' =>  $etiquette
        ]
      );
    }
  
    public function fetchAll()
{
    $classeurs = Etiquette::join('users', 'etiquettes.userid', '=', 'users.id')
        ->join('personnels', 'users.personnelid', '=', 'personnels.id')
        ->select('etiquettes.*', 'personnels.nom as user_nom', 'personnels.prenom as user_prenom')
        ->get();

    $output = '';

    if ($classeurs->count() > 0) {
        $nombre = 1;

        foreach ($classeurs as $classeur) {
            // Utilisation de la méthode value() pour obtenir uniquement la valeur de libellec
            $libelle = Etiquette::where('id', $classeur->parent)->value('libellec');
            //$libelleAffichage = $libelle ? $libelle . ' / ' . $classeur->libellec : $classeur->libellec;

            $output .= '<tr>
                <td class="align-middle ps-3 name">' . $nombre . '</td>
                <td>' . ucfirst($classeur->nom_e) . '</td>
                <td>' . ucfirst($libelle).'</td>
                <td>' . ucfirst($classeur->user_nom) . ' ' . ucfirst($classeur->user_prenom) . '</td>
                <td>' . date('d.m.Y H:i:s', strtotime($classeur->created_at)) . '</td>
                <td>
                    <center>
                        <a href="#" id="' . $classeur->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editModal" title="Modifier" ><i class="far fa-edit"></i> </a>
                        <a href="#" id="' . $classeur->id . '" class="text-danger mx-1 deleteIcon" title="Supprimer"><i class="far fa-trash-alt"></i></a>
                    </center>
                </td>
            </tr>';

            $nombre++;
        }

        echo $output;
    } else {
        echo '<tr>
            <td colspan="6">
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
            $title = $request->title;
            $nomEtiquette = $request->nomEtiquette;
    
            // Vérifier si $request->nomEtiquette contient des éléments
            if ($nomEtiquette) {
                // Si oui, $title contiendra $nomEtiquette + $title
                $title = $nomEtiquette . ' / ' . $title;
            }
    
            $check = Etiquette::where('libellec', $title)->first();
    
            if ($check) {
                return response()->json([
                    'status' => 201,
                ]);
            } else {
                $Etiquette->libellec = $title;
                $Etiquette->parent = $request->parent;
                $Etiquette->description = $request->description;
    
                $Etiquette->userid = Auth()->user()->id;
                $Etiquette->save();
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
