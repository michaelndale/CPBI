<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Historique;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
  public function index()
  {
    $title = 'Dossier';
    return view('folder.index', ['title' => $title]);
  }

  public function fetchAll()
  {
    $folder = Folder::orderBy('title', 'ASC')->get();
    $output = '';
    if ($folder->count() > 0) {

      $nombre = 1;
      foreach ($folder as $rs) {
        $output .= '<tr>
              <td class="align-middle ps-3 name">' . $nombre . '</td>
              <td>' . ucfirst($rs->title) . '</td>
              <td>
              <center>
               
                <div class="btn-group me-2 mb-2 mb-sm-0">
                  <a  data-bs-toggle="dropdown" aria-expanded="false">
                       <i class="mdi mdi-dots-vertical ms-2"></i>
                  </a>
                  <div class="dropdown-menu">
                      <a class="dropdown-item text-primary mx-1 editIcon " id="' . $rs->id . '"  data-bs-toggle="modal" data-bs-target="#editFolderModal" title="Modifier"><i class="far fa-edit"></i> Modifier</a>
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
          <center><font size="50px"><i class="far fa-trash-alt"  ></i> </font><br><br>
         Ceci est vide  !</center> </h6>
        </center>
        </td>
        </tr>';
    }
  }

  // insert a new folder ajax request
  public function store(Request $request)
  {
    try {
      $title = $request->ftitle;
      $check = Folder::where('title', $title)->first();
      if ($check) {
        return response()->json([
          'status' => 201,
        ]);
      } else {

        $folder = new Folder();
        $folder->title = $request->ftitle;
        $folder->userid = Auth()->user()->id;
        $folder->save();
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
  public function edit(Request $request)
  {
    $id = $request->id;
    $fon = Folder::find($id);
    return response()->json($fon);
  }

  // update an folder ajax request
  public function update(Request $request)
  {
    try {


      $title = $request->flibelle;
      $check = Folder::where('title', $title)->first();
      if ($check) {
        return response()->json([
          'status' => 201,
        ]);
      } else {

        $emp = Folder::find($request->fid);
        if ($emp->userid == Auth::id()) {
          $emp->title = $request->flibelle;
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

      $emp = Folder::find($request->id);
      if ($emp->userid == Auth::id()) {
        $id = $request->id;
        Folder::destroy($id);
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
