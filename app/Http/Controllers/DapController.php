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
          <td class="align-middle">  '.$nombre.' </td>
          <td class="align-middle"> #  '.$datas->numerodap.'  </td>
          <td class="align-middle"> '.$datas->referencefeb.'  </td>
          <td class="align-middle"> '.$datas->created_at.' </td>
          <td class="align-middle"> '.$datas->ov.' </td>
          <td class="align-middle"> '.$datas->cho.' </td>
          <td class="align-middle">
            <a href="#" id="' .$datas->id. '" class="text-info mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editcompteModal" title="modifier le compte"><i class="fas fa-window-restore"></i>  </a>
            <a href="#" id="' .$datas->id. '" class="text-info mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editcompteModal" title="modifier le compte"><i class="bi-pencil-square h4"></i><i class="fa fa-edit"></i>  </a>
            <a href="#" id="' .$datas->id. '" class="text-danger mx-1 deleteIcon" title="Supprimer le compte"><i class="fa fa-trash"></i>  </a>
          </td>
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

      $activity = new dap;
      $activity->comptebancaire= $request->comptebanque;
      $activity->lieu = $request->lieu;
      $activity->activiteiddap = $request->activityid;

      $activity->numerodap = $request->numerodap;
      $activity->projetiddap = $request->projetid;
      
      $activity->serviceid= $request->serviceid;
     
      $activity->referencefeb = $request->febid;
      $activity->etabliepar= $request->etabliepar;
      $activity->lignebud= $request->ligneid;
     
      $activity->ov= $request->ov;
      $activity->cho= $request->ch;
      $activity->etablie_nom= $request->etablie_nom;

      $activity->demandeetablie= $request->demandeetablie;
      $activity->chefComposante= $request->chefComposante;
      $activity->signaturechef= $request->signaturechef;
      $activity->datechefcomposante= $request->datechefcomposante;

      $activity->verifier= $request->verifier;
      $activity->chefcomptable= $request->chefcomptable;
      $activity->signaturechefcomptable= $request->signaturechefcomptable;
      $activity->datechefcomptable= $request->datechefcomptable;

      $activity->approuver= $request->approuver;
      $activity->chefservice= $request->chefservice;
      $activity->signaturechefservice= $request->signaturechefservice;
      $activity->datechefservice= $request->datechefservice;

      $activity->resposablefinancier= $request->resposablefinancier;
      $activity->secretairegenerale= $request->secretairegenerale;
      $activity->datesecretairegenerale= $request->datesecretairegenerale;
      $activity->chefprogramme= $request->chefprogramme;

      $activity->observation= $request->observation;

      $activity->userid = Auth::id();
      $activity->save();

      $dap=DB::table('daps')->select('id')->first();
      $IDf= $dap->id;
          // insersion module elments de details
          foreach ($request->numerodetail as $key => $items)
          {

            $elementdap = new Elementdap();
            $elementdap->dapid  =  $IDf;
            $elementdap->libelle= $request->description[$key];
            $elementdap->montant=  $request->montant[$key];
            $elementdap->save();
          }
      return response()->json([
       'status' => 200,
       
      ]);
    }   

  } catch (Exception $e) {
    return back()->with('failed', 'Echec ! vous avez une erreur d\'execution ');
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
