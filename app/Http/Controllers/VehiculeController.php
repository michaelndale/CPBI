<?php

namespace App\Http\Controllers;

use App\Models\Carburant;
use App\Models\Historique;
use App\Models\Status;
use App\Models\Typevehicule;
use App\Models\Vehicule;
use Exception;
use Illuminate\Http\Request;

class VehiculeController extends Controller
{
    public function index()
    {
      $active = 'Parc';
      $title = 'Vehicule';
      $menu= 'vehicule';

      $carburent = Carburant::all();
      $type = Typevehicule::all();
      $statut = Status::all();

      return view(
        'vehicule.index',
        [
          'title' => $title,
          'active' => $active,
          'menu' => $menu,
          'carburent' => $carburent,
          'type' => $type,
          'statut' => $statut
        ]
      );
    }
  
    public function fetchAll()
    {
      $vehicule = Vehicule::orderBy('id', 'DESC')->get();
      $output = '';
      if ($vehicule->count() > 0) {
        $output .= '<table class="table table-striped table-sm fs--1 mb-0">
        <thead>
        <tr>
          <th class="align-middle ps-3 name">#</th>
          <th >Blaque</th>
          <th >Marque</th>
          <th >Modèle</th>
          <th >N<sup>o</sup> Série</th>
          <th >Couleur</th>
          <th >Type</th>
          <th >Carburent</th>
          <th >Statut</th>
          <th >Date</th>
          <th><center>ACTION</center></th>
        </tr>
          </thead>
          <tbody class="list">
           ';
        $nombre = 1;
        foreach ($vehicule as $rs) {
          $output .= '<tr>
              <td class="align-middle ps-3 name">' . $nombre . '</td>
              <td>' . ucfirst($rs->matricule). '</td>
              <td>' . ucfirst($rs->marque). '</td>
              <td>' . ucfirst($rs->modele). '</td>
              <td>' . ucfirst($rs->numeroserie). '</td>
              <td>' . ucfirst($rs->couleur). '</td>
              <td>' . ucfirst($rs->type). '</td>
              <td>' . ucfirst($rs->carburent). '</td>
              <td>' . ucfirst($rs->active). '</td>
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
  
    // insert a new vehicule request
    public function store(Request $request)
    {
     
      try {
        $title = $request->matricule;
        $check = Vehicule::where('matricule',$title)->first();
        if($check){
          return response()->json([
            'status' => 201,
          ]);
        }else{

    
        $vehicule = new Vehicule();

        $vehicule->matricule= $request->matricule;
        $vehicule->marque= $request->marque;
        $vehicule->modele= $request->modele;
        $vehicule->couleur= $request->couleur;
        $vehicule->numeroserie= $request->numserie;
        $vehicule->type= $request->type;
        $vehicule->carburent= $request->carburent;
        $vehicule->active= $request->statut;
        $vehicule->userid = Auth()->user()->id;
        $vehicule->save();

        $his = new Historique();
        $function ="Creation";
        $operation ="Nouveau véhicule ".$request->title;
        $link ='vehicule';
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
  
    // edit an vehicule request
    public function edit(Request $request)
    {
      $id = $request->id;
      $fon = Vehicule::find($id);
      return response()->json($fon);
    }
  
    // update an vehicule request
    public function update(Request $request)
    {
   
      try {
        $title = $request->blaque;
        $check = Vehicule::where('matricule',$title)->first();
        
        if($check){
          return response()->json([
            'status' => 201,
          ]);
        }else{
  
          $emp = Vehicule::find($request->vh_id);
          $emp->matricule= $request->blaque;
          $emp->marque= $request->marque;
          $emp->modele= $request->modele;
          $emp->couleur= $request->couleur;
          $emp->numeroserie= $request->numeroserie;
          $emp->type= $request->type;
          $emp->carburent= $request->carburent;
          $emp->active= $request->statut;
          $emp->userid = Auth()->user()->id;
          $emp->update();

          $his = new Historique();
          $function ="Mises a jours";
          $operation ="Nouveau véhicule: ".$request->blaque;
          $link ='vehicule';
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
      
      $function ="Suppression";
      $operation ="Supprission vehicule";
      $link ='vehicule';
      $his->fonction = $function;
      $his->operation = $operation;
      $his->link = $link;
      $his->userid = Auth()->user()->id;
      $his->save();

      $id = $request->id;
      Vehicule::destroy($id);
    }
}
