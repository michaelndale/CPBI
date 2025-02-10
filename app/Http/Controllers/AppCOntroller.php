<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Communique;
use App\Models\Contact;
use App\Models\Folder;
use App\Models\Project;
use App\Models\signalefeb;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; // Import the Log class

class AppCOntroller extends Controller
{
  public function index()
  {
      $title = "Tableau de bord";
     
      $project = Project::all();
      
      $user = User::all();
     
      $activite = Activity::all();
    
      $encours = Project::where('statut', 'Activé')->count();
      
    
      $folder = Folder::orderBy('title', 'ASC')->get();
     
      $jour = date('Y-m-d');

      try {
          $communique = Communique::join('users', 'communiques.userid', '=', 'users.id')
              ->join('personnels', 'users.personnelid', '=', 'personnels.id')
              ->select('communiques.*', 'personnels.nom as user_nom', 'personnels.prenom as user_prenom')
              ->where('datelimite', '>=', $jour)
              ->get();
      } catch (\Exception $e) {
          Log::error('Erreur lors de la récupération des communiqués: ' . $e->getMessage());
          $communique = [];
      }

      session(['service' => 1]); // Définit la session 'service' à 1

      // Fetching data from the database with error handling
      try {
          $TOTAL_FEB = DB::table('febs')->get();
      } catch (\Exception $e) {
          Log::error('Erreur lors de la récupération des FEBs: ' . $e->getMessage());
          $TOTAL_FEB = [];
      }

      try {
          $TOTAL_DAP = DB::table('daps')->get();
      } catch (\Exception $e) {
          Log::error('Erreur lors de la récupération des DAPs: ' . $e->getMessage());
          $TOTAL_DAP = [];
      }

      try {
          $TOTAL_DAPPS = DB::table('dapbpcs')->get();
      } catch (\Exception $e) {
          Log::error('Erreur lors de la récupération des DAPBPCS: ' . $e->getMessage());
          $TOTAL_DAPPS = [];
      }

      try {
          $TOTAL_LIGNE_BUDGET = DB::table('comptes')->get();
      } catch (\Exception $e) {
          Log::error('Erreur lors de la récupération des comptes: ' . $e->getMessage());
          $TOTAL_LIGNE_BUDGET = [];
      }

      try {
          $INTERVENANT = DB::table('affectations')->get();
      } catch (\Exception $e) {
          Log::error('Erreur lors de la récupération des intervenants: ' . $e->getMessage());
          $INTERVENANT = [];
      }

      // GRAPHIC FEB
      $startOfYear = Carbon::now()->startOfYear();
      $endOfYear = Carbon::now()->endOfYear();

      $monthsInFrench = [
          '1' => 'Janvier',
          '2' => 'Février',
          '3' => 'Mars',
          '4' => 'Avril',
          '5' => 'Mai',
          '6' => 'Juin',
          '7' => 'Juillet',
          '8' => 'Août',
          '9' => 'Septembre',
          '10' => 'Octobre',
          '11' => 'Novembre',
          '12' => 'Décembre',
      ];

      $monthsInYearFebs = array_fill_keys(array_keys($monthsInFrench), 0);
      $monthsInYearDaps = array_fill_keys(array_keys($monthsInFrench), 0);
      $monthsInYear = array_fill_keys(array_keys($monthsInFrench), 0);

      $projectId = session()->get('id'); // Récupérer l'ID du projet depuis la session

      try {
          if ($projectId) {
              // Récupérer les enregistrements pour le projet spécifique
              $febsData = DB::table('febs')
                  ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
                  ->whereBetween('created_at', [$startOfYear, $endOfYear])
                  ->where('projetid', $projectId)
                  ->groupBy('month')
                  ->orderBy('month', 'ASC')
                  ->get();

              foreach ($febsData as $feb) {
                  $monthsInYearFebs[$feb->month] = $feb->total;
              }

              $dapsData = DB::table('daps')
                  ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
                  ->whereBetween('created_at', [$startOfYear, $endOfYear])
                  ->where('projetiddap', $projectId)
                  ->groupBy('month')
                  ->orderBy('month', 'ASC')
                  ->get();

              foreach ($dapsData as $daps) {
                  $monthsInYearDaps[$daps->month] = $daps->total;
              }

              $BONpets = DB::table('bonpetitcaisses')
                  ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
                  ->whereBetween('created_at', [$startOfYear, $endOfYear])
                  ->where('projetid', $projectId)
                  ->groupBy('month')
                  ->orderBy('month', 'ASC')
                  ->get();

              foreach ($BONpets as $BONpet) {
                  $monthsInYear[$BONpet->month] = $BONpet->total;
              }
          } else {
              // Récupérer les enregistrements sans projet spécifique
              $febsData = DB::table('febs')
                  ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
                  ->whereBetween('created_at', [$startOfYear, $endOfYear])
                  ->groupBy('month')
                  ->orderBy('month', 'ASC')
                  ->get();

              foreach ($febsData as $feb) {
                  $monthsInYearFebs[$feb->month] = $feb->total;
              }

              $dapsData = DB::table('daps')
                  ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
                  ->whereBetween('created_at', [$startOfYear, $endOfYear])
                  ->groupBy('month')
                  ->orderBy('month', 'ASC')
                  ->get();

              foreach ($dapsData as $daps) {
                  $monthsInYearDaps[$daps->month] = $daps->total;
              }

              $BONpets = DB::table('bonpetitcaisses')
                  ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
                  ->whereBetween('created_at', [$startOfYear, $endOfYear])
                  ->groupBy('month')
                  ->orderBy('month', 'ASC')
                  ->get();

              foreach ($BONpets as $BONpet) {
                  $monthsInYear[$BONpet->month] = $BONpet->total;
              }
          }
      } catch (\Exception $e) {
          Log::error('Erreur lors de la génération des graphiques: ' . $e->getMessage());
      }

      $months = array_values($monthsInFrench);
      $totalsFebs = array_values($monthsInYearFebs);
      $totalsDaps = array_values($monthsInYearDaps);
      $totals = array_values($monthsInYear);

      $maxValue = max($totals);
      $minValue = min($totals);

      return view('dashboard.dashboard', [
          'title' => $title,
          'project' => $project,
          'user' => $user,
          'activite' => $activite,
          'encours' => $encours,
          'folder' => $folder,
          'communique' => $communique,
          'TOTAL_FEB' => $TOTAL_FEB,
          'TOTAL_DAP' => $TOTAL_DAP,
          'TOTAL_DAPPS' => $TOTAL_DAPPS,
          'TOTAL_LIGNE_BUDGET' => $TOTAL_LIGNE_BUDGET,
          'INTERVENANT' => $INTERVENANT,
          'months' => $months,
          'totalsFebs' => $totalsFebs,
          'totalsDaps' => $totalsDaps,
          'totals' => $totals,
          'maxValue' => $maxValue,
          'minValue' => $minValue,
      ]);
  }


