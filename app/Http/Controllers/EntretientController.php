<?php

namespace App\Http\Controllers;

use App\Models\Element_entretien;
use App\Models\Entretien_programmer;
use App\Models\Entretient;
use App\Models\Fournisseur;
use App\Models\Vehicule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EntretientController extends Controller
{
  public function index()
  {
    $active = 'Parc';
    $title = 'Entretient';

    $vehicule = Vehicule::all();
    $founisseur = Fournisseur::all();

    return view(
      'entretient.index',
      [
        'title' => $title,
        'active' => $active,
        'vehicule' => $vehicule,
        'founisseurs' => $founisseur
      ]
    );
  }

  public function fetchAll()
  {
    $entretien = Entretient::orderBy('id', 'DESC')
      ->join('users', 'entretients.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('entretients.*', 'personnels.prenom as user_prenom')
      ->get();

    $output = '';
    if ($entretien->count() > 0) {

      $nombre = 1;
      foreach ($entretien as $rs) {
        $output .= '<tr>
                <td class="align-middle ps-3 name">' . $nombre . '</td>
                <td>' . ucfirst($rs->vehicule_id) . '</td>
                <td>' . date('d.m.Y', strtotime($rs->dateEntretien)) . '</td>
                <td>' . ucfirst($rs->typeEntretien) . '</td>
                 <td>' . ucfirst($rs->cout) . '</td>
               
                <td>' . ucfirst($rs->kilometrage) . '</td>
                <td>' . ucfirst($rs->fournisseur) . '</td>
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
          <td colspan="11">
          <center>
            <h6 style="margin-top:1% ;color:#c0c0c0"> 
            <center><font size="50px"><i class="fa fa-info-circle"  ></i> </font><br><br>
                Ceci est vide  !</center> </h6>
          </center>
          </td>
          </tr>';
    }
  }

  public function store(Request $request)
  {
    try {
      // Démarrer une transaction
      DB::beginTransaction();
      // Créer une nouvelle instance d'Entretient
      $entretien = new Entretient();
      $entretien->vehicule_id        = $request->vehiculeid;
      $entretien->typeEntretien      = $request->type_entretien;
      $entretien->descriptionTravaux = $request->description;
      $entretien->kilometrage        = $request->kilometrage;
      $entretien->fournisseur        = $request->fournisseur;
      $entretien->dateEntretien      = $request->datejour;
      $entretien->cout               = $request->couttotal;
      $entretien->userid             = Auth::id();
      $entretien->save();
      $IDe = $entretien->id;

      if (!empty($request->type_entretient_prochaine) && !empty($request->date_entretient_prochaine)) {
        $programmer = new Entretien_programmer();
        $programmer->vehicule_id     =  $request->vehiculeid;
        $programmer->type_entretien  =  $request->type_entretient_prochaine;
        $programmer->date_prevue     =  $request->date_entretient_prochaine;
        $programmer->description_pe  =  $request->description_entretient_prochaine;
        $programmer->userid          =  Auth::id();
        $programmer->save();
      }
      
      foreach ($request->numerodetail as $key => $items) {
        $somme_total = $request->pu[$key] * $request->qty[$key];

        $element = new Element_entretien();

        $element->entretienid  = $IDe;
        $element->libelle      = $request->libelle[$key];
        $element->unite        = $request->unit_cost[$key];
        $element->quantite     = $request->qty[$key];
        $element->prixunite    = $request->pu[$key];
        $element->prixtotal    = $somme_total;
        $element->userid       = Auth::id();
        
        $element->save();
      }

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

  // edit an entretien request
  public function edit(Request $request)
  {
    $id = $request->id;
    $fon = Entretient::find($id);
    return response()->json($fon);
  }

  // update an entretien request
  public function update(Request $request)
  {
    try {

      $emp = Entretient::find($request->idv);
      $emp->matricule = $request->matriculev;
      $emp->marque = $request->marquev;
      $emp->modele = $request->modelev;
      $emp->couleur = $request->couleurv;
      $emp->numeroserie = $request->numseriev;
      $emp->type = $request->typev;
      $emp->carburent = $request->carburentv;
      $emp->statut = $request->statutv;
      $emp->update();

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
  public function deleteEntretient(Request $request)
  {
    try {
      $emp = Entretient::find($request->id);
      if ($emp->userid == Auth::id()) {
        $id = $request->id;
        Entretient::destroy($id);
        $elements = Element_entretien::where('id', '=', $id)->get();
        foreach ($elements as $element) {
          $element->delete();
        }
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
