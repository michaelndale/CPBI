<?php

namespace App\Http\Controllers;

use App\Models\activitefeb;
use App\Models\Activity;
use App\Models\Apreviation;
use App\Models\attache_feb;
use App\Models\Beneficaire;
use App\Models\Compte;
use App\Models\dap;
use App\Models\Dja;
use App\Models\Elementdap;
use App\Models\Elementdjas;
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
use Illuminate\Support\Str;



class FebController extends Controller
{

  public function create()
  {
    // Récupérer l'ID de la session

    $projectId = session()->get('id');
    $exerciceId = session()->get('exercice_id');
    // Vérifie si l'ID de projet existe dans la session
    if (!$projectId && !$exerciceId) {
      // Gérer le cas où l'ID du projet et exercice est invalide
      return redirect()->back()->with('error', "La session du projet et de l'exercice est terminée. Vous allez être redirigé...");
    }

    $exerciceId = session()->get('exercice_id');

    $title = "Nouvel  F.E.B";
    $personnel = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
      ->orderBy('nom', 'ASC')
      ->get();

    $activite = DB::table('activities')
      ->orderBy('id', 'DESC')
      ->where('projectid', $projectId)
      ->where('activities.execiceid', $exerciceId)
      ->get();

    $attache = Apreviation::all();

    $compte =  DB::table('comptes')
      ->where('comptes.projetid', $projectId)
      ->where('compteid', '=', 0)
      ->get();

    $beneficaire = Beneficaire::orderBy('libelle')->get();

     // Trouver le dernier numéro existant
     $lastFeb = Feb::where('projetid', $projectId)
     ->where('execiceid', $exerciceId)
     ->orderBy('numerofeb', 'desc') 
     ->first();

      // Générer un nouveau numéro en ajoutant 1 au dernier trouvé
      $newNumero = $lastFeb ? $lastFeb->numerofeb + 1 : 1;


    return view(
      'document.feb.new',
      [
        'title' => $title,
        'activite' => $activite,
        'personnel' => $personnel,
        'compte' => $compte,
        'beneficaire' => $beneficaire,
        'attache' => $attache,
        'newNumero' => $newNumero
      ]
    );
  }

  public function fetchAll()
  {
    $devise = session()->get('devise');
    $budget = session()->get('budget');
    $projectId = session()->get('id');
    $exerciceId = session()->get('exercice_id');



    $searchTerm = request()->get('search_numerofeb', null);

    // Pagination: Définir le nombre d'éléments par page
    $perPage = 25;

    $query = DB::table('febs')
      ->orderBy('numerofeb', 'asc')
      ->join('comptes', 'febs.sous_ligne_bugdetaire', '=', 'comptes.id')
      ->join('users', 'febs.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('febs.*', 'personnels.prenom as user_prenom', 'comptes.numero as code')
      ->where('febs.execiceid', $exerciceId)
      ->where('febs.projetid', $projectId);

    if ($searchTerm) {
      $query->where(function ($query) use ($searchTerm) {
        $query->where('febs.numerofeb', '=', $searchTerm)
          ->orWhere('febs.total', '=', $searchTerm);
      });
    }

    // Utilisation de paginate
    $data = $query->paginate($perPage);

    $output = '';

    if ($data->isNotEmpty()) {
      foreach ($data as $datas) {
        $sommefeb = DB::table('elementfebs')
          ->where('febid', $datas->id)
          ->where('elementfebs.projetids', $projectId)
          ->where('elementfebs.exerciceids', $exerciceId)
          ->sum('montant');

        $getDocument = attache_feb::join('apreviations', 'attache_febs.annexid', 'apreviations.id')
          ->select('apreviations.abreviation', 'apreviations.libelle')
          ->where('attache_febs.febid', $datas->id)
          ->get();

        $pourcentage = round(($sommefeb * 100) / $budget, 2);
        $sommefebFormatted = number_format($sommefeb, 0, ',', ' ');

        $checkedString = $getDocument->isNotEmpty()
          ? implode(', ', $getDocument->map(fn($doc) => '<i class="fa fa-check-circle" style="color: green;" title="' . $doc->libelle . '"></i> ' . $doc->abreviation)->toArray())
          : '<i class="fa fa-times-circle" style="color: red;" title="Aucun fichier attaché disponible"></i>';

        $description = ucfirst( Str::limit($datas->descriptionf, 50, '...'));

        $statut = $datas->statut !== 1
          ? "<span class='badge rounded-pill bg-subtle-primary text-primary font-size-11'> <i class='fa fa-check'></i> Disponible </span>"
          : "<span class='badge rounded-pill bg-danger-subtle text-danger font-size-11'> <i class='fa fa-times'></i> Terminé </span>";

        $cryptedId = Crypt::encrypt($datas->id);

        $message = $datas->signale == 1 ? ' 
            <div class="spinner-grow text-danger" role="status" style="width: 0.5rem; height: 0.5rem;"> <span class="sr-only"> Loading...</span> </div>' : '';



        $output .= "
            <tr>
                <td align='center'>{$message}</td>
                <td align='center'>
                    <center>
                        <div class='btn-group me-2 mb-2 mb-sm-0'>
                            <a data-bs-toggle='dropdown' aria-expanded='false'>
                                <i class='mdi mdi-dots-vertical ms-2'></i> Options
                            </a>
                            <div class='dropdown-menu'>
                                <a href='feb/{$cryptedId}/view' class='dropdown-item mx-1' id='{$datas->id}'>
                                    <i class='fas fa-eye'></i> Voir
                                </a>";
        if ($getDocument->isNotEmpty()) {
          $output .= "
                                <a href='feb/{$cryptedId}/showannex' class='dropdown-item mx-1' id='{$datas->id}'>
                                    <i class='fas fa-paperclip'></i> Attachez les annex
                                </a>";
        }
        $output .= "
                                <a href='feb/{$cryptedId}/edit' class='dropdown-item mx-1' id='{$datas->id}' title='Modifier'>
                                    <i class='far fa-edit'></i> Modifier
                                </a>
                                <a href='feb/{$datas->id}/generate-pdf-feb' class='dropdown-item mx-1'>
                                    <i class='fa fa-print'></i> Générer PDF
                                </a>";
        if ($datas->signale == 1) {
          $output .= "
                                <a class='dropdown-item desactiversignale' id='{$datas->id}' href='#'>
                                    <i class='fas fa-random'></i> Désactiver le signal ?
                                </a>";
        }
        $output .= "
                                <a class='dropdown-item text-white mx-1 deleteIcon' id='{$datas->id}' data-numero='{$datas->numerofeb}' href='#' style='background-color:red'>
                                    <i class='far fa-trash-alt'></i> Supprimer
                                </a>
                            </div>
                        </div>
                    </center>
                </td>
                <td align='center'><b>{$datas->numerofeb}</b></td>
                    <td align='right'><b>{$sommefebFormatted}</b></td>
                    <td align='center'>{$datas->periode}</td>
                    <td align='center'>{$datas->code}</td>
                    <td>{$description}</td>
                    <td align='center'>{$checkedString}</td>
                    <td align='center'>{$statut}</td>
                    <td align='center'>" . date('d-m-Y', strtotime($datas->datefeb)) . "</td>
                    <td align='center'>" . date('d-m-Y', strtotime($datas->created_at)) . "</td>
                    <td align='left'>" . ucfirst($datas->user_prenom) . "</td>
                    <td align='center'>{$pourcentage}%</td>
                </tr>";
      }
    } else {
      $output .= '
            <tr>
                <td colspan="13">
                    <center>
                        <h6 style="margin-top:1%; color:#c0c0c0">
                            <font size="50px"><i class="fas fa-info-circle"></i></font>
                            <br><br>Aucun résultat trouvé.
                        </h6>
                    </center>
                </td>
            </tr>';
    }

    // Ajouter la pagination dans le rendu HTML
    $pagination = $data->links('pagination::bootstrap-4')->toHtml();

    return response()->json(['table' => $output, 'pagination' => $pagination]);
  }

  public function store(Request $request)
  {
   
  
    $IDP = session()->get('id');

    $exerciceId = session()->get('exercice_id');

   // dd($exerciceId);

    DB::beginTransaction();

    try {


      $IDP = session()->get('id');

      $numerofeb = $request->numerofeb;
      $check = Feb::where('numerofeb', $numerofeb)
        ->where('projetid', $IDP)
        ->where('febs.execiceid', $exerciceId)
        ->first();

      $comp = $request->referenceid;
      $compp = explode("-", $comp);

      $grandcompte = $compp[0];
      $souscompte  = $compp[1];

      $somme_budget_ligne = DB::table('rallongebudgets')
        ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
        ->where('rallongebudgets.projetid', $IDP)
        ->where('rallongebudgets.execiceid', $exerciceId)
        ->where('rallongebudgets.souscompte', $souscompte)
        ->sum('rallongebudgets.budgetactuel');


      $somme_budget_grand_ligne = DB::table('rallongebudgets')
        ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
        ->where('rallongebudgets.projetid', $IDP)
        ->where('rallongebudgets.execiceid', $exerciceId)
        ->where('rallongebudgets.compteid', $grandcompte)
        ->sum('rallongebudgets.budgetactuel');

      $somme_activite_ligne = DB::table('elementfebs')

        ->join('febs', 'elementfebs.febid', 'febs.id')

        ->where('febs.acce_signe', 1)
        ->where('febs.comptable_signe', 1)
        ->where('febs.chef_signe', 1)

        ->where('projetids', $IDP)
        ->where('elementfebs.exerciceids', $exerciceId)
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
          'message' => "Le montant dépasse à la fois le budget de l'activité et celui du sous-ligne budgétaire disponible.",
          'need_confirmation' => 'ligne'
        ]);
      }

