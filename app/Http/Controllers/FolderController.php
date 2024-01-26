<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Historique;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function index()
    {
      $title = 'Folder';
      $active = "Dashboard";
      return view(
        'folder.index',
        [
          'title' => $title,
          'active' => $active
        ]
      );
    }
  
    public function fetchAll()
    {
      $folder = Folder::all();
      $output = '';
      if ($folder->count() > 0) {
        $output .= '<table class="table table-striped table-sm fs--1 mb-0">
          <thead>
            <tr>
              <th class="sort border-top ps-3" data-sort="name">#</th>
              <th class="sort border-top ps-3" data-sort="name">Titre</th>
              <th class="sort border-top ps-3" data-sort="name">ACTION</th>
            </tr>
          </thead>
          <tbody class="list">
           ';
        $nombre = 1;
        foreach ($folder as $rs) {
          $output .= '<tr>
              <td class="align-middle ps-3 name">' . $nombre . '</td>
              <td>' . ucfirst($rs->title). '</td>
              <td>
              
                <a href="#" id="' . $rs->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#edit_FolderModal"><i class="bi-pencil-square h4"></i> Edit</a>
                <a href="#" id="' . $rs->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i> Delete </a>
              </td>
            </tr>';
          $nombre++;
        }
        $output .= '</tbody></table>';
        echo $output;
      } else {
        echo '<h3 class="text-center text-secondery my-5" >  No record in the database ! </h3>';
      }
    }
  
    // insert a new folder ajax request
    public function store(Folder $folder,Historique $his, Request $request)
    {

      $function ="Creation";
      $operation ="New folder add : ".$request->ftitle;
      $user = 'Michael ndale';
      $link ='folder ';
      $his->fonction = $function;
      $his->operation = $operation;
      $his->userid = Auth()->user()->id;
      $his->link = $link;
      $his->save();

      $folder->flibelle = $request->ftitle;
      $folder->userid = Auth()->user()->id;
      $folder->save();
      return response()->json([
        'status' => 200,
      ]);
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
      $emp = Folder::find($request->fid);
      $emp->flibelle= $request->flibelle;
      $emp->userid = Auth()->user()->id;
      $emp->update();
      return response()->json([
        'status' => 200,
      ]);
    }
  
    // supresseion
    public function deleteall(Request $request , Historique $his)
    {
      $function ="Suppression";
      $operation ="Supprission  ";
      $link ='folder ';
      $his->fonction = $function;
      $his->operation = $operation;
      $his->userid = Auth()->user()->id;
      $his->link = $link;
      $his->save();

      $id = $request->id;
      Folder::destroy($id);
    }
}