<?php

namespace App\Http\Controllers;

use App\Models\Carburant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarburantController extends Controller
{
   

    public function allcaburent()
    {
      $folder = Carburant::orderBy('libelle', 'ASC')->get();
      $output = '';
      if ($folder->count() > 0) {
        $nombre = 1;
        foreach ($folder as $rs) {
          $output .= '<tr>
                <td class="align-middle ps-3 name">' . $nombre . '</td>
                <td>' . ucfirst($rs->libelle) . '</td>
                <td>
                <center>
                  <div class="btn-group me-2 mb-2 mb-sm-0">
                    <a  data-bs-toggle="dropdown" aria-expanded="false">
                         <i class="mdi mdi-dots-vertical ms-2"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item text-primary mx-1 editcarburent" id="' . $rs->id . '"  data-bs-toggle="modal" data-bs-target="#editCarModal" title="Modifier"><i class="far fa-edit"></i> Modifier</a>
                        <a class="dropdown-item text-danger mx-1 deleteCar"  id="' . $rs->id . '"  title="Supprimer"><i class="far fa-trash-alt"></i> Supprimer</a>
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

    public function storecarburent(Request $request)
    {
      try {
        $title = $request->libellec;
        $check = Carburant::where('libelle', $title)->first();
        if ($check) {
          return response()->json([
            'status' => 201,
          ]);
        } else {

          $type = new Carburant();
          
          $type->libelle = $request->libellec;
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
  public function editcarburent(Request $request)
  { 
    $id = $request->id;
    $type = Carburant::find($id);
    return response()->json($type);
  }

  // update an folder ajax request
  public function updatecarburent(Request $request)
  {
    try {
      $titre = $request->clibelle;
      $check = Carburant::where('libelle', $titre)->first();
      if ($check) {
        return response()->json([
          'status' => 201,
        ]);
      } else {

        $type = Carburant::find($request->cid);
        if ($type->userid == Auth::id()) {
          $type->libelle = $request->clibelle;
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
  public function deletecarburent(Request $request)
  {
    try {
      $emp = Carburant::find($request->id);
      if ($emp->userid == Auth::id()) {
        $id = $request->id;
        Carburant::destroy($id);
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
