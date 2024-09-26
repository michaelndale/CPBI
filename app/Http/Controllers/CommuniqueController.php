<?php

namespace App\Http\Controllers;

use App\Models\Communique;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CommuniqueController extends Controller
{
    
    public function index()
    {
        $title = 'Communication';
        return view(
            'communique.index',
            [
                'title' => $title,
            ]
        );
    }

    public function liste()
    {
        $com = Communique::join('users', 'communiques.userid', '=', 'users.id')
            ->join('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('communiques.*', 'personnels.nom as user_nom', 'personnels.prenom as user_prenom')
            ->get();
        $output = '';


        if ($com->count() > 0) {
            $nombre = 1;
            foreach ($com as $coms) {
                $cryptedId = Crypt::encrypt($coms->id);

                $date_day = date('Y-m-d');
                

                if($coms->datelimite >= $date_day){
                    $statut = '<span class="badge rounded-pill bg-primary font-size-11"> &nbsp;&nbsp; Ouvert &nbsp;&nbsp; </span>';

                }else{
                    $statut = '<span class="badge rounded-pill bg-danger font-size-11"> &nbsp;&nbsp; Fermer &nbsp;&nbsp; </span>';

                }

                $output .= '<tr>
              
                <td>' . ucfirst($coms->titre) . '</td>
                 <td>' . ucfirst($coms->description) . '</td>
                <td>' . date('d-m-Y', strtotime($coms->datelimite)) . '</td>
                <td>' . ucfirst($coms->user_nom) . ' ' . ucfirst($coms->user_prenom) . '</td>
                <td> <center>' . $statut . '</center></td>
                <td>' . date('d-m-Y H:i:s', strtotime($coms->created_at)) . '</td>
                <td>
                    <center>
                      
                        <a href="#" id="' . $coms->id . '" data-numero="' . $coms->titre . '"  class="text-danger mx-1 deleteIcon" title="Supprimer"><i class="far fa-trash-alt"></i></a>
                    </center>
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

    public function store(Request $request) 
    {
        try {

            $com = new Communique();
            $com->titre = $request->titre;
            $com->description = $request->description;
            $com->datelimite = $request->datelimite;
            $com->userid = Auth::id();
            $com->save();
            return response()->json([
                'status' => 200,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 505,
            ]);
        }
    }

    public function show(Request $request)
    {
        $id = $request->id;
        $com = Communique::find($id);
        return response()->json($com);
    }

    public function update(Request $request, Communique $communique)
    {
        try {

            $com = Communique::find($request->idgl);
            if ($com->userid == Auth::id()) {
                $com->titre = $request->titre_up;
                $com->description = $request->description_up;
                $com->datelilite = $request->datelinite;
                $com->userid = $request->userid;
                $com->update();
                return response()->json([
                    'status' => 200,
                ]);
            } else {
                return response()->json([
                    'status' => 201,
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 505,
            ]);
        }
    }

    public function destroy(Request $request,Communique $communique)
    {

        try {
            $id = $request->id;
            $com = Communique::find($id);

            if ($com && $com->userid == Auth::id()) {

                Communique::destroy($id);

                return response()->json([
                    'status' => 200,
                ]);
            } else {

                return response()->json([
                    'status' => 205,
                    'message' => 'Vous n\'avez pas l\'autorisation nécessaire pour supprimer cette communication. Veuillez contacter le créateur  pour procéder à la suppression.'
                ]);
            }
        } catch (\Exception $e) {

            return response()->json([
                'status' => 500,
                'message' => 'Erreur lors de la suppression du ligne bidgétaire.',
                'error' => $e->getMessage(), // Message d'erreur de l'exception
                'exception' => (string) $e // Détails de l'exception convertis en chaîne
            ]);
        }
    }

}
