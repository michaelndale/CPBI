<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\Project;
use App\Models\Rallongebudget;
use App\Models\typeprojet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class RallongebudgetController extends Controller
{
  public function index()
  {
    // Récupération des valeurs de la session
    $IDP = session()->get('id');
    $devise = session()->get('devise');
    $budget = session()->get('budget');
    $periode = session()->get('periode');

    // Définition du titre de la page
    $title = 'Budgétisation';

    // Récupération des comptes associés au projet en cours
    $compte = Compte::where('projetid', $IDP)
      ->where('compteid', 0)
      ->get();

    // Récupération de tous les types de budget
    $typebudget = TypeProjet::all();

    // Récupération des données du projet
    $projetdatat = Project::find($IDP);

    // Vérification que les données du projet ont été récupérées
    if (!$projetdatat) {
      // Gestion du cas où le projet n'existe pas
      return redirect()->route('error.page')->with('error', 'Projet non trouvé.');
    }

    // Retourne la vue avec les données nécessaires
    return view('rallonge.index', [
      'title' => $title,
      'compte' => $compte,
      'periode' => $periode,
      'typebudget' => $typebudget,
      'projetdatat' => $projetdatat
    ]);
  }



  public function fetchAll()
  {
    // Récupération des valeurs de la session
    $IDP = session()->get('id');
    $devise = session()->get('devise');
    $budget = session()->get('budget');
    $periode = session()->get('periode');

    // Récupération des données de base
    $data = Compte::where('compteid', 0)
      ->where('projetid', $IDP)
      ->get();

    $showData = Project::find($IDP);

    $sommerepartie = DB::table('rallongebudgets')
      ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
      ->where('rallongebudgets.projetid', $IDP)
      ->sum('budgetactuel');

    $user = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->where('users.id', $showData->lead)
      ->get();

    // Calcul du budget total
    $somme_budget = DB::table('rallongebudgets')
      ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
      ->where('rallongebudgets.projetid', $IDP)
      ->sum('budgetactuel');

    // Calcul des données pour FEB
    $datasommefeb = DB::table('elementfebs')
      ->where('projetids', $IDP)
      ->sum('montant');

    $pourcentagefeb = $budget ? round(($datasommefeb * 100) / $budget, 2) : 0;
    $sommefeb = number_format($datasommefeb, 0, ',', ' ');

    $messageFEB = $pourcentagefeb == 100
      ? '<center><span class="badge rounded-pill bg-primary font-size-11">Terminer</span></center>'
      : '<center><span class="badge rounded-pill bg-success font-size-11">Encours</span></center>';

    // Initialisation du message pour le budget global
    $pglobale = $showData->budget ? round(($somme_budget * 100) / $showData->budget, 2) : 0;
    $message = $sommerepartie == $showData->budget
      ? '<center><span class="badge rounded-pill bg-primary font-size-11">Terminer</span></center>'
      : '<center><span class="badge rounded-pill bg-success font-size-11">Encours</span></center>';

    $poursommerepartie = $showData->budget ? round(($sommerepartie * 100) / $showData->budget, 2) : 0;
    $messageR = $poursommerepartie == 100
      ? '<center><span class="badge rounded-pill bg-primary font-size-11">Terminer</span></center>'
      : '<center><span class="badge rounded-pill bg-success font-size-11">Encours</span></center>';

    $output = '';

    if ($data->count() > 0) {
      $nombre = 1;

      $output .= '
          <table class="table table-bordered table-sm fs--1 mb-0">
              <tr style="background-color:#82E0AA">
                  <td style="padding:5px"><b>Rubrique du projet</b></td>
                  <td style="padding:5px"><b>Pays / région</b></td>
                  <td style="padding:5px"><b>N<sup>o</sup> Projet</b></td>
                  <td style="padding:5px"><b><center>Budget</center></b></td>
                  <td style="padding:5px"><b><center>%</center></b></td>
                  <td style="padding:5px"><b><center>Statut</center></b></td>
              </tr>
              <tr>
                  <td style="padding:5px; width:50%">' . htmlspecialchars($showData->title) . '</td>
                  <td style="padding:5px">' . htmlspecialchars($showData->region) . '</td>
                  <td style="padding:5px">' . htmlspecialchars($showData->numeroprojet) . '</td>
                  <td style="padding:5px" align="right">' . number_format($showData->budget, 0, ',', ' ') . '</td>
                  <td><center>100%</center></td>
                  <td>' . $message . '</td>
              </tr>
              <tr>
                  <td colspan="3">Montant total réparti</td>
                  <td style="padding:5px" align="right">' . number_format($somme_budget, 0, ',', ' ') . '</td>
                  <td><center>' . $pglobale . '%</center></td>
                  <td>' . $messageR . '</td>
              </tr>
              <tr>
                  <td colspan="3">Montant en cours de consommation</td>
                  <td style="padding:5px" align="right">' . $sommefeb . '</td>
                  <td><center>' . $pourcentagefeb . '%</center></td>
                  <td>' . $messageFEB . '</td>
              </tr>
          </table>
          <br>';
//class="table table-striped table-bordered table-sm table-centered align-middle table-nowrap mb-0"
      $output .= '
          <table class="table table-bordered table-sm fs--1 mb-0" >
              <thead>
                  <tr style="background-color:#82E0AA;">
                      <th><b>#</b></th>
                      <th><b>Code</b></th>
                      <th style="width:25%"><b>Description ligne budgétaire</b></th>
                      <th><center><b>Budget</b></center></th>';

      for ($i = 1; $i <= $periode; $i++) {
        $output .= '<th><center><b>T' . $i . '</b></center></th>';
      }
      $output .= '<th><center><b>Dépense</b></center></th>
                      <th><b>%</b></th>
                  </tr>
              </thead>
              <tbody>';

      foreach ($data as $datas) {
        // Calcul du budget total par ligne
        $somme_budget_ligne = DB::table('rallongebudgets')
          ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
          ->where('rallongebudgets.projetid', $IDP)
          ->where('rallongebudgets.compteid', $datas->id)
          ->sum('rallongebudgets.budgetactuel');

        //if ($somme_budget_ligne != 0) {
          $output .= '
                  <tr style="background-color:#F5F5F5">
                      <td><b>' . $nombre . '</b></td>
                      <td><b>' . ucfirst($datas->numero) . '</b></td>
                      <td><b>' . ucfirst($datas->libelle) . '</b></td>
                      <td align="right"><b>' . number_format($somme_budget_ligne, 0, ',', ' ') . '</b></td>';

          for ($i = 1; $i <= $periode; $i++) {
            $tglign = 'T'.$i;
            $somme_TMOntant = DB::table('elementfebs')
              ->where('tperiode', $tglign)
              ->where('projetids', $IDP)
              ->where('grandligne', $datas->id)
              ->sum('montant');

            $output .= '<td align="right"><b>' . number_format($somme_TMOntant, 0, ',', ' ') . '</b></td>';
          }

          $total_TMOntant = DB::table('elementfebs')
            ->where('projetids', $IDP)
            ->where('grandligne', $datas->id)
            ->sum('montant');
          $pourcentagelignetotal = $somme_budget_ligne ? round(($total_TMOntant * 100) / $somme_budget_ligne, 2) : 0;

          $output .= '
                      <td align="right"><b>' . number_format($total_TMOntant, 0, ',', ' ') . '</b></td>
                      <td align="right">' . $pourcentagelignetotal . '%</td>
                  </tr>';

          // Récupération des sous-comptes
          $sous_compte = DB::table('rallongebudgets')
            ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
            ->select('rallongebudgets.*', 'comptes.libelle', 'comptes.numero', 'rallongebudgets.id as idr')
            ->where('rallongebudgets.projetid', $IDP)
            ->where('rallongebudgets.compteid', $datas->id)
            ->get();

          foreach ($sous_compte as $sc) {
            $ids = Crypt::encrypt($sc->id);
         
            $showme = $showData->autorisation == 1
              ? '
              <div class="btn-group me-2 mb-2 mb-sm-0">
                    <a  data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical ms-2"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item text-primary mx-1 showrevision" id="'.$sc->idr.'"  data-bs-toggle="modal" data-bs-target="#revisionModal" title="Revision budgétaire"><i class="far fa-edit"></i> Execute la revision budgétaire </a>
                        <a class="dropdown-item text-danger mx-1 deleterevision"  id="'.$sc->idr.'"  href="#" title="Supprimer le compte"><i class="far fa-trash-alt"></i> Supprimer la ligne</a>
                    </div>
                  </div>
              '
              : '';

            $difference = $sc->retruction == 1 ? "difference" : '';
            $url = $sc->retruction == 1 ? '<a href="' . $sc->urldoc . '" target="_blank" title="Voir les conditions"><i class="fas fa-external-link-alt text-success"></i></a>' : '';

            $output .= '
                      <tr class="' . $difference . '">
                          <td style="background-color:#F5F5F5">' . $showme . '</td>
                          <td>' . ucfirst($sc->numero) . '</td>
                          <td>' . ucfirst($sc->libelle) . ' ' . $url . '</td>
                          <td align="right">' . number_format($sc->budgetactuel, 0, ',', ' ') . '</td>';

            for ($i = 1; $i <= $periode; $i++) {
              $RefT = 'T' . $i;
              $TMOntant = DB::table('elementfebs')
                ->where('tperiode', $RefT)
                ->where('projetids', $IDP)
                ->where('grandligne', $sc->compteid)
                ->where('eligne', $sc->souscompte)
                ->sum('montant');

              $output .= '<td align="right">' . number_format($TMOntant, 0, ',', ' ') . '</td>';
            }

            $montantGlobaledepense = DB::table('elementfebs')
              ->where('projetids', $IDP)
              ->where('grandligne', $sc->compteid)
              ->where('eligne', $sc->souscompte)
              ->sum('montant');
            $POURCENTAGEPARLIGNE = $sc->budgetactuel ? round(($montantGlobaledepense * 100) / $sc->budgetactuel, 2) : 0;

            $output .= '
                          <td align="right">' . number_format($montantGlobaledepense, 0, ',', ' ') . '</td>
                          <td align="right">' . $POURCENTAGEPARLIGNE . '%</td>
                      </tr>';
          }
          $nombre++;
        //}
      }
      $output .= '</tbody></table>';
    }

    echo $output;
  }


  // insert a new rallongement request
  public function store(Request $request)
  {
      try {
          // Récupération des valeurs de la session
          $IDP = session()->get('id');
          $budget = session()->get('budget');
          
          // Récupération des données de la requête
          $compte = $request->input('compteid');
          $scompte = $request->input('scomptef');
          
          // Vérification de l'existence d'un budget pour le même projet, compte et sous-compte
          $check = Rallongebudget::where('compteid', $compte)
              ->where('souscompte', $scompte)
              ->where('projetid', $IDP)
              ->first();
  
          if ($check) {
              return response()->json(['status' => 203]);
          }
  
          // Calcul du budget total actuel
          $somme_budget = DB::table('rallongebudgets')
              ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
              ->where('rallongebudgets.projetid', $IDP)
              ->sum('budgetactuel');
  
          // Détermination du statut de rétruction
          $retruction = $request->has('customSwitch1') ? 1 : 0;
  
          // Récupération de l'URL du document si elle est fournie
          $urldocValue = $request->filled('urldoc') ? $request->input('urldoc') : "";
  
          // Calcul du budget global après ajout du nouveau budget
          $globale = $request->input('budgetactuel') + $somme_budget;
  
          // Vérification si le budget global reste dans les limites du budget projet
          if ($budget >= $globale) {
              // Création et sauvegarde de la nouvelle rallonge budgétaire
              $rallonge = new Rallongebudget();
              $rallonge->projetid = $IDP;
              $rallonge->compteid = $compte;
              $rallonge->souscompte = $scompte;
              $rallonge->budgetactuel = $request->input('budgetactuel');
              $rallonge->retruction = $retruction;
              $rallonge->urldoc = $urldocValue;
              $rallonge->typeprojet = $request->input('typeprojet');
              $rallonge->userid = auth()->user()->id;
              $rallonge->save();
  
              return response()->json(['status' => 200]);
          } else {
              return response()->json(['status' => 201]);
          }
      } catch (Exception $e) {
          // Log the exception for debugging purposes
  
          return response()->json(['status' => 202],['error' => $e->getMessage()]);
      }
  }
  

  public function storesc(Rallongebudget $gl, Request $request)
  {
    $gl->projetid = $request->cid;
    $gl->compteid = $request->code;
    $gl->depensecumule = $request->libelle;
    $gl->budgetactuel = $request->libelle;
    $gl->userid = Auth()->user()->id;
    $gl->save();
    return response()->json([
      'status' => 200,
    ]);
  }


  public function updatlignebudget(Request $request)
  {
      
      $IDP = session()->get('id');
      $budget = session()->get('budget');
  
      // Calcul du budget total
      $somme_budget = DB::table('rallongebudgets')
          ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
          ->where('rallongebudgets.projetid', $IDP)
          ->sum('budgetactuel');
  
      $globale = $somme_budget - $request->ancienmontantligne;
      $globale += $request->r_budgetactuel;
  
      if ($budget >= $globale) {
          $MisesA =  Rallongebudget::find($request->r_idr);
          $MisesA->budgetactuel = $request->r_budgetactuel;
          $MisesA->update();
  
          if ($MisesA) {
              $updateligne = Compte::find($request->r_souscompte);
              $updateligne->numero = $request->r_code;
              $updateligne->libelle = $request->r_libelle;
              $updateligne->update();
  
              return response()->json(['status' => 200, 'message' => 'Très bien! Le budget a été bien modifié.']);
          } else {
              return response()->json(['status' => 202, 'message' => 'Échec ! Le budget n\'a pas été modifié.']);
          }
      } else {
          return response()->json(['status' => 205, 'message' => 'Attention ! Vous ne devez pas dépasser le montant du budget global.']);
      }
  }
  


  // SHOW ELEMENT
  public function showrallonge(Request $request)
  {
      // Valider la requête pour s'assurer que 'id' est présent
      $validated = $request->validate([
          'id' => 'required|integer' // Supposons que l'ID est un entier
      ]);
  
      try {
          $key = $validated['id'];
  
          // Récupérer les données
          $dataJon = DB::table('rallongebudgets')
              ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
              ->select('rallongebudgets.*', 'comptes.libelle', 'comptes.numero', 'rallongebudgets.id as idr')
              ->where('rallongebudgets.id', $key)
              ->get();
  
          // Vérifier si des données ont été trouvées
          if ($dataJon->isEmpty()) {
              return response()->json([
                  'status' => 404,
                  'message' => 'Aucune rallonge budgétaire trouvée pour cet ID.'
              ], 404);
          }
  
          // Retourner les données en format JSON
          return response()->json($dataJon, 200);
      } catch (Exception $e) {
          // Gérer les exceptions
          return response()->json([
              'status' => 500,
              'message' => 'Erreur lors de la récupération des données : ' . $e->getMessage()
          ], 500);
      }
  }
  

  // edit an service ajax request
  public function addsc(Request $request)
  {
    $id = $request->id;
    $fon = Rallongebudget::find($id);
    return response()->json($fon);
  }

  // update an service ajax request
  public function update(Request $request)
  {
    $emp = Rallongebudget::find($request->gc_id);
    $emp->gc_title = $request->gc_title;
    $emp->update();

    return response()->json([
      'status' => 200,
    ]);
  }


  public function findSousCompte(Request $request)
  {
    try {
      $ID = session()->get('id');
      $data = Compte::where('compteid', $request->id)
        ->where('souscompteid', '=', 0)
        ->where('projetid', $ID)
        ->get();

      return response()->json($data);
    } catch (Exception $e) {
      return response()->json([
        'status' => 202,
      ]);
    }
  }

  public function condictionsearch(Request $request)
  {
    try {
      $ID = session()->get('id');
      $comp = $request->id;
      $compp = explode("-", $comp);

      $grandcompte = $compp[0];
      $souscompte  = $compp[1];

      $data = DB::table('rallongebudgets')
        ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
        ->select('rallongebudgets.*', 'comptes.libelle', 'comptes.numero')
        ->Where('rallongebudgets.projetid', $ID)
        ->where('rallongebudgets.souscompte', $souscompte)
        ->get();


      $output = '';
      if ($data->count() > 0) {
        foreach ($data as $key => $datas) {
          if ($datas->retruction == 1) {

            $output .= '
            <br>
           <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="mdi mdi-block-helper me-2"></i>
            Attention! Cette ligne est soumise aux conditions d\'utilisation , <a href="' . $datas->urldoc . '" target="_blank"><i class="fas fa-external-link-alt text-success"></i></a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>

          ';
          } else {
            $output .= '<i class="fa fa-info-circle" ></i>  Il n\'y a pas des condictions d\'utilisation';
          }
        }
        echo $output;
      } else {
        echo ' <tr>
          <td colspan="3">
          <center>
            <h6 style="margin-top:1% ;color:#c0c0c0"> 
            <center><font size="50px"><i class="fa fa-info-circle"  ></i> </font><br><br>
           Ceci est vide  !</center> </h6>
          </center>
          </td>
          </tr>';
      }
    } catch (Exception $e) {
      return response()->json([
        'status' => 202,
      ]);
    }
  }


  public function deleteall(Request $request)
  {
    try {

      $emp = Rallongebudget::find($request->id);

      if ($emp->userid == Auth::id()) {
    
        $id = $request->id;
        Rallongebudget::where('id', $id)->delete();
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
