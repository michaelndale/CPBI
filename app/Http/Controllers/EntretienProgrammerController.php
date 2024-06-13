<?php

namespace App\Http\Controllers;

use App\Models\Entretien_programmer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EntretienProgrammerController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function fetchallp()
  {
    $entretien = Entretien_programmer::orderBy('id', 'DESC')
      ->join('users', 'entretien_programmers.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('entretien_programmers.*', 'personnels.prenom as user_prenom')
      ->get();

    $output = '';
    if ($entretien->count() > 0) {

      $nombre = 1;
      foreach ($entretien as $rs) {
        $output .= '<tr>
                <td class="align-middle ps-3 name">' . $nombre . '</td>
                <td>' . ucfirst($rs->vehicule_id) . '</td>
                <td>' . ucfirst($rs->type_entretien) . '</td>
                 <td>' . date('d.m.Y', strtotime($rs->date_prevue)) . '</td>
                <td>' . $rs->description_pe . '</td>
                 <td>' . ucfirst($rs->user_prenom) . '</td>
                <td>' . date('d.m.Y', strtotime($rs->created_at)) . '</td>
                <td>
                <center>
                 <div class="btn-group me-2 mb-2 mb-sm-0">
                  <a  data-bs-toggle="dropdown" aria-expanded="false">
                       <i class="mdi mdi-dots-vertical ms-2"></i>
                  </a>
                  <div class="dropdown-menu">
                    
                      <a class="dropdown-item text-white mx-1 deleteEntretient"  id="' . $rs->id . '"  href="#" style="background-color:red"><i class="far fa-trash-alt"></i> Supprimer</a>
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


  // supresseion
  public function deleteProgramme(Request $request)
  {
    try {
      $emp = Entretien_programmer::find($request->id);
      if ($emp->userid == Auth::id()) {
        $id = $request->id;
        Entretien_programmer::destroy($id);
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

  public function storeProgramme(Request $request)
  {
   
    try {
      // Démarrer une transaction
      DB::beginTransaction();
      // Créer une nouvelle instance d'Entretient
    
        $programmer = new Entretien_programmer();
        $programmer->vehicule_id     =  $request->vehiculeid;
        $programmer->type_entretien  =  $request->type_entretient_prochaine;
        $programmer->date_prevue     =  $request->date_entretient_prochaine;
        $programmer->description_pe  =  $request->description_entretient_prochaine;
        $programmer->userid          =  Auth::id();
        $programmer->save();
      
      
      // Confirmer la transaction
      DB::commit();
      // Répondre avec succès
      return response()->json([
        'status' => 200,
        'message' => 'Entretien créé avec succès',
      ]);
    }
     catch (Exception $e) {
      // Annuler la transaction en cas d'erreur
      DB::rollBack();
      return response()->json([
        'status' => 500,
        'error' => $e->getMessage(),
      ], 500);
    }
  }
  

}
