<?php

namespace App\Http\Controllers;

use App\Models\Feb;
use App\Models\Folder;
use App\Models\Historique;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FebController extends Controller
{
    public function new ()
    {
      $title='FEB';
      $active = 'Project';
      $ID = session()->get('id');

      $personnel = DB::table('users')->Where('fonction', '!=','Chauffeur')->get();

      $activite = DB::table('activities')
            ->orderby('id','DESC')
            ->Where('projectid', $ID)
            ->get();
      
      return view('document.feb.new', 
        [
          'title' =>$title,
          'activite' => $activite,
          'active' => $active,
          'personnel' => $personnel
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


        $activity = new Feb();
        $activity->title = $request->title;
        $activity->numeroprojet = $request->numeroProjet;
        $activity->region = $request->region;
        $activity->budget= $request->budget;
        $activity->description= $request->description;
        $activity->save();

        return response()->json([
         'status' => 200,
         
        ]);
       
      }

    public function list()
    {
        $title="FEB";
        $data= Feb::all();
        $total = Feb::all()->count();
        $personnel = DB::table('users')->Where('fonction', '!=','Chauffeur')->get();
        $active = 'Project';
        $ID = session()->get('id');
        $activite = DB::table('activities')
              ->orderby('id','DESC')
              ->Where('projectid', $ID)
              ->get();
        return view('document.feb.list', 
        [
          'title' =>$title,
          'data' => $data,
          'total' => $total,
          'active' => $active,
          'activite' => $activite,
          'personnel' => $personnel
        ]);
    }
}
