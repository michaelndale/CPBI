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
              <td class="align-middle ps-3 name">' . htmlspecialchars($nombre) . '</td>
              <td><a href="' . route('responsabilite.index', $rs->id) . '">' . ucfirst($rs->title) . '</a></td>
              <td align="center">
               <div class="btn-group me-2 mb-2 mb-sm-0">
                            <a data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical ms-2"></i> Options
                            </a>

                      <div class="dropdown-menu">
                      <a  href="'. route('responsabilite.index', $rs->id) . '" id="' . htmlspecialchars($rs->id) . '" href="#" class="dropdown-item mx-1 "  title="Voir les responsabilite"><i class="fa fa-list"></i> Voir les responsabilités</a>
                        <a  href="#" id="' . htmlspecialchars($rs->id) . '" href="#" class="dropdown-item mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#edit_functionModal" title="Modifier"><i class="far fa-edit"></i> Modifier </a>
                        <a  href="#" id="' . htmlspecialchars($rs->id) . '" href="#" class="dropdown-item mx-1 eleteIcon" data-bs-toggle="modal" data-bs-target="#edit_functionModal" title="Modifier"><i class="far fa-trash-alt"></i> Supprimer</a>
                      </div>
                </div>
              </td>
            </tr>';
         $nombre++;
        }
      
        echo $output;
      } else {
        echo '
        <tr>
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
