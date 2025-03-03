<?php

namespace App\Http\Controllers;

use App\Models\categoriebeneficiaire;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriebeneficiaireController extends Controller
{
  
    public function allcategoriebeneficiaire()
    {
      $categorie = categoriebeneficiaire::orderBy('titre', 'ASC')->get();
      $output = '';
      if ($categorie->count() > 0) {
  
        $nombre = 1;
        foreach ($categorie as $rs) {
          $output .= '<tr>
                <td>' . $nombre . '</td>
                <td>' . ucfirst($rs->titre) . '</td>
                <td>' .date('d-m-Y', strtotime($rs->created_at)).  '</td>
                <td>
              
                  <div class="btn-group me-2 mb-2 mb-sm-0">
                    <a  data-bs-toggle="dropdown" aria-expanded="false">
                         <i class="mdi mdi-dots-vertical ms-2"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item text-primary mx-1 editCategorie" id="' . $rs->id . '"  data-bs-toggle="modal" data-bs-target="#editcatModal" title="Modifier"><i class="far fa-edit"></i> Modifier</a>
                        <a class="dropdown-item text-danger mx-1 deletecategorie"  id="' . $rs->id . '"  href="#"><i class="far fa-trash-alt"></i> Supprimer</a>
                    </div>
                 </div>
                
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


    public function  selectcategorie()
    {
      $categorie = categoriebeneficiaire::orderBy('titre', 'ASC')->get();
      $output = '';
      $output.='<option> Séléctionner catégorie </option>';
      if ($categorie->count() > 0) {
  
        $nombre = 1;
        foreach ($categorie as $rs) {
          $output .= '
          <option value="'.$rs->id.'"> '.$rs->titre.' </option>
                    ';
          $nombre++;
        }
  
        echo $output;
      } else {
        echo '<option> Ceci est vide </option>';
      }
    }

   
  
    // insert a new categorie ajax request
    public function storecategorie(Request $request)
    {
      try {
        $title = $request->titre;
        $check =categoriebeneficiaire::where('titre', $title)->first();
        if ($check) {
          return response()->json([
            'status' => 201,
          ]);
        } else {
  
          $categorie = new categoriebeneficiaire();
          $categorie->titre = $request->titre;
          $categorie->userid = Auth()->user()->id;
          $categorie->save();
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
  
    // edit an categorie ajax request
    public function edit(Request $request)
    {
      $id = $request->id;
      $fon = categoriebeneficiaire::find($id);
      return response()->json($fon);
    }
  
    // update an categorie ajax request
    public function updatecate(Request $request)
    {
      try {
  
  
        $title = $request->ctitre;
        $check = categoriebeneficiaire::where('titre', $title)->first();
        if ($check) {
          return response()->json([
            'status' => 201,
          ]);
        } else {
  
          $emp = categoriebeneficiaire::find($request->catid);
          if ($emp->userid == Auth::id()) {
            $emp->titre = $request->ctitre;
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
    public function deletecategorie(Request $request)
    {
      try {
  
        $emp = categoriebeneficiaire::find($request->id);
        if ($emp->userid == Auth::id()) {
          $id = $request->id;
          categoriebeneficiaire::destroy($id);
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
