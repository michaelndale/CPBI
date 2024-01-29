<?php

namespace App\Http\Controllers;

use App\Models\Fonction;
use Exception;
use Illuminate\Http\Request;

class FonctionController extends Controller
{
    public function index()
    {
      $title = 'Function';
      $active = 'Parameter';
      return view(
        'fonction.index',
        [
          'title' => $title,
          'active' => $active
        ]
      );
    }
  
    public function fetchAll()
    {
      $function = Fonction::all();
      $output = '';
      if ($function->count() > 0) {
      
        $nombre = 1;
        foreach ($function as $rs) {
          $output .= '<tr>
              <td class="align-middle ps-3 name">' . $nombre . '</td>
              <td>' . ucfirst($rs->title). '</td>
              <td>
                <center>
                  <a href="#" id="' . $rs->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#edit_functionModal" title="Modifier" ><i class="far fa-edit"></i> </a>
                  <a href="#" id="' . $rs->id . '" class="text-danger mx-1 deleteIcon" title="Supprimer"><i class="far fa-trash-alt"></i></a>
                </center>
              </td>
            </tr>';
          $nombre++;
        }
      
        echo $output;
      } else {
        echo '<h3 class="text-center text-secondery my-5" >  Aucun enregistrement dans la base de données </h3>';
      }
    }
  
    // insert a new employee ajax request
    public function store(Fonction $function, Request $request)
    {
      try {
        $title = $request->title;
        $check = Fonction::where('title',$title)->first();
        if($check){
          return response()->json([
            'status' => 201,
          ]);
        }else{

          $function = new Fonction();

          $function->title = $request->title;
          $function->userid = Auth()->user()->id;
          $function->save();

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
      $fon = Fonction::find($id);
      return response()->json($fon);
    }
  
    // update an function ajax request
    public function update(Request $request)
    {

      try {
        $title = $request->fun_title;
        $check = Fonction::where('title',$title)->first();
        
        if($check){
          return response()->json([
            'status' => 201,
          ]);
        }else{
  
          $emp = Fonction::find($request->fun_id);
          $emp->title = $request->fun_title;
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
      fonction::destroy($id);
    }
}
