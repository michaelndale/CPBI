<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Historique;
use Exception;
use Illuminate\Http\Request;


class DepartementController extends Controller
{
    public function index()
    {
      $title = 'Depatment';
     
      return view(
        'departement.index',
        [
          'title' => $title,
         
        ]
      );
    }
  
    public function fetchAll()
    {
      $departement = Departement::all();
      $output = '';
      if ($departement->count() > 0) {
      
        $nombre = 1;
        foreach ($departement as $rs) {
          $output .= '<tr>
              <td class="align-middle ps-3 name">' . $nombre . '</td>
              <td>' . ucfirst($rs->title). '</td>
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
        echo '<tr>
        <td colspan="3">
        <center>
          <h6 style="margin-top:1% ;color:#c0c0c0"> 
          <center><font size="10px"><i class="far fa-trash-alt"  ></i> </font><br><br>
          Ceci est vide  !</center> </h6>
        </center>
        </td>
        </tr>
        ';
      }
    }
  
    // insert a new employee ajax request
    public function store(Departement $departement,Historique $his,Request $request)
    {
     
      try {
        $title = $request->title;
        $check = Departement::where('title',$title)->first();
        if($check){
          return response()->json([
            'status' => 201,
          ]);
        }else{

    
      $departement = new Departement();
      $departement->title = $request->title;
      $departement->userid = Auth()->user()->id;
      $departement->save();

      $his = new Historique();
      $function ="Creation";
      $operation ="New Departement add : ".$request->title;
      $link ='Departement';
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
  
    // edit an employee ajax request
    public function edit(Request $request)
    {
      $id = $request->id;
      $fon = Departement::find($id);
      return response()->json($fon);
    }
  
    // update an function ajax request
    public function update(Request $request)
    {
   
      try {
        $title = $request->dep_title;
        $check = Departement::where('title',$title)->first();
        
        if($check){
          return response()->json([
            'status' => 201,
          ]);
        }else{
  
          $emp = Departement::find($request->dep_id);
          $emp->title = $request->dep_title;
          $emp->userid = Auth()->user()->id;
          $emp->update();

          $his = new Historique();
          $function ="Mises a jours";
          $operation ="Nouveau departement : ".$request->title;
          $link ='Departement';
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
      $operation ="Delete Departement";
      $user = 'Michael ndale';
      $link ='Departement';
      $his->fonction = $function;
      $his->operation = $operation;
      $his->link = $link;
      $his->userid = Auth()->user()->id;
      $his->save();

      $id = $request->id;
      Departement::destroy($id);
    }
}
