<?php

namespace App\Http\Controllers;

use App\Models\Carnetbord;
use App\Models\Fournisseur;
use App\Models\Project;
use App\Models\Service;
use App\Models\Vehicule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarnetbordController extends Controller
{
    public function index()
  {
   
    $title = 'Carnet de bord';

    $vehicule = Vehicule::all();
    $founisseur = Fournisseur::all();
    $service = Service::all();
    $projet = Project::all();

    return view(
      'carnet_bord.index',
      [
        'title' => $title,
        'vehicule' => $vehicule,
        'founisseurs' => $founisseur,
        'service' => $service,
        'projet' => $projet
      ]
    );
  }

  public function fetchAll()
  {
    $entretien = Carnetbord::orderBy('id', 'DESC')
      ->join('users', 'carnetbords.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('carnetbords.*', 'personnels.prenom as user_prenom')
      ->get();

    $output = '';
    if ($entretien->count() > 0) {

      $nombre = 1;
      foreach ($entretien as $rs) {
        $output .= '
            <tr>
                <td class="align-middle ps-3 name">' . $nombre . '</td>
                <td>' . ucfirst($rs->numero_plaqu) . '</td>
                <td>' . ucfirst($rs->service_id) . '</td>
                <td>' . ucfirst($rs->itineraire) . '</td>
                <td>' . ucfirst($rs->objectmission) . '</td>
                <td>' . ucfirst($rs->chefmission) . '</td>
                <td>' . ucfirst($rs->projetid) . '</td>
                <td>' . ucfirst($rs->index_depart) . '</td>
                <td>' . ucfirst($rs->index_retour) . '</td>
                <td>' . ucfirst($rs->kms_parcourus) . '</td>
                <td>' . ucfirst($rs->carburant_littre) . '</td>
                <td>' . ucfirst($rs->user_prenom) . '</td>
                <td>' . date('d.m.Y', strtotime($rs->created_at)) . '</td>
                <td>
                    <center>
                        <div class="btn-group me-2 mb-2 mb-sm-0">
                            <a  data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical ms-2"></i>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item text-white mx-1 deleteIcon"  id="' . $rs->id . '"  href="#" style="background-color:red"><i class="far fa-trash-alt"></i> Supprimer</a>
                            </div>
                        </div>
                    </center>
                </td>
            </tr>';
        $nombre++;
      }

      echo $output;
    } else {
      echo '
        <tr>
            <td colspan="13">
                <center>
                <h6 style="margin-top:1% ;color:#c0c0c0"> 
                <center><font size="50px"><i class="fa fa-info-circle"  ></i> </font><br><br>
                    Ceci est vide  !</center> </h6>
                </center>
            </td>
        </tr> ';
    }
  }

  public function store(Request $request)
  {
    try {
      // Démarrer une transaction
      DB::beginTransaction();
      // Créer une nouvelle instance d'Entretient
      $carnet = new Carnetbord();
      $carnet->numero_plaque = $request->numero_plaque;
      $carnet->service_id = $request->service_id;
      $carnet->itineraire = $request->itineraire;
      $carnet->objectmission = $request->objectmission;
      $carnet->chefmission = $request->chefmission;
      $carnet->projetid = $request->projetid ;
      $carnet->index_depart = $request->index_depart ;
      $carnet->index_retour = $request->index_retour;
      $carnet->kms_parcourus = $request->kms_parcourus;
      $carnet->carburant_littre = $request->carburant_littre;
      $carnet->signature_mission = $request->signature_mission;
      $carnet->userid             = Auth::id();
      $carnet->save();
   

    

      // Confirmer la transaction
      DB::commit();
      // Répondre avec succès
      return response()->json([
        'status' => 200,
        'message' => 'Entretien créé avec succès',
      ]);
    } catch (Exception $e) {
      // Annuler la transaction en cas d'erreur
      DB::rollBack();
      return response()->json([
        'status' => 500,
        'error' => $e->getMessage(),
      ], 500);
    }
  }

   // update an entretien request
   public function update(Request $request)
   {
     try {
 
       $carnet = Carnetbord::find($request->idv);
       $carnet->numero_plaque = $request->matriculev;
       $carnet->service_id = $request->marquev;
       $carnet->itineraire = $request->modelev;
       $carnet->objectmission = $request->couleurv;
       $carnet->chefmission = $request->numseriev;
       $carnet->projetid = $request->typev;
       $carnet->index_depart = $request->carburentv;
       $carnet->index_retour = $request->statutv;
       $carnet->kms_parcourus = $request->statutv;
       $carnet->carburant_littre = $request->statutv;
       $carnet->signature_mission = $request->statutv;
       $carnet->update();
       return response()->json([
         'status' => 200,
       ]);
     } catch (Exception $e) {
 
       return response()->json([
         'status' => 202,
       ]);
     }
   }
 
   // supresseion
   public function delete(Request $request)
   {
     try {
       $carnet = Carnetbord::find($request->id);
       if ($carnet->userid == Auth::id()) {
         $id = $request->id;
         Carnetbord::destroy($id);
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