      // Deuxième vérification
      if ($somme_budget_grand_ligne < $montant_somme) {
        return response()->json([
          'status' => 204,
          'message' => 'Le montant dépasse le budget de la grande ligne budgétaire disponible (' . $somme_budget_grand_ligne . '€).',
        ]);
      }



      if ($check) {
        return response()->json([
          'status' => 201
        ]);
      } else {


        $activity = new Feb();
        $activity->numerofeb = $request->numerofeb;
        $activity->projetid = $request->projetid;
        $activity->periode = $request->periode;
        $activity->datefeb = $request->datefeb;
        $activity->datelimite = $request->datelimite;
        $activity->ligne_bugdetaire = $grandcompte;
        $activity->sous_ligne_bugdetaire = $souscompte;
        $activity->descriptionf = $request->descriptionf;
        $activity->acce = $request->acce;
        $activity->comptable = $request->comptable;
        $activity->chefcomposante = $request->chefcomposante;
        $activity->execiceid = $exerciceId;

        if ($request->beneficiaire !== 'autres') {
          $activity->beneficiaire = $request->beneficiaire;
        } else {
          $activity->autresBeneficiaire = $request->autresBeneficiaire;
        }

        $activity->total = $sum;
        $activity->userid = Auth()->user()->id;
        $activity->save();

        $IDf = $activity->id;

        $cryptedId = Crypt::encrypt($IDf);

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
          $elementfeb->exerciceids = $exerciceId;
          $elementfeb->userid = Auth()->user()->id;
          $elementfeb->save();
        }

        if ($request->has('annex')) {
          foreach ($request->annex as $key => $annexid) {
            $newAnnex = new attache_feb();
            $newAnnex->febid = $IDf;
            $newAnnex->annexid = $annexid;
            $newAnnex->save(); // Enregistre chaque nouvelle instance
          }
        }



        DB::commit();

