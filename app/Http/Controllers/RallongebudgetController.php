<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\Coutbudget;
use App\Models\Project;
use App\Models\Rallongebudget;
use App\Models\typeprojet;
use Illuminate\Support\Str;
use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class RallongebudgetController extends Controller
{
  
  public function index()
  {

    if (!session()->has('id')) {
      return redirect()->route('dashboard');
    }

     // Définition du titre de la page
     $title = 'Budgétisation';

    // Récupération des valeurs de la session
    $IDP = session()->get('id');
   
    $periode = session()->get('periode');
    $exerciceId = session()->get('exercice_id');

    // Récupération des comptes associés au projet en cours
    $compte = Compte::where('projetid', $IDP)->where('compteid', 0)->get();

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
      'projetdatat' => $projetdatat,

    ]);
  }

  public function fetchAll($isForPrinting = false)
  {
    // Récupération des valeurs de la session
    $IDP        = session()->get('id');
    $devise     = session()->get('devise');
    $budget     = session()->get('budget');
    $periode    = session()->get('periode');
    $exerciceId = session()->get('exercice_id');

    // Récupération des données de base
    $data = Compte::where('compteid', 0)->where('projetid', $IDP)->get();

    // Récupération des informations du projet
    $showData = DB::table('projects')
                    ->join('exercice_projets', 'projects.id', '=', 'exercice_projets.project_id')
                    ->where('projects.id', $IDP)
                    ->where('exercice_projets.id', $exerciceId)
                    ->select(
                        'projects.*',
                        'exercice_projets.numero_e',
                        'exercice_projets.budget as budgets',
                        'exercice_projets.estart_date as estart_date',
                        'exercice_projets.edeadline as edeadline',
                    )
                    ->first();

    // Calcul du budget total réparti
    $sommerepartie = DB::table('rallongebudgets')
                        ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
                        ->where('rallongebudgets.projetid', $IDP)
                        ->where('rallongebudgets.execiceid', $exerciceId)
                        ->sum('budgetactuel');

    // Récupération des informations sur l'utilisateur responsable du projet

    // Calcul du budget total et du pourcentage FEB
    $datasommefeb = DB::table('elementfebs')
                        ->join('febs', 'elementfebs.febid', 'febs.id')
                        ->where('projetids', $IDP)
                        ->where('exerciceids', $exerciceId)
                        ->where('febs.acce_signe', 1)
                        ->where('febs.comptable_signe', 1)
                        ->where('febs.chef_signe', 1)
                        ->sum('montant');

    $pourcentagefeb = $budget ? round(($datasommefeb * 100) / $budget, 2) : 0;

    $sommefeb = number_format($datasommefeb, 0, ',', ' ');

    $messageFEB = $pourcentagefeb == 100
        ? '<center><span class="badge rounded-pill bg-primary font-size-11">Terminé</span></center>'
        : '<center><span class="badge rounded-pill bg-success font-size-11">En cours</span></center>';

    // Initialisation du message pour le budget global
    $pglobale = $showData->budgets ? round(($sommerepartie * 100) / $showData->budgets, 2) : 0;
    $message = $sommerepartie == $showData->budgets
        ? '<center><span class="badge rounded-pill bg-primary font-size-11">Terminé</span></center>'
        : '<center><span class="badge rounded-pill bg-success font-size-11">En cours</span></center>';

    $poursommerepartie = $showData->budgets ? round(($sommerepartie * 100) / $showData->budgets, 2) : 0;
    $messageR = $poursommerepartie == 100
        ? '<center><span class="badge rounded-pill bg-primary font-size-11">Terminé</span></center>'
        : '<center><span class="badge rounded-pill bg-success font-size-11">En cours</span></center>';

    // Construction du tableau de résumé du projet
    $output = '';
    if ($data->count() > 0) {
      $nombre = 1;

      $output .= '
              <table class="table table-bordered table-sm fs--1 mb-0">
                  <tr style="background-color:#82E0AA">
                      <td > <b>Rubrique du projet</b></td>
                      <td > <b>Pays / région</b></td>
                      <td > <b>Exercice</b></td>
                      <td > <b>Date début et fin</b></td>
                      <td > <b>N<sup>o</sup> Projet</b></td>
                      <td > <b><center>Budget</center></b></td>
                      <td > <b><center>%</center></b></td>
                      <td > <b><center>Statut</center></b></td>
                  </tr>
                  <tr>
                      <td style="padding:5px; width:40%">' . htmlspecialchars($showData->title) . '</td>
                      <td style="padding:5px">' . htmlspecialchars($showData->region) . '</td>
                      <td style="padding:3px">' . htmlspecialchars($showData->numero_e) . '</td>
                      <td style="padding:5px">' . date('d/m/Y', strtotime($showData->estart_date))  . ' - ' . date('d/m/Y', strtotime($showData->edeadline))  . '  </td>
                      <td style="padding:5px">' . htmlspecialchars($showData->numeroprojet) . '</td>
                      <td style="padding:5px" align="right">' . number_format($showData->budgets, 0, ',', ' ') . '</td>
                      <td align="right">100%</td>
                      <td>' . $message . '</td>
                  </tr>
                  <tr>
                      <td colspan="5">Total Budget Réparti</td>
                      <td style="padding:5px" align="right">' . number_format($sommerepartie, 0, ',', ' ') . '</td>
                      <td align="right">' . $pglobale . '%</td>
                      <td>' . $messageR . '</td>
                  </tr>
                  <tr>
                      <td colspan="5">Montant en cours de consommation</td>
                      <td style="padding:5px" align="right">' . $sommefeb . '</td>
                      <td align="right">' . $pourcentagefeb . '%</td>
                      <td>' . $messageFEB . '</td>
                  </tr>
              </table>';

      // Type de budget
      $typeBudget = typeprojet::all();

       // Variable pour vérifier s'il existe au moins un type de budget avec des données valides
      $anyBudgetAvailable = false;

      foreach ($typeBudget as $typeBudgets) {
        $cle_id_type_projet = $typeBudgets->id;

        // Vérifier si le type de budget contient des éléments

        $containsElements = false;
        $totalBudget = 0; // Initialisation du total du budget
        
        foreach ($data as $datas) {
          $somme_budget_ligne = DB::table('rallongebudgets')
            ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
            ->where('rallongebudgets.projetid', $IDP)
            ->where('rallongebudgets.execiceid', $exerciceId)
            ->where('rallongebudgets.compteid', $datas->id)
            ->where('comptes.cle_type_projet', $cle_id_type_projet)
            ->sum('rallongebudgets.budgetactuel');



          if ($somme_budget_ligne > 0) {
            $containsElements = true;
            $totalBudget += $somme_budget_ligne; // Ajouter au total du budget
        }

        


        }

        // Afficher le titre du type de budget seulement s'il contient des éléments
        if ($containsElements && $totalBudget > 0) {
          $anyBudgetAvailable = true;
          $output .= '<br><h5>&nbsp; &nbsp;&nbsp;<u>' . $cle_id_type_projet . '. '. $typeBudgets->titre . '</u></h5>';

          $output .= '
                      <table class="table table-bordered table-sm fs--1 mb-0">
                          <thead>
                              <tr style="background-color:#82E0AA;">
                                  <th style="width:2%"><b>#</b></th>
                                  <th style="width:4%"><b>Compte</b></th>
                                  <th style="width:25%"><b>Postes Budgétaire</b></th>
                                  <th><center><b>Prévisions</b></center></th>';

          for ($i = 1; $i <= $periode; $i++) {
            $output .= '<th><center><b>T' . $i . '</b></center></th>';
          }

          $output .= '<th><center><b>Dépenses</b></center></th>
                                  <th><b><center>Relicat</center></b></th>
                                  <th><b><center>T.E</center></b></th>
                              </tr>
                          </thead>
                          <tbody>';

          // Initialisation des totaux
          $totalBudget = 0;
          $totalDepense = 0;
          $totalT = array_fill(1, $periode, 0);

          foreach ($data as $datas) {
            $somme_budget_ligne = DB::table('rallongebudgets')
              ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
              ->where('rallongebudgets.projetid', $IDP)
              ->where('rallongebudgets.execiceid', $exerciceId)
              ->where('rallongebudgets.compteid', $datas->id)
              ->where('comptes.cle_type_projet', $cle_id_type_projet)
              ->sum('rallongebudgets.budgetactuel');

            if ($somme_budget_ligne > 0) {
              $output .= '
                              <tr style="background-color:#F5F5F5">
                                  <td> </td>
                                  <td><b>' . ucfirst($datas->numero) . '</b></td>
                                  <td><b>' . ucfirst($datas->libelle) . '</b></td>
                                  <td align="right"><b>' . number_format($somme_budget_ligne, 0, ',', ' ') . '</b></td>';

              $totalBudget += $somme_budget_ligne;

              for ($i = 1; $i <= $periode; $i++) {
                $tglign = 'T' . $i;
                $somme_TMOntant = DB::table('elementfebs')
                  ->join('febs', 'elementfebs.febid', 'febs.id')
                  ->where('tperiode', $tglign)
                  ->where('projetids', $IDP)
                  ->where('grandligne', $datas->id)
                  ->where('exerciceids', $exerciceId)
                  ->where('febs.acce_signe', 1)
                  ->where('febs.comptable_signe', 1)
                  ->where('febs.chef_signe', 1)

                  ->sum('montant');



                $output .= '<td align="right"><b>' . number_format($somme_TMOntant, 0, ',', ' ') . '</b></td>';
                $totalT[$i] += $somme_TMOntant;
              }

              $somme_montantligne = DB::table('elementfebs')

                ->join('febs', 'elementfebs.febid', 'febs.id')

                ->where('projetids', $IDP)
                ->where('grandligne', $datas->id)
                ->where('exerciceids', $exerciceId)

                ->where('febs.acce_signe', 1)
                ->where('febs.comptable_signe', 1)
                ->where('febs.chef_signe', 1)

                ->sum('montant');

              $totalDepense += $somme_montantligne;

              $reliquat = $somme_budget_ligne - $somme_montantligne;
              $pourcentageparligne = $somme_budget_ligne
                ? round(($somme_montantligne * 100) / $somme_budget_ligne, 2)
                : 0;

              $output .= '
                              <td align="right"><b>' . number_format($somme_montantligne, 0, ',', ' ') . '</b></td>
                              <td align="right"><b>' . number_format($reliquat, 0, ',', ' ') . '</b></td>
                              <td align="right"><b>' . $pourcentageparligne . '%</b></td>
                          </tr>';

              // Récupération des sous-comptes
              $sous_compte = DB::table('rallongebudgets')
                ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
                ->select('rallongebudgets.*', 'comptes.libelle', 'comptes.cle_type_projet', 'comptes.numero', 'rallongebudgets.id as idr')
                ->where('rallongebudgets.projetid', $IDP)
                ->where('rallongebudgets.execiceid', $exerciceId)
                ->where('rallongebudgets.compteid', $datas->id)
                ->where('comptes.cle_type_projet', $cle_id_type_projet)
                ->get();

              foreach ($sous_compte as $sc) {
                $ids = Crypt::encrypt($sc->id);
                $showme = '';
                if (!$isForPrinting) {
                  $showme = $showData->autorisation == 1
                    ? '<div class="btn-group me-2 mb-2 mb-sm-0">
                                          <a data-bs-toggle="dropdown" aria-expanded="false">
                                              <i class="mdi mdi-dots-vertical ms-2"></i>
                                          </a>
                                            <div class="dropdown-menu">
                                             <a class="dropdown-item mx-1 showeHistorique" 
                                              data-id="' . $sc->idr . '" 
                                              id="' . $sc->idr . '" 
                                              data-bs-toggle="modal" 
                                              data-bs-target="#HistoriqueModalScrollable" 
                                              title="Historique budgétaire">
                                                <i class="fa fa-info-circle"></i> Historique ligne budgétaire
                                            </a>
                                            

                                              <a class="dropdown-item mx-1 showrevision" id="' . $sc->idr . '" data-bs-toggle="modal" data-bs-target="#revisionModal" title="Revision budgétaire"><i class="far fa-edit"></i> Execute la revision budgétaire </a>
                                             
                                             
                                            </div>
                                      </div>'
                    : '';
                }

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
                    ->where('exerciceids', $exerciceId)
                    ->where('grandligne', $sc->compteid)
                    ->where('eligne', $sc->souscompte)
                    ->sum('montant');

                  $output .= '<td align="right">' . number_format($TMOntant, 0, ',', ' ') . '</td>';
                }

                $montantGlobaledepense = DB::table('elementfebs')
                  ->where('projetids', $IDP)
                  ->where('exerciceids', $exerciceId)
                  ->where('grandligne', $sc->compteid)
                  ->where('eligne', $sc->souscompte)
                  ->sum('montant');
                $POURCENTAGEPARLIGNE = $sc->budgetactuel ? round(($montantGlobaledepense * 100) / $sc->budgetactuel, 2) : 0;

                $output .= '
                                  <td align="right">' . number_format($montantGlobaledepense, 0, ',', ' ') . '</td>
                                  <td align="right">' . number_format($sc->budgetactuel - $montantGlobaledepense, 0, ',', ' ') . '</td>
                                  <td align="right">' . $POURCENTAGEPARLIGNE . '%</td>
                              </tr>';
              }
              $nombre++;
            }
          }

          // Ajout des totaux pour chaque type de budget
          $output .= '
                      <tr style="background-color:#82E0AA;">
                          <td colspan="3"><b>Total ' . htmlspecialchars($typeBudgets->titre) . '</b></td>
                          <td align="right"><b>' . number_format($totalBudget, 0, ',', ' ') . '</b></td>';

          for ($i = 1; $i <= $periode; $i++) {
            $output .= '<td align="right"><b>' . number_format($totalT[$i], 0, ',', ' ') . '</b></td>';
          }

          $output .= '<td align="right"><b>' . number_format($totalDepense, 0, ',', ' ') . '</b></td>
                              
                                <td align="right">' . number_format($totalBudget - $totalDepense, 0, ',', ' ') . ' </td>
                              <td align="right">' . ($totalDepense > 0 ? round(($totalDepense * 100) / $sommerepartie, 2) : 0) . '%</td>
                          </tr>';

          $output .= '</tbody></table>';
        }
      }


      // Si aucun type de budget n'a de données valides, afficher un message global
      if (!$anyBudgetAvailable) {
        $output .= '<br>';
        $output .= '<div class="alert alert-warning d-flex justify-content-between align-items-center col-xl-7" style="margin:auto; padding: 10px;" role="alert">';
        // Texte aligné à gauche
        $output .= '<span><i class="fas fa-exclamation-triangle"></i> Aucune budgétisation n\'est disponible pour l\'ensemble de l\'exercice du projet.</span>';
        // Bouton aligné à droite
        $output .= '<a href="#" data-bs-toggle="modal" data-bs-target="#addDealModal" class="btn btn-outline-primary rounded-pill btn-sm"><i class="fas fa-plus-circle"></i> Commencer la création</a>';
        $output .= '</div> <br>';
      }

    }

    return $output;
  }

  // insert a new rallongement request
  public function store(Request $request)
  {
    try {
      // Récupération des valeurs de la session
      $IDP = session()->get('id');
      $budget = session()->get('budget');
      $exerciceId = session()->get('exercice_id'); 

      $montant_new_budget = trim($request->input('budgetactuel'));

      // Récupération des données de la requête
      $compte = $request->input('compteid');
      $scompte = $request->input('scomptef');

      // Vérification de l'existence d'un budget pour le même projet, compte et sous-compte
      $check = Rallongebudget::where('compteid', $compte)
        ->where('souscompte', $scompte)
        ->where('projetid', $IDP)
        ->where('rallongebudgets.execiceid', $exerciceId)
        ->first();

      if ($check) {
        return response()->json(['status' => 203]);
      }

      // Calcul du budget total actuel
      $somme_budget = DB::table('rallongebudgets')
        ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
        ->where('rallongebudgets.projetid', $IDP)
        ->where('rallongebudgets.execiceid', $exerciceId)
        ->sum('budgetactuel');

      // Détermination du statut de rétruction
      $retruction = $request->has('customSwitch1') ? 1 : 0;

      // Récupération de l'URL du document si elle est fournie
      $urldocValue = $request->filled('urldoc') ? $request->input('urldoc') : "";

      // Calcul du budget global après ajout du nouveau budget
      $globale = $montant_new_budget + $somme_budget;

      // Vérification si le budget global reste dans les limites du budget projet
      if ($budget >= $globale) {
        // Création et sauvegarde de la nouvelle rallonge budgétaire
        $rallonge = new Rallongebudget();
        $rallonge->projetid = $IDP;
        $rallonge->compteid = $compte;
        $rallonge->souscompte = $scompte;
        $rallonge->budgetactuel = $montant_new_budget;
        $rallonge->retruction = $retruction;
        $rallonge->urldoc = $urldocValue;
        $rallonge->userid = auth()->user()->id;
        $rallonge->execiceid = $exerciceId ;
        $rallonge->save();

        return response()->json(['status' => 200]);
      } else {
        return response()->json(['status' => 201]);
      }
    } catch (Exception $e) {
      // Log the exception for debugging purposes

      return response()->json(['status' => 202], ['error' => $e->getMessage()]);
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
    $exerciceId = session()->get('exercice_id');
    

    // Calcul du budget total
    $somme_budget = DB::table('rallongebudgets')
      ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
      ->where('rallongebudgets.projetid', $IDP)
      ->where('rallongebudgets.execiceid', $exerciceId)
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
    $exerciceId = session()->get('exercice_id');

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

  public function showHistorique(Request $request)
  {
    // Vérifiez que l'ID est fourni
    $key = $request->id; // Utiliser `query` pour GET
    $exerciceId = session()->get('exercice_id');

    if (!$key) {
      return response()->json('<p>Aucun ID fourni.</p>', 400);
    }

    // Récupérer les données
    $dataJon = DB::table('rallongebudgets')
      ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
      ->select('rallongebudgets.*', 'comptes.libelle', 'comptes.numero', 'rallongebudgets.id as idr', 'comptes.id as idCompte')
      ->where('rallongebudgets.id', $key)
      ->where('rallongebudgets.execiceid', $exerciceId)
      ->first();

    // Vérifiez si les données existent
    if (!$dataJon) {
      return response()->json('<p>Aucune donnée trouvée pour cet ID.</p>', 404);
    }

    // Générer la sortie HTML
    $output = '<table class="table table-bordered table-striped table-sm fs--1 mb-0">';
    $output .= '<tbody>';
    $output .= '<tr>';
    $output .= '<td><b>Code : </b><br>' . $dataJon->numero . '</td>';
    $output .= '<td style="width:60%"><b> Libellé :</b> <br>' . $dataJon->libelle . '</td>';
    $output .= '<td><b> Budget Actuel : </b><br>' . number_format($dataJon->budgetactuel, 0, ',', ' ') . '</td>';
    $output .= '</tr>';
    $output .= '</tbody></table>';

    // Récupérer les données du second tableau (recherche dans febs)
    $febsData = DB::table('febs')
      ->orderBy('numerofeb', 'asc')
      ->join('users', 'febs.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('febs.numerofeb', 'febs.datefeb', 'febs.id as febid', 'febs.created_at', 'personnels.prenom as user_prenom')

      ->where('febs.acce_signe', 1)
      ->where('febs.comptable_signe', 1)
      ->where('febs.chef_signe', 1)

      ->where('febs.sous_ligne_bugdetaire', $dataJon->idCompte)
      ->get();

    // Initialisation du total global
    $totalGlobal = 0;

    // Vérifiez si des données ont été trouvées
    if ($febsData->isEmpty()) {
      $output .= '<br> 
                  <div class="alert alert-warning" role="alert">
                    <i class="fa fa-info-circle"></i> Aucune donnée trouvée dans febs pour cet ligne .
                  </div>
                  ';
    } else {
      // Générer la sortie HTML pour le second tableau
      $output .= '<br><h5><i class="fa fa-info-circle"></i> <u>Listes des FEBS des éléments associés  </u></h5>';
      $output .= '<table class="table table-bordered table-striped table-sm fs--1 mb-0">';

      $output .= '<tbody>';

      foreach ($febsData as $feb) {
        // Afficher les informations de chaque FEB
        $output .= '<tr>';
        $output .= '<td><b>Numéro FEB : </b>' . $feb->numerofeb . '</td>';
        $output .= '<td><b>Date FEB : </b>' . $feb->datefeb . '</td>';
        $output .= '<td><b>Créé le :  </b>' . date('d-m-Y', strtotime($feb->created_at)) . '</td>';
        $output .= '<td><b>Créé : </b>' . $feb->user_prenom . '</td>';
        $output .= '<td> </td>';
        $output .= '<td> </td>';

        $output .= '</tr>';

        // Récupérer les éléments associés à ce FEB
        $elements = DB::table('elementfebs')
          ->where('febid', $feb->febid)
          ->get();

        // Initialisation du total pour ce FEB
        $totalFEB = 0;

        // Vérifier si des éléments existent pour ce FEB
        if ($elements->isEmpty()) {
          $output .= '<tr><td colspan="4">Aucun élément trouvé pour ce FEB.</td></tr>';
        } else {
          // Ajouter un sous-tableau pour les éléments
          $output .= '<tr><th>Libellé / Description</th><th>Unité</th><th>Quantité</th><th>Fréquence</th><th>Prix Unitaire</th><th>Montant</th></tr>';
          foreach ($elements as $element) {
            $output .= '<tr>';
            $output .= '<td>' . $element->libelle_description . '</td>';
            $output .= '<td>' . $element->unite . '</td>';
            $output .= '<td>' . $element->quantite . '</td>';
            $output .= '<td>' . $element->frequence . '</td>';
            $output .= '<td align="right">' . number_format($element->pu, 0, ',', ' ') . '</td>';
            $output .= '<td align="right">' . number_format($element->montant, 0, ',', ' ') . '</td>';
            $output .= '</tr>';

            // Ajouter au total du FEB
            $totalFEB += $element->montant;
          }

          // Afficher le total pour ce FEB
          $output .= '<tr><td colspan="5"><b>Total  : </b> </td> <td > <b>' . number_format($totalFEB, 0, ',', ' ') . '</b></td></tr>';

          // Ajouter au total global
          $totalGlobal += $totalFEB;
        }

        // Ajouter une ligne de séparation entre les FEBs
        $output .= '<tr><td colspan="7"><hr></td></tr>';
      }

      // Afficher le total global
      $output .= '<tr><td colspan="6"><b>Total Global : </b></td><td><b>' . number_format($totalGlobal, 0, ',', ' ') . '</b></td></td></tr>';

      $output .= '</tbody></table>';
    }

    return response()->json($output);
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
      $exerciceId = session()->get('exercice_id');

      $grandcompte = $compp[0];
      $souscompte  = $compp[1];

      $data = DB::table('rallongebudgets')
        ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
        ->select('rallongebudgets.*', 'comptes.libelle', 'comptes.numero')
        ->Where('rallongebudgets.projetid', $ID)
        ->where('rallongebudgets.souscompte', $souscompte)
        ->where('rallongebudgets.execiceid', $exerciceId)
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

  public function personnaliserContenuHtml($html)
  {
    // Ajouter l'en-tête au début du HTML généré
    $enteteHtml = '<h3><center>COMMUNAUTE DES EGLISES DE PENTECOTE AU BURUNDI "CEPBU"</center></h3>';

    $pied = "<p><center><small>Adresse: Boulevard de l'UPRONA No 38 ; BP. 2915 Bujumbura-Burundi ; Tél. (+257) 22 223466 ; (+257) 22 214889 ; Email : info@cepbu.bi</small></center></p>";

    // Insérer l'en-tête et la devise au début du HTML
    $html = $enteteHtml . $html;

    // Insérer le pied de page à la fin du HTML
    $html .= $pied;

    // Réduire la taille du texte dans le tableau et enlever le gras
    $html = preg_replace('/<table/', '<table  style="border-collapse: collapse; width: 100%; font-size: 11px; margin: 0; padding: 0;"', $html); // Taille de police réduite à 12px et marges/paddings à 0

    $html = preg_replace('/<tr/', '<tr style="margin: 0;  border: thin solid #c0c0c0; padding: 2px;"', $html); // Marges/paddings des lignes à 0
    $html = preg_replace('/<td/', '<td style="margin: 0;  border: thin solid #c0c0c0; padding: 2px;" ', $html); // Marges/paddings des cellules à 0

    $html = preg_replace('/<b>/', '', $html); // Suppression de toutes les balises <b>
    $html = preg_replace('/<\/b>/', '', $html); // Suppression de toutes les balises </b>

    return $html;
  }

  public function telecharger_rapport_budget()
  {
    // Génération du contenu HTML à convertir en PDF
    $html = $this->fetchAll(true); // true indique que c'est pour l'impression

    // Extraire le titre du projet à partir du contenu HTML
    preg_match('/<td style="padding:5px; width:50%">(.*?)<\/td>/', $html, $matches);
    $titre_projet = isset($matches[1]) ? $matches[1] : 'Projet'; // Utilisation du titre par défaut 'Projet' si non trouvé

    // Personnaliser le contenu HTML
    $html = $this->personnaliserContenuHtml($html);

    // Configuration de Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $options->set('defaultFont', 'Arial');

    // Initialisation de Dompdf avec les options
    $dompdf = new Dompdf($options);

    // Chargement du HTML dans Dompdf
    $dompdf->loadHtml($html);

    // Définition du format du papier et de l'orientation (A4 paysage)
    $dompdf->setPaper('A4', 'landscape');

    // Rendu du PDF
    $dompdf->render();

    // Nom du fichier PDF à télécharger avec le titre du projet
    $fileName = 'rapport_' . Str::slug($titre_projet) . '.pdf'; // Utilisation de Str::slug pour formater le titre

    // Téléchargement du PDF
    return $dompdf->stream($fileName);
  }

}
