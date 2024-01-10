<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Compte;
use App\Models\Folder;
use App\Models\Historique;
use App\Models\Notification;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function new ()
    {
      $title='New project';
      $active = 'Project';
      $members=User::all();
      $Folder= Folder::all();
      $compte = Compte::where('compteid', '=', NULL)->get();
      return view('project.new', 
        [
          'title' =>$title,
          'dataMember' => $members,
          'dataFolder' => $Folder,
          'active' => $active,
          'compte' => $compte
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
      public function store(Request $request , Notification $notis, Historique $his)
      {

        // notification initialisation

        $function ="Creation";
        $operation ="New project add : ".$request->title;
        $user = 'Michael ndale';
        $link ='list_project';
        $his->function = $function;
        $his->operation = $operation;
        $his->user = $user;
        $his->link = $link;
        $his->save();

        // fin notification

        // notification initialisation

        
        $operation ="New project add : ".$request->title;
        $user = 'Michael ndale';
        $link ='list_project';
       
        $notis->operation = $operation;
        $notis->user = $user;
        $notis->link = $link;
        $notis->save();


        $project = new Project();
        $project->title = $request->title;
        $project->numeroprojet = $request->numeroProjet;
        $project->region = $request->region;
        $project->lead = $request->leader;
        $project->lieuprojet = $request->lieuProjet;
        $project->devise = $request->devise;
        $project->numerorapport = $request->numeroRapport;
        $project->numerodossier = $request->numeroDossier;
        $project->start_date= $request->startdate;
        $project->deadline= $request->deadline;
        $project->budget= $request->budget;
        $project->description= $request->description;

        $project->save();


        return response()->json([
         'status' => 200,
         
        ]);
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
        $total = Project::all()->count();
        $active = 'Project';
        return view('project.list', 
        [
          'title' =>$title,
          'data' => $data,
          'total' => $total,
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
