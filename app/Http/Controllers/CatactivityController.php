<?php

namespace App\Http\Controllers;

use App\Models\Catactivity;
use App\Models\Historique;
use Exception;
use Illuminate\Http\Request;

class CatactivityController extends Controller
{
    public function cat()
    {
      $title = 'Category';
      $active = 'Activity';
      return view(
        'activite.cat',
        [
          'title' => $title,
          'active' => $active
        ]
      );
    }
  
    public function fetchAll()
    {
      $cat = Catactivity::all();
      $output = '';
      if ($cat->count() > 0) {
        $output .= '<table class="table table-striped table-sm fs--1 mb-0">
          <thead>
            <tr>
              <th class="sort border-top ps-3" data-sort="name">#</th>
              <th class="sort border-top ps-3" data-sort="name">Title</th>
              <th class="sort border-top ps-3" data-sort="name">ACTION</th>
            </tr>
          </thead>
          <tbody class="list">
           ';
        $nombre = 1;
        foreach ($cat as $rs) {
          $output .= '<tr>
              <td class="align-middle ps-3 name">' . $nombre . '</td>
              <td>' . ucfirst($rs->libelle). '</td>
              <td>
             
             
                <center>
                <a href="#" id="' . $rs->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#edit_catModal" title="Modifier" ><i class="far fa-edit"></i> </a>
                <a href="#" id="' . $rs->id . '" class="text-danger mx-1 deleteIcon" title="Supprimer"><i class="far fa-trash-alt"></i></a>
                  </center>
             
                </td>
            </tr>';
          $nombre++;
        }
        $output .= '</tbody></table>';
        echo $output;
      } else {
        echo '<h4 class="text-center text-secondery my-5" >  Aucun enregistrement dans la base de données ! </h4>';
      }
    }
  
    // insert a new cat ajax request
    public function store(Request $request)
    {
      try {
     

      $cat = new Catactivity();
      $cat->libelle = $request->title;
      $cat->userid = Auth()->user()->id;
      $cat->save();

        $function ="Creation";
        $operation ="New category add : ".$request->title;
     
     
        $his = new Historique();
        $function ="Creation";
        $operation ="Nouveau categoroe ".$request->title;
        $link ='categorie';
        $his->fonction = $function;
        $his->operation = $operation;
        $his->link = $link;
        $his->userid = Auth()->user()->id;
        $his->save();

      
      return response()->json([
        'status' => 200,
      ]);
    } catch (Exception $e) {
       
      return response()->json([
        'status' => 202,
      ]);
    }
    }
  
    // edit an cat ajax request
    public function edit(Request $request)
    {
      $id = $request->id;
      $fon = Catactivity::find($id);
      return response()->json($fon);
    }
  
    // update an cat ajax request
    public function update(Request $request)
    {
      $emp = Catactivity::find($request->ser_id);
      $emp->libelle = $request->libelle;
      $emp->update();
      
      return response()->json([
        'status' => 200,
      ]);
    }
  
    // supresseion
    public function deleteall(Request $request, Historique $his)
    {
      $function ="Delete";
      $operation ="Delete category ";
      $user = 'Michael ndale';
      $link ='history';
      $his->function = $function;
      $his->operation = $operation;
      $his->user = $user;
      $his->link = $link;
      $his->save();

      $id = $request->id;
      Catactivity::destroy($id);
    }
}
