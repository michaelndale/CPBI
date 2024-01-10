<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Folder;
use App\Models\Historique;
use App\Models\Notification;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index ()
    {
      $title='Activite';
      $active = 'Activite';
      $members=User::all();
      $Folder= Folder::all();
      return view('activite.index', 
        [
          'title' =>$title,
          'dataMember' => $members,
          'dataFolder' => $Folder,
          'active' => $active
      ]);
    }


  
      // insert a new employee ajax request
      public function store(Request $request , Notification $notis, Historique $his)
      {
        
        $operation ="New activite: ".$request->title;
        $link ='listactivity';
        $notis->operation = $operation;
        $his->userid  = Auth()->user()->id;
        $notis->link = $link;
        $notis->save();


        $activity = new Activity();
        $activity->title = $request->title;
        $activity->numeroprojet = $request->numeroProjet;
        $activity->region = $request->region;
        $activity->budget= $request->budget;
        $activity->description= $request->description;
        $activity->save();

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
        $title="List activity";
        $data= Activity::all();
        $total = Activity::all()->count();
        $active = 'Activity';
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
