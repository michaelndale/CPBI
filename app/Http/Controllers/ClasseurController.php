<?php

namespace App\Http\Controllers;

use App\Models\Classeur;
use Exception;
use Illuminate\Http\Request;

class ClasseurController extends Controller
{
    public function index()
    {
      $title = 'Classeur';
      $active = 'Archivage';
      return view(
        'classeur.index',
        [
          'title' => $title,
          'active' => $active
        ]
      );
    }
  
    public function fetchAll()
    {
      $Classeur = Classeur::all();
      $output = '';
      if ($Classeur->count() > 0) {
       
        $nombre = 1;
        foreach ($Classeur as $rs) {
          $output .= '<tr>
              <td class="align-middle ps-3 name">' . $nombre . '</td>
              <td>' . ucfirst($rs->libellec). '</td>
              <td>
  
              <center>
              <a href="#" id="' . $rs->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editModal" title="Modifier" ><i class="far fa-edit"></i> </a>
              <a href="#" id="' . $rs->id . '" class="text-danger mx-1 deleteIcon" title="Supprimer"><i class="far fa-trash-alt"></i></a>
            </center>
              
               
              </td>
            </tr>';
          $nombre++;
        }
     
        echo $output;
      } else {
        echo '<h3 class="text-center text-secondery my-5" > Aucun enregistrement dans la base de données ! </h3>';
      }
    }
  
    // insert a new employee ajax request
    public function store(Classeur $Classeur, Request $request)
    {
  
      try {
        
        $title = $request->title;
        $check = Classeur::where('libellec',$title)->first();
  
        if($check){
          return response()->json([
            'status' => 201,
          ]);
        }else{
          $Classeur->libellec= $request->title;
          $Classeur->userid = Auth()->user()->id;
          $Classeur->save();
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
      $fon = Classeur::find($id);
      return response()->json($fon);
    }
  
    // update an function ajax request
    public function update(Request $request)
    {
  
      try {
        $title = $request->cs_title;
        $check = Classeur::where('libellec',$title)->first();
        
        if($check){
          return response()->json([
            'status' => 201,
          ]);
        }else{
  
            $emp = Classeur::find($request->cs_id);
            $emp->libellec = $request->cs_title;
            $emp->userid = Auth()->user()->id;
            $emp->update();
            
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
    public function deleteall(Request $request)
    {
      $id = $request->id;
      Classeur::destroy($id);
    }
}
