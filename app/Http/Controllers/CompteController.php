<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompteController extends Controller
{
  public function index()
  {
    $ID = session()->get('id');
    $active = 'Project';
    $title = 'Compte & Ligne';
    $compte = Compte::where('compteid', '=', 0)
      ->where('projetid', $ID)
      ->get();
    return view(
      'compteligne.index',
      [
        'title' => $title,
        'active' => $active,
        'compte' => $compte
      ]
    );
  }

  public function selectcompte()
  {
    $ID = session()->get('id');
    $service = Compte::where('compteid', '=', 0)
      ->where('projetid', $ID)
      ->get();
    $output = '';
    if ($service->count() > 0) {

      $output .= ' <select class="form-select" id="compteid" name="compteid">
       <option value="">Aucun</option>';
      foreach ($service as $rs) {
        $output .=
          '
              <option value="' . $rs->id . '" >' . ucfirst($rs->gc_libelle) . '</option>
            ';
      }
      $output .= ' </select>';
      echo $output;
    } else {
      echo ' <tr>
                <td colspan="4">
                <center>
                  <h6 style="margin-top:1% ;color:#c0c0c0"> 
                  <center><font size="50px"><i class="far fa-trash-alt"  ></i> </font><br><br>
                Ceci est vide  !</center> </h6>
                </center>
                </td>
                </tr>
             ';
    }
  }

  public function sousselectcompte()
  {

    $ID = session()->get('id');
    $service = Compte::where('compteid', '!=', '0')
      ->where('projetid', $ID)
      ->get();;
    $output = '';
    if ($service->count() > 0) {

      $output .= '<select class="form-select" id="souscompteid" name="souscompteid">
       <option value="">Aucun</option>';
      foreach ($service as $rs) {
        $output .= '
            <option value="' . $rs->id . '" >' . ucfirst($rs->libelle) . '</option>
            ';
      }
      $output .= ' </select>';
      echo $output;
    } else {
      echo '<h3 class="text-center text-secondery my-5" > Aucun enregistrement dans la base de données ! </h3>';
    }
  }


  public function fetchAll()
  {
    $ID = session()->get('id');
    $service = Compte::where('compteid', '=', 0)
      ->where('projetid', $ID)
      ->get();
    $output = '';
    if ($service->count() > 0) {

      $nombre = 1;
      foreach ($service as $rs) {
        $id = $rs->id;
        $output .= '<tr style="background-color:#F5F5F5">
              <td class="align-middle ps-3 name"><b>' . $nombre . '</td>
              <td><b>' . ucfirst($rs->numero) . '</b></td>
              <td><b>' . ucfirst($rs->libelle) . '</b></td>
              <td align="center" style="width:13%">
             
              <a href="#" id="' . $rs->id . '" class="text-success mx-1 savesc" data-bs-toggle="modal" data-bs-target="#addDealModalSousCompte" title="Ajouter sous compte"><i class="fa fa-plus-circle"></i></a>
              
                <a href="#" id="' . $rs->id . '" class="text-danger mx-1 deleteIcon" title="Supprimer le compte"><i class="fa fa-trash"></i>  </a>
               
                </td>
            </tr>
            ';

//            <a href="#" id="' . $rs->id . '" class="text-info mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editcompteModal" title="modifier le compte"><i class="bi-pencil-square h4"></i><i class="fa fa-edit"></i>  </a>

        $sous_compte = Compte::where('compteid', $id)
          ->where('souscompteid', '=', 0)
          ->where('projetid', $ID)
          ->get();
        if ($sous_compte->count() > 0) {
          $ndale = 1;
          foreach ($sous_compte as $sc) {
            $ids = $sc->id;

            // <a href="#" id="' . $sc->id . '" class="text-success mx-1 ssavesc" data-bs-toggle="modal" data-bs-target="#addssousDealModal"><i class="fa fa-plus-circle"></i> </a>
            $output .= '
                  <tr>
                    <td class="align-left" style="background-color:#F5F5F5"></td>
                    <td>' . ucfirst($sc->numero) . '</td>
                    <td>' . ucfirst($sc->libelle) . '</td>
                    <td align="center">
                   
                        
                        
                        <a href="#" id="' . $sc->id . '" class="text-danger mx-1 deleteIcon"><i class="fa fa-trash"></i>  </a>
                    
                        </td>
                  </tr>
            ';
            $ndale++;
          }


          $sous_sous_compte = Compte::where('souscompteid', $ids)
            ->where('projetid', $ID)
            ->get();
          if ($sous_sous_compte->count() > 0) {
            $nd = 1;
            foreach ($sous_sous_compte as $ssc) {
              $output .= '
                <tr>
                  <td class="align-middle ps-3 name">' . $nombre . '.' . $ndale . '.' . $nd . '</td>
                  <td>' . ucfirst($ssc->numero) . '</td>
                  <td>' . ucfirst($ssc->libelle) . '</td>
                  <td>
                    <center>
                    <a href="#" id="' . $ssc->id . '" class="text-success mx-1 ssavesc" data-bs-toggle="modal" data-bs-target="#addssousDealModal"><i class="fa fa-plus-circle"></i> </a>
                    <a href="#" id="' . $ssc->id . '" class="text-info mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editcompteModal"><i class="bi-pencil-square h4"></i><i class="fa fa-edit"></i>  </a>
                    <a href="#" id="' . $ssc->id . '" class="text-danger mx-1 deleteIcon"><i class="fa fa-trash"></i> </a>
                    </center>
                     </td>
                </tr>
          ';
              $nd++;
            }
          }
        }





        $nombre++;
      }

      echo $output;
    } else {
      echo ' <tr>
                <td colspan="4">
                <center>
                  <h6 style="margin-top:1% ;color:#c0c0c0"> 
                  <center><font size="50px"><i class="far fa-trash-alt"  ></i> </font><br><br>
                Ceci est vide  !</center> </h6>
                </center>
                </td>
                </tr>
             ';
    }
  }

  // Insert a new ligne budgetaire ajax request
  public function store(Compte $gc, Request $request)
  {
    try {
      $ID = session()->get('id');
      $title = $request->libelle;
      $code= $request->code;
      $check = Compte::where('libelle', $title)
        ->where('numero', $code)
        ->where('projetid', $ID)
        ->first();
      if ($check) {
        return response()->json([
          'status' => 201,
        ]);
      } else {
        $gc = new Compte();

        $gc->projetid = $request->projetid;
        $gc->numero = $request->code;
        $gc->libelle = $request->libelle;
        $gc->userid = Auth()->user()->id;

        $gc->save();
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

  public function storesc(Request $request)
  {

    try {
      $ID = session()->get('id');
      $title = $request->libelle;
      $code= $request->code;
      $check = Compte::where('libelle', $title)
        ->where('numero', $code)
        ->where('projetid', $ID)
        ->first();
      if ($check) {
        return response()->json([
          'status' => 201,
        ]);
      } else {

        $gl = new Compte();
        $gl->projetid = $request->projetid;
        $gl->compteid = $request->cid;
        $gl->numero = $request->code;
        $gl->libelle = $request->libelle;
        $gl->userid = Auth()->user()->id;
        $gl->save();

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

  public function storessc(Compte $gl, Request $request)
  {
    $gl = new Compte();
    $gl->projetid = $request->projetid;
    $gl->compteid = $request->scid;
    $gl->souscompteid = $request->sscid;
    $gl->numero = $request->code;
    $gl->libelle = $request->libelle;
    $gl->userid = Auth()->user()->id;
    $gl->save();
    return response()->json([
      'status' => 200,
    ]);
  }

  // edit an service ajax request
  public function edit(Request $request)
  {
    $id = $request->id;
    $fon = Compte::find($id);
    return response()->json($fon);
  }

  // edit an service ajax request
  public function addsc(Request $request)
  {
    $id = $request->id;
    $fon = Compte::find($id);
    return response()->json($fon);
  }



  // update an service ajax request
  public function update(Request $request)
  {
    try {

      $emp = Compte::find($request->gc_id);
      if ($emp->userid == Auth::id()) {

    
    $emp->gc_title = $request->gc_title;
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
  public function deleteall(Request $request)
  {
    try {
      $id = $request->id;
      $emp = Compte::find($id);
      if ($emp->userid == Auth::id()) {

       
        Compte::destroy($id);
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
