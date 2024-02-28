<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Compte;
use App\Models\Elementfeb;
use App\Models\Feb;
use App\Models\Historique;
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

        $output .= '
        <tr>
        <td>
          <center>
              <div class="btn-group me-2 mb-2 mb-sm-0">
                <button class="btn btn-primary btn-sm dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-dots-vertical ms-2"></i> Action
                </button>
                <div class="dropdown-menu">
                    <a href="feb/' . $datas->id . '/view" class="dropdown-item text-success mx-1 voirIcon" id="' . $datas->id . '"  ><i class="far fa-edit"></i> Voir feb</a>
                    <a class="dropdown-item text-primary mx-1 editIcon " id="' . $datas->id . '"  data-bs-toggle="modal" data-bs-target="#editFolderModal" title="Modifier"><i class="far fa-edit"></i> Modifier</a>
                    <a class="dropdown-item text-danger mx-1 deleteIcon"  id="' . $datas->id . '"  href="#"><i class="far fa-trash-alt"></i> Supprimer</a>
                </div>
            </div>
          </center>

          </td>
          <td> <b>' . $datas->numerofeb . ' </b>  </td>
          <td> ' . $datas->facture . '  </td>
          <td> ' . $datas->datefeb . ' </td>
          <td> ' . $datas->bc . ' </td>
          <td> ' . $datas->periode . ' </td>
          <td> ' . $datas->om . ' </td>
          <td> <b> ' . $sommefeb . ' ' . $devise . '</b>  </td>
          <td> ' . $pourcentage . '%</td>
          
        </tr>
      ';
        $nombre++;
      }
      echo $output;
    } else {
      echo
      '
      <tr>
      <td colspan="10">
      <center>
        <h6 style="margin-top:1% ;color:#c0c0c0"> 
        <center><font size="50px"><i class="far fa-trash-alt"  ></i> </font><br><br>
        Ceci est vice !</center> </h6>
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
          <td > Montant globale d\'expression des besoins</td>
          <td class="align-right" padding-left:5px> <b> ' . $sommefeb . ' ' . $devise . '</b>  </td>
          <td > ' . $pourcentage . '%</td> 
          <td> &nbsp;</td>
      ';


    echo $output;
  }



  // insert a new employee ajax request
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

          $activity = new Feb();
          $activity->numerofeb = '000' . $datanumero;
          $activity->projetid = $request->projetid;
          $activity->activiteid = $request->activityid;
          $activity->periode = $request->periode;
          $activity->datefeb = $request->datefeb;
          $activity->ligne_bugdetaire = $grandcompte;
          $activity->bc = $request->bc;
          $activity->facture = $request->facture;
          $activity->om = $request->om;
          $activity->acce = $request->acce;
          $activity->comptable = $request->comptable;
          $activity->chefcomposante = $request->chefcomposante;
          $activity->total = $sum;
          $activity->userid = Auth::id();
          $activity->save();

          $IDf = $activity->id;
          // insersion module elments de details
          foreach ($request->numerodetail as $key => $items) {

            $element1 = $request->pu[$key];
            $element2 = $request->qty[$key];
            $element3 = $request->frenquency[$key];
            $somme_total = $element1 * $element2 * $element3;



            $elementfeb = new Elementfeb();

            $elementfeb->febid      =  $IDf;
            $elementfeb->libellee   =  $request->description[$key];
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

    $dataActivite = Activity::where('id', $ida)->first();

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

    return view(
      'document.feb.voir',
      [
        'title' => $title,
        'dataFeb' => $key,
        'dataActivite' => $dataActivite,
        'dataLigne' => $dataLigne,
        'sommelignpourcentage' => $sommelignpourcentage,
        'datElement' => $datElement,
        'sommefeb' => $sommefeb,
        'etablienom' => $etablienom,
        'comptable_nom' => $comptable_nom,
        'checcomposant_nom' => $checcomposant_nom,
        'POURCENTAGE_GLOGALE' => $POURCENTAGE_GLOGALE

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
