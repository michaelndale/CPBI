<?php

namespace App\Http\Controllers;

use App\Models\Beneficaire;
use App\Models\categoriebeneficiaire;
use App\Models\Historique;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BeneficaireController extends Controller
{
    

    public function index()
    {
      $title = 'Bénéficiaire';
      $caregories = categoriebeneficiaire::all();
      return view('beneficiaire.index', 
        [
          'title' => $title ,
          'caregorie' => $caregories
        ]);
    }
  
    public function fetchAll()
    {
        $databenef = DB::table('beneficaires')
            ->join('categoriebeneficiaires', 'beneficaires.categorieid', '=', 'categoriebeneficiaires.id')
            ->select('beneficaires.*', 'categoriebeneficiaires.titre')
            ->orderBy('categoriebeneficiaires.titre', 'ASC') // Trier par catégorie d'abord
            ->orderBy('beneficaires.libelle', 'ASC') // Puis trier les bénéficiaires
            ->get()
            ->groupBy('titre'); // Grouper les bénéficiaires par catégorie
    
        $output = '';
        if ($databenef->count() > 0) {
            foreach ($databenef as $categorie => $beneficiaires) {
                $output .= '
                    <tr class="bg-light">
                        <td colspan="7" class="fw-bold text-primary">' . ucfirst($categorie) . '</td>
                    </tr>';
    
                $nombre = 1;
                foreach ($beneficiaires as $rs) {
                    $output .= '
                    <tr>
                        <td class="align-middle ps-3 name">' . $nombre . '</td>
                        <td>' . ucfirst($rs->libelle) . '</td>
                        <td>' . ucfirst($rs->adresse) . '</td>
                        <td>' . ucfirst($rs->telephoneone) . '</td>
                        <td>' . ucfirst($rs->telephonedeux) . '</td>
                        <td>' . ucfirst($rs->description) . '</td>
                        <td>
                            <center>
                                <div class="btn-group me-2 mb-2 mb-sm-0">
                                    <a data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical ms-2"></i>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item text-primary mx-1 editIcon" id="' . $rs->id . '" data-bs-toggle="modal" data-bs-target="#editbeneModal" title="Modifier"><i class="far fa-edit"></i> Modifier</a>
                                        <a class="dropdown-item text-danger mx-1 deleteIcon" id="' . $rs->id . '" href="#"><i class="far fa-trash-alt"></i> Supprimer</a>
                                    </div>
                                </div>
                            </center>
                        </td>
                    </tr>';
                    $nombre++;
                }
            }
        } else {
            $output .= '<tr>
                <td colspan="8">
                    <center>
                        <h6 style="margin-top:1%; color:#c0c0c0">
                            <center>
                                <font size="50px"><i class="fa fa-info-circle"></i></font><br><br>
                                Ceci est vide !
                            </center>
                        </h6>
                    </center>
                </td>
            </tr>';
        }
    
        echo $output;
    }
    
    // insert a new ben ajax request
    public function store(Request $request)
    {
      try {
        $title = $request->nom;
        $check = Beneficaire::where('libelle', $title)->first();
        if ($check) {
          return response()->json([
            'status' => 201,
          ]);
        } else {
  
          $ben = new Beneficaire();

          $ben->categorieid = $request->cid;
          $ben->libelle = $request->nom;
          $ben->adresse = $request->adresse;
          $ben->telephoneone = $request->telephoneun;
          $ben->telephonedeux = $request->telephonedeux;
          $ben->description = $request->description;
          $ben->userid =  Auth::id();
          $ben->save();

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
  
    // edit an ben ajax request
    public function edit(Request $request)
    {
      $id = $request->id;

      $fon = DB::table('beneficaires')
          ->join('categoriebeneficiaires', 'beneficaires.categorieid', 'categoriebeneficiaires.id')   
          ->Select('beneficaires.*','beneficaires.id as idb','categoriebeneficiaires.titre','categoriebeneficiaires.id as idc')
          ->Where('beneficaires.id', $id)
          ->first();

      return response()->json($fon);
    }
  
    // update an ben ajax request
    public function update(Request $request)
    {
      try {
  
          $emp = Beneficaire::find($request->bid);

          if ($emp->userid == Auth::id()) 
          {
            $emp->categorieid = $request->cids;
            $emp->libelle = $request->bnom;
            $emp->adresse = $request->badresse;
            $emp->telephoneone = $request->btelephoneun;
            $emp->telephonedeux = $request->btelephonedeux;
            $emp->description = $request->bdescription;
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
  
    // supresseion
    public function deleteall(Request $request, Historique $his)
    {
      try {
  
        $emp = Beneficaire::find($request->id);
        if ($emp->userid == Auth::id()) {
         
          $id = $request->id;
          Beneficaire::destroy($id);
          
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
