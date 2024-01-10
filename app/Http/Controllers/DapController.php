<?php

namespace App\Http\Controllers;

use App\Models\dap;
use App\Models\Folder;
use App\Models\Historique;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class DapController extends Controller
{
    public function new ()
    {
      $title='DAP';
      $active = 'Document';
      $members=User::all();
      $Folder= Folder::all();
      return view('document.feb.new', 
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


        $activity = new Dap();
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
        $title="DAP";
        $data= dap::all();
        $total = dap::all()->count();
        $active = 'Document';
        return view('document.dap.list', 
        [
          'title' =>$title,
          'data' => $data,
          'total' => $total,
          'active' => $active
        ]);
    }
}
