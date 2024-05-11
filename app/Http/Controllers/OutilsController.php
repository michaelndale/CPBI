<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use App\Models\Typevehicule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutilsController extends Controller
{
  public function index()
  {
    $title = 'Outils PA';

    return view(
      'outilspa.index',
      [
        'title' => $title,

      ]
    );
  }

  public function alltype()
  {
    $folder = Typevehicule::orderBy('libelle', 'ASC')->get();
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
                        <a class="dropdown-item text-primary mx-1 editType" id="' . $rs->id . '"  data-bs-toggle="modal" data-bs-target="#editTypeModal" title="Modifier"><i class="far fa-edit"></i> Modifier</a>
                        <a class="dropdown-item text-danger mx-1 deleteType"  id="' . $rs->id . '"  title="Supprimer"><i class="far fa-trash-alt"></i> Supprimer</a>
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

  public function storetype(Request $request)
  {
    try {
      $title = $request->titre;
      $check = Typevehicule::where('libelle', $title)->first();
      if ($check) {
        return response()->json([
          'status' => 201,
        ]);
      } else {

        $type = new Typevehicule();

        $type->libelle = $request->titre;
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
  public function edittype(Request $request)
  {
    $id = $request->id;
    $type = Typevehicule::find($id);
    return response()->json($type);
  }

  // update an folder ajax request
  public function updatetype(Request $request)
  {
    try {
      $titre = $request->ttitre;
      $check = Typevehicule::where('libelle', $titre)->first();
      if ($check) {
        return response()->json([
          'status' => 201,
        ]);
      } else {

        $type = Typevehicule::find($request->tid);
        if ($type->userid == Auth::id()) {
          $type->libelle = $request->ttitre;
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
  public function deletetype(Request $request)
  {
    try {

      $emp = Typevehicule::find($request->id);
      if ($emp->userid == Auth::id()) {
        $id = $request->id;
        Typevehicule::destroy($id);
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
