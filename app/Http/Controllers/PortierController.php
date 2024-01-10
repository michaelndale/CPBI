<?php

namespace App\Http\Controllers;

use App\Models\Historique;
use App\Models\Portier;
use App\Models\User;
use App\Models\Vehicule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PortierController extends Controller
{
    public function index()
    {
      $title  = 'Portier';
      $active = 'Portier';
      $chauffeur   = DB::table('users')->orWhere('fonction', 'Chauffeur')->get();
      $chefmission = DB::table('users')->orWhere('fonction', '!=','Chauffeur')->get();
      $vehicule    = DB::table('vehicules')->orWhere('active', 'Activé')->get();
      return view(
        'portier.index',
        [
          'title' => $title,
          'active' => $active,
          'chauffeur' => $chauffeur,
          'chefmission' => $chefmission,
          'vehicule' => $vehicule
        ]
      );
    }
  
    public function fetchAll()
    {
      $portier = Portier::all();
      $output = '';
      if ($portier->count() > 0) {
        $output .= '<table class="table table-striped table-sm fs--1 mb-0">
        <thead>
        <tr>
          <th class="align-middle ps-3 name">#</th>
          <th >Date</th>
          <th >Object</th>
          <th >Utineraire</th>
          <th >Heure de depart</th>
          <th >Heure arriver</th>
          <th >Chauffeur</th>
          <th >Blaque</th>
          <th >Chef de mission</th>
          <th >Signature</th>
          <th><center>ACTION</center></th>
        </tr>
          </thead>
          <tbody class="list">
           ';
        $nombre = 1;
        foreach ($portier as $rs) {
          $output .= '<tr>
              <td class="align-middle ps-3 name">' . $nombre . '</td>
              <td>' . date('d.m.Y', strtotime($rs->datep)) . '</td>
              <td>' . ucfirst($rs->	objectp). '</td>
              <td>' . ucfirst($rs->	utineraire). '</td>
              <td>' . ucfirst($rs->	heuredepart). '</td>
              <td>' . ucfirst($rs->	heurearrive). '</td>
              <td>' . ucfirst($rs->	chauffeur). '</td>
              <td>' . ucfirst($rs->	blaque). '</td>
              <td>' . ucfirst($rs->	chefmission). '</td>
              <td>' . ucfirst($rs->	signature). '</td>
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
        echo '<h3 class="text-center text-secondery my-5" >  Aucun enregistrement dans la base de données </h3>';
      }
    }
  
    // insert a new employee ajax request
    public function store(Request $request)
    {
     
      try {
  
      $portier = new Portier();

      $portier->datep = $request->datejour;
      $portier->objectp = $request->object;
      $portier->utineraire = $request->utineraire; 
      $portier->heuredepart = $request->heuresortie; 
      $portier->heurearrive = $request->heureretour;
      $portier->chauffeur = $request->chauffeur;
      $portier->blaque = $request->blaque;
      $portier->chefmission= $request->chefmission;
      $portier->signature= $request->signature;
      $portier->note= $request->note;
      $portier->userid = Auth()->user()->id;
      $portier->save();

      $his = new Historique();
      $function ="Portier";
      $operation ="Sortie voiture: ".$request->blaque;
      $link ='portier';
      $his->fonction = $function;
      $his->operation = $operation;
      $his->link = $link;
      $his->userid = Auth()->user()->id;
      $his->save();

      return response()->json([
        'status' => 200,
      ]);


        
      } catch (Exception $e) {
       
        return response()->json([
          'status' => 202,
        ]);
      }





    
     
    }
  
    // edit an employee ajax request
    public function edit(Request $request)
    {
      $id = $request->id;
      $fon = portier::find($id);
      return response()->json($fon);
    }
  
    // update an function ajax request
    public function update(Request $request)
    {
   
      try {
        $title = $request->dep_title;
        $check = portier::where('title',$title)->first();
        
        if($check){
          return response()->json([
            'status' => 201,
          ]);
        }else{
  
          $emp = portier::find($request->dep_id);
          $emp->title = $request->dep_title;
          $emp->userid = Auth()->user()->id;
          $emp->update();

          $his = new Historique();
          $function ="Mises a jours";
          $operation ="Nouveau portier : ".$request->title;
          $link ='portier';
          $his->fonction = $function;
          $his->operation = $operation;
          $his->link = $link;
          $his->userid = Auth()->user()->id;
          $his->save();
    
          
          return response()->json([
            'status' => 200,
          ]);
        }
      } catch (Exception $e) {
    
        return response()->json([
          'status' => 202,
        ]);
      }
    }
  
    // supresseion
    public function deleteall(Request $request, Historique $his)
    {
      $function ="Delete";
      $operation ="Delete portier";
      $user = 'Michael ndale';
      $link ='portier';
      $his->fonction = $function;
      $his->operation = $operation;
      $his->link = $link;
      $his->userid = Auth()->user()->id;
      $his->save();

      $id = $request->id;
      portier::destroy($id);
    }
}
