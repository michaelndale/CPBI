<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Catactivity;
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
      
      return view('activite.index', 
        [
          'title' =>$title,
          'dataProject' => $dataProjet,
          'dataCategorie' => $dataCategorie,
          'active' => $active
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
        $output .= '<table class="table table-striped table-sm fs--1 mb-0">
        <thead>
        <tr>
          <th class="align-middle ps-3 name">#</th>
          <th >Titre</th>
          <th >Pays</th>
          <th >Montant</th>
          <th >Date</th>
          <th><center>ACTION</center></th>
        </tr>
          </thead>
          <tbody class="list">
           ';
        $nombre = 1;
        foreach ($act as $rs) {
          $output .= '<tr>
              <td class="align-middle ps-3 name">' . $nombre . '</td>
              <td>' . ucfirst($rs->titre). '</td>
              <td>' . ucfirst($rs->pays). '</td>
              <td>' . ucfirst($rs->montantbudget). '</td>
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
        $output .= '</tbody></table>';
        echo $output;
      } else {
        echo '<h3 class="text-center text-secondery my-5" >  Aucun enregistrement dans la base de données ! </h3>';
      }
    }


  
      // insert a new ajax request
      public function store(Request $request , Notification $notis, Historique $his)
      {
        
       // $operation ="Nouveau activite: ".$request->title;
       // $link ='listactivity';
        //$notis->operation = $operation;
        ////$his->userid  = Auth()->user()->id;
       // $notis->link = $link;
       // $notis->save();


        $activity = new Activity();
        $activity->titre = $request->titre;
        $activity->projectid = $request->projetid;
        $activity->pays = $request->pays;
        $activity->montantbudget= $request->montant;
        $activity->catid= $request->categorieid;
        $activity->description= $request->description;
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