  public function rh()
  {
    $title = "Tableau de bord";
    $user = User::all();
    session(['service' => 2]); // Définit la session 'service' à 1
    return view(
      'dashboard.rh',
      [

        'title' => $title,
        'user' => $user,
      ]
    );
  }


  public function archivage()
  {
    $title = "Tableau de bord";
    $user = User::all();
    session(['service' => 3]); // Définit la session 'service' à 1
    return view(
      'dashboard.archivage',
      [

        'title' => $title,
    
        'user' => $user,
      ]
    );
  }

  public function parcAuto()
  {
    $title = "Tableau de bord";
    $user = User::all();
    session(['service' => 4]); // Définit la session 'service' à 1
    return view(
      'dashboard.parc',
      [

        'title' => $title,
        'user' => $user,
      ]
    );
  }


  public function start()
  {

    $title = "Bienvenue";
    //  $dernier = Project::orderBy('id', 'DESC')->limit(1)->get();

    $currentHour = date('H');

    // Déterminez le message en fonction de l'heure
    if ($currentHour < 12) {
        $greeting = 'Bonjour';
    } elseif ($currentHour < 18) {
        $greeting = 'Bon après-midi';
    } else {
        $greeting = 'Bonsoir';
    }

    return view(
      'dashboard.start',
      [

        'title' => $title,
        'greeting' => $greeting
      ]
    );
  }



