<?php

namespace App\Http\Controllers;

use App\Models\activitefeb;
use App\Models\Activity;
use App\Models\Beneficaire;
use App\Models\Compte;
use App\Models\Elementfeb;
use App\Models\Feb;
use App\Models\Historique;
use App\Models\Identification;
use App\Models\Personnel;
use App\Models\Project;
use App\Models\Rallongebudget;
use App\Models\Vehicule;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use Carbon\Carbon;



class FebController extends Controller
{
  public function fetchAll()
{
    $devise = session()->get('devise');
    $budget = session()->get('budget');
    $ID = session()->get('id');
    
    $data = DB::table('febs')
        ->orderBy('numerofeb', 'Asc')
        ->where('projetid', $ID)
        ->get();

    $output = '';
    
    if ($data->isNotEmpty()) {
        foreach ($data as $datas) {
            $sommefeb = DB::table('elementfebs')
                ->where('febid', $datas->id)
                ->sum('montant');

            $pourcentage = round(($sommefeb * 100) / $budget, 2);
            $sommefeb = number_format($sommefeb, 0, ',', ' ');

            $facture = $datas->facture ? "checked" : "";
            $om = $datas->om ? "checked" : "";
            $bc = $datas->bc ? "checked" : "";
            $nec = $datas->nec ? "checked" : "";
            $fpdevis = $datas->fpdevis ? "checked" : "";

            $cryptedId = Crypt::encrypt($datas->id);

            $output .= '
            <tr>
                <td>
                    <center>
                        <div class="btn-group me-2 mb-2 mb-sm-0">
                            <button class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical ms-2"></i> Actions
                            </button>
                            <div class="dropdown-menu">
                                <a href="feb/' . $cryptedId . '/view" class="dropdown-item text-success mx-1 voirIcon" id="' . $datas->id . '">
                                    <i class="fas fa-eye"></i> Voir feb
                                </a>
                                <a href="feb/' . $cryptedId . '/edit" class="dropdown-item text-primary mx-1 editIcon" id="' . $datas->id . '" title="Modifier">
                                    <i class="far fa-edit"></i> Modifier
                                </a>
                                <a href="feb/' . $datas->id . '/generate-pdf-feb" class="dropdown-item mx-1">
                                    <i class="fa fa-print"></i> Générer document PDF
                                </a>
                                <a class="dropdown-item text-danger mx-1 deleteIcon" id="' . $datas->id . '" href="#">
                                    <i class="far fa-trash-alt"></i> Supprimer
                                </a>
                            </div>
                        </div>
                    </center>
                </td>
                <td align="center">' . $datas->numerofeb . '</td>
                <td align="center">' . $sommefeb . ' ' . $devise . '</td>
                <td align="center">' . $datas->periode . '</td>
                <td align="center"><input type="checkbox" ' . $facture . ' class="form-check-input" /></td>
                <td align="center"><input type="checkbox" ' . $om . ' class="form-check-input" /></td>
                <td align="center"><input type="checkbox" ' . $bc . ' class="form-check-input" /></td>
                <td align="center"><input type="checkbox" ' . $nec . ' class="form-check-input" /></td>
                <td align="center"><input type="checkbox" ' . $fpdevis . ' class="form-check-input" /></td>
                <td align="center">' . date('d-m-Y', strtotime($datas->datefeb)) . '</td>
                <td align="center">' . $pourcentage . '%</td>
            </tr>';
        }
    } else {
        $output .= '
        <tr>
            <td colspan="11">
                <center>
                    <h6 style="margin-top:1%; color:#c0c0c0">
                        <center>
                            <font size="50px">
                                <i class="fas fa-info-circle"></i>
                            </font>
                            <br><br>
                            Ceci est vide !
                        </center>
                    </h6>
                </center>
            </td>
        </tr>';
    }

    echo $output;
}



