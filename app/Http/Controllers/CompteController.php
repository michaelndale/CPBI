<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\Rallongebudget;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompteController extends Controller
{
  public function index()
  {
    // Vérifie si l'ID de projet existe dans la session
    if (!session()->has('id')) {
      // Redirige vers le tableau de bord si l'ID de projet n'existe pas dans la session
      return redirect()->route('dashboard')->with('error', 'ID de projet non trouvé dans la session.');
    }

    // Récupère l'ID de projet depuis la session
    $ID = session()->get('id');

    // Définit les variables pour le titre de la page et l'onglet actif
    $active = 'Project';
    $title = 'Compte & Ligne';

    // Récupère tous les comptes dont le compteid est 0 et le projetid est égal à l'ID de session
    $compte = Compte::where('compteid', 0)
      ->where('projetid', $ID)
      ->get();

    // Retourne la vue avec les données nécessaires
    return view('compteligne.index', [
      'title' => $title,
      'active' => $active,
      'compte' => $compte,
    ]);
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
    $services = Compte::where('compteid', 0)
      ->where('projetid', $ID)
      ->get();

    $output = '';
    $nombre = 1;

    if ($services->count() > 0) {
      foreach ($services as $rs) {
        $output .= '<tr style="background-color:#F5F5F5">
                  <td class="align-middle ps-3 name"><b>' . $nombre . '</b></td>
                  <td><b>' . ucfirst($rs->numero) . '</b></td>
                  <td><b>' . ucfirst($rs->libelle) . '</b></td>
                  <td align="center" style="width:13%">
                  <div class="btn-group me-2 mb-2 mb-sm-0">
                      <a  data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="mdi mdi-dots-vertical ms-2"></i>
                      </a>
                      <div class="dropdown-menu">
                          <a class="dropdown-item text-primary mx-1 savesc" id="' . $rs->id . '"  data-bs-toggle="modal" data-bs-target="#addDealModalSousCompte" title="Modifier le compte"><i class="fa fa-plus-circle"></i> Ajouter une sous ligne</a>
                          <a class="dropdown-item text-primary mx-1 editsc" id="' . $rs->id . '"  data-bs-toggle="modal" data-bs-target="#EditModalSousCompte" title="Ajouter sous compte"><i class="far fa-edit"></i> Modifier la ligne</a>
                          <a class="dropdown-item text-danger mx-1 deleteIcon"  id="' . $rs->id . '"  href="#" title="Supprimer le compte"><i class="far fa-trash-alt"></i> Supprimer la ligne</a>
                      </div>
                  </div>
                  </td>
              </tr>';

        $sous_comptes = Compte::where('compteid', $rs->id)
          ->where('souscompteid', 0)
          ->where('projetid', $ID)
          ->get();

        $ndale = 1;
        foreach ($sous_comptes as $sc) {
          $output .= '<tr>
                      <td class="align-left" style="background-color:#F5F5F5"></td>
                      <td>' . ucfirst($sc->numero) . '</td>
                      <td>' . ucfirst($sc->libelle) . '</td>
                      <td align="center">
                      <div class="btn-group me-2 mb-2 mb-sm-0">
                          <a  data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="mdi mdi-dots-vertical ms-2"></i>
                          </a>
                          <div class="dropdown-menu">
                              <a class="dropdown-item text-primary mx-1 editsc" id="' . $sc->id . '"  data-bs-toggle="modal" data-bs-target="#EditModalSousCompte" title="Ajouter sous compte"><i class="far fa-edit"></i> Modifier la ligne</a>
                              <a class="dropdown-item text-danger mx-1 deleteIcon"  id="'.$sc->id.'"  href="#" title="Supprimer le compte"><i class="far fa-trash-alt"></i> Supprimer la ligne</a>
                          </div>
                      </div>
                      </td>
                  </tr>';

          $sous_sous_comptes = Compte::where('souscompteid', $sc->id)
            ->where('projetid', $ID)
            ->get();

          $nd = 1;
          foreach ($sous_sous_comptes as $ssc) {
            $output .= '<tr>
                          <td class="align-middle ps-3 name">' . $nombre . '.' . $ndale . '.' . $nd . '</td>
                          <td>' . ucfirst($ssc->numero) . '</td>
                          <td>' . ucfirst($ssc->libelle) . '</td>
                          <td>
                              <center>
                                  <a href="#" id="' . $ssc->id . '" class="text-success mx-1 ssavesc" data-bs-toggle="modal" data-bs-target="#addssousDealModal"><i class="fa fa-plus-circle"></i></a>
                                  <a href="#" id="' . $ssc->id . '" class="text-info mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editcompteModal"><i class="fa fa-edit"></i></a>
                                  <a href="#" id="' . $ssc->id . '" class="text-danger mx-1 deleteIcon"><i class="fa fa-trash"></i></a>
                              </center>
                          </td>
                      </tr>';
            $nd++;
          }
          $ndale++;
        }
        $nombre++;
      }
    } else {
      $output .= '<tr>
              <td colspan="4">
                  <center>
                      <h6 style="margin-top:1%; color:#c0c0c0"> 
                          <center><font size="50px"><i class="far fa-trash-alt"></i></font><br><br>
                          Ceci est vide !
                      </center>
                  </h6>
              </center>
              </td>
          </tr>';
    }

    echo $output;
  }

  // Insert a new ligne budgetaire ajax request
  public function store(Compte $gc, Request $request)
  {
    try {
      $ID = session()->get('id');
      $title = $request->libelle;
      $code = $request->code;
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
      $code = $request->code;
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

  public function updatecompte(Request $request)
  {
    try {

      $emp = Compte::find($request->cidedit);
      if ($emp->userid == Auth::id()) {

        $emp->libelle = $request->ctitleedit;
        $emp->numero = $request->ccodeedit;

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

        Rallongebudget::where('souscompte', $id)->delete();

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
