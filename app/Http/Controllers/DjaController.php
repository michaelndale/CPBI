<?php

namespace App\Http\Controllers;

use App\Models\Dja;
use App\Models\Folder;
use App\Models\Historique;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class DjaController extends Controller
{

      // insert a new employee ajax request
      public function store(Request $request , Notification $notis, Historique $his)
      {
        
        $operation ="New activite: ".$request->title;
        $link ='listactivity';
        $notis->operation = $operation;
        $his->userid  = Auth()->user()->id;
        $notis->link = $link;
        $notis->save();


        $activity = new Dja();
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
        $title="DJA";
        $data= Dja::all();
        $total = Dja::all()->count();
        $active = 'Project';
        return view('document.dja.list', 
        [
          'title' =>$title,
          'data' => $data,
          'total' => $total,
          'active' => $active
        ]);
    }
}