  public function notificationdoc()
  {

    $documents = collect([]);

    $documentacce = DB::table('febs')
      ->Where('acce', Auth::id())
      ->Where('acce_signe',  0)
      ->get();


    $documentcompte = DB::table('febs')
      ->Where('comptable', Auth::id())
      ->Where('comptable_signe',  0)
      ->get();


    $documentchefcomposent = DB::table('febs')
      ->Where('chefcomposante', Auth::id())
      ->Where('chef_signe',  0)
      ->get();


$dap_demandeetablie= DB::table('daps')
->Where('demandeetablie', Auth::id() )
->Where('demandeetablie_signe',  0)
->get();



$dap_verifier= DB::table('daps')
->Where('verifierpar', Auth::id() )
->Where('verifierpar_signe',  0)
->get();

$dap_approuverpar= DB::table('daps')
->Where('approuverpar', Auth::id() )
->Where('approuverpar_signe',  0)
->get();

$dap_responsable= DB::table('daps')
->Where('responsable', Auth::id() )
->Where('responsable_signe',  0)
->get();

$dap_secretaire= DB::table('daps')
->Where('secretaire', Auth::id() )
->Where('secretaure_general_signe',  0)
->get();

$dap_chefprogramme= DB::table('daps')
->Where('chefprogramme', Auth::id() )
->Where('chefprogramme_signe',  0)
->get();


    $documents = $documents->concat($documentacce)
      ->concat($documentcompte)
      ->concat($documentchefcomposent);

      $dap_documents = $documents->concat($dap_demandeetablie)
      ->concat($dap_verifier)
      ->concat($dap_approuverpar)
      ->concat($dap_responsable)
      ->concat($dap_secretaire)
      ->concat($dap_chefprogramme);


    $output = '';
    if ($documents->count() > 0) {

      $nombre = 1;
      $anne = date('Y');
      foreach ($documents as $doc) {


        $cryptedIDoc = Crypt::encrypt($doc->id);



        if (isset($doc->datelimite) && !empty($doc->datelimite)) {
          $datelimite = date('d-m-Y', strtotime($doc->datelimite));
        } else {
          $datelimite = 'Pas de date limite';
        }



        $output .= '<tr>
              <td>' . $nombre . '</td>
              <td>FEB</td>
              <td><a href="' . route('key.viewFeb', $cryptedIDoc) . '"><b><u>' . ucfirst($doc->numerofeb) . '/' . $anne . '</u></b></a></td>
              <td>' . date('d-m-Y', strtotime($doc->datefeb)) . '</td>
              <td>' . date('d-m-Y', strtotime($doc->created_at)) . '</td>
              <td>' . $datelimite . '</td>
             
            </tr>';
        $nombre++;
      }

      echo $output;
    } 

    if ($dap_documents->count() > 0) {

      $nombre_dap = 1;
      $anne = date('Y');
      foreach ($dap_documents as $dap_doc) {


        $cryptedIDocdap = Crypt::encrypt($dap_doc->id);

        $output .= '<tr>
              <td>' . $nombre_dap . '</td>
              <td>DAP</td>
              <td><a href="' . route('viewdap', $cryptedIDocdap) . '"><b><u>' . ucfirst($dap_doc->numerodp) . '/' . $anne . '</u></b></a></td>
              <td>' . date('d-m-Y', strtotime($dap_doc->dateautorisation)) . '</td>
              <td>' . date('d-m-Y', strtotime($dap_doc->created_at)) . '</td>
              <td> </td>
             
            </tr>';
            $nombre_dap++;
      }

      echo $output;
    } 
    
    else {
      echo ' <tr>
      <td colspan="5">
      <center>
        <h6 style="margin-top:1% ;color:#c0c0c0"> 
        <center><font size="50px"><i class="fa fa-info-circle"  ></i> </font><br><br>
       Ceci est vide  !</center> </h6>
      </center>
      </td>
      </tr>';
    }
  }


  public function navnotificationdoc()
  {

    $documents = collect([]);

    $documentacce = DB::table('febs')
      ->Where('acce', Auth::id())
      ->Where('acce_signe',  0)
      ->limit(3)
      ->get();


    $documentcompte = DB::table('febs')
      ->Where('comptable', Auth::id())
      ->Where('comptable_signe',  0)
      ->limit(3)
      ->get();


    $documentchefcomposent = DB::table('febs')
      ->Where('chefcomposante', Auth::id())
      ->Where('chef_signe',  0)
      ->limit(3)
      ->get();


    $documents = $documents->concat($documentacce)
      ->concat($documentcompte)
      ->concat($documentchefcomposent);

    $output = '';
    if ($documents->count() > 0) {

      $nombre = 1;
      $anne = date('Y');
      foreach ($documents as $doc) {






        $cryptedIDoc = Crypt::encrypt($doc->id);


        $output .= '<a href="' . route('key.viewFeb', $cryptedIDoc) . '" class="text-reset notification-item">
        <div class="d-flex">
          <div class="avatar-xs me-3">
            <span class="avatar-title bg-success rounded-circle font-size-16">
              <i class="ri-checkbox-circle-line"></i>
            </span>
          </div>
          <div class="flex-1">
            <h6 class="mb-1">FEB:' . ucfirst($doc->numerofeb) . '/' . $anne . '</h6>
            <div class="font-size-12 text-muted">
              <p class="mb-1"><i class="mdi mdi-clock-outline"></i>  Date du feb ' . date('d-m-Y', strtotime($doc->datefeb)) . '</p>
              <p class="mb-0"><i class="mdi mdi-clock-outline"></i> Date creation' . date('d-m-Y', strtotime($doc->created_at)) . '</p>
            </div>
          </div>
        </div>
      </a>
        
        
    ';
      }

      echo $output;
    } else {
      echo ' <tr>
        <td colspan="5">
        <center>
          <h6 style="margin-top:1% ;color:#c0c0c0"> 
          <center><font size="50px"><i class="fa fa-info-circle"  ></i> </font><br><br>
         Ceci est vide  !</center> </h6>
        </center>
        </td>
        </tr>';
    }
  }


