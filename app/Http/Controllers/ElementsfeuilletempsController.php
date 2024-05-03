<?php

namespace App\Http\Controllers;

use App\Models\elementsfeuilletemps;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ElementsfeuilletempsController extends Controller
{
    public function eindex()
  {
    $title = 'Element Feuille de temps';
    return view('feuilletemps.eft', ['title' => $title]);
  }

  public function fetchAllft()
  {
    $eft = elementsfeuilletemps::all();
    $output = '';
    if ($eft->count() > 0) {

      $nombre = 1;
      foreach ($eft as $rs) {
        $output .= '<tr>
              <td class="align-middle ps-3 name">' . $nombre . '</td>
              <td>' . $rs->tempsmoyennne . '</td>
              <td>' . $rs->tempstotal . '</td>
              <td>
              <center>
              <a class="editIcon " id="' . $rs->id . '"  data-bs-toggle="modal" data-bs-target="#editelementsfeuilletempsModal" title="Modifier"><i class="far fa-edit"></i> Modifier</a>
                </center>
              </td>
            </tr>';
        $nombre++;
      }

      echo $output;
    } else {
      echo ' <tr>
        <td colspan="4">
        <center>
          <h6 style="margin-top:1% ;color:#c0c0c0"> 
          <center><font size="50px"><i class="fa fa-info-circle"  ></i> </font><br><br>
         Ceci est vide  !</center> </h6>
        </center>
        </td>
        </tr>';
    }
  }

  // insert a new eft ajax request
  public function storeft(Request $request)
  {
    try {
     
        $eft = new elementsfeuilletemps();

        $eft->tempstotal = $request->tempstotal;
        $eft->tempsmoyennne = $request->tempsmoyennne;
        $eft->userid = Auth::id();
        $eft->save();

        return response()->json([
          'status' => 200,
        ]);
      
    } catch (Exception $e) {
      return response()->json([
        'status' => 202,
      ]);
    }
  }

  // edit an eft ajax request
  public function editf(Request $request)
  {
    $id = $request->id;
    $fon = elementsfeuilletemps::find($id);
    return response()->json($fon);
  }

  // update an eft ajax request
  public function sefl(Request $request)
  {
    try {
        $emp = elementsfeuilletemps::find($request->tid);

        if ($emp->userid == Auth::id()) {

        $emp->tempstotal = $request->etempstotal;
        $emp->tempsmoyennne = $request->etempsmoyennne;

          $emp->update();
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
