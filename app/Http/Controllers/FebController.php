<?php

namespace App\Http\Controllers;

use App\Models\activitefeb;
use App\Models\Activity;
use App\Models\Compte;
use App\Models\Elementfeb;
use App\Models\Feb;
use App\Models\Historique;
use App\Models\Identification;
use App\Models\Rallongebudget;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class FebController extends Controller
{
  public function fetchAll()
  {
    $devise = session()->get('devise');
    $budget = session()->get('budget');

    $ID = session()->get('id');
    $data = DB::table('febs')
      ->orderby('id', 'DESC')
      ->Where('projetid', $ID)
      ->get();

    $output = '';
    if ($data->count() > 0) {
      $nombre = 1;
      foreach ($data as $datas) {

        $sommefeb = DB::table('elementfebs')
          ->Where('febid', $datas->id)
          ->SUM('montant');

        $pourcentage = round(($sommefeb * 100) / $budget);

        $sommefeb = number_format($sommefeb, 0, ',', ' ');

        if($datas->facture==1){ $facture="checked" ; } else{ $facture=""; }
        if($datas->om==1){ $om="checked" ; } else{ $om=""; }
        if($datas->bc==1){ $bc="checked" ; } else{ $bc=""; }
        if($datas->nec==1){ $nec="checked" ; } else{ $nec=""; }
        if($datas->fpdevis==1){ $fpdevis="checked" ; } else{ $fpdevis=""; }
        
        $output .= '
        <tr>
        <td>
          <center>
              <div class="btn-group me-2 mb-2 mb-sm-0">
                <button class="btn btn-primary btn-sm dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-dots-vertical ms-2"></i> Action
                </button>
                <div class="dropdown-menu">
                    <a href="feb/'.$datas->id.'/view" class="dropdown-item text-success mx-1 voirIcon" id="'.$datas->id.'"  ><i class="far fa-edit"></i> Voir feb</a>
                    <a href="feb/'.$datas->id.'/edit" class="dropdown-item text-primary mx-1 editIcon " id="'.$datas->id.'"  title="Modifier"><i class="far fa-edit"></i> Modifier</a>
                    <a class="dropdown-item text-danger mx-1 deleteIcon"  id="' . $datas->id . '"  href="#"><i class="far fa-trash-alt"></i> Supprimer</a>
                </div>
            </div>
          </center>

          </td>
          <td> <b>'. $datas->numerofeb .' </b>  </td>
          <td> <b> ' . $sommefeb . ' ' . $devise . '</b>  </td>
          <td align="center"> ' . $datas->periode . ' </td>
          <td align="center"> <input type="checkbox"  '. $facture .' class="form-check-input" />  </td>
          <td align="center"> <input type="checkbox"  '. $om .' class="form-check-input" />  </td>
          <td align="center"> <input type="checkbox"  '. $bc .' class="form-check-input" />  </td>
          <td align="center"> <input type="checkbox"  '. $nec .' class="form-check-input" />  </td>
          <td align="center"> <input type="checkbox"  '. $fpdevis.' class="form-check-input" />  </td>
          <td align="center"> ' .date('d-m-Y', strtotime($datas->datefeb)). '  </td>
          <td align="center"> ' . $pourcentage . '%</td>
          
        </tr>
      ';
        $nombre++;
      }
      echo $output;
    } else {
      echo
      '
      <tr>
      <td colspan="11">
      <center>
        <h6 style="margin-top:1% ;color:#c0c0c0"> 
        <center><font size="50px"><i class="fas fa-info-circle"  ></i> </font><br><br>
        Ceci est vide !</center> </h6>
      </center>
      </td>
      </tr>
      
      ';
    }
  }


  public function Sommefeb()
  {
    $devise = session()->get('devise');
    $budget = session()->get('budget');
    $ID = session()->get('id');

    $data = DB::table('elementfebs')
      ->orderby('id', 'DESC')
      ->Where('projetids', $ID)
      ->SUM('montant');

    $output = '';

    $pourcentage = round(($data * 100) / $budget);
    $sommefeb = number_format($data, 0, ',', ' ');

    $output .= '
          <td > &nbsp; Montant global de l\'expression des besoins</td>
          <td class="align-right" > ' . $sommefeb . ' ' . $devise . ' </td>
          <td > ' . $pourcentage . '%</td> 
          <td> &nbsp;</td>
      ';


    echo $output;
  }


  public function store(Request $request)
  {
    try {
      $IDP = session()->get('id');

      $comp = $request->referenceid;
      $compp = explode("-", $comp);

      $grandcompte = $compp[0];
      $souscompte  = $compp[1];

      $somme_budget_ligne = DB::table('rallongebudgets')
        ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
        ->Where('rallongebudgets.projetid', $IDP)
        ->Where('rallongebudgets.souscompte', $souscompte)
        ->SUM('rallongebudgets.budgetactuel');


      $somme_activite_ligne = DB::table('elementfebs')
        ->Where('projetids', $IDP)
        ->Where('eligne', $souscompte)
        ->SUM('montant');

      $datanumero = DB::table('febs')
        ->orderby('id', 'DESC')
        ->Where('projetid', $IDP)
        ->get()
        ->count();
      $datanumero += 1;


      $sum = 0;

      foreach ($request->numerodetail as $key => $items) {
        $element1 = $request->pu[$key];
        $element2 = $request->qty[$key];
        $element3 = $request->frenquency[$key];
        $somme = $element1 * $element2 * $element3;
        $sum += $somme;
      }

      $montant_somme = $sum + $somme_activite_ligne;

      if ($somme_budget_ligne >= $montant_somme) {

        $numerofeb = $request->numerofeb;
        $check = Feb::where('numerofeb', $numerofeb)->first();
        if ($check) {
          return response()->json([
            'status' => 201,
          ]);
        } else {

          if($request->has('bc')){ $bc=1 ; } else{ $bc=0 ; }
          if($request->has('om')){ $om=1 ; } else{ $om=0 ; }
          if($request->has('facture')){ $facture=1 ; } else{ $facture=0 ; }
          if($request->has('fpdevis')){ $fpdevis=1 ; } else{ $fpdevis=0 ; }
          if($request->has('nec')){ $nec=1 ; } else{ $nec=0 ; }

          $activity = new Feb();
          $activity->numerofeb = '000' . $datanumero;
          $activity->projetid = $request->projetid;
          $activity->periode = $request->periode;
          $activity->datefeb = $request->datefeb;
          $activity->ligne_bugdetaire = $grandcompte;
          $activity->descriptionf = $request->descriptionf;
          $activity->bc = $bc;
          $activity->facture = $facture;
          $activity->om = $om;
          $activity->fpdevis = $fpdevis;
          $activity->nec = $nec;
          $activity->acce = $request->acce;
          $activity->comptable = $request->comptable;
          $activity->chefcomposante = $request->chefcomposante;
          $activity->total = $sum;
          $activity->userid = Auth::id();
          $activity->save();


          $IDf = $activity->id;
          // insersion module elments de details

          $elementsSelectionnes= $request->numerodetail;
          foreach ($elementsSelectionnes as $key => $items) {
        

            $element1 = $request->pu[$key];
            $element2 = $request->qty[$key];
            $element3 = $request->frenquency[$key];
            $somme_total = $element1 * $element2 * $element3;



            $elementfeb = new Elementfeb();

            $elementfeb->febid      =  $IDf;
            $elementfeb->libellee   =  $request->description[$key];
            $elementfeb->libelle_description   =  $request->libelle_description[$key];
            $elementfeb->unite      =  $request->unit_cost[$key];
            $elementfeb->quantite   =  $request->qty[$key];
            $elementfeb->frequence  =  $request->frenquency[$key];
            $elementfeb->pu         =  $request->pu[$key];
            $elementfeb->montant    =  $somme_total;
            $elementfeb->projetids  =  $request->projetid;
            $elementfeb->tperiode   =  $request->periode;
            $elementfeb->grandligne =  $grandcompte;
            $elementfeb->eligne     =  $souscompte;
            $elementfeb->numero     =  '000' . $datanumero;

            $elementfeb->save();

          }

          return response()->json([
            'status' => 200,

          ]);
        }
      } else {

        return response()->json([
          'status' => 203,
        ]);
      }
    } catch (Exception $e) {
      return response()->json([
        'status' => 202 + $e,
      ]);
    }
  }


  public function Updatestore(Request $request)
  {
    try {
      $activity = Feb::find($request->febid);

     
          if($request->has('bc')){ $bc=1 ; } else{ $bc=0 ; }
          if($request->has('om')){ $om=1 ; } else{ $om=0 ; }
          if($request->has('facture')){ $facture=1 ; } else{ $facture=0 ; }
          if($request->has('fpdevis')){ $fpdevis=1 ; } else{ $fpdevis=0 ; }
          if($request->has('nec')){ $nec=1 ; } else{ $nec=0 ; }


          $activity->numerofeb = $request->numerofeb;
          $activity->activiteid = $request->activityid;
          $activity->periode = $request->periode;
          $activity->datefeb = $request->datefeb;
          $activity->ligne_bugdetaire = $request->referenceid;
          $activity->bc = $bc;
          $activity->facture = $facture;
          $activity->om = $om;
          $activity->fpdevis = $fpdevis;
          $activity->nec = $nec;
          $activity->comptable = $request->comptable;
          $activity->chefcomposante = $request->chefcomposante;
          //$activity->total = $sum;
         //$activity->userid = Auth::id();
         
          $do = $activity->update();

  
          foreach ($request->numerodetail as $key => $items) {

            $elementfeb = Elementfeb::find($request->idfd[$key]);
           
            $elementfeb->libellee   =  $request->description[$key];
            $elementfeb->unite      =  $request->unit_cost[$key];
            $elementfeb->quantite   =  $request->qty[$key];
            $elementfeb->frequence  =  $request->frenquency[$key];
            $elementfeb->pu         =  $request->pu[$key];
            $elementfeb->montant    =  $request->amount[$key];
          
            $elementfeb->save();

          } 
          if($do){
            return redirect()->back()->with('success', 'Mises ajours reussi avec succès.');
          }else{
            return redirect()->back()->with('faided', 'Erreur de mises ajours.');
          }
          
        
   
    } catch (Exception $e) {
      return response()->json([
        'status' => 202,
      ]);
    }
  }
  

  public function findligne(Request $request)
  {
    try {
      $ID = session()->get('id');
      $data = DB::table('elementfebs')
        ->join('febs', 'elementfebs.febid', '=', 'febs.id')
        ->select('elementfebs.*', 'febs.projetid', 'febs.ligne_bugdetaire')
        ->Where('febs.ligne_bugdetaire', $request->id)
        //   ->orWhere('febs.projetid', $ID)
        ->get();

      return response()->json($data);
    } catch (Exception $e) {
      return response()->json([
        'status' => 202,
      ]);
    }
  }

  public function getactivite(Request $request)
  {
    $output = '';

    $comp = str_replace(' ', '', $request->id);
      $compp = explode("-",$comp);

      $grandcompte = $compp[0];
      $souscompte  = $compp[1];
   
    $activiteligne = Activity::where('compteidr', $souscompte) ->get();

   // dd($souscompte);
    if ($activiteligne->count() > 0) {

     
      $output .= '
        <select type="text" class="form-control form-control-sm"   name="description[]" id="description" >
        <option disabled="true" selected="true">--Aucun--</option>';
      foreach ($activiteligne as $datas) {
        $output .= '
          <option value="'.$datas->id.'">'.$datas->titre.'</option>
        ';
      }
      $output .= '</select>';
    }
    else{
      $output .= 'Aucune element trouver ';
    }

    echo $output;
    
  }


  public function findfebelement(Request $request)
  {

    $ID = session()->get('id');

    $budget = session()->get('budget');

    $devise = session()->get('devise');


    $data = DB::table('febs')
      ->join('activities', 'febs.activiteid', '=', 'activities.id')
      ->join('comptes', 'febs.ligne_bugdetaire', '=', 'comptes.id')
      ->join('personnels', 'febs.acce', '=', 'personnels.id')
      ->join('rallongebudgets', 'febs.ligne_bugdetaire', '=', 'rallongebudgets.compteid')
      ->select('febs.*', 'activities.id', 'activities.titre', 'comptes.libelle', 'personnels.nom', 'personnels.prenom', 'rallongebudgets.budgetactuel')

      ->Where('numerofeb', $request->id)
      ->Where('febs.projetid', $ID)
      ->get();



    if ($data->count() > 0) {

      $output = '';
      foreach ($data as $datas) {}
        $budgetactuel =   $datas->budgetactuel;

        // total consommation sur la ligne
        $totoSUM = DB::table('elementfebs')
          ->orderby('id', 'DESC')
          ->Where('numero', $request->id)
          ->SUM('montant');

        $pourcentageligne = round(($totoSUM * 100) / $budgetactuel);
        $sommefeb = number_format($totoSUM, 0, ',', ' ');

        $pourcentage_global_b = round(($budgetactuel * 100) / $budget);

        $output .= '
      <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
        <tr>
          <td> Ligne bugetaire</td>
          <td colspan="7"> <b> ' . $datas->libelle . '</b>  </td>
        </tr>
          <tr>
            <td> Titre Activite </td>
            <td> <b> ' . $datas->titre . '</b>  </td>
            <td> Etablie par : </td>
            <td> <b> ' . ucfirst($datas->nom) . ' ' . ucfirst($datas->prenom) . '</b>  </td>
            <td> Montant globale projet </td>
            <td> <b> '  . number_format($budget, 0, ',', ' ') . ' ' .  $devise  . '</b>   </td>
          </tr>
        
        <tr>
          <td> Montant globale ligne </td>
          <td> <b> ' . number_format($budgetactuel, 0, ',', ' ') . ' ' .  $devise  . '</b>  </td>
          <td> Montant globale FEB</td>
          <td> <b> ' . number_format($totoSUM, 0, ',', ' ') . '  ' .  $devise  . '</b>  </td>
          <td> Taux execution projet </td>
          <td> <b> ' . $pourcentage_global_b . ' %</b>  </td>
          <td > Taux execution ligne </td>
          <td> <b> ' . $pourcentageligne . ' %</b>  </td>
        </tr>
      </table>
    ';


      echo $output;
      
    } else {
      $output = '
      <table class="table table-striped table-sm fs--1 mb-0" style="background-color:rgba(255, 0, 0, 0.2)"> 
        <tr>
          <td>
            <center>
              <h6 style="margin-top:1% ;color:black" > 
              <center><font size="10px"><i class="far fa-trash-alt"  ></i> </font><br><br>
              Attention : ceci est  est vide  !</center> </h6>
            </center>
          </td>
        </tr>
      </table>
      ';
    }

  
  }

  public function list()
  {
    $title = "FEB";
    $ID = session()->get('id');
    $compte =  DB::table('comptes')
      ->Where('comptes.projetid', $ID)
      ->Where('compteid', '=', 0)
      ->get();


    $personnel = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->Where('fonction', '!=', 'Chauffeur')
      ->orderBy('nom', 'ASC')
      ->get();

    $comptable = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->Where('role', '=', 'Comptable')
      ->orderBy('nom', 'ASC')
      ->get();

    $chefcomposant = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->Where('role', '=', 'Chef de Composante/Projet/Section')
      ->orWhere('role', '=', 'Chef de Service')
      ->orderBy('nom', 'ASC')
      ->get();

    $activite = DB::table('activities')
      ->orderby('id', 'DESC')
      ->Where('projectid', $ID)
      ->get();


    return view(
      'document.feb.list',
      [
        'title' => $title,
        'activite' => $activite,
        'personnel' => $personnel,
        'compte' => $compte,

        'comptable' => $comptable,
        'chefcompable' => $chefcomposant
      ]
    );
  }

  public function show(Feb $key)
  {
    $budget = session()->get('budget');
    $IDB = session()->get('id');

    $title = 'Feb';
    $ida = $key->activiteid;
    $idl = $key->ligne_bugdetaire;
    $idfeb =  $key->id;

   // $dataActivite =  DB::table('activities')
  //  ->join('activitefebs', 'activities.id', '=', 'activitefebs.activiteid')
   // ->Where('activitefebs.febid', $idfeb)
    //->get();

    $dataLigne = Compte::where('id', $idl)->first();

    // Debut % ligfne
    $sommelign = DB::table('elementfebs')
      ->Where('eligne', $idl)
      ->SUM('montant');
    $sommelignpourcentage = round(($sommelign * 100) / $budget);
    // fin

    // sommes element

    $sommefeb = DB::table('elementfebs')
      ->Where('febid', $idfeb)
      ->SUM('montant');

    //

    // DEBUT DE TAUX EXECUTION DU PROJET
    $sommerepartie = DB::table('rallongebudgets')
      ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
      ->Where('rallongebudgets.projetid', $IDB)
      ->SUM('budgetactuel');
    $POURCENTAGE_GLOGALE = round(($sommerepartie * 100) / $budget);
    // FIN TAUX EXECUTION 



    //etablie par 
    $etablienom =  DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->Where('users.id', $key->acce)
      ->first();

    //comptable
    $comptable_nom =  DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->Where('users.id', $key->comptable)
      ->first();


    //chef composant
    $checcomposant_nom =  DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->Where('users.id', $key->chefcomposante)
      ->first();

    $datElement = Elementfeb::where('febid', $idfeb)->get();

    $dateinfo = Identification::all();

    return view(
      'document.feb.voir',
      [
        'title' => $title,
        'dataFeb' => $key,
       // 'dataActivite' => $dataActivite,
        'dataLigne' => $dataLigne,
        'sommelignpourcentage' => $sommelignpourcentage,
        'datElement' => $datElement,
        'sommefeb' => $sommefeb,
        'etablienom' => $etablienom,
        'comptable_nom' => $comptable_nom,
        'checcomposant_nom' => $checcomposant_nom,
        'POURCENTAGE_GLOGALE' => $POURCENTAGE_GLOGALE,
        'dateinfo' => $dateinfo

      ]
    );
  }

  public function showonefeb(Feb $key)
  {
    $budget = session()->get('budget');
    $IDB = session()->get('id');
   

    $title = 'Feb';
    $ida = $key->activiteid;
    $idl = $key->ligne_bugdetaire;
    $idfeb =  $key->id;

    $ID = session()->get('id');
    $compte =  DB::table('comptes')
      ->Where('comptes.projetid', $ID)
      ->Where('compteid', '=', 0)
      ->get();

    $dataJosonfeb = Feb::find($idfeb);
    //$febactivite = Activity::find($idfeb);

    $personnel = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->Where('fonction', '!=', 'Chauffeur')
      ->orderBy('nom', 'ASC')
      ->get();

    $comptable = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->Where('role', '=', 'Comptable')
      ->orderBy('nom', 'ASC')
      ->get();

    $chefcomposant = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->Where('role', '=', 'Chef de Composante/Projet/Section')
      ->orWhere('role', '=', 'Chef de Service')
      ->orderBy('nom', 'ASC')
      ->get();

    $activite = DB::table('activities')
      ->orderby('id', 'DESC')
      ->Where('projectid', $ID)
      ->get();

    $dataActivite = activitefeb::where('activiteid', $ida)->get();

    $dataLigne = Compte::where('id', $idl)->first();

    // Debut % ligfne
    $sommelign = DB::table('elementfebs')
      ->Where('eligne', $idl)
      ->SUM('montant');
    $sommelignpourcentage = round(($sommelign * 100) / $budget);
    // fin

    // sommes element

    $sommefeb = DB::table('elementfebs')
      ->Where('febid', $idfeb)
      ->SUM('montant');

    //

    // DEBUT DE TAUX EXECUTION DU PROJET
    $sommerepartie = DB::table('rallongebudgets')
      ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
      ->Where('rallongebudgets.projetid', $IDB)
      ->SUM('budgetactuel');
    $POURCENTAGE_GLOGALE = round(($sommerepartie * 100) / $budget);
    // FIN TAUX EXECUTION 



    //etablie par 
    $etablienom =  DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->Where('users.id', $key->acce)
      ->first();

    //comptable
    $comptable_nom =  DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'personnels.id')
      ->Where('users.id', $key->comptable)
      ->first();


    //chef composant
    $checcomposant_nom =  DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'personnels.id')
      ->Where('users.id', $key->chefcomposante)
      ->first();

    $datElement = Elementfeb::where('febid', $idfeb)->get();

    return view(
      'document.feb.edit',
      [
        'title' => $title,
        'dataFe' => $dataJosonfeb,
        'dataActivite' => $dataActivite,
        'dataLigne' => $dataLigne,
        'sommelignpourcentage' => $sommelignpourcentage,
        'datElement' => $datElement,
        'sommefeb' => $sommefeb,
        'etablienom' => $etablienom,
        'comptable_nom' => $comptable_nom,
        'checcomposant_nom' => $checcomposant_nom,
        'POURCENTAGE_GLOGALE' => $POURCENTAGE_GLOGALE,
        'activite' => $activite,
        'personnel' => $personnel,
        'compte' => $compte,

        'comptable' => $comptable,
        'chefcompable' => $chefcomposant

      ]
    );
  }


  public function update(Request $request)
  {
    try {
      $emp = Feb::find($request->febid);

      if (!empty($request->accesignature)) {
        $accesignature = 1;
      } else {
        $accesignature = 0;
      }
      if (!empty($request->comptablesignature)) {
        $comptablesignature = 1;
      } else {
        $comptablesignature = 0;
      }
      if (!empty($request->chefsignature)) {
        $chefsignature = 1;
      } else {
        $chefsignature = 0;
      }

      $emp->acce_signe = $accesignature;
      $emp->comptable_signe = $comptablesignature;
      $emp->chef_signe = $chefsignature;

      $emp->update();

      return back()->with('success', 'Très bien! le signature  est bien enregistrer');
    } catch (Exception $e) {
      return back()->with('failed', 'Echec ! le signature  n\'est pas creer ');
    }
  }

  public function delete(Request $request)
  {
    $his = new Historique;
    $function = "Suppression";
    $operation = "Suppression FEB";
    $link = 'feb';
    $his->fonction = $function;
    $his->operation = $operation;
    $his->userid = Auth()->user()->id;
    $his->link = $link;
    $his->save();

    $id = $request->id;
    Feb::destroy($id);
  }
}