  public function Sommefeb()
  {
    $devise = session()->get('devise');
    $budget = session()->get('budget');
    $ID = session()->get('id');

    $data = DB::table('elementfebs')
      ->Where('projetids', $ID)
      ->SUM('montant');

    $output = '';

    $pourcentage = round(($data * 100) / $budget, 2);
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
      DB::beginTransaction();
  
      try {
          $IDP = session()->get('id');
  
          $comp = $request->referenceid;
          $compp = explode("-", $comp);
  
          $grandcompte = $compp[0];
          $souscompte  = $compp[1];
  
          $somme_budget_ligne = DB::table('rallongebudgets')
              ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
              ->where('rallongebudgets.projetid', $IDP)
              ->where('rallongebudgets.souscompte', $souscompte)
              ->sum('rallongebudgets.budgetactuel');
              
  
          $somme_budget_grand_ligne = DB::table('rallongebudgets')
              ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
              ->where('rallongebudgets.projetid', $IDP)
              ->where('rallongebudgets.compteid', $grandcompte)
              ->sum('rallongebudgets.budgetactuel');
  
          $somme_activite_ligne = DB::table('elementfebs')
              ->where('projetids', $IDP)
              ->where('eligne', $souscompte)
              ->sum('montant');
  
          $sum = 0;
  
          foreach ($request->numerodetail as $key => $items) {
              $element1 = $request->pu[$key];
              $element2 = $request->qty[$key];
              $element3 = $request->frenquency[$key];
              $somme = $element1 * $element2 * $element3;
              $sum += $somme;
          }
  
          $montant_somme = $sum + $somme_activite_ligne;
  
          // Première vérification
          if ($somme_budget_ligne < $montant_somme && !$request->has('confirm_ligne')) {
              return response()->json([
                  'status' => 203,
                  'message' => "Le montant dépasse à la fois le budget de l'activité et celui du sous-ligne budgétaire disponible. Souhaitez-vous poursuivre les opérations sur la ligne budgétaire, sachant que cela pourrait affecter l'exécution du budget pour d'autres activités ?",
                  'need_confirmation' => 'ligne'
              ]);
          }
  
          // Deuxième vérification
          if ($somme_budget_grand_ligne < $montant_somme) {
            return response()->json([
                'status' => 204,
                'message' => 'Le montant dépasse le budget de la grande ligne budgétaire disponible ('.$somme_budget_grand_ligne.'€).',
            ]);
        }
  
          $numerofeb = $request->numerofeb;
          $check = Feb::where('numerofeb', $numerofeb)
              ->where('projetid', $IDP)
              ->first();
  
          if ($check) {
              return response()->json([
                  'status' => 201
              ]);
          } else {
              $bc = $request->has('bc') ? 1 : 0;
              $om = $request->has('om') ? 1 : 0;
              $facture = $request->has('facture') ? 1 : 0;
              $fpdevis = $request->has('fpdevis') ? 1 : 0;
              $nec = $request->has('nec') ? 1 : 0;
  
              $activity = new Feb();
              $activity->numerofeb = $request->numerofeb;
              $activity->projetid = $request->projetid;
              $activity->periode = $request->periode;
              $activity->datefeb = $request->datefeb;
              $activity->datelimite = $request->datelimite;
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
              $activity->beneficiaire = $request->beneficiaire;
              $activity->total = $sum;
              $activity->userid = Auth::id();
              $activity->save();
  
              $IDf = $activity->id;
  
              foreach ($request->numerodetail as $key => $items) {
                  $somme_total = $request->pu[$key] * $request->qty[$key] * $request->frenquency[$key];
  
                  $elementfeb = new Elementfeb();
                  $elementfeb->febid = $IDf;
                  $elementfeb->numero = $request->numerofeb;
                  $elementfeb->libellee = $request->description[$key];
                  $elementfeb->libelle_description = $request->libelle_description[$key];
                  $elementfeb->unite = $request->unit_cost[$key];
                  $elementfeb->quantite = $request->qty[$key];
                  $elementfeb->frequence = $request->frenquency[$key];
                  $elementfeb->pu = $request->pu[$key];
                  $elementfeb->montant = $somme_total;
                  $elementfeb->projetids = $request->projetid;
                  $elementfeb->tperiode = $request->periode;
                  $elementfeb->grandligne = $grandcompte;
                  $elementfeb->eligne = $souscompte;
                  $elementfeb->userid = Auth::id();
                  $elementfeb->save();
              }
  
              DB::commit();
  
              return response()->json([
                  'status' => 200,
              ]);
          }
      } catch (\Exception $e) {
          DB::rollBack();
  
          return response()->json([
              'status' => 202,
              'error' => $e->getMessage()
          ]);
      }
  }
  



