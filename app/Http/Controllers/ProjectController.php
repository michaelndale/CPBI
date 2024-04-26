<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\Devise;
use App\Models\Folder;
use App\Models\Historique;
use App\Models\Notification;
use App\Models\Personnel;
use App\Models\Project;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function new ()
    {
      $title='New project';
      $active = 'Project';
      $members= DB::table('users')
              ->join('personnels', 'users.personnelid', '=', 'personnels.id')
              ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
              ->orWhere('fonction', '!=' ,'Chauffeur')
              ->orderBy('nom', 'ASC')
              ->get();

      $Folder= Folder::all();
      $devise= Devise::all();
      $compte = Compte::where('compteid', '=', NULL)->get();
      return view('project.new', 
        [
          'title' =>$title,
          'dataMember' => $members,
          'dataFolder' => $Folder,
          'active' => $active,
          'compte' => $compte,
          'devise' => $devise
      ]);
    }

    public function  closeproject ()
    {
      session()->forget('id');
      session()->forget('title');
      session()->forget('numeroprojet');
      session()->forget('ligneid');
      session()->forget('devise');

      return redirect()->route('dashboard')->with('success', 'Très bien! le projet  est bien fermer');
      
    }

      // insert a new employee ajax request
    public function store(Request $request)
    {
      try {
          // verification de l'existence du project
          $numero = $request->numeroProjet;
          $check = Project::where('numeroprojet',$numero)->first();
    
          if($check){
            return response()->json([
              'status' => 201,
            ]);
          }else{

        // Insertion historique

            $his = new Historique();
            $function ="Projet";
            $operatio ="Nouveau projet ".$request->title;
            $link ='projet';
            $his->fonction = $function;
            $his->operation = $operatio;
            $his->link = $link;
            $his->userid = Auth()->user()->id;
            $his->save();

        // Noveau project
    
        $budget =str_replace(' ', '', ($request->budget));
        $annee = date('Y');
        
        $project = new Project();

        $project->title = $request->title;
        $project->lead = $request->leader;
        $project->start_date= $request->startdate;
        $project->deadline= $request->deadline;
        $project->region = $request->region;
        $project->numerodossier = $request->numeroDossier;
        $project->numeroprojet = $request->numeroProjet;
        $project->lieuprojet = $request->lieuProjet;
        $project->devise = $request->devise;
        $project->description= $request->description;
        $project->budget= $budget;
        $project->annee= $annee;
        $project->periode= $request->periode;
        $project->userid = Auth()->user()->id;

        $project->save();
        

        $lastInsertedId= $project->id;
        $cryptedId = Crypt::encrypt($lastInsertedId); 
        return response()->json([
         'status' => 200,
         'lastid' =>  $cryptedId
        ]);

        // fin du chargement
          }
      } catch (Exception $e) {
        return response()->json([
          'status' => 202,
        ]);
      }
       
        
        
      }




      

    public function list()
    {
        $title="List project";
        $data= Project::orderBy('id', 'DESC')->get();
        $active = 'Project';
        return view('project.list', 
        [
          'title' =>$title,
          'data' => $data,
          'active' => $active
        ]);
    }

    public function show($key)
    {
      

      $title="Show project";
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
      

    
      
      $user=  DB::table('users')
            ->join('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
            ->Where('users.id', $check->lead)
            ->first();
   
      
      $sommerepartie= DB::table('elementfebs')
      ->Where('projetids', $check->id)
      ->SUM('montant');

      $intervennant = DB::table('affectations')
      ->join('personnels', 'affectations.memberid', '=', 'personnels.id')
      ->join('users', 'affectations.memberid', '=', 'users.personnelid')
      ->select('affectations.*','personnels.nom', 'personnels.prenom','users.avatar')
      ->where('affectations.projectid',$check->id)
      ->get();

      return view('project.voir', 
        [
          'title' =>$title,
          'active' => $active,
          'dataProject' => $check,
          'responsable' => $user,
          'sommerepartie' => $sommerepartie,
          'intervennant' => $intervennant
        ]);
      
    }


    public function editshow($key)
    {
      $title="Show project";
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

      $act = DB::table('activities')
            ->orderby('id','DESC')
            ->Where('projectid', $check->id)
            ->get();
      
      $user=  DB::table('users')
            ->join('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
            ->Where('users.id', $check->lead)
            ->get();
      $alluser= DB::table('users')
            ->join('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
            ->whereNot('users.id', 1)
            ->get();

      $sommerepartie= DB::table('rallongebudgets')
            ->Where('projetid', $check->id)
            ->SUM('budgetactuel');

           


      return view('project.modifier', 
        [
          'title' =>$title,
          'active' => $active,
          'dataProject' => $check,
          'activite' => $act,
          'responsable' => $user,
          'sommerepartie' => $sommerepartie,
          'alluser'    => $alluser
          
        ]);
    }



    public function updateprojet(Request $request)
    {
        $project = Project::find($request->pid);

        $date_debut= date("Y-m-d", strtotime($request->datedebut));
        $date_fin =  date("Y-m-d", strtotime($request->datefin));
      

        $project->title = $request->ptitre;
        $project->lead = $request->resid;
        $project->budget= $request->montant;
        $project->numeroprojet= $request->numero;
       
        $project->start_date= $date_debut;
        $project->deadline= $date_fin;
        $project->region = $request->region;
        $project->lieuprojet = $request->lieu;
        $project->description= $request->description;
        $project->devise= $request->devise;
        $project->periode= $request->periode;
        $project->autorisation= $request->autorisation;
        $project->statut= $request->statut;
    
        $project->update();
          
        if ($project) {

          session()->put('id', $project->id);
          session()->put('title', $project->title);
          session()->put('numeroprojet', $project->numeroprojet);
          session()->put('ligneid', $project->ligneid);
          session()->put('devise', $project->devise);
          session()->put('budget', $project->budget);
          session()->put('periode', $project->periode);
          
          return back()->with('success', 'Très bien! le projet  est bien modifier');
      } else {
          return back()->with('failed', 'Echec ! le categorie n\'est pas creer ');
      }
    }


    public function revisionbudget()
    {
      $IDP = session()->get('id');
    
      $title = 'Budgetisation';
      $compte= Compte::all();
      $showData = Project::find($IDP);

      $compte = Compte::where('compteid', '=', NULL)
      ->where('projetid',$IDP)
      ->get();

      return view('project.revision',
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
      try {
      $emp = Project::find($request->id);
      if ($emp->userid == Auth::id()) {
        $id = $request->id;
        Project::destroy($id);
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
