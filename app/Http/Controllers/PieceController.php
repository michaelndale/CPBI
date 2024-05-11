<?php

namespace App\Http\Controllers;

use App\Models\Piece;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PieceController extends Controller
{
  // Liste
  public function allpiece()
  {
    $folder = Piece::orderBy('nom', 'ASC')->get();
    $output = '';
    if ($folder->count() > 0) {
      $nombre = 1;
      foreach ($folder as $rs) {
        $output .= '<tr>
                <td class="align-middle ps-3 name">' . $nombre . '</td>
                <td>' . ucfirst($rs->nom) . '</td>
              
                <td>' . ucfirst($rs->numero) . '</td>
                <td>' . ucfirst($rs->fournisseurid) . '</td>
                <td>' . $rs->prix . '</td>
                <td>' . $rs->dateprix . '</td>
                <td>' . $rs->constructeur . '</td>
                <td>
                <center>
                  <div class="btn-group me-2 mb-2 mb-sm-0">
                    <a  data-bs-toggle="dropdown" aria-expanded="false">
                         <i class="mdi mdi-dots-vertical ms-2"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item text-primary mx-1 editpiece" id="' . $rs->id . '"  data-bs-toggle="modal" data-bs-target="#editpieceModal" title="Modifier"><i class="far fa-edit"></i> Modifier</a>
                        <a class="dropdown-item text-danger mx-1 deletePiece"  id="' . $rs->id . '"  title="Supprimer"><i class="far fa-trash-alt"></i> Supprimer</a>
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

  // Enregistrement
  public function storepiece(Request $request)
  {
    $nom = $request->nomP;
    $chek = Piece::where('nom', $nom)->first();
    if ($chek) {
      return response()->json([
        'status' => 202,
      ]);
    } else {
      $piece = new Piece();
      $piece->fournisseurid = $request->fournisseurP;
      $piece->nom = $request->nomP;
      $piece->constructeur = $request->constructeurP;
      $piece->numero = $request->numeroP;
      $piece->prix = $request->prixP;
      $piece->dateprix = $request->dateprixP;
      $piece->userid = Auth::id();
      $piece->save();

      return response()->json([
        'status' => 200,
      ]);
    }
  }

  // Get Piece request
  public function editpiece(Request $request)
  {
    $id = $request->id;
    $fou = Piece::find($id);
    return response()->json($fou);
  }

  // Update Fournisseur ajax request
  public function updatepiece(Request $request)
  {
    try {


      $piece = Piece::find($request->ippi);
      if ($piece->userid == Auth::id()) {

        $piece->fournisseurid = $request->fournisseurPi;
        $piece->nom = $request->nomPi;
        $piece->constructeur = $request->constructeurPi;
        $piece->numero = $request->numeroPi;
        $piece->prix = $request->prixPi;
        $piece->dateprix = $request->dateprixPi;

        $piece->update();

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

  // Supresseion
  public function deletepiece(Request $request)
  {
    try {
      $emp = Piece::find($request->id);
      if ($emp->userid == Auth::id()) {
        $id = $request->id;
        Piece::destroy($id);
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