  public function Updatestore(Request $request)
  {
    DB::beginTransaction();

    try {
      $IDP = session()->get('id');

      $activity = Feb::find($request->febid);

      $bc = $request->has('bc') ? 1 : 0;
      $om = $request->has('om') ? 1 : 0;
      $facture = $request->has('facture') ? 1 : 0;
      $fpdevis = $request->has('fpdevis') ? 1 : 0;
      $nec = $request->has('nec') ? 1 : 0;

      $activity->numerofeb = $request->numerofeb;
      $activity->periode = $request->periode;
      $activity->datefeb = $request->datefeb;
      $activity->datelimite = $request->datelimite;
      $activity->bc = $bc;
      $activity->facture = $facture;
      $activity->om = $om;
      $activity->fpdevis = $fpdevis;
      $activity->nec = $nec;
      $activity->comptable = $request->comptable;
      $activity->acce = $request->acce;
      $activity->chefcomposante = $request->chefcomposante;
      $activity->descriptionf = $request->descriptionf;
      $activity->beneficiaire = $request->beneficiaire;
      $activity->update();

      $dataToUpdate = [];

      foreach ($request->numerodetail as $key => $itemID) {
        if (isset($request->idelements[$key]) && !empty($request->idelements[$key])) {
          $idelements = $request->idelements[$key];
          $elementfeb = Elementfeb::find($idelements);
          if ($elementfeb) {
            $dataToUpdate[] = [
              'id' => $idelements,
              'libelle_description' => $request->libelle_description[$key],
              'unite' => $request->unit_cost[$key],
              'quantite' => $request->qty[$key],
              'frequence' => $request->frenquency[$key],
              'pu' => $request->pu[$key],
              'montant' => $request->amount[$key],
              'libellee' => $request->libelleid[$key]
            ];
          }
        } else {
          $newfeb = new Elementfeb();
          $newfeb->febid = $request->febid;
          $newfeb->libelle_description = $request->libelle_description[$key];
          $newfeb->unite = $request->unit_cost[$key];
          $newfeb->quantite = $request->qty[$key];
          $newfeb->frequence = $request->frenquency[$key];
          $newfeb->pu = $request->pu[$key];
          $newfeb->montant = $request->amount[$key];
          $newfeb->projetids = $request->projetid;
          $newfeb->tperiode = $request->periode;
          $newfeb->grandligne = $request->grandligne;
          $newfeb->eligne = $request->eligne;
          $newfeb->numero = $request->numerofeb;
          $newfeb->libellee = $request->libelleid[$key];
          $newfeb->userid = Auth::id();
          $newfeb->save();
        }
      }

      foreach ($dataToUpdate as $data) {
        Elementfeb::where('id', $data['id'])->update($data);
      }

      DB::commit();

      return redirect()->back()->with('success', 'FEB mises à jour avec succès');
    } catch (\Exception $e) {
      DB::rollBack();

      return redirect()->back()->with('failed', 'FEB erreur des mises à jour: ' . $e->getMessage());
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
    $compp = explode("-", $comp);

    $grandcompte = $compp[0];
    $souscompte  = $compp[1];

    $activiteligne = Activity::where('compteidr', $souscompte)->get();

    // dd($souscompte);
    if ($activiteligne->count() > 0) {

      $output .= '
        <select type="text" class="form-control form-control-sm"   name="description[]" id="description" required>
        <option disabled="true" selected="true">--Aucun--</option>';
      foreach ($activiteligne as $datas) 
        {
          $output .= ' <option value="' . $datas->id . '">' . $datas->titre . '</option>';
        }
      $output .= '</select>';
    } else {
      $output .= 'Aucune element trouver ';
    }

    echo $output;
  }


  public function findfebelement(Request $request)
  {
    $IDs = $request->ids; // Utilisez 'ids' pour obtenir tous les identifiants sélectionnés
    $devise = session()->get('devise');
    $budget = session()->get('budget');
    $IDP = session()->get('id');



    // Initialisez une variable pour stocker les sorties de tableau
    $output = '';
    $output .= '
    <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
    <tr>
      <th>Numéro du FEB</th>
      <th>Activité</th>
      <th>Montant total </th>
      <th><center>Taux Exécution/projet </center></th>
     
    </tr>';

    $totoglobale = 0; // Initialiser le total global à zéro
    $pourcentage_total = 0; // Initialiser le pourcentage total à zéro

    foreach ($IDs as $ID) {
      // Effectuez la recherche de données pour chaque identifiant sélectionné
      $data = DB::table('febs')
        ->where('febs.id', $ID)
        ->get();



      if ($data->count() > 0) {

        $totoSUM = DB::table('elementfebs')
          ->orderBy('id', 'DESC')
          ->where('febid', $ID)
          ->sum('montant');

        // Ajouter $totoSUM au total global
        $totoglobale += $totoSUM;

        // Générer la sortie HTML pour chaque élément sélectionné
        foreach ($data as $datas) {
          // sommes element
          $sommefeb = DB::table('elementfebs')
            ->Where('febid', $datas->id)
            ->Where('projetids', $IDP)
            ->SUM('montant');

          $pourcentage = round(($sommefeb * 100) / $budget, 2);

          // Ajouter le pourcentage de cette itération au pourcentage total
          $pourcentage_total += $pourcentage;

          // Construire la sortie HTML pour chaque élément sélectionné
          $output .= '<input type="hidden"  name="febid[]" id="febid[]"  value="' . $datas->id . '" />';
          $output .= '<td width="7%"> ' . $datas->numerofeb . '</td>';
          $output .= '<td width="40%">' . $datas->descriptionf . '</td>';
          $output .= '<td width="10%" align="right">' .  number_format($totoSUM, 0, ',', ' ') . '</td>';
          $output .= '<td width="10%" align="center"> ' . $pourcentage . '%</td></tr>';
        }
      } else {
        $output = '<p style="background-color:red ; padding:4px; color:white"> <i class="fa fa-search"></i> Aucun élément trouvé, aucune valeur est en sélectionnée</p>';
      }
    }

    // Ajouter la ligne pour afficher le total global
    $output .= '
          <tr style=" background-color: #040895;">
          <td style="color:white"> Montant total global</td> <td colspan="2" align="right"  style="color:white">  ' . number_format($totoglobale, 0, ',', ' ')  . '</td>
          <td style="color:white" align="center">' . $pourcentage_total . ' %</td>
          </tr> 
        </table>';

    // Retournez la sortie HTML complète
    return $output;
  }

  public function findfebelementretour(Request $request)
{
    $IDs = $request->ids; // Utilisez 'ids' pour obtenir tous les identifiants sélectionnés
    $devise = session()->get('devise');
    $budget = session()->get('budget');
    $IDP = session()->get('id');

    // Initialisez une variable pour stocker les sorties de tableau
    $output = '';
    $output .= '
    <table class="table table-striped table-sm fs--1 mb-0 table-bordered" style="width:100%">
    ';

    $totoglobale = 0; // Initialiser le total global à zéro
    $pourcentage_total = 0; // Initialiser le pourcentage total à zéro

    foreach ($IDs as $ID) {
        // Effectuez la recherche de données pour chaque identifiant sélectionné
        $data = DB::table('febs')
            ->where('febs.id', $ID)
            ->get();

        $personnels = Personnel::all();

        if ($data->count() > 0) {
            $totoSUM = DB::table('elementfebs')
                ->where('febid', $ID)
                ->sum('montant');

            // Ajouter $totoSUM au total global
            $totoglobale += $totoSUM;

            // Générer la sortie HTML pour chaque élément sélectionné
            foreach ($data as $datas) {
                // Sommes élément
                $sommefeb = DB::table('elementfebs')
                    ->where('febid', $datas->id)
                    ->where('projetids', $IDP)
                    ->sum('montant');

                $ligneinfo = Compte::where('id', $datas->ligne_bugdetaire)
                    ->first();

                $pourcentage = round(($sommefeb * 100) / $budget, 2);

                // Ajouter le pourcentage de cette itération au pourcentage total
                $pourcentage_total += $pourcentage;

                // Construire la sortie HTML pour chaque élément sélectionné
                $output .= '<input type="hidden" name="febid[]" value="' . $datas->id . '" />';
                $output .= '<input type="hidden" name="ligneid[]" value="' . $datas->ligne_bugdetaire . '" />';
                $output .= '<tr>';
                $output .= '<td width="10%"> Numéro FEB : ' . $datas->numerofeb . '</td>';
                $output .= '<td width="20%"> Montant de l\'Avance <input type="number" name="montantavance[]" style="width: 100%; border:1px solid #c0c0c0" /></td>';
                $output .= '<td width="20%"> Durée avance <input type="number" name="duree_avance[]" style="width: 100%; border:1px solid #c0c0c0" /></td>';
                $output .= '<td width="20%">Description <input type="text" name="descriptionel[]" style="width: 100%; border:1px solid #c0c0c0" /> </td>';
                $output .= '<td> </td>';
                $output .= '</tr>';
            }
        }
    }
    $output .= '</table>';

    $output .= '
    <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
        <tr>
            <td><b>Fonds reçus par</b></td>
        </tr>
        <tr>
            <td>
                <select class="form-control form-control-sm" name="beneficiaire" id="beneficiaire">
                    <option value="">-- Fonds reçus par --</option>';
                    foreach ($personnels as $personnel) {
                        $output .= '<option value="' . $personnel->userid . '">' . $personnel->nom . ' ' . $personnel->prenom . '</option>';
                    }
    $output .= '
                </select>
            </td>
        </tr>
    </table>';

    return $output;
}

  public function list()
  {
    $title = "FEB";
    $ID = session()->get('id');
    $compte =  DB::table('comptes')
      ->Where('comptes.projetid', $ID)
      ->Where('compteid', '=', 0)
      ->get();

    $beneficaire = Beneficaire::orderBy('libelle')->get();


    $personnel = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
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
        'beneficaire' => $beneficaire
      ]
    );
  }

  public function show($key)
  {
     
      $key = Crypt::decrypt($key);
      $check = Feb::findOrFail($key);

      $title = 'FEB';
      $idl = $check->ligne_bugdetaire;
      $idfeb = $check->id;

      $datElement = Elementfeb::where('febid', $idfeb)->get();
      $IDB = $check->projetid;
      $chec = Project::findOrFail($IDB);
      $budget = $chec->budget;

     /* if (!session()->has('budget')) {
          $idprojetcrispte = Crypt::encrypt($check->projetid);
          $ke = Crypt::decrypt($idprojetcrispte);
          $chec = Project::findOrFail($ke);
  
          session()->put('id', $chec->id);
          session()->put('title', $chec->title);
          session()->put('numeroprojet', $chec->numeroprojet);
          session()->put('ligneid', $chec->ligneid);
          session()->put('devise', $chec->devise);
          session()->put('budget', $chec->budget);
          session()->put('periode', $chec->periode);
      } 
  
      $budget = session()->get('budget');
      $IDB = session()->get('id');
  */
     
      $onebeneficaire = Beneficaire::find($check->beneficiaire);
  
      $sommeallfeb = DB::table('elementfebs')
          ->where('projetids', $IDB)
          ->sum('montant');
  
      $dataLigne = Compte::find($idl);
  
      $sommelign = DB::table('elementfebs')
          ->where('grandligne', $idl)
          ->sum('montant');
  
      $sommelignpourcentage = round(($sommelign * 100) / $budget, 2);
  
      $sommefeb = DB::table('elementfebs')
          ->where('febid', $idfeb)
          ->where('projetids', $IDB)
          ->sum('montant');
  
      $POURCENTAGE_GLOGALE = round(($sommeallfeb * 100) / $budget, 2);
  
      $createur = DB::table('users')
          ->join('personnels', 'users.personnelid', '=', 'personnels.id')
          ->select('personnels.nom', 'personnels.prenom')
          ->where('users.id', $check->userid)
          ->first();
  
      $etablienom = DB::table('users')
          ->join('personnels', 'users.personnelid', '=', 'personnels.id')
          ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as userid')
          ->where('users.id', $check->acce)
          ->first();
  
      $comptable_nom = DB::table('users')
          ->join('personnels', 'users.personnelid', '=', 'personnels.id')
          ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
          ->where('users.id', $check->comptable)
          ->first();
  
      $checcomposant_nom = DB::table('users')
          ->join('personnels', 'users.personnelid', '=', 'personnels.id')
          ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
          ->where('users.id', $check->chefcomposante)
          ->first();
  
      
  
      $dateinfo = Identification::all();
  
      return view('document.feb.voir', [
          'title' => $title,
          'dataFeb' => $check,
          'dataprojets' => $chec,
          'dataLigne' => $dataLigne,
          'sommelignpourcentage' => $sommelignpourcentage,
          'datElement' => $datElement,
          'sommefeb' => $sommefeb,
          'etablienom' => $etablienom,
          'comptable_nom' => $comptable_nom,
          'checcomposant_nom' => $checcomposant_nom,
          'POURCENTAGE_GLOGALE' => $POURCENTAGE_GLOGALE,
          'dateinfo' => $dateinfo,
          'createur' => $createur,
          'onebeneficaire' => $onebeneficaire,
      ]);
  }
  
  public function showonefeb($idf)
  {
      // Check if the session variable 'id' exists
      if (!session()->has('id')) {
          return redirect()->route('dashboard');
      }
  
      $budget = session()->get('budget');
      $IDB = session()->get('id');
  
      $idf = Crypt::decrypt($idf);
  
      $dataJosonfeb = DB::table('febs')
          ->join('comptes', 'febs.ligne_bugdetaire', 'comptes.id')
          ->select('febs.*', 'febs.id as idfb', 'comptes.id as idc', 'comptes.numero as numeroc', 'comptes.libelle as libellec')
          ->where('febs.id', $idf)
          ->first();
  
      $title = 'FEB';
  
      $idl = $dataJosonfeb->ligne_bugdetaire;
      $idfeb = $dataJosonfeb->id;
  
      $ID = session()->get('id');
      $compte = DB::table('comptes')
          ->where('comptes.projetid', $ID)
          ->where('compteid', '=', 0)
          ->get();
  
      $personnel = DB::table('users')
          ->join('personnels', 'users.personnelid', '=', 'personnels.id')
          ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
          ->where('fonction', '!=', 'Chauffeur')
          ->orderBy('nom', 'ASC')
          ->get();
  
      $dataLigne = Compte::where('id', $idl)->first();
  
      // Debut % ligne
      $sommelign = DB::table('elementfebs')
          ->where('grandligne', $idl)
          ->sum('montant');
      $sommelignpourcentage = round(($sommelign * 100) / $budget);
      // fin
  
      // sommes element
      $sommefeb = DB::table('elementfebs')
          ->where('febid', $idfeb)
          ->sum('montant');
      // fin
  
      // DEBUT DE TAUX EXECUTION DU PROJET
      $datafebs = DB::table('elementfebs')
          ->orderBy('id', 'DESC')
          ->where('projetids', $ID)
          ->sum('montant');
  
      $POURCENTAGE_GLOGALE = round(($datafebs * 100) / $budget);
      // FIN TAUX EXECUTION
  
      // Etablie par
      $etablienom = DB::table('users')
          ->join('personnels', 'users.personnelid', '=', 'personnels.id')
          ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
          ->where('users.id', $dataJosonfeb->acce)
          ->first();
  
      // Comptable
      $comptable_nom = DB::table('users')
          ->join('personnels', 'users.personnelid', '=', 'personnels.id')
          ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'personnels.id', 'users.id as userid')
          ->where('users.id', $dataJosonfeb->comptable)
          ->first();
  
      // Chef composant
      $checcomposant_nom = DB::table('users')
          ->join('personnels', 'users.personnelid', '=', 'personnels.id')
          ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
          ->where('users.id', $dataJosonfeb->chefcomposante)
          ->first();
  
      $datElement = DB::table('elementfebs')
          ->join('activities', 'elementfebs.libellee', 'activities.id')
          ->select('elementfebs.*', 'elementfebs.id as idef', 'activities.id as ida', 'activities.titre as titrea')
          ->where('febid', $idfeb)
          ->get();
  
      $datElementgene = DB::table('elementfebs')
          ->join('activities', 'elementfebs.libellee', 'activities.id')
          ->select('elementfebs.*', 'elementfebs.id as idef', 'activities.id as ida', 'activities.titre as titrea')
          ->where('febid', $idfeb)
          ->first();
      $activiteligne = Activity::where('compteidr', $datElementgene->eligne)->get();
  
      $beneficaire = Beneficaire::orderBy('libelle')->get();
      $onebeneficaire = Beneficaire::where('id', $dataJosonfeb->beneficiaire)->first();
  
      return view(
          'document.feb.edit',
          [
              'title' => $title,
              'dataFe' => $dataJosonfeb,
              'dataLigne' => $dataLigne,
              'sommelignpourcentage' => $sommelignpourcentage,
              'datElement' => $datElement,
              'sommefeb' => $sommefeb,
              'etablienom' => $etablienom,
              'comptable_nom' => $comptable_nom,
              'checcomposant_nom' => $checcomposant_nom,
              'POURCENTAGE_GLOGALE' => $POURCENTAGE_GLOGALE,
              'personnel' => $personnel,
              'compte' => $compte,
              'datElementgene' => $datElementgene,
              'activiteligne' => $activiteligne,
              'beneficaire' => $beneficaire,
              'onebeneficaire' => $onebeneficaire,
          ]
      );
  }
  


  public function update(Request $request)
  {

    try {

      if (!empty($request->accesignature) || !empty($request->comptablesignature) || !empty($request->chefsignature)) {
        $emp = Feb::find($request->febid);

        if (!empty($request->accesignature)) {
          $accesignature = 1;
        } else {
          $accesignature = $request->clone_accesignature;
        }
        if (!empty($request->comptablesignature)) {
          $comptablesignature = 1;
        } else {
          $comptablesignature = $request->clone_comptablesignature;
        }
        if (!empty($request->chefsignature)) {
          $chefsignature = 1;
        } else {
          $chefsignature = $request->clone_chefsignature;
        }

        $emp->acce_signe = $accesignature;
        $emp->comptable_signe = $comptablesignature;
        $emp->chef_signe = $chefsignature;

        $emp->update();

        return back()->with('success', 'Très bien! La signature a bien été enregistrée');
      } else {
        return back()->with('failed', 'Cochez la case située en dessous de votre nom si vous êtes accrédité pour apposer votre signature.');
      }
    } catch (Exception $e) {
      return back()->with('failed', 'Échec ! La signature n\'a pas été créée');
    }
  }




  public function generatePDFfeb($id)
  {
      // Vérifie si la variable de session 'id' existe
     
     
      $check = Feb::findOrFail($id);

      $title = 'FEB';
      $idl = $check->ligne_bugdetaire;
      $idfeb = $check->id;

      $datElement = Elementfeb::where('febid', $idfeb)->get();
      $IDB = $check->projetid;
      $chec = Project::findOrFail($IDB);
      $budget = $chec->budget;
  
      // Instancie Dompdf
      $dompdf = new Dompdf();
      $infoglo = DB::table('identifications')->first();
  
      $datafeb = DB::table('febs')
          ->join('comptes', 'febs.ligne_bugdetaire', 'comptes.id')
          ->join('projects', 'febs.projetid', '=', 'projects.id')
          ->select('febs.*', 'comptes.id as idc', 'projects.title as libelleA', 'comptes.numero as numeroc', 'comptes.libelle as libellec')
          ->where('febs.id', $id)
          ->first();
  
      $onebeneficaire = Beneficaire::where('id', $datafeb->beneficiaire)->first();
  
     
      $ID = session()->get('id');
  
      $compte = DB::table('comptes')
          ->where('comptes.projetid', $ID)
          ->where('compteid', '=', 0)
          ->get();
  
      $personnel = DB::table('users')
          ->join('personnels', 'users.personnelid', '=', 'personnels.id')
          ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
          ->where('fonction', '!=', 'Chauffeur')
          ->orderBy('nom', 'ASC')
          ->get();
  
      $dataLigne = Compte::where('id', $idl)->first();
  
      $sommeallfeb = DB::table('elementfebs')
          ->where('projetids', $IDB)
          ->sum('montant');
      $POURCENTAGE_GLOGALE = round(($sommeallfeb * 100) / $budget, 2);
  
      $sommelign = DB::table('elementfebs')
          ->where('grandligne', $idl)
          ->sum('montant');
      $sommelignpourcentage = round(($sommelign * 100) / $budget, 2);
  
      $sommefeb = DB::table('elementfebs')
          ->where('febid', $idfeb)
          ->sum('montant');
  
      // Calcul du taux d'exécution du projet
      $sommerepartie = DB::table('rallongebudgets')
          ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
          ->where('rallongebudgets.projetid', $IDB)
          ->sum('budgetactuel');
  
      // Etablie par
      $etablienom = DB::table('users')
          ->join('personnels', 'users.personnelid', '=', 'personnels.id')
          ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as userid')
          ->where('users.id', $datafeb->acce)
          ->first();
  
      // Comptable
      $comptable_nom = DB::table('users')
          ->join('personnels', 'users.personnelid', '=', 'personnels.id')
          ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as userid')
          ->where('users.id', $datafeb->comptable)
          ->first();
  
      // Chef composant
      $checcomposant_nom = DB::table('users')
          ->join('personnels', 'users.personnelid', '=', 'personnels.id')
          ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
          ->where('users.id', $datafeb->chefcomposante)
          ->first();
  
   
  
      // Génère le fichier PDF
      $pdf = FacadePdf::loadView('document.feb.feb', compact(
          'infoglo',
          'datafeb',
          'sommelignpourcentage',
          'sommefeb',
          'etablienom',
          'comptable_nom',
          'checcomposant_nom',
          'POURCENTAGE_GLOGALE',
          'personnel',
          'compte',
          'datElement',
          'dataLigne',
          'onebeneficaire',
          'chec'
      ));
  
      $pdf->setPaper('A4', 'landscape'); // Format A4 en mode paysage
     
      // Nom du fichier PDF téléchargé avec numéro FEB et date actuelle
      $fileName = 'FEB_NUM' . $datafeb->numerofeb . '_' . Carbon::now()->format('iHs_dmY') . '.pdf';

      // Télécharge le PDF
      return $pdf->download($fileName);
  }
  

  
  public function generateWordFeb($id)
  {
      // Check if the session variable 'id' exists
      if (!session()->has('id')) {
          return redirect()->route('dashboard');
      }
  
      $budget = session()->get('budget');
      $IDB = session()->get('id');
  
      // Retrieve necessary data from the database
      $infoglo = DB::table('identifications')->first();
  
      $datafeb = DB::table('febs')
          ->join('comptes', 'febs.ligne_bugdetaire', 'comptes.id')
          ->join('projects', 'febs.projetid', '=', 'projects.id')
          ->select('febs.*', 'comptes.id as idc', 'projects.title as libelleA', 'comptes.numero as numeroc', 'comptes.libelle as libellec')
          ->where('febs.id', $id)
          ->first();
  
      $onebeneficaire = Beneficaire::where('id', $datafeb->beneficiaire)->first();
  
      $idl = $datafeb->ligne_bugdetaire;
      $idfeb = $datafeb->id;
  
      $compte = DB::table('comptes')
          ->where('comptes.projetid', $IDB)
          ->where('compteid', '=', 0)
          ->get();
  
      $personnel = DB::table('users')
          ->join('personnels', 'users.personnelid', '=', 'personnels.id')
          ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
          ->where('fonction', '!=', 'Chauffeur')
          ->orderBy('nom', 'ASC')
          ->get();
  
      $dataLigne = Compte::where('id', $idl)->first();
  
      $sommeallfeb = DB::table('elementfebs')
          ->where('projetids', $IDB)
          ->sum('montant');
      $POURCENTAGE_GLOGALE = round(($sommeallfeb * 100) / $budget, 2);
  
      $sommelign = DB::table('elementfebs')
          ->where('grandligne', $idl)
          ->sum('montant');
      $sommelignpourcentage = round(($sommelign * 100) / $budget, 2);
  
      $sommefeb = DB::table('elementfebs')
          ->where('febid', $idfeb)
          ->sum('montant');
  
      $sommerepartie = DB::table('rallongebudgets')
          ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
          ->where('rallongebudgets.projetid', $IDB)
          ->sum('budgetactuel');
  
      $etablienom = DB::table('users')
          ->join('personnels', 'users.personnelid', '=', 'personnels.id')
          ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as userid')
          ->where('users.id', $datafeb->acce)
          ->first();
  
      $comptable_nom = DB::table('users')
          ->join('personnels', 'users.personnelid', '=', 'personnels.id')
          ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as userid')
          ->where('users.id', $datafeb->comptable)
          ->first();
  
      $checcomposant_nom = DB::table('users')
          ->join('personnels', 'users.personnelid', '=', 'personnels.id')
          ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
          ->where('users.id', $datafeb->chefcomposante)
          ->first();
  
      $datElement = Elementfeb::where('febid', $idfeb)->get();
  
      // Render the Blade view to HTML
      $htmlContent = View::make('document.feb.feb', compact(
          'infoglo',
          'datafeb',
          'sommelignpourcentage',
          'sommefeb',
          'etablienom',
          'comptable_nom',
          'checcomposant_nom',
          'POURCENTAGE_GLOGALE',
          'personnel',
          'compte',
          'datElement',
          'dataLigne',
          'onebeneficaire'
      ))->render();
  
      // Create a new PHPWord Object
      $phpWord = new PhpWord();
      $section = $phpWord->addSection();
  
      // Add HTML content to the Word document
      Html::addHtml($section, $htmlContent);
  
      // Save the document
      $fileName = 'feb.docx';  // Name of the file to be created
      $tempFile = tempnam(sys_get_temp_dir(), $fileName);  // Create a temporary file
  
      // Write the Word document to the temporary file
      $writer = IOFactory::createWriter($phpWord, 'Word2007');
      $writer->save($tempFile);
  
      // Return the document as a download and delete the temporary file after sending
      return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
  }
  

  

  public function delete(Request $request)
  {

    try {

      $emp = Feb::find($request->id);
      if ($emp->userid == Auth::id()) {
        $id = $request->id;


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

        $elements = Elementfeb::where('febid', '=', $id)->get();
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

  public function checkfeb(Request $request)
  {
      $ID = session()->get('id');
      $numero = $request->numerofeb;

      $feb = Feb::where('numerofeb', $numero)
      ->where('projetid', $ID)
      ->exists();

      return response()->json(['exists' => $feb]);
    
  }


  public function deleteelementsfeb(Request $request)
  {

    try {

      $emp = Elementfeb::find($request->id);
      if ($emp->userid == Auth::id()) {
        $id = $request->id;


        $his = new Historique;
        $function = "Suppression";
        $operation = "Suppression les details de la feb ";
        $link = 'feb';
        $his->fonction = $function;
        $his->operation = $operation;
        $his->userid = Auth()->user()->id;
        $his->link = $link;
        $his->save();

        $elements = Elementfeb::where('id', '=', $id)->get();
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
