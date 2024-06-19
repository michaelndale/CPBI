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
use Illuminate\Support\Facades\Crypt;
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
    $personnel = DB::table('users')
    ->join('personnels', 'users.personnelid', '=', 'personnels.id')
    ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
    ->orderBy('nom', 'ASC')
    ->get();

    return view(
      'carnet_bord.index',
      [
        'title'       => $title,
        'vehicule'    => $vehicule,
        'founisseurs' => $founisseur,
        'service'     => $service,
        'projet'      => $projet,
        'personnel'   => $personnel
      ]
    );
  }

  public function fetchAll()
  {
    $entretien = Carnetbord::orderBy('id', 'DESC')
      ->leftjoin('services', 'carnetbords.service_id', 'services.id')
      ->leftjoin('projects', 'carnetbords.projetid', 'projects.id')
      ->join('users', 'carnetbords.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('carnetbords.*', 'projects.title as projec_title','services.title as service_name', 'personnels.prenom as user_prenom')
      ->get();

    $output = '';
    if ($entretien->count() > 0) {

      $nombre = 1;
      foreach ($entretien as $rs) {
        $chef_mission = DB::table('users')
        ->leftjoin('personnels', 'personnels.id', 'users.personnelid')
        ->select('users.*', 'personnels.nom', 'users.id as idu', 'personnels.id', 'personnels.email', 'personnels.sexe', 'personnels.phone', 'personnels.fonction', 'personnels.prenom')
        ->where('users.id', $rs->chefmission)
        ->first();

        $nom = $chef_mission->nom.' '.$chef_mission->prenom;
        $cryptedId = Crypt::encrypt($rs->id);
        $output .= '
            <tr>
                <td class="align-middle ps-3 name">' . $nombre . '</td>
                <td>' . ucfirst($rs->numero_plaque) . '</td>
                 <td>' . ucfirst($rs->datejour) . '</td>
                <td>' . ucfirst($rs->service_name) . '</td>
                <td>' . ucfirst($rs->itineraire) . '</td>
                <td>' . ucfirst($rs->objectmission) . '</td>
                <td>' . ucfirst($nom) . '</td>
                <td>' . ucfirst($rs->projec_title) . '</td>
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
                                 <a href="carnetbord/' . $cryptedId . '/view" class="dropdown-item mx-1 voirIcon"><i class="far fa-eye"></i> Voir</a>
                                <a class="dropdown-item  mx-1 editIcon"  id="' . $rs->id . '"  href="#" data-bs-toggle="modal" data-bs-target="#EditDealModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent" ><i class="fa fa-edit"></i> Modifier</a>
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
      $carnet->numero_plaque = $request->vehicule;
      $carnet->service_id = $request->service;
      $carnet->itineraire = $request->ituneraire;
      $carnet->objectmission = $request->object;
      $carnet->chefmission = $request->chefmission;
      $carnet->projetid = $request->projetid ;
      $carnet->index_depart = $request->indexdepart ;
      $carnet->index_retour = $request->indexretour;
      $carnet->kms_parcourus = $request->kilometrage;
      $carnet->carburant_littre = $request->carburant;
      $carnet->datejour = $request->datejour;
      $carnet->userid             = Auth::id();
      $carnet->save();
  
      // Confirmer la transaction
      DB::commit();
      // Répondre avec succès
      return response()->json([
        'status' => 200,
        'message' => 'Opération du carnet de bord créé avec succès',
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

  public function showCarnet(Request $request)
  {
    $id = $request->id;
    $ft = Carnetbord::find($id);
    return response()->json($ft);
  }

   // update  request
   public function updateCarnet(Request $request)
   {
     try {
 
       $carnet = Carnetbord::find($request->idc);
       $carnet->numero_plaque = $request->cvehicule;
      $carnet->service_id = $request->cservice;
      $carnet->itineraire = $request->cituneraire;
      $carnet->objectmission = $request->cobject;
      $carnet->chefmission = $request->cchefmission;
      $carnet->projetid = $request->cprojetid ;
      $carnet->index_depart = $request->cindexdepart ;
      $carnet->index_retour = $request->cindexretour;
      $carnet->kms_parcourus = $request->ckilometrage;
      $carnet->carburant_littre = $request->ccarburant;
      $carnet->datejour = $request->cdatejour;
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
