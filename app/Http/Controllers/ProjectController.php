<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Affectation;
use App\Models\BailleursDeFonds;
use App\Models\Bonpetitcaisse;
use App\Models\Compte;
use App\Models\dap;
use App\Models\Devise;
use App\Models\Dja;
use App\Models\Elementboncaisse;
use App\Models\Elementdap;
use App\Models\Elementdjas;
use App\Models\Elementfeb;
use App\Models\Elementplanoperationnel;
use App\Models\Feb;
use App\Models\Feuilletemps;
use App\Models\Folder;
use App\Models\Historique;
use App\Models\Notification;
use App\Models\Personnel;
use App\Models\Planoperationnel;
use App\Models\Project;
use App\Models\Rallongebudget;
use App\Models\User;
use App\Models\Revision; 
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
  public function new()
  {
    $title = 'Nouveau projet';
    $members = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->orderBy('nom', 'ASC')
      ->get();
    $Folder = Folder::all();
    $devise = Devise::all();
  
    return view(
      'project.new',
      [
        'title' => $title,
        'dataMember' => $members,
        'dataFolder' => $Folder,
        'devise' => $devise
      ]
    );
  }

  public function  closeproject()
  {
    session()->forget('id');
    session()->forget('title');
    session()->forget('numeroprojet');
    session()->forget('ligneid');
    session()->forget('devise');
    session()->forget('lead');


    return redirect()->route('dashboard')->with('success', 'Très bien! le projet  est bien fermer');
  }

  // insert a new employee ajax request
  public function store(Request $request)
  {
      DB::beginTransaction();
  
      try {
          // Vérification de l'existence du projet
          $numero = $request->numeroProjet;
          $check = Project::where('numeroprojet', $numero)->first();
          if ($check) {
              return response()->json([
                  'status' => 201,
              ]);
          }
  
          $budget = str_replace(' ', '', $request->budget);
          $annee = date('Y');
  
          // Création du projet
          $project = new Project();
          $project->title = $request->title;
          $project->lead = $request->leader; // Utilisation de $request->leader comme lead du projet
          $project->start_date = $request->startdate;
          $project->deadline = $request->deadline;
          $project->region = $request->region;
          $project->numerodossier = $request->numeroDossier;
          $project->numeroprojet = $request->numeroProjet;
          $project->lieuprojet = $request->lieuProjet;
          $project->devise = $request->devise;
          $project->description = $request->description;
          $project->budget = $budget;
          $project->annee = $annee;
          $project->periode = $request->periode;
          $project->userid = Auth()->user()->id;
          $project->save();
  
          // Vérification que le projet a été enregistré avec succès
          if (!$project) {
              throw new Exception("Erreur lors de la création du projet.");
          }
  
          // Ajout de l'utilisateur actuel comme intervenant du projet
          $intervenant = new Affectation();
          $intervenant->projectid = $project->id;
          $intervenant->memberid = Auth::id(); // Utilisateur actuel
          $intervenant->save();
  
          if($request->leader != Auth::id()){
               // Ajout du leader comme intervenant principal du projet
            $leaderIntervenant = new Affectation();
            $leaderIntervenant->projectid = $project->id;
            $leaderIntervenant->memberid = $request->leader; // Leader du projet
            $leaderIntervenant->save();
          }
       
  
          // Insertion dans l'historique
          $historique = new Historique();
          $historique->fonction = "Projet";
          $historique->operation = "Nouveau projet " . $request->title;
          $historique->link = 'projet';
          $historique->userid = Auth()->user()->id;
          $historique->save();
  
          // Clé cryptée pour l'ID du projet
          $lastInsertedId = $project->id;
          $cryptedId = Crypt::encrypt($lastInsertedId);
  
          // Engagement des changements dans la base de données
          DB::commit();
  
          return response()->json([
              'status' => 200,
              'lastid' =>  $cryptedId
          ]);
  
      } catch (Exception $e) {
          // En cas d'erreur, annulation des changements et réponse d'erreur
          DB::rollback();
          return response()->json([
              'status' => 202,
              'message' => $e->getMessage(),
          ]);
      }
  }

  public function store_revision(Request $request)
  {
      // Validation des données
      $validated = $request->validate([
          'projet_id' => 'required|exists:projects,id',  // Assurez-vous que le projet existe
          'ancien_montant' => 'required|numeric|min:0',  // Validation de l'ancien montant
          'nouveau_montant' => 'required|numeric|min:0', // Validation du nouveau montant
          'description' => 'required|string|max:255',    // Validation de la description
      ]);

      // Démarrer une transaction pour garantir l'intégrité des données
      DB::beginTransaction();

      try {
          // Création de la révision budgétaire
          $revision = new Revision();
          $revision->projet_id = $validated['projet_id'];
          $revision->ancien_montant = $validated['ancien_montant'];
          $revision->nouveau_montant = $validated['nouveau_montant'];
          $revision->description = $validated['description'];
          $revision->save(); // Sauvegarde dans la base de données

          // Mise à jour du budget dans la table `projects`
          $project = Project::find($validated['projet_id']);
          $project->budget = $validated['nouveau_montant']; // Mettre à jour le budget
          $project->save(); // Sauvegarder les changements dans la table projects

          // Si tout est bon, on commit la transaction
          DB::commit();

          // Retourner un message de succès avec redirection
          return redirect()->back()->with('success', 'Révision budgétaire enregistrée et budget mis à jour avec succès.');
      } catch (\Exception $e) {
          // En cas d'erreur, on annule (rollback) la transaction
          DB::rollBack();

          // Retourner un message d'erreur avec redirection
          return redirect()->back()->with('error', 'Une erreur est survenue, veuillez réessayer.');
      }
  }

  public function list()
  {
    $title = "Liste des projets";
    $data = DB::table('projects')
    ->join('users', 'projects.lead', '=', 'users.id')
    ->join('personnels', 'users.personnelid', '=', 'personnels.id')
    ->select('projects.*', 'projects.id as idpr', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
    ->get();

    $active = 'Projet';
    return view(
      'project.list',
      [
        'title' => $title,
        'data' => $data,
        'active' => $active
      ]
    );
  }

  public function show($key)
  {
    // Décryptage de la clé de projet
    $key = Crypt::decrypt($key);
      // Recherche du projet correspondant
      $check = Project::where('projects.id', $key)
      ->join('users', 'projects.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('projects.*', 'projects.id as idpr', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->first();

    // Si le projet n'existe pas, redirection avec un message d'erreur
    if (!$check) {

      return redirect()->back()->with('modal_message', "Projet non trouvé.");
    }

    // Vérifier si l'utilisateur est affecté à ce projet
    $isAuthorized = DB::table('affectations')
      ->where('projectid', $key)
      ->where('memberid', Auth::id())
      ->exists();

    // Si l'utilisateur n'est pas autorisé, redirection avec un message d'erreur
    if (!$isAuthorized) {

      return redirect()->back()->with('modal_message', "Vous n'avez pas l'accréditation pour accéder à ce projet. Veuillez contacter le chef du projet pour être affecté aux intervenants .");
    }


    // Mise à jour de la session avec les informations du projet
    session()->put([
      'id' => $check->idpr,
      'title' => $check->title,
      'numeroprojet' => $check->numeroprojet,
      'ligneid' => $check->ligneid,
      'devise' => $check->devise,
      'budget' => $check->budget,
      'periode' => $check->periode,
      'lead' => $check->lead,
    ]);

    // Récupération des informations de l'utilisateur responsable du projet
    $user = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->where('users.id', $check->lead)
      ->first();

    // Calcul de la somme des montants des éléments FEB
    $sommerepartie = DB::table('elementfebs')
      ->where('projetids', $check->id)
      ->sum('montant');

    // Récupération des intervenants du projet
    $intervennant = DB::table('affectations')
    ->join('users', 'affectations.memberid', '=', 'users.id')
    ->join('personnels', 'users.personnelid', '=', 'personnels.id')
    ->select('affectations.*', 'personnels.nom', 'personnels.prenom', 'users.avatar', 'users.is_connected')
    ->where('affectations.projectid', $check->id)
    ->get();
    $title = $check->title;


    $bailleurs = BailleursDeFonds::select(
      'bailleurs_de_fonds.nom',
      'bailleurs_de_fonds.contact_nom',
      'bailleurs_de_fonds.contact_email',
      'bailleurs_de_fonds.contact_telephone'
  )
  ->join('projet_acces_bailleurs', 'bailleurs_de_fonds.id', '=', 'projet_acces_bailleurs.bailleurs_id')
  ->where('projet_acces_bailleurs.projet_id', $key)
  ->get();
  

    // Retourne la vue avec les données du projet
    return view('project.voir', [
      'title' => $title,
      'active' => 'Project',
      'dataProject' => $check,
      'responsable' => $user,
      'sommerepartie' => $sommerepartie,
      'intervennant' => $intervennant,
      'bailleurs'    => $bailleurs
    ]);
  }

  public function showrevision($key)
  {
    $title = "Revision Budgetaire";
    // Décryptage de la clé de projet
    $key = Crypt::decrypt($key);

    // Recherche du projet correspondant
    $check = Revision::where('projet_id', $key)
            ->join('projects', 'revisions.projet_id', 'projects.id')
            ->join('users', 'revisions.user_id', '=', 'users.id')
            ->join('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('projects.id as id', 'revisions.*', 'projects.title as titre', 'personnels.nom', 'personnels.prenom')
            ->get();
    // Retourne la vue avec les données du projet


    return view('project.revision', [
      'title' => $title,
      'active' => 'Project',
      'revisions' => $check
    ]);
  }

  public function editshow($key)
  {
   
    $active = 'Project';

    $key = Crypt::decrypt($key);
    $check = Project::find($key);

    session()->put('id', $check->id);
    session()->put('title', $check->title);
    session()->put('numeroprojet', $check->numeroprojet);
    session()->put('ligneid', $check->ligneid);
    session()->put('devise', $check->devise);
    session()->put('budget', $check->budget);
    session()->put('periode', $check->periode);
    session()->put('lead', $check->lead);
    $title = "Modification du project : ".$check->title;

    $act = DB::table('activities')
      ->orderby('id', 'DESC')
      ->Where('projectid', $check->id)
      ->get();

    $user =  DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->Where('users.id', $check->lead)
      ->get();
    $alluser = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->whereNot('users.id', 1)
      ->get();

    $sommerepartie = DB::table('rallongebudgets')
      ->Where('projetid', $check->id)
      ->SUM('budgetactuel');




    return view(
      'project.modifier',
      [
        'title' => $title,
        'active' => $active,
        'dataProject' => $check,
        'activite' => $act,
        'responsable' => $user,
        'sommerepartie' => $sommerepartie,
        'alluser'    => $alluser

      ]
    );
  }

  public function updateprojet(Request $request)
  {
    $project = Project::find($request->pid);

    $date_debut = date("Y-m-d", strtotime($request->datedebut));
    $date_fin =  date("Y-m-d", strtotime($request->datefin));


    $project->title = $request->ptitre;
    $project->lead = $request->resid;
    $project->budget = $request->montant;
    $project->numeroprojet = $request->numero;

    $project->start_date = $date_debut;
    $project->deadline = $date_fin;
    $project->region = $request->region;
    $project->lieuprojet = $request->lieu;
    $project->description = $request->description;
    $project->devise = $request->devise;
    $project->periode = $request->periode;
    $project->autorisation = $request->autorisation;
    $project->statut = $request->statut;

    $project->update();

    if ($project) {

      session()->put('id', $project->id);
      session()->put('title', $project->title);
      session()->put('numeroprojet', $project->numeroprojet);
      session()->put('ligneid', $project->ligneid);
      session()->put('devise', $project->devise);
      session()->put('budget', $project->budget);
      session()->put('periode', $project->periode);
      session()->put('lead', $project->lead);

      return back()->with('success', 'Très bien! le projet  est bien modifier');
    } else {
      return back()->with('failed', 'Echec ! le categorie n\'est pas creer ');
    }
  }

  public function revisionbudget()
  {
    $IDP = session()->get('id');

    $title = 'Budgetisation';
    $compte = Compte::all();
    $showData = Project::find($IDP);

    $compte = Compte::where('compteid', '=', NULL)
      ->where('projetid', $IDP)
      ->get();

    return view(
      'project.revision',
      [
        'title' => $title,
        'compte' => $compte,
        'showData' => $showData,
        'compte' => $compte


      ]
    );
  }


  public function deleteprojet(Request $request)
  {
    DB::beginTransaction();

    try {
      $emp = Project::find($request->id);

      if ($emp && $emp->userid == Auth::id()) {
        $id = $request->id;

        // Supprimer le projet
        Project::destroy($id);

        // Supprimer les autres éléments associés
        Compte::where('projetid', $id)->delete();
        Rallongebudget::where('projetid', $id)->delete();
        Activity::where('projectid', $id)->delete();
        Feb::where('projetid', $id)->delete();
        Elementfeb::where('projetids', $id)->delete();
        Dap::where('projetiddap', $id)->delete();
        Elementdap::where('projetidda', $id)->delete();
        Dja::where('projetiddja', $id)->delete();
        Elementdjas::where('projetiddjas', $id)->delete();
        Bonpetitcaisse::where('projetid', $id)->delete();
        Elementboncaisse::where('projetid', $id)->delete();
        Affectation::where('projectid', $id)->delete();
        Planoperationnel::where('projetid', $id)->delete();
        Elementplanoperationnel::where('projetref', $id)->delete();
        Feuilletemps::where('projetid', $id)->delete();

        DB::commit();

        return response()->json([
          'status' => 200,
        ]);
      } else {
        DB::rollBack();
        return response()->json([
          'status' => 205,
          'message' => 'Vous n\'avez pas l\'autorisation nécessaire pour supprimer ce projet. Veuillez contacter le créateur du projet pour procéder à la suppression.'
        ]);
      }
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'status' => 500,
        'message' => 'Erreur lors de la suppression du projet.',
        'error' => $e->getMessage(), // Message d'erreur de l'exception
        'exception' => (string) $e // Détails de l'exception convertis en chaîne
      ]);
    }
  }


}
