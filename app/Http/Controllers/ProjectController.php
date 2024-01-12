<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Compte;
use App\Models\Devise;
use App\Models\Folder;
use App\Models\Historique;
use App\Models\Notification;
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
      $members= DB::table('users')->orWhere('fonction', '!=','Chauffeur')->get();
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

    public function affectation ()
    {
      $title='Affectation project';
      $project = Project::all();
      $member = User::all();
      $active = 'Project';
      return view('project.affectation', 
        [
          'title' =>$title,
          'project' => $project,
          'active' => $active,
          'member' => $member
      ]);
    }

     // Affectation store
    public function storeAffectation(Request $request)
    {
      $affectation = new Affectation();
      
      $affectation->project_id= $request->project_id;
      $affectation->member_id= $request->member;

      $affectation->save();

      return redirect()->route('list_project');
    }

    

      // insert a new employee ajax request
      public function store(Request $request )
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

            // insertion historique
            $his = new Historique();
            $function ="Projet";
            $operatio ="Nouveau projet ".$request->title;
            $link ='projet';
            $his->fonction = $function;
            $his->operation = $operatio;
            $his->link = $link;
            $his->userid = Auth()->user()->id;
            $his->save();
            // fin historique


            // notification initialisation
            $operation ="Nouveau projet : ".$request->title;
            $link ='projet';
            $notis = new Notification();
            $notis->operation = $operation;
            $notis->userid= $request->leader;
            $notis->link = $link;
            $notis->save();
            // fin initialisation notification

        // cahrgement du noveau project
        $project = new Project();
        $project->title = $request->title;
        $project->numeroprojet = $request->numeroProjet;
        $project->region = $request->region;
        $project->lead = $request->leader;
        $project->lieuprojet = $request->lieuProjet;
        $project->ligneid = $request->ligne;
        $project->devise = $request->devise;
        $project->numerorapport = $request->numeroRapport;
        $project->numerodossier = $request->numeroDossier;
        $project->start_date= $request->startdate;
        $project->deadline= $request->deadline;
        $project->budget= $request->budget;
        $project->description= $request->description;
        $project->userid = Auth()->user()->id;
        $project->save();
        return response()->json([
          'status' => 200,
         ]);

        // fin du chargement
          }
      } catch (Exception $e) {
        return response()->json([
          'status' => 202,
        ]);
      }
       
        //$lastinsertedId = session($project->id);

       //return redirect()->route('newAffectation',$lastinsertedId);
        //redirect()->route('newAffectation');
       //  return 
        
       // $lastinsertedId = session($project->id);

       // return redirect()->route('newAffectation',$lastinsertedId);
        
      }

    public function list()
    {
        $title="List project";
        $data= Project::all();
        $active = 'Project';
        return view('project.list', 
        [
          'title' =>$title,
          'data' => $data,
          'active' => $active
        ]);
    }

    public function show(Project $cle)
    {
      $title="Show project";
      $active = 'Project';
      $dataProject= Project::all();
      //where('id', $cle )->firstOrFail();
      return view('project.voir', 
        [
          'title' =>$title,
          'active' => $active,
          'dataProject' => $dataProject,
          
        ]);
    }
    
}
