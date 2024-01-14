<?php

namespace App\Http\Controllers;

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

    public function  closeproject ()
    {
      session()->forget('id');

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
        $annee = date('Y');
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
        $project->annee= $annee;
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
      

      return view('project.voir', 
        [
          'title' =>$title,
          'active' => $active,
          'dataProject' => $key,
          
        ]);
    }
    
}
