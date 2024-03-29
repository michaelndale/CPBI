<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\dap;
use App\Models\Elementdap;
use App\Models\Folder;
use App\Models\Historique;
use App\Models\Notification;
use App\Models\Service;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DapController extends Controller
{
   
  public function fetchAll()
  {
    $ID = session()->get('id');

    $data = DB::table('daps')
          ->orderby('id','DESC')
          ->Where('projetiddap', $ID)
          ->get();

    $output = '';
    if ($data->count() > 0) {
      $nombre = 1;
      foreach ($data as $datas) {
        $output .= '
        <tr>
          <td> 
          <center>
                <div class="btn-group me-2 mb-2 mb-sm-0">
                  <button class="btn btn-primary btn-sm dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="mdi mdi-dots-vertical ms-2"></i> Action
                  </button>
                  <div class="dropdown-menu">
                      <a href="dap/' . $datas->id . '/verificationdap" class="dropdown-item text-primary mx-1 voirIcon" id="' . $datas->id . '"  ><i class="far fa-edit"></i> Vérification et Approbation </a>
                      <a class="dropdown-item text-danger mx-1 deleteIcon"  id="' . $datas->id . '"  href="#"><i class="far fa-trash-alt"></i> Supprimer</a>
                  </div>
              </div>
            </center>
          </td>
          <td> '.$datas->numerodap.'  </td>
          <td> '.$datas->referencefeb.'  </td>
          <td> '.$datas->created_at.' </td>
          <td> '.$datas->ov.' </td>
          <td> '.$datas->cho.' </td>
          <td> '.$datas->cho.' </td>
          <td> '.$datas->cho.' </td>
          <td> '.$datas->cho.' </td>
        </tr>
      '
          ;
        $nombre++;
      }
      echo $output;
    } else {
      echo '<tr>
        <td colspan="9">
        <center>
          <h6 style="margin-top:1% ;color:#c0c0c0"> 
          <center><font size="10px"><i class="far fa-trash-alt"  ></i> </font><br><br>
          Ceci est vide  !</center> </h6>
        </center>
        </td>
        </tr>
        ';
    }
  }

      // insert a new employee ajax request
      public function store(Request $request , Notification $notis, Historique $his)
      {

        try {
          
        $numerodap = $request->numerodap;
        $check = dap::where('numerodap',$numerodap)->first();
        if($check){
          return response()->json([
            'status' => 201,
          ]);
        }else{

      $dap = new dap;

      $dap->numerodap = $request->numerodap;
      $dap->serviceid= $request->serviceid;
      $dap->projetiddap = $request->projetid;
      $dap->referencefeb = $request->febid;
      $dap->lieu = $request->lieu;
      $dap->comptabiliteb= $request->comptebanque;
      $dap->ov= $request->ov;
      $dap->cho= $request->ch;
      $dap->demandeetablie= $request->demandeetablie;
      $dap->verifierpar= $request->verifier;
      $dap->approuverpar= $request->approuver;
      $dap->responsable= $request->resposablefinancier;
      $dap->secretaire= $request->secretairegenerale;
      $dap->chefprogramme= $request->chefprogramme;
      $dap->observation= $request->observation;
      $dap->userid = Auth::id();

      $go = $dap->save();
      
      if($go){
        return response()->json([
          'status' => 200,
          
         ]);
      }else{
        return response()->json([
          'status' => 202,
          
         ]);
      }
    
    }   

  } catch (Exception $e) {
    return response()->json([
      'status' => 203,
      
     ]);
  
  }


  }

    public function list()
    {
        $title="DAP";
        $active = 'Project';
        // service
        $service = Service::all();
        $compte = Compte::where('compteid', '=', NULL)->get();
        // utilisateur
        $personnel = DB::table('users')
                  ->join('personnels', 'users.personnelid', '=', 'personnels.id')
                  ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
                  ->orWhere('fonction', '!=' ,'Chauffeur')
                  ->orderBy('nom', 'ASC')
                  ->get();

        // projet encours
        $ID = session()->get('id');

        // Activite
        $activite = DB::table('activities')
                    ->orderby('id','DESC')
                    ->Where('projectid', $ID)
                    ->get();

        // feb
        $feb = DB::table('febs')
              ->orderby('id','DESC')
              ->Where('projetid', $ID)
              ->get();



        return view('document.dap.list', 
        [
          'title'     => $title,
          'active'    => $active,
          'activite'  => $activite,
          'personnel' => $personnel,
          'service'   => $service,
          'feb'       => $feb,
          'compte'    => $compte
        ]);
    }
}
