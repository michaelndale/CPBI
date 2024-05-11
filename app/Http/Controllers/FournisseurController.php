<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FournisseurController extends Controller
{
  //Get all Fournisseur
  public function fetchfournisseur()
  {
    $folder = Fournisseur::orderBy('nom', 'ASC')->get();
    $output = '';
    if ($folder->count() > 0) {
      $nombre = 1;
      foreach ($folder as $rs) {
        $output .= '<tr>
                <td class="align-middle ps-3 name">' . $nombre . '</td>
                <td>' . ucfirst($rs->nom) . '</td>
                <td>' . ucfirst($rs->adresse) . '</td>
                <td>' . ucfirst($rs->phone) . '</td>
                <td>' . $rs->email . '</td>
                <td>' . ucfirst($rs->type) . '</td>
                <td>
                <center>
                  <div class="btn-group me-2 mb-2 mb-sm-0">
                    <a  data-bs-toggle="dropdown" aria-expanded="false">
                         <i class="mdi mdi-dots-vertical ms-2"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item text-primary mx-1 editfournisseur" id="' . $rs->id . '"  data-bs-toggle="modal" data-bs-target="#editFournisseurModal" title="Modifier"><i class="far fa-edit"></i> Modifier</a>
                        <a class="dropdown-item text-danger mx-1 deleteFournisseur"  id="' . $rs->id . '"  title="Supprimer"><i class="far fa-trash-alt"></i> Supprimer</a>
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
          <td colspan="8">
          <center>
            <h6 style="margin-top:1% ;color:#c0c0c0"> 
            <center><font size="50px"><i class="fa fa-info-circle"  ></i> </font><br><br>
           Ceci est vide  !</center> </h6>
          </center>
          </td>
          </tr>';
    }
  }

   //Get Select Fournisseur
  public function Selectfournisseur()
  {
    $folder = Fournisseur::orderBy('nom', 'ASC')->get();
    $output = '';

    if ($folder->count() > 0) {
      $output .= '<select > ';
      foreach ($folder as $rs) {
        $output .= '<option value="' . ucfirst($rs->nom) . '" >' . ucfirst($rs->nom) . '</option>';
      }
      $output .= '</select>';
      echo $output;
    }
  }

  //Save Fournisseur request
  public function storefournisseur(Request $request)
  {
    $nom = $request->nom;
    $chek = Fournisseur::where('nom', $nom)->first();
    if ($chek) {
      return response()->json([
        'status' => 202,
      ]);
    } else {
      $fourn = new Fournisseur();
      $fourn->nom = $request->nomF;
      $fourn->adresse = $request->adresseF;
      $fourn->email = $request->emailF;
      $fourn->type = $request->typeF;
      $fourn->phone = $request->phoneF;
      $fourn->userid = Auth::id();
      $fourn->save();

      return response()->json([
        'status' => 200,
      ]);
    }
  }

  // Get Fournisseur request
  public function editfournisseur(Request $request)
  {
    $id = $request->id;
    $fou = Fournisseur::find($id);
    return response()->json($fou);
  }

  // Update Fournisseur ajax request
  public function updatefournisseur(Request $request)
  {
    try {
    

        $Four = Fournisseur::find($request->idFo);
        if ($Four->userid == Auth::id()) {

          $Four->nom = $request->nomFo;
          $Four->adresse = $request->adresseFo;
          $Four->email = $request->emailFo;
          $Four->phone = $request->phoneFo;
          $Four->type = $request->typeFo;
          $Four->update();

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
        'error' => $e->getMessage()
      ]);
    }
  }

 // Delete Fournisseur ajax request
  public function deletefournisseur(Request $request)
  {
    try {
      $emp = Fournisseur::find($request->id);
      if ($emp->userid == Auth::id()) {
        $id = $request->id;
        Fournisseur::destroy($id);
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
