<?php

namespace App\Http\Controllers;

use App\Models\Devise;
use App\Models\Historique;
use App\Models\PaysModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviseController extends Controller
{
    public function index()
    {
      $title = 'Devise';
      $pays = PaysModel::all();
      return view('devise.index',
       [
        'title' => $title,
        'pays'  => $pays
      ]);
    }
  
    public function fetchAll()
    {
      $devise = Devise::orderBy('libelle', 'ASC')->get();
      $output = '';
      if ($devise->count() > 0) {
  
        $nombre = 1;
        foreach ($devise as $rs) {
          $output .= '<tr>
                <td class="align-middle ps-3 name">' . $nombre . '</td>
                <td>' . ucfirst($rs->libelle) . '</td>
                <td>' . ucfirst($rs->pays) . '</td>
                <td>
                    <center>
                        <div class="btn-group me-2 mb-2 mb-sm-0">
                            <a  data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical ms-2"></i>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item  mx-1 editIcon " id="' . $rs->id . '"  data-bs-toggle="modal" data-bs-target="#editdeviseModal" title="Modifier"><i class="far fa-edit"></i> Modifier</a>
                                <a class="dropdown-item text-danger mx-1 deleteIcon"  id="' . $rs->id . '"  data-titre="' . $rs->libelle . '"  href="#"><i class="far fa-trash-alt"></i> Supprimer</a>
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
          <td colspan="5">
          <center>
            <h6 style="margin-top:1% ;color:#c0c0c0"> 
            <center><font size="50px"><i class="fa fa-info-circle"  ></i> </font><br><br>
                Ceci est vide  !</center> </h6>
          </center>
          </td>
          </tr>';
      }
    }
  
    // insert a new devise ajax request
    public function store(Request $request)
    {
      try {
        $title = $request->devise;
        $check = Devise::where('libelle', $title)->first();
        if ($check) {
          return response()->json([
            'status' => 201,
          ]);
        } else {
  
          $devise = new Devise();

          $devise->libelle = $request->devise;
          $devise->pays = $request->pays;
          $devise->userid =  Auth::id();
          $devise->save();

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
  
    // edit an devise ajax request
    public function edit(Request $request)
    {
      $id = $request->id;
      $fon = Devise::find($id);
      return response()->json($fon);
    }
  
    // update an devise ajax request
    public function update(Request $request)
    {
      try {
  
  
        $title = $request->ddevise;
        $check = Devise::where('libelle', $title)->first();
        if ($check) {
          return response()->json([
            'status' => 201,
          ]);
        } else {
  
          $emp = Devise::find($request->iddevise);

          if ($emp->userid == Auth::id()) 
          {
            $emp->pays = $request->dpays;
            $emp->libelle = $request->ddevise;
            $emp->update();
            
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
        ]);
      }
    }
  
    // supresseion
    public function deleteall(Request $request, Historique $his)
    {
      try {
  
        $emp = Devise::find($request->id);
        if ($emp->userid == Auth::id()) {
         
          $id = $request->id;
          Devise::destroy($id);
          
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