        return response()->json([
          'status' => 200,
          'redirect' => route('key.viewFeb', $cryptedId),
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


  public function storeUtilisation(Request $request)
  {
   
  
    $IDP = session()->get('id');

    $exerciceId = session()->get('exercice_id');

   // dd($exerciceId);

    DB::beginTransaction();

    try {


      $IDP = session()->get('id');

      $numerofeb = $request->numerofeb;
      $check = Feb::where('numerofeb', $numerofeb)
        ->where('projetid', $IDP)
        ->where('febs.execiceid', $exerciceId)
        ->first();

      $comp = $request->referenceid;
      $compp = explode("-", $comp);

      $grandcompte = $compp[0];
      $souscompte  = $compp[1];

      $somme_budget_ligne = DB::table('rallongebudgets')
        ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
        ->where('rallongebudgets.projetid', $IDP)
        ->where('rallongebudgets.execiceid', $exerciceId)
        ->where('rallongebudgets.souscompte', $souscompte)
        ->sum('rallongebudgets.budgetactuel');


      $somme_budget_grand_ligne = DB::table('rallongebudgets')
        ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
        ->where('rallongebudgets.projetid', $IDP)
        ->where('rallongebudgets.execiceid', $exerciceId)
        ->where('rallongebudgets.compteid', $grandcompte)
        ->sum('rallongebudgets.budgetactuel');

      $somme_activite_ligne = DB::table('elementfebs')

        ->join('febs', 'elementfebs.febid', 'febs.id')

        ->where('febs.acce_signe', 1)
        ->where('febs.comptable_signe', 1)
        ->where('febs.chef_signe', 1)

        ->where('projetids', $IDP)
        ->where('elementfebs.exerciceids', $exerciceId)
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
          'message' => "Le montant dépasse à la fois le budget de l'activité et celui du sous-ligne budgétaire disponible.",
          'need_confirmation' => 'ligne'
        ]);
      }

      // Deuxième vérification
      if ($somme_budget_grand_ligne < $montant_somme) {
        return response()->json([
          'status' => 204,
          'message' => 'Le montant dépasse le budget de la grande ligne budgétaire disponible (' . $somme_budget_grand_ligne . '€).',
        ]);
      }



      if ($check) {
        return response()->json([
          'status' => 201
        ]);
      } else {


        $activity = new Feb();
        $activity->numerofeb = $request->numerofeb;
        $activity->projetid = $request->projetid;
        $activity->periode = $request->periode;
        $activity->datefeb = $request->datefeb;
        $activity->datelimite = $request->datelimite;
        $activity->ligne_bugdetaire = $grandcompte;
        $activity->sous_ligne_bugdetaire = $souscompte;
        $activity->descriptionf = $request->descriptionf;
        $activity->acce = $request->acce;
        $activity->comptable = $request->comptable;
        $activity->chefcomposante = $request->chefcomposante;
        $activity->execiceid = $exerciceId;

        if ($request->beneficiaire !== 'autres') {
          $activity->beneficiaire = $request->beneficiaire;
        } else {
          $activity->autresBeneficiaire = $request->autresBeneficiaire;
        }

        $activity->total = $sum;
        $activity->userid = Auth()->user()->id;
        $activity->save();

        $IDf = $activity->id;

        $cryptedId = Crypt::encrypt($IDf);

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
          $elementfeb->exerciceids = $exerciceId;
          $elementfeb->userid = Auth()->user()->id;
          $elementfeb->save();
        }

        if ($request->has('annex')) {
          foreach ($request->annex as $key => $annexid) {
            $newAnnex = new attache_feb();
            $newAnnex->febid = $IDf;
            $newAnnex->annexid = $annexid;
            $newAnnex->save(); // Enregistre chaque nouvelle instance
          }
        }



        DB::commit();

        return response()->json([
          'status' => 200,
          'redirect' => route('key.viewFeb', $cryptedId),
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

  public function notificationFeb()
  {
    $feb_notification = DB::table('febs')
      ->join('projects', 'febs.projetid', '=', 'projects.id')
      ->join('exercice_projets','febs.execiceid', 'exercice_projets.id')
      ->join('comptes', 'febs.sous_ligne_bugdetaire', '=', 'comptes.id')
      ->join('users', 'febs.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select(
        'febs.*',
        'febs.id as idfeb',
        'personnels.prenom as user_prenom',
        'comptes.numero as code',
        'projects.id AS projet_id',
        'projects.title AS projet_title',
        'projects.numeroprojet AS projet_numero',
        'personnels.nom AS user_nom',
        'personnels.prenom AS user_prenom',
        'projects.annee AS projet_annee'
      )
      
      ->where(function ($query) {
        $query->where('febs.acce', Auth::id())->where('febs.acce_signe', 0)
          ->orWhere('febs.comptable', Auth::id())->where('febs.comptable_signe', 0)
          ->orWhere('febs.chefcomposante', Auth::id())->where('febs.chef_signe', 0);
      })
      ->where('exercice_projets.status', '=', 'Actif')
      ->orderBy('projects.title') // Ordonner par titre de projet
      ->orderBy('febs.numerofeb')
      ->get();

    $output = '';
    $lastProjectTitle = null;
    $numooOrder = 1;

    // Si des notifications sont trouvées
    if ($feb_notification->isNotEmpty()) {
      // Regrouper les éléments par projet
      $groupedByProject = $feb_notification->groupBy('projet_title');

      foreach ($groupedByProject as $projectTitle => $febs) {
        // Afficher le titre du projet
        $output .= '<tr style="background-color:#addfad">
                            <td colspan="8"><b>' . ucfirst($projectTitle) . '</b></td>
                        </tr>';

        // Afficher les notifications pour chaque projet
        foreach ($febs as $feb) {
          // Calculer le montant total des DAP pour chaque ligne
          $sumMontant = DB::table('elementfebs')

            ->join('febs', 'elementfebs.febid', 'febs.id')

            //->where('febs.acce_signe', 1)
            //->where('febs.comptable_signe', 1)
            //->where('febs.chef_signe', 1)

            ->where('febid', $feb->idfeb)
            ->sum('montant');

          $cryptedIDoc = Crypt::encrypt($feb->idfeb);

          // Détails de chaque notification
          $output .= '
                                <tr>
                                    <td>' . $numooOrder . '</td>
                                    <td align="right"><a href="' . route('key.viewFeb', $cryptedIDoc) . '"><b>' . $feb->numerofeb . '/' . $feb->projet_annee . ' <i class="fas fa-external-link-alt"></i></b></a></td>
                                    <td align="right"><b>' . number_format($sumMontant, 0, ',', ' ') . '</b> </td>
                                    <td>' . date('d-m-Y', strtotime($feb->datefeb)) . '</td>
                                    <td>' . date('d-m-Y', strtotime($feb->datelimite)) . '</td>
                                    <td>' . date('d-m-Y', strtotime($feb->created_at)) . '</td>
                                    <td>' . ucfirst($feb->user_nom) . ' ' . ucfirst($feb->user_prenom) . '</td>
                                </tr>';
          $numooOrder++;
        }
      }
    } else {
      $output = '<tr>
                       <td colspan="9" style="background-color: rgba(255, 0, 0, 0.1);">
                              <center>
                                  <h6 style="color:red"><i class="fa fa-info-circle"></i> Aucun document trouvé</h6>
                              </center>
                          </td>
                    </tr>';
    }

    return $output;
  }

  public function notificationdap()
  {
    $dap_notifications = DB::table('daps')
      ->join('projects', 'daps.projetiddap', '=', 'projects.id')
      ->join('exercice_projets','daps.exerciceids', 'exercice_projets.id')
      ->join('users', 'daps.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select(
        'daps.*',
        'projects.id AS projet_id',
        'projects.title AS projet_title',
        'projects.numeroprojet AS projet_numero',
        'personnels.nom AS user_nom',
        'personnels.prenom AS user_prenom',
        'projects.annee AS projet_annee',
        'daps.id as iddaps'
      )
      ->where(function ($query) {
        $query->where('daps.demandeetablie', Auth::id())->where('daps.demandeetablie_signe', 0)
          ->orWhere('daps.verifierpar', Auth::id())->where('daps.verifierpar_signe', 0)
          ->orWhere('daps.approuverpar', Auth::id())->where('daps.approuverpar_signe', 0)
          ->orWhere('daps.responsable', Auth::id())->where('daps.responsable_signe', 0)
          ->orWhere('daps.secretaire', Auth::id())->where('daps.secretaure_general_signe', 0)
          ->orWhere('daps.chefprogramme', Auth::id())->where('daps.chefprogramme_signe', 0);
      })
      ->where('exercice_projets.status', '=', 'Actif')
      ->orderBy('projects.title') // Ordonner par titre de projet
      ->orderBy('daps.numerodp')
      ->get();

    $output = '';
    $lastProjectTitle = null;
    $numooOrder = 1;

    // Si des notifications sont trouvées
    if ($dap_notifications->isNotEmpty()) {
      // Regrouper les éléments par projet
      $groupedByProject = $dap_notifications->groupBy('projet_title');

      foreach ($groupedByProject as $projectTitle => $daps) {
        // Afficher le titre du projet
        $output .= '<tr style="background-color:#addfad">
                              <td colspan="8"><b>' . ucfirst($projectTitle) . '</b></td>
                          </tr>';

        // Afficher les notifications pour chaque projet
        foreach ($daps as $dap) {
          // Calculer le montant total des DAP pour chaque ligne
          $totalDapAmount = $this->getTotalDap($dap->iddaps);
          $cryptedIDoc = Crypt::encrypt($dap->iddaps);

          // Détails de chaque notification
          $output .= '
          <tr>
              <td>' . $numooOrder . '</td>
              <td align="right"><a href="' . route('viewdap', $cryptedIDoc) . '"><b>' . $dap->numerodp . '/' . $dap->projet_annee . ' <i class="fas fa-external-link-alt"></i></b></a></td>
              <td align="right"><b>' . number_format($totalDapAmount, 0, ',', ' ') . '</b> </td>
              <td>' . (strtotime($dap->dateautorisation) !== false && $dap->dateautorisation != '' ? date('d-m-Y', strtotime($dap->dateautorisation)) : '-') . '</td>
              <td>' . (strtotime($dap->created_at) !== false && $dap->created_at != '' ? date('d-m-Y', strtotime($dap->created_at)) : '-') . '</td>
              <td>' . (strtotime($dap->updated_at) !== false && $dap->updated_at != '' ? date('d-m-Y', strtotime($dap->updated_at)) : '-') . '</td>
              <td>' . ucfirst($dap->user_nom) . ' ' . ucfirst($dap->user_prenom) . '</td>
          </tr>';
          $numooOrder++;
        }
      }
    } else {
      $output = '<tr>
                          <td colspan="9" style="background-color: rgba(255, 0, 0, 0.1);">
                              <center>
                                  <h6 style="color:red"><i class="fa fa-info-circle"></i> Aucun document trouvé</h6>
                              </center>
                          </td>
                      </tr>';
    }

    return $output;
  }

  public function notificationDja()
  {
    $dja_notify = DB::table('djas')
      ->join('projects', 'djas.projetiddja', '=', 'projects.id')
      ->join('exercice_projets','djas.exerciceids', 'exercice_projets.id')
      ->join('users', 'djas.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->join('daps', 'djas.dapid', '=', 'daps.id')
      ->select(
        'djas.*',
        'djas.id as iddjas',
        'djas.numerodjas as numero',
        'projects.id AS projet_id',
        'projects.title AS projet_title',
        'projects.numeroprojet AS projet_numero',
        'personnels.nom AS user_nom',
        'personnels.prenom AS user_prenom',
        'projects.annee AS projet_annee'
      )
      ->where(function ($query) {
        $query->where('djas.fonds_demande_par', Auth::id())->where('djas.signe_fonds_demande_par', 0)
          ->orWhere('djas.avance_approuver_par', Auth::id())->where('djas.signe_avance_approuver_par', 0)
          ->orWhere('djas.avance_approuver_par_deux', Auth::id())->where('djas.signe_avance_approuver_par_deux', 0)
          ->orWhere('djas.avance_approuver_par_trois', Auth::id())->where('djas.signe_avance_approuver_par_trois', 0)
          ->orWhere('djas.fond_debourser_par', Auth::id())->where('djas.signe_fond_debourser_par', 0)
          ->orWhere('djas.fond_recu_par', Auth::id())->where('djas.signe_fond_recu_par', 0)
          ->orWhere('djas.pfond_paye', Auth::id())->where('djas.signature_pfond_paye', 0)
          ->orWhere('djas.fonds_retournes_caisse_par', Auth::id())->where('djas.signe_reception_pieces_justificatives', 0);
      })
      ->where('exercice_projets.status', '=', 'Actif')
      ->orderBy('projects.title')  // Trier par le titre du projet
      ->orderBy('djas.numerodjas', 'asc')  // Puis trier par le numéro Dja
      ->get();

    $output = '';
    $lastProjectTitle = null;
    $numooOrder = 1;

    if ($dja_notify->isNotEmpty()) {
      foreach ($dja_notify as $djas) {
        // Afficher le titre du projet uniquement s'il est différent du précédent
        if ($lastProjectTitle !== $djas->projet_title) {
          $output .= '<tr style="background-color:#addfad">
                      <td colspan="8"><b>' . ucfirst($djas->projet_title) . '</b></td>
                  </tr>';
          $lastProjectTitle = $djas->projet_title;
        }

        // Calculer le montant total des Djas pour chaque ligne
        $totalDjaAmount = $djas->montant_avance_un;
        $cryptedIDoc = Crypt::encrypt($djas->iddjas);

        // Vérifier si la justification est présente
        $justifieStatus = $djas->justifie == 1 ? '<input type="checkbox" class="form-check-input"  checked disabled>' : '<input type="checkbox" disabled>';

        // Détails de chaque notification
        $output .= '
                  <tr>
                      <td>' . $numooOrder . '</td>
                      <td align="right"><a href="' . route('voirDja', $djas->iddjas) . '"><b>' . $djas->numero . '/' . $djas->projet_annee . ' <i class="fas fa-external-link-alt"></i></b></a></td>
                      <td align="right"><b>' . number_format($totalDjaAmount, 0, ',', ' ') . '</b> </td>
                      <td align="center"> ' . $justifieStatus . '</td>  <!-- Affichage de la case à cocher pour "justifie" -->
                      <td>' . $djas->duree_avance . ' Jours</td>
                      <td>' . date('d-m-Y', strtotime($djas->created_at)) . '</td>
                      <td>' . date('d-m-Y', strtotime($djas->updated_at)) . '</td>
                      <td>' . ucfirst($djas->user_nom) . ' ' . ucfirst($djas->user_prenom) . '</td>
                  </tr>';
        $numooOrder++;
      }
    } else {
      $output = '<tr>
              <td colspan="8" style="background-color: rgba(255, 0, 0, 0.1);">
                              <center>
                                  <h6 style="color:red"><i class="fa fa-info-circle"></i> Aucun document trouvé</h6>
                              </center>
                          </td>
          </tr>';
    }

    return $output;
  }

  public function notificationBpc()
  {
    $bpc_notification = DB::table('bonpetitcaisses')
      ->join('projects', 'bonpetitcaisses.projetid', '=', 'projects.id')
      ->join('exercice_projets','bonpetitcaisses.exercice_id', 'exercice_projets.id')
      ->join('users', 'bonpetitcaisses.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select(
        'bonpetitcaisses.*',
        'bonpetitcaisses.id as idbpc',
        'personnels.prenom as user_prenom',
        'projects.id AS projet_id',
        'projects.title AS projet_title',
        'projects.numeroprojet AS projet_numero',
        'personnels.nom AS user_nom',
        'personnels.prenom AS user_prenom',
        'projects.annee AS projet_annee'
      )
      ->where(function ($query) {
        $query->where('bonpetitcaisses.etabli_par', Auth::id())->where('bonpetitcaisses.etabli_par_signature', 0)
          ->orWhere('bonpetitcaisses.verifie_par', Auth::id())->where('bonpetitcaisses.verifie_par_signature', 0)
          ->orWhere('bonpetitcaisses.approuve_par', Auth::id())->where('bonpetitcaisses.approuve_par_signature', 0);
      })
      ->where('exercice_projets.status', '=', 'Actif')
      ->orderBy('projects.title') // Trier par projet pour regrouper les éléments similaires
      ->orderBy('numero') // Trier les notifications dans un projet par numéro
      ->get();

    $output = '';
    $lastProjectTitle = null;

    if ($bpc_notification->isNotEmpty()) {
      foreach ($bpc_notification as $feb) {
        // Afficher le titre du projet uniquement si différent du précédent
        if ($lastProjectTitle !== $feb->projet_title) {
          $output .= '<tr style="background-color:#addfad">
                                  <td colspan="8"><b>' . ucfirst($feb->projet_title) . '</b></td>
                              </tr>';
          $lastProjectTitle = $feb->projet_title;
        }

        // Détails de chaque notification

        $cryptedIDoc = Crypt::encrypt($feb->idbpc);
        $num = 1;
        $output .= '
                          <tr>
                              <td>' . $num . '</td>
                           
                              <td align="right"><a href="' . route('viewbpc', $cryptedIDoc) . '"><b>' . $feb->numero . '/' . $feb->projet_annee . ' <i class="fas fa-external-link-alt"></i></b></a></td>
                              <td align="right"><b>' . number_format($feb->total_montant, 0, ',', ' ') . '</b></td>
                              <td>' . date('d-m-Y', strtotime($feb->date)) . '</td>
                              <td>' . ucfirst($feb->titre) . '</td>
                                <td>' . date('d-m-Y', strtotime($feb->updated_at)) . '</td>
                              <td>' . ucfirst($feb->user_nom) . ' ' . ucfirst($feb->user_prenom) . '</td>
                          </tr>';
        $num++;
      }
    } else {
      $output = '<tr>
                          <td colspan="8" style="background-color: rgba(255, 0, 0, 0.1);">
                              <center>
                                  <h6 style="color:red"><i class="fa fa-info-circle"></i> Aucun document trouvé</h6>
                              </center>
                          </td>
                      </tr>';
    }

    return $output;
  }

  public function notificationfac()
  {
    $feb_notification = DB::table('febpetitcaisses')
      ->join('projects', 'febpetitcaisses.projet_id', '=', 'projects.id')
      ->join('exercice_projets','febpetitcaisses.exercice_id', 'exercice_projets.id')
      ->join('comptes', 'febpetitcaisses.compte_id', '=', 'comptes.id')
      ->join('users', 'febpetitcaisses.user_id', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select(
        'febpetitcaisses.*',
        'febpetitcaisses.id as idfac',
        'personnels.prenom as user_prenom',
        'comptes.numero as code',
        'projects.id AS projet_id',
        'projects.title AS projet_title',
        'projects.numeroprojet AS projet_numero',
        'personnels.nom AS user_nom',
        'personnels.prenom AS user_prenom',
        'projects.annee AS projet_annee'
      )
      ->where(function ($query) {
        $query->where('febpetitcaisses.verifie_par', Auth::id())->where('febpetitcaisses.etabli_par_signature', 0)
          ->orWhere('febpetitcaisses.etabli_par', Auth::id())->where('febpetitcaisses.verifie_par_signature', 0)
          ->orWhere('febpetitcaisses.approuve_par', Auth::id())->where('febpetitcaisses.approuve_par_signature', 0);
      })
      ->where('exercice_projets.status', '=', 'Actif')
      ->orderBy('projects.title') // Ordonner par titre de projet
      ->orderBy('febpetitcaisses.numero')
      ->get();

    $output = '';
    $lastProjectTitle = null;
    $numooOrder = 1;

    // Si des notifications sont trouvées
    if ($feb_notification->isNotEmpty()) {
      // Regrouper les éléments par projet
      $groupedByProject = $feb_notification->groupBy('projet_title');

      foreach ($groupedByProject as $projectTitle => $febs) {
        // Afficher le titre du projet
        $output .= '<tr style="background-color:#addfad">
                            <td colspan="8"><b>' . ucfirst($projectTitle) . '</b></td>
                        </tr>';

        // Afficher les notifications pour chaque projet
        foreach ($febs as $feb) {
          // Calculer le montant total des DAP pour chaque ligne


          $cryptedIDoc = Crypt::encrypt($feb->idfac);

          // Détails de chaque notification
          $output .= '
                                <tr>
                                    <td>' . $numooOrder . '</td>
                                    <td align="right"><a href="' . route('viewfebpc', $cryptedIDoc) . '"><b>' . $feb->numero . '/' . $feb->projet_annee . ' <i class="fas fa-external-link-alt"></i></b></a></td>
                                    <td align="right"><b>' . number_format($feb->montant, 0, ',', ' ') . '</b> </td>
                                    <td>' . date('d-m-Y', strtotime($feb->date_dossier)) . '</td>
                                    <td>' . date('d-m-Y', strtotime($feb->date_limite)) . '</td>
                                    <td>' . date('d-m-Y', strtotime($feb->created_at)) . '</td>
                                    <td>' . ucfirst($feb->user_nom) . ' ' . ucfirst($feb->user_prenom) . '</td>
                                </tr>';
          $numooOrder++;
        }
      }
    } else {
      $output = '<tr>
                       <td colspan="9" style="background-color: rgba(255, 0, 0, 0.1);">
                              <center>
                                  <h6 style="color:red"><i class="fa fa-info-circle"></i> Aucun document trouvé</h6>
                              </center>
                          </td>
                    </tr>';
    }

    return $output;
  }

  public function notificationdac()
  {
    $dap_notifications = DB::table('dapbpcs')
      ->join('projects', 'dapbpcs.projetid', '=', 'projects.id')
      ->join('exercice_projets','dapbpcs.exercice_id', 'exercice_projets.id')
      ->join('users', 'dapbpcs.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select(
        'dapbpcs.*',
        'projects.id AS projet_id',
        'projects.title AS projet_title',
        'projects.numeroprojet AS projet_numero',
        'personnels.nom AS user_nom',
        'personnels.prenom AS user_prenom',
        'projects.annee AS projet_annee',
        'dapbpcs.id as idddaps'
      )
      ->where(function ($query) {
        $query->where('dapbpcs.demande_etablie', Auth::id())->where('dapbpcs.demande_etablie_signe', 0)
          ->orWhere('dapbpcs.verifier', Auth::id())->where('dapbpcs.verifier_signe', 0)
          ->orWhere('dapbpcs.approuver', Auth::id())->where('dapbpcs.approuver_signe', 0)
          ->orWhere('dapbpcs.autoriser', Auth::id())->where('dapbpcs.autoriser_signe', 0)
          ->orWhere('dapbpcs.secretaire', Auth::id())->where('dapbpcs.chefprogramme_signe', 0)
          ->orWhere('dapbpcs.chefprogramme', Auth::id())->where('dapbpcs.secretaire_signe', 0);
      })
      ->where('exercice_projets.status', '=', 'Actif')
      ->orderBy('projects.title') // Ordonner par titre de projet
      ->orderBy('dapbpcs.numerodap')
      ->get();

    $output = '';
    $lastProjectTitle = null;
    $numooOrder = 1;

    // Si des notifications sont trouvées
    if ($dap_notifications->isNotEmpty()) {
      // Regrouper les éléments par projet
      $groupedByProject = $dap_notifications->groupBy('projet_title');

      foreach ($groupedByProject as $projectTitle => $daps) {
        // Afficher le titre du projet
        $output .= '<tr style="background-color:#addfad">
                              <td colspan="8"><b>' . ucfirst($projectTitle) . '</b></td>
                          </tr>';

        // Afficher les notifications pour chaque projet
        foreach ($daps as $dap) {
          // Calculer le montant total des DAP pour chaque ligne

          $cryptedIDoc = Crypt::encrypt($dap->idddaps);

          // Détails de chaque notification
          $output .= '
                                  <tr>
                                      <td>' . $numooOrder . '</td>
                                      <td align="right"><a href="' . route('viewdappc', $cryptedIDoc) . '"><b>' . $dap->numerodap . '/' . $dap->projet_annee . ' <i class="fas fa-external-link-alt"></i></b></a></td>
                                    
                                      <td>' . date('d-m-Y', strtotime($dap->demande_etablie)) . '</td>
                                      <td>' . date('d-m-Y', strtotime($dap->created_at)) . '</td>
                                      <td>' . date('d-m-Y', strtotime($dap->updated_at)) . '</td>
                                      <td>' . ucfirst($dap->user_nom) . ' ' . ucfirst($dap->user_prenom) . '</td>
                                  </tr>';
          $numooOrder++;
        }
      }
    } else {
      $output = '<tr>
                          <td colspan="9" style="background-color: rgba(255, 0, 0, 0.1);">
                              <center>
                                  <h6 style="color:red"><i class="fa fa-info-circle"></i> Aucun document trouvé</h6>
                              </center>
                          </td>
                      </tr>';
    }

    return $output;
  }

  public function notificationrac()
  {
    $rac_notifications = DB::table('rappotages')
      ->join('projects', 'rappotages.projetid', '=', 'projects.id')
      ->join('exercice_projets','rappotages.exercice_id', 'exercice_projets.id')
      ->join('users', 'rappotages.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select(
        'rappotages.*',
        'projects.id AS projet_id',
        'projects.title AS projet_title',
        'projects.numeroprojet AS projet_numero',
        'personnels.nom AS user_nom',
        'personnels.prenom AS user_prenom',
        'projects.annee AS projet_annee',
        'rappotages.id as idrac'
      )
      ->where(function ($query) {
        $query->where('rappotages.verifier_par', Auth::id())->where('rappotages.verifier_signature', 0)
          ->orWhere('rappotages.approver_par', Auth::id())->where('rappotages.approver_signature', 0);
      })
      ->where('exercice_projets.status', '=', 'Actif')
      ->orderBy('projects.title') // Ordonner par titre de projet
      ->orderBy('rappotages.numero_groupe')
      ->get();

    $output = '';
    $lastProjectTitle = null;
    $numooOrder = 1;

    // Si des notifications sont trouvées
    if ($rac_notifications->isNotEmpty()) {
      // Regrouper les éléments par projet
      $groupedByProject = $rac_notifications->groupBy('projet_title');

      foreach ($groupedByProject as $projectTitle => $racs) {
        // Afficher le titre du projet
        $output .= '<tr style="background-color:#addfad">
                              <td colspan="8"><b>' . ucfirst($projectTitle) . '</b></td>
                          </tr>';

        // Afficher les notifications pour chaque projet
        foreach ($racs as $rac) {
          // Calculer le montant total des DAP pour chaque ligne

          $cryptedIDoc = Crypt::encrypt($rac->idrac);

          // Détails de chaque notification
          $output .= '
          <tr>
              <td>'.$numooOrder.'</td>
              <td align="right"><a href="'.route('Rapport.cloture.caisse').'"><b>'.$rac->numero_groupe.' <i class="fas fa-external-link-alt"></i></b></a></td>
              <td align="right">' . $rac->dernier_solde. '</td>
              <td>' . (isset($rac->created_at) ? date('d-m-Y', strtotime($rac->created_at)) : '') . '</td>
              <td>' . (isset($rac->updated_at) ? date('d-m-Y', strtotime($rac->updated_at)) : '') . '</td>
              <td>' . ucfirst($rac->user_nom) . ' ' . ucfirst($rac->user_prenom) . '</td>
          </tr>';
          
          $numooOrder++;
        }
      }
    } else {
      $output = '<tr>
                          <td colspan="9" style="background-color: rgba(255, 0, 0, 0.1);">
                              <center>
                                  <h6 style="color:red"> <i class="fa fa-info-circle"></i> Aucun document trouvé</h6>
                              </center>
                          </td>
                      </tr>';
    }

    return $output;
  }

  private function getTotalDap($dapId)
  {
    $febIds = DB::table('elementdaps')
      ->where('dapid', $dapId)
      ->pluck('referencefeb');

    return DB::table('elementfebs')
      ->whereIn('febid', $febIds)
      ->sum('montant');
  }

  public function Sommefeb()
  {
    $devise = session()->get('devise');
    $budget = session()->get('budget');
    $ID = session()->get('id');
    $exerciceId = session()->get('exercice_id');


    $data = DB::table('elementfebs')

      ->join('febs', 'elementfebs.febid', 'febs.id')
      ->where('febs.acce_signe', 1)
      ->where('febs.comptable_signe', 1)
      ->where('febs.chef_signe', 1)
      ->Where('projetids', $ID)
      ->where('elementfebs.exerciceids', $exerciceId)
      ->SUM('montant');

    $output = '';

    $pourcentage = round(($data * 100) / $budget, 2);
    $sommefeb = number_format($data, 0, ',', ' ');

    $output .= '
          <td> &nbsp; Montant global de l\'expression des besoins</td>
          <td class="align-right" > ' . $sommefeb . ' ' . $devise . ' </td>
          <td > ' . $pourcentage . '%</td> 
          <td> &nbsp;</td>
      ';
    echo $output;
  }

 

  public function Updatestore(Request $request)
  {
    DB::beginTransaction();

    try {
      $activity = Feb::find($request->febid);
      $IDf = $request->febid;

      $get_lead = DB::table('febs')
        ->join('projects', 'febs.projetid', '=', 'projects.id')
        ->select('projects.lead as lead')
        ->where('febs.id', $request->febid)
        ->first();




      $lead = (int) session()->get('lead');
      $projet_lead = (int) $get_lead->lead;

      $UserIdFeb = (int) $activity->userid;

      if ($UserIdFeb !== Auth::id() || $projet_lead !== $lead) {

        return redirect()->back()->with('failed', 'Vous n\'avez pas l\'autorisation nécessaire pour Modifier le FEB. Veuillez contacter le créateur pour procéder à la suppression.');
      }


      $comp = $request->ligneid;
      $compp = explode("-", $comp);

      $grandcompte = $compp[0];
      $souscompte = $compp[1];


      $IDP = session()->get('id');
      $activityTwo = Elementdap::where('referencefeb', $request->febid)->get();
      // Vérifier si des éléments existent
      if ($activityTwo->isNotEmpty()) {
        // Mettre à jour les éléments FEB existants
        foreach ($activityTwo as $element) {
          $element->update([
            'ligneided' => $souscompte,
          ]);
        }
      }

      $activityTree = Elementdjas::where('febid', $request->febid)->get();
      // Vérifier si des éléments existent
      if ($activityTree->isNotEmpty()) {
        // Mettre à jour les éléments FEB existants
        foreach ($activityTree as $elementTree) {
          $elementTree->update([
            'ligneid' => $souscompte,
          ]);
        }
      }


      if ($request->acce == $request->ancien_acce) {
        $acce_signe = $request->acce_signe;
      } else {
        $acce_signe = 0;
      }


      if ($request->comptable == $request->ancien_comptable) {
        $comptable_signe = $request->comptable_signe;
      } else {
        $comptable_signe = 0;
      }


      if ($request->chefcomposante == $request->ancien_chefcomposante) {
        $chef_signe = $request->chef_signe;
      } else {
        $chef_signe = 0;
      }



      $sum = 0;
      foreach ($request->numerodetail as $key => $items) {
        $element1 = $request->pu[$key];
        $element2 = $request->qty[$key];
        $element3 = $request->frenquency[$key];
        $somme = $element1 * $element2 * $element3;
        $sum += $somme;
      }


      /* if ($sum != $activity->total) {
  $acce_signe = 1;
  $comptable_signe = 1;
  $chef_signe = 1;
  }
  */

      $activity->numerofeb = $request->numerofeb;
      $activity->periode = $request->periode;
      $activity->datefeb = $request->datefeb;
      $activity->datelimite = $request->datelimite;

      $activity->total = $sum;

      $activity->comptable = $request->comptable;
      $activity->acce = $request->acce;
      $activity->chefcomposante = $request->chefcomposante;
      $activity->descriptionf = $request->descriptionf;

      $activity->sous_ligne_bugdetaire = $souscompte;
      $activity->ligne_bugdetaire = $grandcompte;

      if ($request->beneficiaire !== 'autres') {
        $activity->beneficiaire = $request->beneficiaire;
        $activity->autresBeneficiaire = '';
      } else {
        $activity->autresBeneficiaire = $request->autresBeneficiaire;
        $activity->beneficiaire = NULL;
      }


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
              'libellee' => $request->libelleid[$key],
              'tperiode' => $request->periode,
              'numero' => $request->numerofeb,
              'grandligne' => $grandcompte,
              'eligne' => $souscompte
            ];
          }
        } else {
          $newfeb = new Elementfeb();
          $newfeb->febid = $request->febid;
          $newfeb->projetids = $request->projetid;
          $newfeb->tperiode = $request->periode;
          $newfeb->grandligne = $grandcompte;
          $newfeb->eligne = $souscompte;
          $newfeb->numero = $request->numerofeb;

          $newfeb->libelle_description = $request->libelle_description[$key];
          $newfeb->unite = $request->unit_cost[$key];
          $newfeb->quantite = $request->qty[$key];
          $newfeb->frequence = $request->frenquency[$key];
          $newfeb->pu = $request->pu[$key];
          $newfeb->montant = $request->amount[$key];
          $newfeb->libellee = $request->libelleid[$key];
          $newfeb->userid = Auth::id();
          $newfeb->save();
        }
      }

      if ($request->has('annex')) {
        $selectedAnnexes = $request->annex; // Les annexes sélectionnées
        $existingAnnexes = attache_feb::where('febid', $IDf)->pluck('annexid')->toArray(); // Annexes déjà dans la base de données

        // Supprimer les annexes qui ne sont plus sélectionnées
        $toDelete = array_diff($existingAnnexes, $selectedAnnexes);
        attache_feb::where('febid', $IDf)->whereIn('annexid', $toDelete)->delete();

        // Créer ou mettre à jour les annexes sélectionnées
        foreach ($selectedAnnexes as $annexid) {
          attache_feb::updateOrCreate(
            [
              'febid' => $IDf,
              'annexid' => $annexid,
            ],
            [
              'febid' => $IDf,
              'annexid' => $annexid,
            ]
          );
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

    $exerciceId = session()->get('exercice_id');
    $ID = session()->get('id');

    $comp = str_replace(' ', '', $request->id);
    $compp = explode("-", $comp);

    $grandcompte = $compp[0];
    $souscompte  = $compp[1];

    $activiteligne = Activity::where('compteidr', $souscompte)
    ->where('activities.execiceid', $exerciceId)
    ->where('projectid', $ID)
    ->get();

    // dd($souscompte);
    if ($activiteligne->count() > 0) {

      $output .= '
        <select type="text" class="form-control form-control-sm"   name="description[]" id="description" required>
        <option disabled="true" selected="true" value="">--Aucun--</option>';
      foreach ($activiteligne as $datas) {
        $output .= ' <option value="' . $datas->id . '">' . $datas->titre . '</option>';
      }
      $output .= '</select>';
    } else {
      $output .= '<font color="red"><i class="fa fa-times-circle"></i> Aucune  activités trouver sur cette ligne budgétaire  </font> ';
    }

    echo $output;
  }

  public function findfebelement(Request $request)
  {
    $IDs = $request->ids; // Utilisez 'ids' pour obtenir tous les identifiants sélectionnés
    $devise = session()->get('devise');
    $budget = session()->get('budget');
    $IDP = session()->get('id');
    $exerciceId = session()->get('exercice_id');
    

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
            ->where('exerciceids', $exerciceId)
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
          <tr style=" background: rgba(76, 175, 80, 0.3); color:black">
          <td > Montant total global</td> 
          <td colspan="2" align="right">  ' . number_format($totoglobale, 0, ',', ' ')  . '</td>
          <td align="center">' . $pourcentage_total . ' %</td>
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

    $personnel = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
      ->orderBy('nom', 'ASC')
      ->get();

    // Initialisez une variable pour stocker les sorties de tableau
    $output = '';
    /*  $output .= '
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

          $ligneinfo = Compte::where('id', $datas->ligne_bugdetaire)->first();

          $pourcentage = round(($sommefeb * 100) / $budget, 2);

          // Ajouter le pourcentage de cette itération au pourcentage total
          $pourcentage_total += $pourcentage;

          // Construire la sortie HTML pour chaque élément sélectionné
         /// $output .= '<input type="hidden" name="febid[]" value="' . $datas->id . '" />';
         // $output .= '<input type="hidden" name="ligneid[]" value="' . $datas->sous_ligne_bugdetaire . '" />';
         // $output .= '<tr>';
          $output .= '<td width="10%"> Numéro FEB : ' . $datas->numerofeb . '</td>';
          $output .= '<td width="20%"> Montant de l\'Avance <input type="number" min="0" name="montantavance[]" style="width: 100%; border:1px solid #c0c0c0" /></td>';
          $output .= '<td width="20%"> Durée avance <input type="number"  min="0" name="duree_avance[]" style="width: 100%; border:1px solid #c0c0c0" /></td>';
          $output .= '<td colspan="3">Description <input type="text" name="descriptionel[]" style="width: 100%; border:1px solid #c0c0c0" /> </td>';

          $output .= '</tr>';
        }
      }
    }
    $output .= '</table>'; */

    $output .= '
    <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
        
        <tr>
        <td width="20%"> Montant de l\'Avance <input  class="form-control form-control-sm" type="number" min="0" value="0" name="montantavance" style="width: 100%; border:1px solid #c0c0c0" /></td>
        <td width="20%"> Durée avance <input  class="form-control form-control-sm" type="number"  min="0" value="0" name="duree_avance" style="width: 100%; border:1px solid #c0c0c0" /></td>
        <td colspan="3">Description <input class="form-control form-control-sm" type="text" name="descriptionel" style="width: 100%; border:1px solid #c0c0c0" /> </td>
            <td> Fonds reçus par
                <select class="form-control form-control-sm" name="beneficiaire" id="beneficiaire">
                    <option disabled="true" selected="true" >-- Fonds reçus par --</option>';
    foreach ($personnel as $personnel) {
      $output .= '<option value="' . $personnel->userid . '">' . $personnel->nom . ' ' . $personnel->prenom . '</option>';
    }
    $output .= '
                <option selected  value="autres" >--Autres --</option>
                </select>
            </td>
              <td width="20%" id="nomPrenomContainer" style="display: non;"> 
               Autres  Nom & Prénom  de Fonds reçus <br>
                  <input type="text" name="autresBeneficiaire" id="nomPrenomBeneficiaire"class="form-control form-control-sm" style="width: 100%;">
                  <small> Dans le mesure ou la personne n\'est pas sur la liste </small>
                                    
              
              </td>
        </tr>
    </table>';

    return $output;
  }

  public function list()
  {
    // Récupérer l'ID de la session
    $projectId = session()->get('id');
    $exerciceId = session()->get('exercice_id');
    // Vérifie si l'ID de projet existe dans la session
    if (!$projectId && !$exerciceId) {
      // Gérer le cas où l'ID du projet et exercice est invalide
      return redirect()->back()->with('error', "La session du projet et de l'exercice est terminée. Vous allez être redirigé...");
    }

    // Si l'ID de la session est défini, continuer avec le reste de la fonction
    $title = "Liste des FEB";

    return view(
      'document.feb.list',
      [
        'title' => $title,

      ]
    );
  }

  public function show($key)
  {
    $title = 'FEB';
    $key = Crypt::decrypt($key);
    $check = Feb::findOrFail($key);

    

    $idl = $check->sous_ligne_bugdetaire;
    $id_gl = $check->ligne_bugdetaire;
    $idfeb = $check->id;
    $numero_classe_feb = $check->numerofeb;

    $datElement = Elementfeb::where('febid', $idfeb)->get();

    $IDB = $check->projetid;
    $exerciceId = $check->execiceid;

    $chec = DB::table('projects')
    ->join('exercice_projets', 'projects.id', '=', 'exercice_projets.project_id')
    ->where('projects.id', $IDB)
    ->where('exercice_projets.id', $exerciceId)
    ->select(
        'projects.*',
        'exercice_projets.budget as budgets',
    )
    ->first();
    $budget = $chec->budgets;

    $somme_ligne_principale = DB::table('rallongebudgets')
      ->where('compteid', $id_gl)
      ->where('projetid', $IDB)
      ->where('execiceid', $exerciceId)
      ->sum('budgetactuel');

    $onebeneficaire = Beneficaire::find($check->beneficiaire);

    $sommeallfeb = DB::table('elementfebs')

      ->where('numero', '<=', $numero_classe_feb)

      ->join('febs', 'elementfebs.febid', 'febs.id')
      ->where('febs.acce_signe', 1)
      ->where('febs.comptable_signe', 1)
      ->where('febs.chef_signe', 1)

      ->where('projetids', $IDB)
      ->where('elementfebs.exerciceids', $exerciceId)
      ->sum('montant');

    // recuperation la somme de
    $SOMME_PETITE_CAISSE = DB::table('elementboncaisses')
      ->join('bonpetitcaisses', 'elementboncaisses.boncaisse_id', 'bonpetitcaisses.id')
      ->where('elementboncaisses.projetid', $IDB)
      ->where('elementboncaisses.exerciceid', $exerciceId)
      ->where('bonpetitcaisses.approuve_par_signature', 1)
      ->sum('elementboncaisses.montant');


    $dataLigne = Compte::find($idl);

    $sommelign = DB::table('elementfebs')

      ->join('febs', 'elementfebs.febid', 'febs.id')
      ->where('febs.acce_signe', 1)
      ->where('febs.comptable_signe', 1)
      ->where('febs.chef_signe', 1)

      ->where('grandligne', $id_gl)
      ->where('numero', '<=', $numero_classe_feb)
      ->where('projetids', $IDB)
      ->where('elementfebs.exerciceids', $exerciceId)
      ->sum('montant');

    $sommelignpourcentage = $somme_ligne_principale ? round(($sommelign * 100) / $somme_ligne_principale, 2) : 0;

    $sommefeb = DB::table('elementfebs')
      ->where('febid', $idfeb)
      ->where('projetids', $IDB)
      ->where('elementfebs.exerciceids', $exerciceId)
      ->sum('montant');

    $SOMMES_DEJA_UTILISE = $sommeallfeb + $SOMME_PETITE_CAISSE;

    $POURCENTAGE_GLOGALE = $budget ? round(($SOMMES_DEJA_UTILISE * 100) / $budget, 2) : 0;

    $createur = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'users.id as useridp')
      ->where('users.id', $check->userid)
      ->first();

    $etablienom = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as userid')
      ->where('users.id', $check->acce)
      ->first();

    $comptable_nom = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
      ->where('users.id', $check->comptable)
      ->first();

    $checcomposant_nom = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
      ->where('users.id', $check->chefcomposante)
      ->first();

    $dateinfo = Identification::all();

    // Fetch attached documents
    $getDocument = attache_feb::join('apreviations', 'attache_febs.annexid', 'apreviations.id')
      ->select('apreviations.id', 'apreviations.abreviation', 'apreviations.libelle', 'attache_febs.urldoc')
      ->where('attache_febs.febid', $idfeb)
      ->get();

    $attachedDocIds = $getDocument->pluck('id')->toArray(); // Récupérer les IDs des documents attachés 



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
      'getDocument' => $getDocument,
      'attachedDocIds' => $attachedDocIds

    ]);
  }

  public function showannex($key)
  {

    $title = 'FEB';
    $key = Crypt::decrypt($key);
    $check = Feb::findOrFail($key);

    $getDocument = attache_feb::join('apreviations', 'attache_febs.annexid', 'apreviations.id')
      ->select('apreviations.abreviation', 'apreviations.libelle', 'attache_febs.id', 'attache_febs.urldoc')
      ->where('attache_febs.febid', $check->id)
      ->get();

    return view('document.feb.addanex', [
      'title' => $title,
      'getDocument' => $getDocument,
      'dataFeb' => $check

    ]);
  }

  public function showonefeb($idf)
  {
    $title = 'FEB';

  
    $budget = session()->get('budget');
 
    $idf = Crypt::decrypt($idf);

    $dataJosonfeb = DB::table('febs')
      ->leftJoin('comptes', 'febs.sous_ligne_bugdetaire', '=', 'comptes.id')
      ->select('febs.*', 'febs.id as idfb', 'comptes.id as idc', 'comptes.numero as numeroc', 'comptes.libelle as libellec')
      ->where('febs.id', $idf)
      ->first();

      $IDB = $dataJosonfeb->projetid;
      $exerciceId = $dataJosonfeb->execiceid;

    if (!$dataJosonfeb) {
      return redirect()->route('dashboard')->with('error', 'Pas de FEB disponible');
    }

    $idl = $dataJosonfeb->sous_ligne_bugdetaire;
    $idfeb = $dataJosonfeb->id;


    $compte = DB::table('comptes')
      ->where('comptes.projetid', $IDB)
      ->where('compteid', '=', 0)
      ->get();

    $personnel = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
      ->where('fonction', '!=', 'Chauffeur')
      ->orderBy('nom', 'ASC')
      ->get();

    $dataLigne = Compte::where('id', $idl)->first();

    // Calcul des sommes et pourcentages
    $sommelign = DB::table('elementfebs')
      ->where('eligne', $idl)
      ->where('projetids', $IDB)
      ->where('elementfebs.exerciceids', $exerciceId)
      ->sum('montant');
    $sommelignpourcentage = $budget ? round(($sommelign * 100) / $budget) : 0;

    $sommefeb = DB::table('elementfebs')
      ->where('febid', $idfeb)
      ->where('projetids', $IDB)
      ->where('elementfebs.exerciceids', $exerciceId)
      ->sum('montant');

    $datafebs = DB::table('elementfebs')
      ->orderBy('id', 'DESC')
      ->where('projetids', $IDB)
      ->where('elementfebs.exerciceids', $exerciceId)
      ->sum('montant');


    $SOMME_PETITE_CAISSE = DB::table('elementboncaisses')
      ->join('bonpetitcaisses', 'elementboncaisses.boncaisse_id', 'bonpetitcaisses.id')
      ->where('elementboncaisses.projetid', $IDB)
      ->where('elementboncaisses.exerciceid', $exerciceId)
      ->where('bonpetitcaisses.approuve_par_signature', 1)
      ->sum('elementboncaisses.montant');

    $SOMMES_DEJA_UTILISE = $datafebs + $SOMME_PETITE_CAISSE;



    $POURCENTAGE_GLOGALE = $budget ? round(($SOMMES_DEJA_UTILISE * 100) / $budget) : 0;

    // Récupération des noms des responsables
    $etablienom = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
      ->where('users.id', $dataJosonfeb->acce)
      ->first();

    $comptable_nom = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'personnels.id', 'users.id as userid')
      ->where('users.id', $dataJosonfeb->comptable)
      ->first();

    $checcomposant_nom = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
      ->where('users.id', $dataJosonfeb->chefcomposante)
      ->first();

    // Récupération des éléments du FEB
    $datElement = DB::table('elementfebs')
      ->leftJoin('activities', 'elementfebs.libellee', '=', 'activities.id')
      ->leftJoin('comptes', 'elementfebs.eligne', '=', 'comptes.id')
      ->select('elementfebs.*', 'elementfebs.id as idef', 'activities.id as ida', 'activities.titre as titrea', 'comptes.libelle as lignetitre')
      ->where('febid', $idfeb)
      ->get();

    $datElementgene = DB::table('elementfebs')
      ->leftJoin('activities', 'elementfebs.libellee', '=', 'activities.id')
      ->select('elementfebs.*', 'elementfebs.id as idef', 'activities.id as ida', 'activities.titre as titrea')
      ->where('febid', $idfeb)
      ->first();

    $activiteligne = $datElementgene ? Activity::where('compteidr', $dataJosonfeb->sous_ligne_bugdetaire)->get() : collect();

    $all_activitis = Activity::where('compteidr', $dataJosonfeb->sous_ligne_bugdetaire)->get();

    $beneficaire = Beneficaire::orderBy('libelle')->get();

    $onebeneficaire = Beneficaire::where('id', $dataJosonfeb->beneficiaire)->first();
    $attache = Apreviation::all();

    $getDocument = attache_feb::join('apreviations', 'attache_febs.annexid', 'apreviations.id')
      ->select('apreviations.id', 'apreviations.abreviation', 'apreviations.libelle', 'attache_febs.urldoc')
      ->where('attache_febs.febid', $idfeb)
      ->get();

    $attachedDocIds = $getDocument->pluck('id')->toArray(); // Récupérer les IDs des documents attachés 


    return view('document.feb.edit', [
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
      'all_activitis' => $all_activitis,
      'attache'  => $attache,
      'attachedDocIds' => $attachedDocIds
    ]);
  }

