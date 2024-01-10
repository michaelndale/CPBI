<?php

namespace App\Http\Controllers;

use App\Models\Classeur;
use App\Models\Lettreexpediction;
use Exception;
use Illuminate\Http\Request;

class ArchivageController extends Controller
{
    public function index()
    {
      $title = 'Archivage';
      $active = 'Archivage';
      $classeur = Classeur::all();
      return view(
        'archive.index',
        [
          'title' => $title,
          'active' => $active,
          'classeur' => $classeur
        ]
      );
    }
    public function getarchive(Request $request)
    {
      $id = $request->id;
      $resul =  Lettreexpediction::where('classeurid',$id)->orderBy('id', 'DESC')->get(); 
      $output = '';
      if ($resul->count() > 0) {
        $output .= '
        <table>
        <td><input type="checkbox" > Tout achicher | </td>
        <td>Nombre de lignes 
        <select >
          <option>25</option>
          <option>50</option>
          <option>100</option>
          <option>250</option>
          <option>500</option>
          <option>100</option>
        </select>
        </td>
        <td> | Filtrer les lignes  <input type="text" class="form"> </td>
        </table>
        <br>
        <table class="table table-striped table-sm fs--1 mb-0">
            <thead>
            <tr>
              <th class="align-middle ps-3 name">#</th>
              <th >Num</th>
              <th >Num lettre</th>
              <th >Date lettre</th>
              <th >Date destinateur</th>
              <th >Destinateur</th>
              <th><center>ACTION</center></th>
            </tr>
          </thead>
          <tbody class="list">
           ';
        $nombre = 1;
        foreach ($resul as $rs) {
          $output .= '<tr>
              <td class="align-middle ps-3 name">' . $nombre . '</td>
              <td>' . ucfirst($rs->numerogenerale	). '</td>
              <td>' . ucfirst($rs->numeolettre	). '</td>
              <td>' . ucfirst($rs->datelettre	). '</td>
              <td>' . ucfirst($rs->dateexpedition	). '</td>
              <td>' . ucfirst($rs->destinateur	). '</td>
              
              <td>
  
              <center>
              <a href="#" id="' . $rs->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editModal" title="Modifier" ><i class="far fa-edit"></i> </a>
              <a href="#" id="' . $rs->id . '" class="text-danger mx-1 deleteIcon" title="Supprimer"><i class="far fa-trash-alt"></i></a>
            </center>
              
               
              </td>
            </tr>';
          $nombre++;
        }
        $output .= '</tbody></table>';
        echo $output;
      } else {
        echo '<h4 class="text-center text-secondery my-5" > Aucun données pour cette classeur ! </h4>';
      }

      
      //return response()->json($fon);
    }

    public function storeexpediction(Request $request)
    {
  
      try {
        
        $title = $request->numerolettre;
        $check = Lettreexpediction::where('numeolettre',$title)->first();
  
        if($check){
          return response()->json([
            'status' => 201,
          ]);
        }else{
          $lettre = new Lettreexpediction();
          $lettre->classeurid= $request->classeur;
          $lettre->numerogenerale= $request->numerogenerale;
          $lettre->numeolettre= $request->numerolettre;
          $lettre->datelettre= $request->datelettre;
          $lettre->dateexpedition= $request->dateexpiration;
          $lettre->destinateur= $request->destinateur;
          $lettre->note= $request->note;
          $lettre->userid = Auth()->user()->id;

          $lettre->save();
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
    
}
