<?php

namespace App\Http\Controllers;

use App\Models\Carburant;
use App\Models\Statutvehicule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatutvehiculeController extends Controller
{
    public function allstatut()
    {
      $folder = Statutvehicule::orderBy('titre', 'ASC')->get();
      $output = '';
      if ($folder->count() > 0) {
        $nombre = 1;
        foreach ($folder as $rs) {
          $output .= '<tr>
                <td class="align-middle ps-3 name">' . $nombre . '</td>
                <td>' . ucfirst($rs->titre) . '</td>
                <td>
                <center>
                  <div class="btn-group me-2 mb-2 mb-sm-0">
                    <a  data-bs-toggle="dropdown" aria-expanded="false">
                         <i class="mdi mdi-dots-vertical ms-2"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item text-primary mx-1 editStatut" id="' . $rs->id . '"  data-bs-toggle="modal" data-bs-target="#editStatutModal" title="Modifier"><i class="far fa-edit"></i> Modifier</a>
                        <a class="dropdown-item text-danger mx-1 deleteStatut"  id="' . $rs->id . '"  title="Supprimer"><i class="far fa-trash-alt"></i> Supprimer</a>
                    </div>
                 </div>
                  </center>
                </td>
              </tr>';
          $nombre++;
        }
  
        echo $output;
      } else {
        echo ' <tr>
          <td colspan="3">
          <center>
            <h6 style="margin-top:1% ;color:#c0c0c0"> 
            <center><font size="50px"><i class="far fa-trash-alt"  ></i> </font><br><br>
           Ceci est vide  !</center> </h6>
          </center>
          </td>
          </tr>';
      }
    }

    public function storestatut(Request $request)
    {
      try {
        $title = $request->s_titre;
        $check = Statutvehicule::where('titre', $title)->first();
        if ($check) {
          return response()->json([
            'status' => 201,
          ]);
        } else {

          $type = new Statutvehicule();
          
          $type->titre = $request->s_titre;
          $type->userid = Auth::id();
          $type->save();

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


  // edit an folder ajax request
  public function editstatut(Request $request)
  { 
    $id = $request->id;
    $type = Statutvehicule::find($id);
    return response()->json($type);
  }

  // update an folder ajax request
  public function updatestatut(Request $request)
  {
    try {
      $titre = $request->titre_s;
      $check = Statutvehicule::where('titre', $titre)->first();
      if ($check) {
        return response()->json([
          'status' => 201,
        ]);
      } else {

        $type = Statutvehicule::find($request->id_s);
        if ($type->userid == Auth::id()) {
          $type->titre = $request->titre_s;
          $type->update();
          return response()->json([
            'status' => 200,
          ]);
        } else {
          return response()->json([
            'status' => 205,
          ]);
        }
      }
    } catch (Exception $e) {
      return response()->json([
        'status' => 202,
        'error' => $e->getMessage()
      ]);
    }
  }

  // supresseion
  public function deletestatut(Request $request)
  {
    try {
      $emp = Statutvehicule::find($request->id);
      if ($emp->userid == Auth::id()) {
        $id = $request->id;
        Statutvehicule::destroy($id);
        return response()->json([
          'status' => 200,
        ]);
      } else {
        return response()->json([
          'status' => 205,
        ]);
      }
    } catch (Exception $e) {
      return response()->json([
        'status' => 202,
      ]);
    }
  }
}