  public function update(Request $request)
  {
    try {
      if (!empty($request->accesignature) || !empty($request->comptablesignature) || !empty($request->chefsignature)) {
        $emp = Feb::find($request->febid);

        $accesignature = !empty($request->accesignature) ? 1 : $request->clone_accesignature;
        $comptablesignature = !empty($request->comptablesignature) ? 1 : $request->clone_comptablesignature;
        $chefsignature = !empty($request->chefsignature) ? 1 : $request->clone_chefsignature;

        $emp->acce_signe = $accesignature;
        $emp->comptable_signe = $comptablesignature;
        $emp->chef_signe = $chefsignature;

        $emp->update();

        return back()->with('success', 'Très bien! La signature a bien été enregistrée');
      } else {
        return back()->with('failed', 'Vous devez cocher au moins une case pour enregistrer la signature.');
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
    $idl = $check->sous_ligne_bugdetaire;
    $id_gl = $check->ligne_bugdetaire;
    $idfeb = $check->id;
    $numero_classe_feb =  $check->numerofeb;

    $datElement = Elementfeb::where('febid', $idfeb)->get();
   
    $IDB = $check->projetid;
    $exerciceId = $check->execiceid;

    $chec = DB::table('projects')
    ->join('exercice_projets', 'projects.id', '=', 'exercice_projets.project_id')
    ->where('projects.id', $IDB)
    ->where('exercice_projets.id', $exerciceId)
    ->select(
        'projects.*',
        'exercice_projets.budget as budgets',
    )
    ->first();
    $budget = $chec->budgets;

    $somme_ligne_principale = DB::table('rallongebudgets')
      ->where('compteid', $id_gl)
      ->where('rallongebudgets.projetid', $IDB)
      ->where('rallongebudgets.execiceid', $exerciceId)
      ->sum('budgetactuel');


    $sommeallfeb = DB::table('elementfebs')
      ->where('numero', '<=', $numero_classe_feb)
      ->where('projetids', $IDB)
      ->where('exerciceids', $exerciceId)
      ->sum('montant');

    $SOMME_PETITE_CAISSE = DB::table('elementboncaisses')
      ->join('bonpetitcaisses', 'elementboncaisses.boncaisse_id', 'bonpetitcaisses.id')
      ->where('elementboncaisses.projetid', $IDB)
      ->where('elementboncaisses.exerciceid', $exerciceId)
      ->where('bonpetitcaisses.approuve_par_signature', 1)
      ->sum('elementboncaisses.montant');

    $SOMMES_DEJA_UTILISE = $sommeallfeb + $SOMME_PETITE_CAISSE;

    $POURCENTAGE_GLOGALE = $budget ? round(($SOMMES_DEJA_UTILISE * 100) / $budget, 2) : 0;


    $sommelign = DB::table('elementfebs')
      ->where('grandligne', $id_gl)
      ->where('numero', '<=', $numero_classe_feb)
      ->where('projetids', $IDB)
      ->where('elementfebs.exerciceids', $exerciceId)
      ->sum('montant');

    $sommelignpourcentage = $somme_ligne_principale ? round(($sommelign * 100) / $somme_ligne_principale, 2) : 0;


    $sommefeb = DB::table('elementfebs')
      ->where('febid', $idfeb)
      ->sum('montant');

    // Instancie Dompdf
    $dompdf = new Dompdf();
    $infoglo = DB::table('identifications')->first();

    $datafeb = DB::table('febs')
      ->join('comptes', 'febs.sous_ligne_bugdetaire', 'comptes.id')
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


    // Calcul du taux d'exécution du projet
    $sommerepartie = DB::table('rallongebudgets')
      ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
      ->where('rallongebudgets.projetid', $IDB)
      ->where('rallongebudgets.execiceid', $exerciceId)
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
    $fileName = 'FEB_NUMERO_' . $datafeb->numerofeb . '.pdf';

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
      ->where('eligne', $idl)
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
      DB::transaction(function () use ($request) {
        // Récupère l'id FEB depuis la requête
        $idFeb = $request->id;

        // Vérifie que l'id FEB est valide
        if (!$idFeb) {

          return response()->json(
            [
              'status' => 400,
              'message' => 'ID FEB manquant dans la requête'
            ],
            400
          );
        }

        // Récupère le FEB correspondant
        $feb = Feb::find($idFeb);

        // Vérifie si le FEB existe et appartient à l'utilisateur connecté
        $UserIdFeb = (int) $feb->userid;

        if ($feb && $UserIdFeb == Auth::id()) {

          // Suppressions logiques ici...

          // Récupération des éléments DAP associés
          $elementDap = Elementdap::where('referencefeb', '=', $idFeb)->get();

          // Suppression des éléments DAP et des données associées
          if ($elementDap->isNotEmpty()) {
            foreach ($elementDap as $dapElement) {
              // Supprime le DJA associé au DAP si existant
              Dja::where('dapid', '=', $dapElement->dapid)->delete();

              // Supprime le DAP lui-même si existant
              Dap::where('id', '=', $dapElement->dapid)->delete();
            }

            // Supprime les éléments DAP eux-mêmes
            Elementdap::where('referencefeb', '=', $idFeb)->delete();
          }

          // Récupération des éléments FEB associés
          $elementFeb = Elementfeb::where('febid', '=', $idFeb)->get();

          // Suppression des éléments FEB associés s'ils existent
          if ($elementFeb->isNotEmpty()) {
            Elementfeb::where('febid', '=', $idFeb)->delete();
          }

          // Supprime le FEB lui-même
          $feb->delete();
        } else {

          return response()->json(
            // Si l'utilisateur connecté n'est pas le créateur, retourne une erreur
            [
              'status' => 205,
              'message' => 'Vous n\'avez pas l\'autorisation nécessaire pour supprimer le FEB. Veuillez contacter le créateur pour procéder à la suppression.'
            ],
            205
          );
        }
      });

      // Retourne une réponse en cas de succès
      return response()->json(
        [
          'status' => 200,
          'message' => 'Suppression effectuée avec succès'
        ],
        200
      );
    } catch (\Exception $e) {
      // Log de l'erreur
      // Log::error('Erreur lors de la suppression : ' . $e->getMessage());

      // Gestion de l'exception pour une réponse adaptée
      $errorMessage = $e->getMessage();
      if (strpos($errorMessage, '{') !== false) {
        // Si le message contient un JSON encodé, on le retourne directement
        $errorData = json_decode($errorMessage, true);
        return response()->json($errorData, $errorData['status']);
      }

      // Si l'erreur est standard, retourne un message générique
      return response()->json(
        [
          'status' => 500,
          'message' => 'Erreur lors de la suppression : ' . $errorMessage
        ],
        500
      );
    }
  }

  public function desacctiveSignale(Request $request)
  {

    try {

      $emp = Feb::find($request->id);
      if ($emp->userid == Auth::id()) {
        $id = $request->id;

        $emp->signale = 2;
        $emp->update();

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
    $exerciceId = session()->get('exercice_id');

    $feb = Feb::where('numerofeb', $numero)
      ->where('projetid', $ID)
      ->where('febs.execiceid', $exerciceId)
      ->exists();

    return response()->json(['exists' => $feb]);
  }

   

  public function updatannex(Request $request)
  {
    DB::beginTransaction(); // Démarre la transaction
    try {

      if (!empty($request->boncommande)) {
        $originalName = $request->boncommande->getClientOriginalName();
        $timestamp = time();
        $extension = $request->boncommande->getClientOriginalExtension(); // Conserver l'extension correcte
        $imageName = pathinfo($originalName, PATHINFO_FILENAME) . '_goproject_' . $timestamp . '.' . $extension;
        $request->boncommande->move(public_path('projet/bomcommande/'), $imageName);
        $boncommande = 'projet/bomcommande/' . $imageName;
      }

      if (!empty($request->facture)) {
        $originalName = $request->facture->getClientOriginalName();
        $timestamp = time();
        $extension = $request->facture->getClientOriginalExtension(); // Conserver l'extension correcte
        $imageName = pathinfo($originalName, PATHINFO_FILENAME) . '_goproject_' . $timestamp . '.' . $extension;
        $request->facture->move(public_path('projet/facture/'), $imageName);
        $facture = 'projet/facture/' . $imageName;
      }

      if (!empty($request->ordreM)) {
        $originalName = $request->ordreM->getClientOriginalName();
        $timestamp = time();
        $extension = $request->ordreM->getClientOriginalExtension(); // Conserver l'extension correcte
        $imageName = pathinfo($originalName, PATHINFO_FILENAME) . '_goproject_' . $timestamp . '.' . $extension;
        $request->ordreM->move(public_path('projet/ordremission/'), $imageName);
        $ordremission = 'projet/ordremission/' . $imageName;
      }

      if (!empty($request->url_pva)) {
        $originalName = $request->url_pva->getClientOriginalName();
        $timestamp = time();
        $extension = $request->url_pva->getClientOriginalExtension(); // Conserver l'extension correcte
        $imageName = pathinfo($originalName, PATHINFO_FILENAME) . '_goproject_' . $timestamp . '.' . $extension;
        $request->url_pva->move(public_path('projet/pva/'), $imageName);
        $pva = 'projet/pva/' . $imageName;
      }

      if (!empty($request->factureP)) {
        $originalName = $request->factureP->getClientOriginalName();
        $timestamp = time();
        $extension = $request->factureP->getClientOriginalExtension(); // Conserver l'extension correcte
        $imageName = pathinfo($originalName, PATHINFO_FILENAME) . '_goproject_' . $timestamp . '.' . $extension;
        $request->factureP->move(public_path('projet/facture_proformat/'), $imageName);
        $factureProformat = 'projet/facture_proformat/' . $imageName;
      }

      if (!empty($request->rapportM)) {
        $originalName = $request->rapportM->getClientOriginalName();
        $timestamp = time();
        $extension = $request->rapportM->getClientOriginalExtension(); // Conserver l'extension correcte
        $imageName = pathinfo($originalName, PATHINFO_FILENAME) . '_goproject_' . $timestamp . '.' . $extension;
        $request->rapportM->move(public_path('projet/rapport_mission/'), $imageName);
        $rapport_mission = 'projet/rapport_mission/' . $imageName;
      }

      if (!empty($request->termeR)) {
        $originalName = $request->termeR->getClientOriginalName();
        $timestamp = time();
        $extension = $request->termeR->getClientOriginalExtension(); // Conserver l'extension correcte
        $imageName = pathinfo($originalName, PATHINFO_FILENAME) . '_goproject_' . $timestamp . '.' . $extension;
        $request->termeR->move(public_path('projet/terme_reference/'), $imageName);
        $terme_reference = 'projet/terme_reference/' . $imageName;
      }

      if (!empty($request->bordereauV)) {
        $originalName = $request->bordereauV->getClientOriginalName();
        $timestamp = time();
        $extension = $request->bordereauV->getClientOriginalExtension(); // Conserver l'extension correcte
        $imageName = pathinfo($originalName, PATHINFO_FILENAME) . '_goproject_' . $timestamp . '.' . $extension;
        $request->bordereauV->move(public_path('projet/bordereau_versement/'), $imageName);
        $bordereau_versement = 'projet/bordereau_versement/' . $imageName;
      }

      if (!empty($request->recu)) {
        $originalName = $request->recu->getClientOriginalName();
        $timestamp = time();
        $extension = $request->recu->getClientOriginalExtension(); // Conserver l'extension correcte
        $imageName = pathinfo($originalName, PATHINFO_FILENAME) . '_goproject_' . $timestamp . '.' . $extension;
        $request->recu->move(public_path('projet/recu/'), $imageName);
        $recu = 'projet/recu/' . $imageName;
      }

      if (!empty($request->auccuseR)) {
        $originalName = $request->auccuseR->getClientOriginalName();
        $timestamp = time();
        $extension = $request->auccuseR->getClientOriginalExtension(); // Conserver l'extension correcte
        $imageName = pathinfo($originalName, PATHINFO_FILENAME) . '_goproject_' . $timestamp . '.' . $extension;
        $request->auccuseR->move(public_path('projet/accuse_reception/'), $imageName);
        $accuse_reception = 'projet/accuse_reception/' . $imageName;
      }

      if (!empty($request->bordereauE)) {
        $originalName = $request->bordereauE->getClientOriginalName();
        $timestamp = time();
        $extension = $request->bordereauE->getClientOriginalExtension(); // Conserver l'extension correcte
        $imageName = pathinfo($originalName, PATHINFO_FILENAME) . '_goproject_' . $timestamp . '.' . $extension;
        $request->bordereauE->move(public_path('projet/bordereau_expediction/'), $imageName);
        $bordereau_expediction = 'projet/bordereau_expediction/' . $imageName;
      }

      if (!empty($request->appelP)) {
        $originalName = $request->appelP->getClientOriginalName();
        $timestamp = time();
        $extension = $request->appelP->getClientOriginalExtension(); // Conserver l'extension correcte
        $imageName = pathinfo($originalName, PATHINFO_FILENAME) . '_goproject_' . $timestamp . '.' . $extension;
        $request->appelP->move(public_path('projet/appel_cfk/'), $imageName);
        $appel_cfk = 'projet/appel_cfk/' . $imageName;
      }


      if (!empty($request->ra)) {
        $originalName = $request->ra->getClientOriginalName();
        $timestamp = time();
        $extension = $request->ra->getClientOriginalExtension(); // Conserver l'extension correcte
        $imageName = pathinfo($originalName, PATHINFO_FILENAME) . '_goproject_' . $timestamp . '.' . $extension;
        $request->ra->move(public_path('projet/ra/'), $imageName);
        $ra = 'projet/ra/' . $imageName;
      }

      if (!empty($request->autres)) {
        $originalName = $request->autres->getClientOriginalName();
        $timestamp = time();
        $extension = $request->autres->getClientOriginalExtension(); // Conserver l'extension correcte
        $imageName = pathinfo($originalName, PATHINFO_FILENAME) . '_goproject_' . $timestamp . '.' . $extension;
        $request->autres->move(public_path('projet/autres/'), $imageName);
        $autres = 'projet/autres/' . $imageName;
      }





      $UpAnnex = Feb::find($request->febid);

      if (!empty($request->boncommande)) {
        $UpAnnex->url_bon_commande =  $boncommande;
      }
      if (!empty($request->facture)) {
        $UpAnnex->url_facture =  $facture;
      }
      if (!empty($request->ordreM)) {
        $UpAnnex->url_ordre_mission =  $ordremission;
      }
      if (!empty($request->url_pva)) {
        $UpAnnex->url_pva =  $pva;
      }
      if (!empty($request->factureP)) {
        $UpAnnex->url_factureProformat = $factureProformat;
      }
      if (!empty($request->rapportM)) {
        $UpAnnex->url_rapport_mission =  $rapport_mission;
      }
      if (!empty($request->termeR)) {
        $UpAnnex->url_terme_reference =   $terme_reference;
      }
      if (!empty($request->bordereauV)) {
        $UpAnnex->url_bordereau_versement =  $bordereau_versement;
      }
      if (!empty($request->recu)) {
        $UpAnnex->url_recu =  $recu;
      }
      if (!empty($request->auccuseR)) {
        $UpAnnex->url_accusse_reception =  $accuse_reception;
      }
      if (!empty($request->bordereauE)) {
        $UpAnnex->url_bordereau_expediction = $bordereau_expediction;
      }
      if (!empty($request->appelP)) {
        $UpAnnex->url_appel_cfk  =  $appel_cfk;
      }

      if (!empty($request->ra)) {
        $UpAnnex->url_ra  =  $ra;
      }

      if (!empty($request->appelP)) {
        $UpAnnex->url_autres  =  $autres;
      }



      $UpAnnex->update();

      DB::commit();
      return response()->json([
        'status' => 200,
      ]);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json([
        'status' => 202,
      ]);
    }
  }

  public function updat_annex(Request $request)
  {
    DB::beginTransaction(); // Start the transaction
    try {
      // Loop through each document input
      foreach ($request->annexid as $index => $id) {
        // Retrieve the annex record by ID
        $UpAnnex = attache_feb::find($id);

        // Ensure the record exists before proceeding
        if (!$UpAnnex) {
          return redirect()->back()->with('danger', "Annexe ID {$id} non trouvée.");
        }

        // Check if a new file was uploaded for this document
        if (isset($request->doc[$index]) && $request->doc[$index]->isValid()) {
          $originalName = $request->doc[$index]->getClientOriginalName();
          $timestamp = time();
          $extension = $request->doc[$index]->getClientOriginalExtension(); // Correct extension
          $imageName = pathinfo($originalName, PATHINFO_FILENAME) . '_goproject_' . $timestamp . '.' . $extension;
          $request->doc[$index]->move(public_path('projet/doc/'), $imageName);
          $docPath = 'projet/doc/' . $imageName;
        } else {
          // Use the old document path if no new file is uploaded
          $docPath = $request->ancientdoc[$index];
        }

        // Update the document path in the database
        $UpAnnex->urldoc = $docPath;
        $UpAnnex->update();
      }

      DB::commit(); // Commit the transaction if successful
      return redirect()->back()->with('success', 'Mises à jour réussies.');
    } catch (Exception $e) {
      DB::rollBack(); // Rollback the transaction if there's an error
      return redirect()->back()->with('danger', 'Erreur de mise à jour.');
    }
  }

  public function deleteelementsfeb(Request $request)
  {

    try {


      $emp = Elementfeb::find($request->id);


      $lead = (int) session()->get('lead');

      $UserIdFeb = (int) $emp->userid;

      if ($UserIdFeb == Auth::id() || $UserIdFeb == $lead) {

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
