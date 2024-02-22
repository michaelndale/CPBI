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
use Illuminate\Http\Request;
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

      return redirect()->route('dashboard');
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

        return response()->json([
         'status' => 200,
         'lastid' =>  $lastInsertedId
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

    public function show(Project $key)
    {
      $title="Show project";
      $active = 'Project';
      
      session()->put('id', $key->id);
      session()->put('title', $key->title);
      session()->put('numeroprojet', $key->numeroprojet);
      session()->put('ligneid', $key->ligneid);
      session()->put('devise', $key->devise);
      session()->put('budget', $key->budget);
      session()->put('periode', $key->periode);

     
      $act = DB::table('activities')
            ->orderby('id','DESC')
            ->Where('projectid', $key->id)
            ->get();
      
      $user=  DB::table('users')
            ->join('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
            ->Where('users.id', $key->lead)
            ->get();

           
      
            $sommerepartie= DB::table('rallongebudgets')
            ->Where('projetid', $key->id)
            ->SUM('budgetactuel');

           


      return view('project.voir', 
        [
          'title' =>$title,
          'active' => $active,
          'dataProject' => $key,
          'activite' => $act,
          'responsable' => $user,
          'sommerepartie' => $sommerepartie
          
        ]);
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


    
    
}
