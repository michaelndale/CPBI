<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Communique;
use App\Models\Contact;
use App\Models\Folder;
use App\Models\Project;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AppCOntroller extends Controller
{
  public function index()
  {
    $title = "Tableau de bord";
    $active = "Dashboard";
    $project = Project::all();
    $user = User::all();
    $activite = Activity::all();
    $encours = Project::where('statut', 'Activé')->Count();
    $folder = Folder::orderBy('title', 'ASC')->get();
    
    $jour = date('Y-m-d');
    $communique = Communique::join('users', 'communiques.userid', '=', 'users.id')
    ->join('personnels', 'users.personnelid', '=', 'personnels.id')
    ->select('communiques.*', 'personnels.nom as user_nom', 'personnels.prenom as user_prenom')
    ->where('datelimite', '>=', $jour)
    ->get();


    
    
    session(['service' => 1]); // Définit la session 'service' à 1

    $TOTAL_FEB = DB::table('febs')->get();
    $TOTAL_DAP = DB::table('daps')->get();
    $TOTAL_DAPPS = DB::table('dapbpcs')->get();
    $TOTAL_LIGNE_BUDGET = DB::table('comptes')->get();
    $INTERVENANT = DB::table('affectations')->get();

    return view(
      'dashboard.dashboard',
      [

        'title' => $title,
        'active' => $active,
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
        'INTERVENANT' =>  $INTERVENANT



      ]
    );
  }


  public function rh()
  {
    $title = "Tableau de bord";
    $active = "Dashboard";
    $user = User::all();
    session(['service' => 2]); // Définit la session 'service' à 1
    return view(
      'dashboard.rh',
      [

        'title' => $title,
        'active' => $active,
        'user' => $user,
      ]
    );
  }


  public function archivage()
  {
    $title = "Tableau de bord";
    $active = "Dashboard";
    $user = User::all();
    session(['service' => 3]); // Définit la session 'service' à 1
    return view(
      'dashboard.archivage',
      [

        'title' => $title,
        'active' => $active,
        'user' => $user,
      ]
    );
  }

  public function parcAuto()
  {
    $title = "Tableau de bord";
    $active = "Dashboard";
    $user = User::all();
    session(['service' => 4]); // Définit la session 'service' à 1
    return view(
      'dashboard.parc',
      [

        'title' => $title,
        'active' => $active,
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
    if ($currentHour < 18) {
        $greeting = 'Bonjour';
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
}
