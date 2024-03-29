<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Contact;
use App\Models\Folder;
use App\Models\Project;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppCOntroller extends Controller
{
    public function index ()
    {
      $title="Dashboard";
      $active = "Dashboard";
      $project = Project::all();
      $user = User::all();
      $activite= Activity::all();
      $encours = Project::where('statut','Activé')->Count();
      $folder = Folder::orderBy('title', 'ASC')->get();
    //  $dernier = Project::orderBy('id', 'DESC')->limit(1)->get();
      
      return view('dashboard.dashboard', 
      [

        'title' =>$title,
        'active' => $active,
        'project' => $project,
        'user' => $user,
        'activite' => $activite,
        'encours' => $encours,
        'folder' => $folder

      ]);
    }


    public function findClaseur(Request $request){
      try {
        $data=DB::table('projects')
                ->select('annee')
                ->where('numerodossier',$request->id)
                ->distinct()
                ->get();
     
        return response()->json($data);

     
      } catch (Exception $e) {
        return response()->json([
          'status' => 202,
        ]);
      }
       
	}


	public function findAnnee(Request $request){

    try {

      $anne = $request->id;
      $docid= $request->docid;

  
		    $p=DB::table('projects')
          ->select('numeroprojet','title','start_date','deadline','annee','id','statut')
          ->where('annee',$anne)
          ->where('numerodossier',$docid)
          ->orderBy('id', 'DESC')
          ->get();
          return response()->json($p);

  } catch (Exception $e) {
    return response()->json([
      'status' => 202,
    ]);
  }
   
	}




}