  public function findClaseur(Request $request)
  {
    try {
      $data = DB::table('projects')
        ->select('annee')
        ->where('numerodossier', $request->id)
        ->distinct()
        ->get();

      return response()->json($data);
    } catch (Exception $e) {
      return response()->json([
        'status' => 202,
      ]);
    }
  }


  public function findAnnee(Request $request)
  {
    try {
      $anne = $request->id;
      $docid = $request->docid;
      $p = DB::table('projects')
        ->select('numeroprojet', 'title', 'start_date', 'deadline', 'annee', 'id', 'statut')
        ->where('annee', $anne)
        ->where('numerodossier', $docid)
        ->orderBy('id', 'DESC')
        ->get();

      $output = '';
      if ($p->count() > 0) {
        $nombre = 1;
        foreach ($p as $rs) {
          $cryptedId = Crypt::encrypt($rs->id);
          $output .= '<tr class="hover-actions-trigger btn-reveal-trigger position-static">
                            <td class="closed-won border-end"><b><a href="project/' . $cryptedId . '/view"># ' . ucfirst($rs->numeroprojet) . ' </a></b></td>
                            <td class="closed-won border-end ">' . ucfirst($rs->title) . '</td>
                            <td class="closed-won border-end ">' . date('d-m-Y', strtotime($rs->start_date)) . '</td>
                            <td class="closed-won border-end ">' . date('d-m-Y', strtotime($rs->deadline))  . '</td>
                            <td class="closed-won border-end ">' . $rs->statut . '</td>
                            <td class="closed-won border-end ">' . $rs->annee  . '</td>
                </tr>';
          $nombre++;
        }
        return response()->json($output);
      } else {
        return response()->json([
          'message' => 'Ceci est vide !',
        ]);
      }
    } catch (Exception $e) {
      return response()->json([
        'status' => 202,
      ]);
    }
  }

  public function parc()
  {
    $title = "Accueil";
    $user = User::all();
    return view(
      'dashboard.parc',
      [
        'title' => $title,
        'user' => $user
      ]
    );
  }

  public function fetchFebDetails(Request $request)
  {
    // Récupère le febid à partir de la requête AJAX
    $febid = $request->get('febid');

    // Récupère les données associées au febid dans la table signalefebs avec les jointures correctes
    $DetailsSignale = DB::table('signalefebs')
      ->join('users', 'signalefebs.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('signalefebs.*', 'personnels.prenom as user_prenom', 'personnels.nom as user_nom', 'users.avatar as user_avatar','users.is_connected')
      ->where('signalefebs.febid', '=', $febid)
      ->orderBy('id', 'ASC')
      ->get();

    // Récupère les détails spécifiques de la table febs
    $febDetails = DB::table('febs')
      ->join('projects', 'febs.projetid', '=', 'projects.id')
      ->join('affectations', 'febs.projetid', '=', 'affectations.projectid')
      ->join('users', 'febs.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('febs.*', 'febs.id as idf',  'personnels.prenom as user_prenom', 'personnels.nom as user_nom', 'users.avatar as user_avatar',  'users.id as user_id', 'users.is_connected','projects.title as project_title')
      ->where('febs.id', '=', $febid)
      ->first();

    // Retourne la vue partielle avec les données
    return view('signalisation.contenu', compact('DetailsSignale', 'febDetails'));
  }
}
