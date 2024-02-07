<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Catactivity;
use App\Models\Compte;
use App\Models\Folder;
use App\Models\Historique;
use App\Models\Notification;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function index ()
    {
      $title='Activite';
      $active = 'Activite';
      $dataProjet = Project::all();
      $dataCategorie = Catactivity::all();
      $compte = Compte::where('compteid', '=', NULL)->get();
      return view('activite.index', 
        [
          'title' =>$title,
          'dataProject' => $dataProjet,
          'dataCategorie' => $dataCategorie,
          'active' => $active,
          'compte' => $compte,
      ]);
    }

    public function fetchAll()
    {
      $ID = session()->get('id');
      $act = DB::table('activities')
            ->orderby('id','DESC')
            ->Where('projectid', $ID)
            ->get();
               
      $output = '';
      if ($act->count() > 0) {
       
        $nombre = 1;
        foreach ($act as $rs) {
          if($rs->etat_activite=="Annuler"){ $color ='#F08080'; }else{ $color=''; }
          $output .= '
            <tr style="background-color:'.$color.'">
              <td class="align-middle ps-3 name">' . $nombre . '</td>
              <td>' . ucfirst($rs->titre). '</td>
              <td>' . 2024 . '</td>
              <td>' . ucfirst($rs->montantbudget). '</td>
              <td>' . ucfirst($rs->etat_activite). '</td>
              <td>' . date('d.m.Y', strtotime($rs->created_at)) . '</td>
              <td>
                <center>
                  <a href="#" id="' . $rs->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#edit_DepatmentModal" title="Modifier" ><i class="far fa-edit"></i> </a>
                  <a href="#" id="' . $rs->id . '" class="text-danger mx-1 deleteIcon" title="Supprimer"><i class="far fa-trash-alt"></i></a>
                </center>
              </td>
            </tr>';
          $nombre++;
        }
        echo $output;
      } else {
        echo
            '
            <tr>
            <td colspan="6">
            <center>
              <h4 style="margin-top:1% ;color:#c0c0c0"> 
              <center><font size="100px"><i class="far fa-trash-alt"  ></i> </font><br><br>
              Aucun enregistrement dans la base de données !</center> </h4>
            </center>
            </td>
            </tr>
            
            ';
      }
    }


  
      // insert a new ajax request
      public function store(Request $request )
      {
        
       // $operation ="Nouveau activite: ".$request->title;
       // $link ='listactivity';
        //$notis->operation = $operation;
        ////$his->userid  = Auth()->user()->id;
       // $notis->link = $link;
       // $notis->save();


        $activity = new Activity();
        
        $activity->projectid = $request->projetid;
        $activity->compteidr = $request->compteid;
        $activity->titre = $request->titre;
        $activity->montantbudget= $request->montant;
        $activity->etat_activite= $request->etat;
        
        $activity->userid= Auth::id();

        $activity->save();

        return response()->json([
         'status' => 200,
         
        ]);
        
        
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

    public function deleteall(Request $request,)
    {
      $his = new Historique;
      $function ="Supprimer";
      $operation ="Supprimer Activite ";
      $link ='history';
      $his->fonction = $function;
      $his->operation = $operation;
      $his->userid = Auth::id();
      $his->link = $link;
      $his->save();

      $id = $request->id;
      Activity::destroy($id);
    }
    
}
