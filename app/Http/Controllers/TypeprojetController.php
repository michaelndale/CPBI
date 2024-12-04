<?php

namespace App\Http\Controllers;

use App\Models\typeprojet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeprojetController extends Controller
{
    public function index()
    {
      $title = 'Type projet';
      return view('typeprojet.index', ['title' => $title]);
    }
  
    public function fetchAll()
    {
      $typeprojet = typeprojet::orderBy('titre', 'ASC')->get();
      $output = '';
      if ($typeprojet->count() > 0) {
  
        $nombre = 1;
        foreach ($typeprojet as $rs) {
          $output .= '<tr>
                <td class="align-middle ps-3 name">' . $nombre . '</td>
                <td>' . ucfirst($rs->titre) . '</td>
                <td>' . date('d-m-Y', strtotime($rs->created_at)) . '</td>
                <td>
                <center>
                  <div class="btn-group me-2 mb-2 mb-sm-0">
                    <a  data-bs-toggle="dropdown" aria-expanded="false">
                         <i class="mdi mdi-dots-vertical ms-2"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item text-primary mx-1 editIcon " id="' . $rs->id . '"  data-bs-toggle="modal" data-bs-target="#edittypeModal" title="Modifier"><i class="far fa-edit"></i> Modifier</a>
                        <a class="dropdown-item text-danger mx-1 deleteIcon"  id="' . $rs->id . '"  href="#"><i class="far fa-trash-alt"></i> Supprimer</a>
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
            <center><font size="50px"><i class="fa fa-info-circle"  ></i> </font><br><br>
           Ceci est vide  !</center> </h6>
          </center>
          </td>
          </tr>';
      }
    }
  
    // insert a new typeprojet ajax request
    public function store(Request $request)
    {
      try {
        $title = $request->titre;
        $check = typeprojet::where('titre', $title)->first();
        if ($check) {
          return response()->json([
            'status' => 201,
          ]);
        } else {
  
          $typeprojet = new typeprojet();
          $typeprojet->titre = $request->titre;
          $typeprojet->userid = Auth()->user()->id;
          $typeprojet->save();
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
  
    // edit an typeprojet ajax request
    public function edit(Request $request)
    {
      $id = $request->id;
      $fon = typeprojet::find($id);
      return response()->json($fon);
    }
  
    // update an typeprojet ajax request
    public function update(Request $request)
    {
      try {
  
  
        $title = $request->titretype;
        $check = typeprojet::where('titre', $title)->first();
        if ($check) {
          return response()->json([
            'status' => 201,
          ]);
        } else {
  
          $emp = typeprojet::find($request->typeid);
          if ($emp->userid == Auth::id()) {
            $emp->titre = $request->titretype;
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
    public function deleteall(Request $request)
    {
      try {
  
        $emp = typeprojet::find($request->id);
        if ($emp->userid == Auth::id()) {
          $id = $request->id;
          typeprojet::destroy($id);
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
