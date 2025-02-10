<?php

namespace App\Http\Controllers;

use App\Models\Classeur;
use Exception;
use Illuminate\Http\Request;

class ClasseurController extends Controller
{
    public function index()
    {
        $title = 'Classeur';
        $classeur = Classeur::all();
        return view(
            'classeur.index',
            [
                'title' => $title,
                'classeur' => $classeur
            ]
        );
    }

    public function fetchAll()
    {
        $classeurs = Classeur::join('users', 'classeurs.userid', '=', 'users.id')
            ->join('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('classeurs.*', 'personnels.nom as user_nom', 'personnels.prenom as user_prenom')
            ->get();

        $output = '';

        if ($classeurs->count() > 0) {
            $nombre = 1;

            foreach ($classeurs as $classeur) {
                // Utilisation de la méthode value() pour obtenir uniquement la valeur de libellec
                $libelle = Classeur::where('id', $classeur->parent)->value('libellec');
                //$libelleAffichage = $libelle ? $libelle . ' / ' . $classeur->libellec : $classeur->libellec;

                $output .= '<tr>
                <td class="align-middle ps-3 name">' . $nombre . '</td>
                <td>' . ucfirst($classeur->libellec) . '</td>
                <td>' . ucfirst($libelle) . '</td>
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
    public function store(Classeur $Classeur, Request $request)
    {
        try {
            $title = $request->title;
            $nomClasseur = $request->nomClasseur;

            // Vérifier si $request->nomClasseur contient des éléments
            if ($nomClasseur) {
                // Si oui, $title contiendra $nomClasseur + $title
                $title =  $title;
            }

            $check = Classeur::where('libellec', $title)->where('parent', $request->parent)->first();

            if ($check) {
                return response()->json([
                    'status' => 201,
                ]);
            } else {
                $Classeur->libellec = $title;
                $Classeur->parent = $request->parent;
                $Classeur->description = $request->description;

                $Classeur->userid = Auth()->user()->id;
                $Classeur->save();
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

    // edit an employee ajax request
    public function edit(Request $request)
    {
        $id = $request->id;
        $fon = Classeur::find($id);
        return response()->json($fon);
    }

    // update an function ajax request
    public function update(Request $request)
    {

        try {
            $title = $request->cs_title;
            $check = Classeur::where('libellec', $title)->first();

            if ($check) {
                return response()->json([
                    'status' => 201,
                ]);
            } else {

                $emp = Classeur::find($request->cs_id);
                $emp->libellec = $request->cs_title;
                $emp->userid = Auth()->user()->id;
                $emp->update();

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

    // supresseion
    public function deleteall(Request $request)
    {
        $id = $request->id;
        Classeur::destroy($id);
    }

}
