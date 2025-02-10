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
use App\Models\ExerciceProjet;
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
        'title'       => $title,
        'dataMember'  => $members,
        'dataFolder'  => $Folder,
        'devise'      => $devise
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
    session()->forget('exercice_id');

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
        return redirect()->back()->with('error', 'Une erreur est survenue,le numero du proget existe e veuillez réessayer.');
      }

      $budget = str_replace(' ', '', $request->budget);
      $annee = date('Y');

      // Création du projet
      $project = new Project();

      $project->title      = $request->title;
      $project->lead       = $request->leader; // Utilisation de $request->leader comme lead du projet
      $project->start_date = $request->startdate;
      $project->deadline   = $request->deadline;
      $project->region     = $request->region;
      $project->numerodossier = $request->numeroDossier;
      $project->numeroprojet = $request->numeroProjet;
      $project->lieuprojet = $request->lieuProjet;
      $project->devise = $request->devise;
      $project->description = $request->description;
      $project->budget = $budget;
      $project->annee = $annee;
      $project->periode = $request->periode;
      $project->userid = Auth::id();

      $project->save();

      // Vérification que le projet a été enregistré avec succès
      if (!$project) {
        throw new Exception("Erreur lors de la création du projet.");
      }

      $lastInsertedId = $project->id;
      $cryptedId = Crypt::encrypt($lastInsertedId);

      // Ajout de l'utilisateur actuel comme intervenant du projet
      $intervenant = new Affectation();
      $intervenant->projectid = $lastInsertedId;
      $intervenant->memberid = Auth::id(); // Utilisateur actuel
      $intervenant->save();

      if ($request->leader != Auth::id()) {
        // Ajout du leader comme intervenant principal du projet
        $leaderIntervenant = new Affectation();
        $leaderIntervenant->projectid = $lastInsertedId;
        $leaderIntervenant->memberid = $request->leader; // Leader du projet
        $leaderIntervenant->save();
      }
     
       // Formatage automatique du numéro (0001, 0002, etc.)
       $lastProject = ExerciceProjet::where('project_id', $lastInsertedId)->orderBy('id', 'desc')->first();
       $newNumero = $lastProject ? str_pad((int)$lastProject->numero_e + 1, 4, '0', STR_PAD_LEFT) : '0001';
   
       // Mettre tous les autres projets ayant le même project_id en statut "Inactif"
       ExerciceProjet::where('project_id',  $lastInsertedId)->update(['status' => 'Inactif']);
   
       // Création du projet
       $exercice = new ExerciceProjet();
       $exercice->project_id  =  $lastInsertedId;
       $exercice->numero_e = $newNumero;
       $exercice->budget = $budget;
       $exercice->status = 'Actif';
       $exercice->estart_date =  $request->startdate;
       $exercice->edeadline = $request->deadline;
       $exercice->eperiode = $request->periode;
       
       $exercice->save();

       $lastInsertedIdExercice = $exercice->id;
       $cryptedIdExercice = Crypt::encrypt($lastInsertedIdExercice);

      // Engagement des changements dans la base de données
      DB::commit();

      return redirect()->route('key.viewProject', ['project' =>$cryptedId, 'exercice' =>  $cryptedIdExercice])
      ->with('success', 'Exercice créé avec succès.');

    } catch (Exception $e) {
      // En cas d'erreur, annulation des changements et réponse d'erreur
      return redirect()->back()->with('error', 'Une erreur est survenue, veuillez réessayer.');
    }
  }

  public function storeexe(Request $request)
  {
      // Validation des données avec des messages personnalisés
      $request->validate([
          'pid' => 'required|integer',
          'montant' => 'required|string', // Accepter le montant comme une chaîne pour permettre les espaces
          'datedebut' => 'required|date',
          'datefin' => 'required|date|after_or_equal:datedebut',
          'periode' => 'required|string',
          'pexercice' => 'nullable|string',
      ], [
          // Messages pour chaque champ
          'pid.required' => 'Le champ Projet est obligatoire.',
          'pid.integer' => 'Le champ Projet doit être un entier valide.',
          
          'montant.required' => 'Le champ Montant est obligatoire.',
          'montant.string' => 'Le champ Montant doit être une chaîne de caractères.',
          
          'datedebut.required' => 'La date de début est obligatoire.',
          'datedebut.date' => 'La date de début doit être une date valide.',
          
          'datefin.required' => 'La date de fin est obligatoire.',
          'datefin.date' => 'La date de fin doit être une date valide.',
          'datefin.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.',
          
          'periode.required' => 'Le champ Période est obligatoire.',
          'periode.string' => 'Le champ Période doit être une chaîne de caractères.',
          
          'pexercice.string' => 'Le champ Exercice doit être une chaîne de caractères.',
      ]);

      // Supprimer les espaces dans le champ montant avant de l'utiliser
      $montant = str_replace(' ', '', $request->montant);

      // Vérifier si le montant est un nombre valide après suppression des espaces
      if (!is_numeric($montant)) {
          return back()->withErrors(['montant' => 'Le champ Montant doit être un nombre valide.']);
      }

      // Formatage automatique du numéro (0001, 0002, etc.)
      $lastProject = ExerciceProjet::where('project_id', $request->pid)->orderBy('id', 'desc')->first();
      $newNumero = $lastProject ? str_pad((int)$lastProject->numero_e + 1, 4, '0', STR_PAD_LEFT) : '0001';

      // Mettre tous les autres projets ayant le même project_id en statut "Inactif"
      ExerciceProjet::where('project_id', $request->pid)
          ->update(['status' => 'Inactif']);

      // Création du projet
      $project = new ExerciceProjet();
      $project->project_id = $request->pid;
      $project->numero_e = $newNumero;
      $project->budget = $montant; // Enregistrer le montant sans espaces
      $project->status = 'Actif';
      $project->estart_date = $request->datedebut;
      $project->edeadline = $request->datefin;
      $project->eperiode = $request->periode;
      $project->pexercice = $request->pexercice; // Peut être null
      $project->save();

      $lastId = Crypt::encrypt($project->id);

      // Crypter project_id
      $cryptedProjectId = Crypt::encrypt($project->project_id);

      // Rediriger vers la liste des projets avec un message de succès
      return redirect()->route('key.viewProject', ['project' => $cryptedProjectId, 'exercice' => $lastId])
          ->with('success', 'Exercice créé avec succès.');
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

  public function list(Request $request)
  {

    $title = "Liste des projets";
    $search = $request->get('search');
    $filter = $request->get('filter', 'all'); // Récupérer le filtre, par défaut à 'all'

    $query = DB::table('projects')
      ->join('users', 'projects.lead', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('projects.*', 'projects.id as idpr', 'personnels.nom', 'personnels.prenom', 'personnels.fonction');

    // Appliquer le filtre de recherche si présent
    if ($search) {
      $query->where('projects.title', 'like', "%{$search}%")
        ->orWhere('personnels.nom', 'like', "%{$search}%")
        ->orWhere('personnels.prenom', 'like', "%{$search}%");
    }

    // Appliquer le filtre basé sur l'état
    if ($filter !== 'all') {
      $query->where('projects.status', $filter); // Ajustez selon votre logique
    }

    // Pagination des résultats
    $data = $query->paginate(10);

    // Vérifier si la requête est AJAX
    if ($request->ajax()) {
      return response()->json([
        'table' => view('project.project_table', compact('data'))->render(),
        // 'pagination' => view('partials.pagination', compact('data'))->render(),
      ]);
    }

    return view('project.list', compact('title', 'data'));
  }

  public function show($cryptedProjectId, $cryptedExerciceId)
  {
    // Décryptage de la clé de projet
   
    $projectId = Crypt::decrypt($cryptedProjectId);
    $exerciceId = Crypt::decrypt($cryptedExerciceId);

    // Vérifie si l'ID de projet existe dans la session
    if (!$projectId && !$exerciceId) {
      // Gérer le cas où l'ID du projet et exercice est invalide
      return redirect()->back()->with('error', "La session du projet et de l'exercice est terminée. Vous allez être redirigé...");
    }

    // Recherche du projet correspondant
    $check = Project::join('exercice_projets', 'projects.id', '=', 'exercice_projets.project_id')
      ->join('users', 'projects.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('projects.*', 'projects.id as idpr', 'personnels.nom', 
              'personnels.prenom', 'personnels.fonction', 
              'exercice_projets.id as exercice_id',   'exercice_projets.status', 'exercice_projets.numero_e' ,'exercice_projets.budget as budgets', 'exercice_projets.estart_date', 'exercice_projets.edeadline','exercice_projets.eperiode','exercice_projets.pexercice')
      ->where('projects.id', $projectId)
      ->where('exercice_projets.id', $exerciceId)
      ->first();

    

    // Si le projet n'existe pas, redirection avec un message d'erreur
    if (!$check) {

      return redirect()->back()->with('error', "La session du projet et de l'exercice est terminée. Vous allez être redirigé...");
    }

    // Vérifier si l'utilisateur est affecté à ce projet
    $isAuthorized = DB::table('affectations')
      ->where('projectid', $projectId)
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
      'budget' => $check->budgets,
      'periode' => $check->periode,
      'lead' => $check->lead,
      'exercice_id' => $check->exercice_id
    ]);

    // Récupération des informations de l'utilisateur responsable du projet
    $user = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->where('users.id', $check->lead)
      ->first();

    // Calcul de la somme des montants des éléments FEB
    $sommerepartie = DB::table('elementfebs')
      ->join('febs', 'elementfebs.febid', 'febs.id')
      ->where('febs.acce_signe', 1)
      ->where('febs.comptable_signe', 1)
      ->where('febs.chef_signe', 1)

      ->where('projetids', $check->id)
      ->where('exerciceids', $check->exercice_id)
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
      ->where('projet_acces_bailleurs.projet_id',)
      ->get();

        // Récupérer les exercices associés à un projet spécifique
    $exercices = ExerciceProjet::where('project_id', $projectId)->orderBy('id', 'Desc')->get();


    // Retourne la vue avec les données du projet
    return view('project.voir', [
      'title'         => $title,
      'active'        => 'Project',
      'dataProject'   => $check,
      'responsable'   => $user,
      'sommerepartie' => $sommerepartie,
      'intervennant'  => $intervennant,
      'bailleurs'     => $bailleurs,
      'exercices'     => $exercices
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
    $title = "Modification du project : " . $check->title;

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

  public function newexercice($key)
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

    $title = "Nouvelle exercice : " . $check->title;

 
    return view(
      'project.nouveau_exe',
      [
        'title' => $title,
        'active' => $active,
        'dataProject' => $check,

      ]
    );
  }

  public function updateprojet(Request $request)
  {
    $project = Project::find($request->pid);

    $project->title = $request->ptitre;
    $project->lead = $request->resid;
    $project->numeroprojet = $request->numero;
    $project->region = $request->region;
    $project->lieuprojet = $request->lieu;
    $project->description = $request->description;
    $project->devise = $request->devise;
    
    $project->autorisation = $request->autorisation;
    $project->statut = $request->statut;

    $project->update();

    if ($project) {

      session()->put('id', $project->id);
      session()->put('title', $project->title);
      session()->put('numeroprojet', $project->numeroprojet);
      session()->put('ligneid', $project->ligneid);
      session()->put('devise', $project->devise);

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

  // VOIR LES DONNEES L'EXERCICE DES PROJETS
  public function showexercice($id)
  {
      // Récupérer les exercices associés à un projet spécifique
      $exercices = DB::table('projects')
          ->join('exercice_projets', 'projects.id', '=', 'exercice_projets.project_id')
          ->where('projects.id', $id)
          ->orderBy('exercice_projets.id', 'desc')
          ->select(
              'projects.title as projet_title',
              'exercice_projets.numero_e',
              'exercice_projets.project_id',
              'exercice_projets.id as exercice_id',
              'exercice_projets.budget',
              'exercice_projets.status',
              'exercice_projets.created_at',
              'exercice_projets.estart_date',
              'exercice_projets.edeadline',
              'exercice_projets.pexercice',
              'exercice_projets.pexercice'
          )
          ->get();
  
      // Vérifier si des exercices existent pour récupérer le titre du projet
      $projectTitle = $exercices->first()->projet_title ?? 'Aucun projet en exercice disponible';
  
      // Construire les lignes HTML en commençant par le titre du projet
      $rows = "
          <tr>
              <td colspan='8' class='text-bold bg-light'>
                  <b>{$projectTitle}</b>
              </td>
          </tr>
      ";
  
      // Ajouter les exercices comme lignes suivantes
      foreach ($exercices as $index => $exercice) {
          $statutClass = $exercice->status === 'Actif' ? 'text-success' : 'text-danger';
          $statutIcon = $exercice->status === 'Actif'
              ? '<span class="badge rounded-pill bg-subtle-primary text-primary font-size-11">Active</span>'
              : '<span class="badge rounded-pill bg-subtle-danger text-danger font-size-11">Archiver</span>';
          $formattedBudget = number_format($exercice->budget, 0, ',', ' ');
          $formattedDate = date('d-m-Y', strtotime($exercice->created_at));
          $formattedYear = date('Y', strtotime($exercice->created_at));
          $formattedStard = date('d-m-Y', strtotime($exercice->estart_date));
          $formattedEnd = date('d-m-Y', strtotime($exercice->edeadline));
          $titre_ = ucfirst($exercice->pexercice);
  
          // Crypter project_id et exercice_id
          $cryptedProjectId = Crypt::encrypt($exercice->project_id);
          $cryptedExerciceId = Crypt::encrypt($exercice->exercice_id);
  
          // URL dynamique avec les deux IDs cryptés
          $exerciceUrl = route('key.viewProject', ['project' => $cryptedProjectId, 'exercice' => $cryptedExerciceId]);
  
          $rows .= "
              <tr>
                 
                  <th scope='row'><a href='{$exerciceUrl}'>" . ($index + 1) . "</a></th>
                  <th scope='row'><a href='{$exerciceUrl}'>{$titre_}</a></th>
                  <td><a href='{$exerciceUrl}' style='text-decoration: none; color: inherit;'>{$exercice->numero_e}/{$formattedYear} <i class='fas fa-external-link-alt'></i></a></td>
                  <td align='right'><b>{$formattedBudget}</b></td>
                  <td align='right'>{$formattedStard}</td>
                  <td align='right'>{$formattedEnd}</td>
                  <td class='{$statutClass}'><a href='{$exerciceUrl}' style='text-decoration: none; color: inherit;'>{$statutIcon}</a></td>
                  <td><a href='{$exerciceUrl}' style='text-decoration: none; color: inherit;'>{$formattedDate}</a></td>
              </tr>
          ";
      }
  
      // Retourner les lignes HTML comme réponse
      return response()->json(['rows' => $rows]);
  }
  

  
}
