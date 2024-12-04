<?php

namespace App\Http\Controllers;

use App\Models\activitefeb;
use App\Models\Activity;
use App\Models\Apreviation;
use App\Models\attache_feb;
use App\Models\Beneficaire;
use App\Models\Compte;
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
    $ID = session()->get('id');

    // Vérifier si l'ID de la session n'est pas défini
    if (!$ID) {
      // Rediriger vers la route nommée 'dashboard'
      return redirect()->route('dashboard');
    }

    $title = "Nouvel Fiche F.E.B";
    $personnel = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
      ->orderBy('nom', 'ASC')
      ->get();

    $activite = DB::table('activities')
      ->orderBy('id', 'DESC')
      ->where('projectid', $ID)
      ->get();

    $attache = Apreviation::all();

    $compte =  DB::table('comptes')
      ->where('comptes.projetid', $ID)
      ->where('compteid', '=', 0)
      ->get();

    $beneficaire = Beneficaire::orderBy('libelle')->get();

    return view(
      'document.feb.new',
      [
        'title' => $title,
        'activite' => $activite,
        'personnel' => $personnel,
        'compte' => $compte,
        'beneficaire' => $beneficaire,
        'attache' => $attache
      ]
    );
  }

  public function fetchAll()
  {
    // Retrieve session variables
    $devise = session()->get('devise');
    $budget = session()->get('budget');
    $projectId = session()->get('id');

    // Query to fetch data from 'febs' and related tables
    $data = DB::table('febs')
      ->orderBy('numerofeb', 'asc')
      ->join('comptes', 'febs.sous_ligne_bugdetaire', 'comptes.id')
      ->join('users', 'febs.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('febs.*', 'personnels.prenom as user_prenom', 'comptes.numero as code')
      ->where('febs.projetid', $projectId)
      ->get();

    $output = '';

    // Check if data is not empty
    if ($data->isNotEmpty()) {
      foreach ($data as $datas) {
        // Calculate the total amount for the current FEB
        $sommefeb = DB::table('elementfebs')
          ->where('febid', $datas->id)
          ->sum('montant');

        // Fetch attached documents
        $getDocument = attache_feb::join('apreviations', 'attache_febs.annexid', 'apreviations.id')
          ->select('apreviations.abreviation', 'apreviations.libelle')
          ->where('attache_febs.febid', $datas->id)
          ->get();

        // Calculate the percentage of the budget
        $pourcentage = round(($sommefeb * 100) / $budget, 2);
        $sommefebFormatted = number_format($sommefeb, 0, ',', ' ');

        // Generate checked string for attached documents
        if ($getDocument->isNotEmpty()) {
          $checkedString = implode(', ', $getDocument->map(function ($doc) {
            return '<i class="fa fa-check-circle" style="color: green;" title="' . $doc->libelle . '"></i> ' . $doc->abreviation . '';
          })->toArray());
          $checkedString = strtoupper($checkedString);
        } else {
          $checkedString = '<i class="fa fa-times-circle" style="color: red;" title="Aucun fichier attache disponible"></i>';
        }

        // Limit the description length
        $description = Str::limit($datas->descriptionf, 50, '...');

        // Display loading spinner if signaled
        $message = $datas->signale == 1 ? '<div class="spinner-grow text-danger" role="status" style="width: 0.5rem; height: 0.5rem;"><span class="sr-only">Loading...</span></div>' : '';

        // Encrypt the ID for secure URL generation
        $cryptedId = Crypt::encrypt($datas->id);

        // Build the output row
        $output .= '
                <tr>
                    <td>
                        <center>' . $message . '
                            <div class="btn-group me-2 mb-2 mb-sm-0">
                                <a data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical ms-2"></i> Options
                                </a>
                                <div class="dropdown-menu">
                                    <a href="feb/' . $cryptedId . '/view" class="dropdown-item mx-1" id="' . $datas->id . '">
                                        <i class="fas fa-eye"></i> Voir
                                    </a>';
        if ($getDocument->isNotEmpty()) {
          $output .=
            '
                                                <a href="feb/' . $cryptedId . '/showannex" class="dropdown-item mx-1" id="' . $datas->id . '">
                                                    <i class="fas fa-paperclip"></i> Attachez les annex
                                                </a>
                                    ';
        }
        $output .=
          ' <a href="feb/' . $cryptedId . '/edit" class="dropdown-item mx-1" id="' . $datas->id . '" title="Modifier">
                                        <i class="far fa-edit"></i> Modifier
                                    </a>
                                    <a href="feb/' . $datas->id . '/generate-pdf-feb" class="dropdown-item mx-1">
                                        <i class="fa fa-print"></i> Générer PDF
                                    </a>
                                    ';
        if ($datas->signale == 1) {
          $output .=
            '
                                    <a class="dropdown-item desactiversignale" id="' . $datas->id . '" href="#">
                                        <i class="fas fa-random"></i> Désactiver le signal ?
                                    </a>
                                     ';
        }
        $output .=
          '
                                    <a class="dropdown-item text-white mx-1 deleteIcon" id="' . $datas->id . '" data-numero="' . $datas->numerofeb . '" href="#" style="background-color:red">
                                        <i class="far fa-trash-alt"></i> Supprimer
                                    </a>
                                </div>
                            </div>
                        </center>
                    </td>
                    <td align="center"><a href="feb/' . $cryptedId . '/view" class="dropdown-item mx-1" id="' . $datas->id . '"><b>' . $datas->numerofeb . '</b></a></td>
                    <td align="right"><b>' . $sommefebFormatted . '</b></td>
                    <td align="center">' . $datas->periode . '</td>
                    <td align="center">' . $datas->code . '</td>
                   <td>
                        <label title="' . $datas->descriptionf . '">
                            ' . (strlen($description) > 30 ? substr($description, 0, 30) . '...' : $description) . '
                        </label>
                    </td>
                    <td>' . $checkedString . '</td>
                    <td align="center">' . date('d-m-Y', strtotime($datas->datefeb)) . '</td>
                    <td align="center">' . date('d-m-Y', strtotime($datas->created_at)) . '</td>
                    <td align="left">' . ucfirst($datas->user_prenom) . '</td>
                    <td align="center">' . $pourcentage . '%</td>
                </tr>';
      }
    } else {
      // Output when no data is found
      $output .= '
            <tr>
                <td colspan="15">
                    <center>
                        <h6 style="margin-top:1%; color:#c0c0c0">
                            <font size="50px">
                                <i class="fas fa-info-circle"></i>
                            </font>
                            <br><br>
                            Ceci est vide !
                        </h6>
                    </center>
                </td>
            </tr>';
    }

    // Output the generated HTML
    echo $output;
  }

  public function notificationdoc()
  {
    $documents = collect([]);
    $userId = Auth::id();

    // Fonction pour récupérer le montant total des FEB
    function getTotalFeb($febId)
    {
      return DB::table('elementfebs')
        ->where('febid', $febId)
        ->sum('montant');
    }

    // Fonction pour récupérer le montant total des DAP en fonction de plusieurs FEB
    function getTotalDap($dapId)
    {
      $febIds = DB::table('elementdaps') // Suppose que vous avez une table de liaison entre DAP et FEB
        ->where('dapid', $dapId)
        ->pluck('referencefeb');

      return DB::table('elementfebs')
        ->whereIn('febid', $febIds)
        ->sum('montant');
    }

    // Récupération des documents FEB
    $documentacce = DB::table('febs')
      ->join('users', 'febs.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->join('projects', 'febs.projetid', '=', 'projects.id')
      ->where('acce', $userId)
      ->where('acce_signe', 0)
      ->select('febs.*', 'personnels.nom as user_nom', 'personnels.prenom as user_prenom', 'projects.title as projet', 'projects.numeroprojet as numeroprojets')
      ->get();

    $documentacce->each(function ($item) {
      $item->document_type = 'feb';
      $item->total = getTotalFeb($item->id);
    });

    $documentcompte = DB::table('febs')
      ->join('users', 'febs.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->join('projects', 'febs.projetid', '=', 'projects.id')
      ->where('comptable', $userId)
      ->where('comptable_signe', 0)
      ->select('febs.*', 'personnels.nom as user_nom', 'personnels.prenom as user_prenom', 'projects.title as projet', 'projects.numeroprojet as numeroprojets')
      ->get();

    $documentcompte->each(function ($item) {
      $item->document_type = 'feb';
      $item->total = getTotalFeb($item->id);
    });

    $documentchefcomposent = DB::table('febs')
      ->join('users', 'febs.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->join('projects', 'febs.projetid', '=', 'projects.id')
      ->where('chefcomposante', $userId)
      ->where('chef_signe', 0)
      ->select('febs.*', 'personnels.nom as user_nom', 'personnels.prenom as user_prenom', 'projects.title as projet', 'projects.numeroprojet as numeroprojets')
      ->get();

    $documentchefcomposent->each(function ($item) {
      $item->document_type = 'feb';
      $item->total = getTotalFeb($item->id);
    });

    $documents_dap = collect([]);

    $dap_demandeetablie = DB::table('daps')
      ->join('users', 'daps.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->join('projects', 'daps.projetiddap', '=', 'projects.id')
      ->where('demandeetablie', $userId)
      ->where('demandeetablie_signe', 0)
      ->select('daps.*', 'personnels.nom as user_nom', 'personnels.prenom as user_prenom', 'projects.title as projet', 'projects.numeroprojet as numeroprojets')
      ->get();

    $dap_demandeetablie->each(function ($item) {
      $item->document_type = 'dap';
      $item->total = getTotalDap($item->id);
    });

    $dap_verifier = DB::table('daps')
      ->join('users', 'daps.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->join('projects', 'daps.projetiddap', '=', 'projects.id')
      ->where('verifierpar', $userId)
      ->where('verifierpar_signe', 0)
      ->select('daps.*', 'personnels.nom as user_nom', 'personnels.prenom as user_prenom', 'projects.title as projet', 'projects.numeroprojet as numeroprojets')
      ->get();

    $dap_verifier->each(function ($item) {
      $item->document_type = 'dap';
      $item->total = getTotalDap($item->id);
    });

    $dap_approuverpar = DB::table('daps')
      ->join('users', 'daps.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->join('projects', 'daps.projetiddap', '=', 'projects.id')
      ->where('approuverpar', $userId)
      ->where('approuverpar_signe', 0)
      ->select('daps.*', 'personnels.nom as user_nom', 'personnels.prenom as user_prenom', 'projects.title as projet', 'projects.numeroprojet as numeroprojets')
      ->get();

    $dap_approuverpar->each(function ($item) {
      $item->document_type = 'dap';
      $item->total = getTotalDap($item->id);
    });

    $dap_responsable = DB::table('daps')
      ->join('users', 'daps.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->join('projects', 'daps.projetiddap', '=', 'projects.id')
      ->where('responsable', $userId)
      ->where('responsable_signe', 0)
      ->select('daps.*', 'personnels.nom as user_nom', 'personnels.prenom as user_prenom', 'projects.title as projet', 'projects.numeroprojet as numeroprojets')
      ->get();

    $dap_responsable->each(function ($item) {
      $item->document_type = 'dap';
      $item->total = getTotalDap($item->id);
    });

    $dap_secretaire = DB::table('daps')
      ->join('users', 'daps.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->join('projects', 'daps.projetiddap', '=', 'projects.id')
      ->where('secretaire', $userId)
      ->where('secretaure_general_signe', 0)
      ->select('daps.*', 'personnels.nom as user_nom', 'personnels.prenom as user_prenom', 'projects.title as projet', 'projects.numeroprojet as numeroprojets')
      ->get();

    $dap_secretaire->each(function ($item) {
      $item->document_type = 'dap';
      $item->total = getTotalDap($item->id);
    });

    $dap_chefprogramme = DB::table('daps')
      ->join('users', 'daps.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->join('projects', 'daps.projetiddap', '=', 'projects.id')
      ->where('chefprogramme', $userId)
      ->where('chefprogramme_signe', 0)
      ->select('daps.*', 'personnels.nom as user_nom', 'personnels.prenom as user_prenom', 'projects.title as projet', 'projects.numeroprojet as numeroprojets')
      ->get();

    $dap_chefprogramme->each(function ($item) {
      $item->document_type = 'dap';
      $item->total = getTotalDap($item->id);
    });

    /* FEB PETIT CAISS
    $documentfeb_pc = DB::table('febpetitcaisses')
    ->join('users', 'febpetitcaisses.userid', '=', 'users.id')
    ->join('personnels', 'users.personnelid', '=', 'personnels.id')
    ->join('projects', 'febpetitcaisses.projet_id', '=', 'projects.id')
    ->where('acce', $userId)
    ->where('acce_signe', 0)
    ->select('febs.*', 'personnels.nom as user_nom', 'personnels.prenom as user_prenom', 'projects.title as projet', 'projects.numeroprojet as numeroprojets')
    ->get();

    $documentfeb_pc ->each(function ($item) {
      $item->document_type = 'feb pc';
      $item->total = getTotalFeb($item->id);
    });
    */


    $documents = $documents
      ->concat($documentacce)
      ->concat($documentcompte)
      ->concat($documentchefcomposent);

    $dap_documents = $documents_dap
      ->concat($dap_demandeetablie)
      ->concat($dap_verifier)
      ->concat($dap_approuverpar)
      ->concat($dap_responsable)
      ->concat($dap_secretaire)
      ->concat($dap_chefprogramme);



    $all_documents = $documents->concat($dap_documents);

    $output = '';
    $nombre = 1;

    if ($all_documents->count() > 0) {
      // Group documents by project number and title
      $groupedDocuments = $all_documents->groupBy(function ($item) {
        return  ucfirst($item->projet);
      });

      foreach ($groupedDocuments as $projet => $docs) {
        $output .= '<tr style="background-color:#addfad"><td colspan="8"><b>' . ucfirst($projet) . '</b></td></tr>';
        foreach ($docs as $doc) {
          $cryptedIDoc = Crypt::encrypt($doc->id);

          $datefeb = !empty($doc->datefeb) ? date('d-m-Y', strtotime($doc->datefeb)) : '-';
          $dateautorisation = !empty($doc->dateautorisation) ? date('d-m-Y', strtotime($doc->dateautorisation)) : '-';
          $createdAt = !empty($doc->created_at) ? date('d-m-Y', strtotime($doc->created_at)) : '-';
          $datelimite = !empty($doc->datelimite) ? date('d-m-Y', strtotime($doc->datelimite)) : '-';

          $output .= '
                <tr>
                    <td>' . $nombre . '</td>
                    <td>' . ($doc->document_type === 'feb' ? 'FEB' : 'DAP') . '</td>
                    <td align="right"> <a href="' . ($doc->document_type === 'feb' ? route('key.viewFeb', $cryptedIDoc) : route('viewdap', $cryptedIDoc)) . '"><b><u>' . ucfirst($doc->document_type === 'feb' ? $doc->numerofeb : $doc->numerodp) . '/' . date('Y') . ' <i class="fas fa-external-link-alt"></i></u></b></a></td>
                    <td align="right"><b>' . number_format($doc->total, 0, ',', ' ') . '</b></td>
                    <td>' . ($datefeb ?? $dateautorisation) . '</td>
                    <td>' . $createdAt . '</td>
                    <td>' . $datelimite . '</td>
                    <td>' . ucfirst($doc->user_nom) . ' ' . ucfirst($doc->user_prenom) . '</td>
                </tr>';

          $nombre++;
        }
      }
    } else {
      $output = '<tr>
            <td colspan="9" style="background-color:rgba(255,0,0,0)">
            <center>
                <h6 style="color:red">Aucun document trouvé</h6>
            </center>
            </td>
        </tr>';
    }

    return $output;
  }


  public function notificationdap()
  {

    $dap_notifications = DB::table('daps')
    ->join('projects', 'daps.projetiddap', '=', 'projects.id') // Jointure avec la table projects
    ->join('users', 'daps.userid', '=', 'users.id')
    ->join('personnels', 'users.personnelid', '=', 'personnels.id')
    ->select(
        'daps.*',
        'daps.id', // ID de la table DAP
        'projects.id AS projet_id', // ID du projet
        'projects.title AS projet_title', // Titre du projet
        'projects.numeroprojet AS projet_numero', // Numéro du projet
        'personnels.nom AS user_nom', // Nom de l'utilisateur
        'personnels.prenom AS user_prenom', // Prénom de l'utilisateur
        'daps.demandeetablie', // État de demande établie
        'daps.demandeetablie_signe', // État de signature pour demande établie
        'daps.verifierpar', // Vérifié par
        'daps.verifierpar_signe', // État de signature pour vérification
        'daps.approuverpar', // Approuvé par
        'daps.approuverpar_signe', // État de signature pour approbation
        'daps.responsable', // Responsable
        'daps.responsable_signe', // État de signature pour responsable
        'daps.secretaire', // Secrétaire
        'daps.secretaure_general_signe', // État de signature pour secrétaire général
        'daps.chefprogramme', // Chef de programme
        'daps.chefprogramme_signe' // État de signature pour chef de programme
    )
    ->where(function ($query) {
        $query->where(function ($subQuery) {
            $subQuery->where('daps.demandeetablie', Auth::id())
                     ->where('daps.demandeetablie_signe', 0);
        })
        ->orWhere(function ($subQuery) {
            $subQuery->where('daps.verifierpar', Auth::id())
                     ->where('daps.verifierpar_signe', 0);
        })
        ->orWhere(function ($subQuery) {
            $subQuery->where('daps.approuverpar', Auth::id())
                     ->where('daps.approuverpar_signe', 0);
        })
        ->orWhere(function ($subQuery) {
            $subQuery->where('daps.responsable', Auth::id())
                     ->where('daps.responsable_signe', 0);
        })
        ->orWhere(function ($subQuery) {
            $subQuery->where('daps.secretaire', Auth::id())
                     ->where('daps.secretaure_general_signe', 0);
        })
        ->orWhere(function ($subQuery) {
            $subQuery->where('daps.chefprogramme', Auth::id())
                     ->where('daps.chefprogramme_signe', 0);
        });
    })
    ->get();

    if($dap_notifications){ 

      $nombre = 1;
      $output ='';

      foreach ($dap_notifications as $daps => $dap) {
          $output .= '<tr style="background-color:#addfad"><td colspan="8"><b>' . ucfirst($dap->projet_title) . '</b></td></tr>';
   
          $cryptedIDoc = Crypt::encrypt($dap->id);
       
          $output .= '
                <tr>
                    <td></td>
                    <td>'.$dap->numerodp.' </td>
                    <td>'.$dap->numerodp.' </td>
                    <td>'. date('d-m-Y', strtotime($dap->dateautorisation)) .'</td>
                    <td>'.date('d-m-Y', strtotime($dap->created_at)).'</td>
                    <td>'.date('d-m-Y', strtotime($dap->updated_at)).'</td>
                      <td>'.ucfirst($dap->user_nom).' ' .$dap->user_prenom.'</td>
                </tr>';

          $nombre++;
        
      }
      
    } else {
      $output = '<tr>
            <td colspan="9" style="background-color:rgba(255,0,0,0)">
            <center>
                <h6 style="color:red">Aucun document trouvé</h6>
            </center>
            </td>
        </tr>';
    }

    return $output;
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
          <td> &nbsp; Montant global de l\'expression des besoins</td>
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

      $numerofeb = $request->numerofeb;
      $check = Feb::where('numerofeb', $numerofeb)
        ->where('projetid', $IDP)
        ->first();

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

        if ($request->beneficiaire !== 'autres') {
          $activity->beneficiaire = $request->beneficiaire;
        } else {
          $activity->autresBeneficiaire = $request->autresBeneficiaire;
        }

        $activity->total = $sum;
        $activity->userid = Auth()->user()->id;
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
      $activity = Feb::find($request->febid);
      $IDf = $request->febid;

      $get_lead =  DB::table('febs')
        ->join('projects', 'febs.projetid', '=', 'projects.id')
        ->select('projects.lead as lead')
        ->where('febs.id', $request->febid)
        ->first();


      $lead = session()->get('lead');
      $projet_lead = $get_lead->lead;



      /* if ($activity && $activity->userid !== Auth::id() || $projet_lead  !== $lead) { 
     
        return redirect()->back()->with('failed', 'Vous n\'avez pas l\'autorisation nécessaire pour Modifier le FEB. Veuillez contacter le créateur  pour procéder à la suppression.');
      } */
      $comp = $request->ligneid;
      $compp = explode("-", $comp);

      $grandcompte = $compp[0];
      $souscompte  = $compp[1];


      $IDP = session()->get('id');
      $activityTwo = Elementdap::where('referencefeb', $request->febid)->get();
      // Vérifier si des éléments existent
      if ($activityTwo->isNotEmpty()) {
        // Mettre à jour les éléments FEB existants
        foreach ($activityTwo as $element) {
          $element->update([
            'ligneided' =>  $souscompte,
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


      /*  if ($sum != $activity->total) {
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

      $activity->sous_ligne_bugdetaire   = $souscompte;
      $activity->ligne_bugdetaire = $grandcompte;

      if ($request->beneficiaire !== 'autres') {
        $activity->beneficiaire = $request->beneficiaire;
        $activity->autresBeneficiaire = '';
      } else {
        $activity->autresBeneficiaire = $request->autresBeneficiaire;
        $activity->beneficiaire = NULL;
      }

      //signature

      /*$activity->acce_signe   =  $acce_signe;
        $activity->comptable_signe   =  $comptable_signe;
        $activity->chef_signe   =  $chef_signe;  */

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

    $comp = str_replace(' ', '', $request->id);
    $compp = explode("-", $comp);

    $grandcompte = $compp[0];
    $souscompte  = $compp[1];

    $activiteligne = Activity::where('compteidr', $souscompte)->get();

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
    $ID = session()->get('id');

    // Vérifier si l'ID de la session n'est pas défini
    if (!$ID) {
      // Rediriger vers la route nommée 'dashboard'
      return redirect()->route('dashboard');
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
    $chec = Project::findOrFail($IDB);
    $budget = $chec->budget;

    $somme_ligne_principale = DB::table('rallongebudgets')
      ->where('compteid', $id_gl)
      ->sum('budgetactuel');

    $onebeneficaire = Beneficaire::find($check->beneficiaire);

    $sommeallfeb = DB::table('elementfebs')
      ->where('numero', '<=', $numero_classe_feb)
      ->where('projetids', $IDB)
      ->sum('montant');

    // recuperation la somme de
    $SOMME_PETITE_CAISSE = DB::table('elementboncaisses')
      ->join('bonpetitcaisses', 'elementboncaisses.boncaisse_id', 'bonpetitcaisses.id')
      ->where('elementboncaisses.projetid', $IDB)
      ->where('bonpetitcaisses.approuve_par_signature', 1)
      ->sum('elementboncaisses.montant');


    $dataLigne = Compte::find($idl);

    $sommelign = DB::table('elementfebs')
      ->where('grandligne', $id_gl)
      ->where('numero', '<=', $numero_classe_feb)
      ->where('projetids', $IDB)
      ->sum('montant');

    $sommelignpourcentage = $somme_ligne_principale ? round(($sommelign * 100) / $somme_ligne_principale, 2) : 0;

    $sommefeb = DB::table('elementfebs')
      ->where('febid', $idfeb)
      ->where('projetids', $IDB)
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

    if (!session()->has('id')) {
      return redirect()->route('dashboard');
    }

    $budget = session()->get('budget');
    $IDB = session()->get('id');
    $idf = Crypt::decrypt($idf);

    $dataJosonfeb = DB::table('febs')
      ->leftJoin('comptes', 'febs.sous_ligne_bugdetaire', '=', 'comptes.id')
      ->select('febs.*', 'febs.id as idfb', 'comptes.id as idc', 'comptes.numero as numeroc', 'comptes.libelle as libellec')
      ->where('febs.id', $idf)
      ->first();

    if (!$dataJosonfeb) {
      return redirect()->route('dashboard')->with('error', 'Pas de FEB disponible');
    }

    $idl = $dataJosonfeb->sous_ligne_bugdetaire;
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

    // Calcul des sommes et pourcentages
    $sommelign = DB::table('elementfebs')
      ->where('eligne', $idl)
      ->sum('montant');
    $sommelignpourcentage = $budget ? round(($sommelign * 100) / $budget) : 0;

    $sommefeb = DB::table('elementfebs')
      ->where('febid', $idfeb)
      ->sum('montant');

    $datafebs = DB::table('elementfebs')
      ->orderBy('id', 'DESC')
      ->where('projetids', $ID)
      ->sum('montant');


    $SOMME_PETITE_CAISSE = DB::table('elementboncaisses')
      ->join('bonpetitcaisses', 'elementboncaisses.boncaisse_id', 'bonpetitcaisses.id')
      ->where('elementboncaisses.projetid', $IDB)
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
    $chec = Project::findOrFail($IDB);
    $budget = $chec->budget;

    $somme_ligne_principale = DB::table('rallongebudgets')
      ->where('compteid', $id_gl)
      ->sum('budgetactuel');


    $sommeallfeb = DB::table('elementfebs')
      ->where('numero', '<=', $numero_classe_feb)
      ->where('projetids', $IDB)
      ->sum('montant');

    $SOMME_PETITE_CAISSE = DB::table('elementboncaisses')
      ->join('bonpetitcaisses', 'elementboncaisses.boncaisse_id', 'bonpetitcaisses.id')
      ->where('elementboncaisses.projetid', $IDB)
      ->where('bonpetitcaisses.approuve_par_signature', 1)
      ->sum('elementboncaisses.montant');

    $SOMMES_DEJA_UTILISE = $sommeallfeb + $SOMME_PETITE_CAISSE;

    $POURCENTAGE_GLOGALE = $budget ? round(($SOMMES_DEJA_UTILISE * 100) / $budget, 2) : 0;


    $sommelign = DB::table('elementfebs')
      ->where('grandligne', $id_gl)
      ->where('numero', '<=', $numero_classe_feb)
      ->where('projetids', $IDB)
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
    DB::beginTransaction();

    try {

      $id = $request->id;
      $emp = Feb::find($request->id);

      if ($emp && $emp->userid == Auth::id()) {
        $id = $request->id;

        Feb::destroy($id);
        Elementfeb::where('febid', '=', $id)->get();
        Elementdap::where('referencefeb', $id)->delete();
        Elementdjas::where('febid', $id)->delete();

        DB::commit();

        return response()->json([
          'status' => 200,
        ]);
      } else {
        DB::rollBack();
        return response()->json([
          'status' => 205,
          'message' => 'Vous n\'avez pas l\'autorisation nécessaire pour supprimer le FEB. Veuillez contacter le créateur  pour procéder à la suppression.'
        ]);
      }
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'status' => 500,
        'message' => 'Erreur lors de la suppression du FEB.',
        'error' => $e->getMessage(), // Message d'erreur de l'exception
        'exception' => (string) $e // Détails de l'exception convertis en chaîne
      ]);
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

    $feb = Feb::where('numerofeb', $numero)
      ->where('projetid', $ID)
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

      $lead = session()->get('lead');
      $emp = Elementfeb::find($request->id);
      if ($emp->userid == Auth::id() || $emp->userid = $lead) {
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
