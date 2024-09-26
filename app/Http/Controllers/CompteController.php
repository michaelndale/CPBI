<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Bonpetitcaisse;
use App\Models\Compte;
use App\Models\Coutbudget;
use App\Models\Elementboncaisse;
use App\Models\Elementdap;
use App\Models\Elementdjas;
use App\Models\Elementfeb;
use App\Models\Feb;
use App\Models\Rallongebudget;
use App\Models\typeprojet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

      $typebudget = typeprojet::all();
      $coutbudget = Coutbudget::all();

    // Retourne la vue avec les données nécessaires
    return view('compteligne.index', [
      'title' => $title,
      'active' => $active,
      'compte' => $compte,
      'typebudget' => $typebudget,
      'coutbudget' =>  $coutbudget
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
    ->join('users', 'comptes.userid', '=', 'users.id')
    ->join('personnels', 'users.personnelid', '=', 'personnels.id')
    ->leftJoin('coutbudgets', 'comptes.cle_cout', '=', 'coutbudgets.id')
    ->leftJoin('typeprojets', 'comptes.cle_type_projet', '=', 'typeprojets.id')
    ->select('comptes.*', 'personnels.prenom as personnel_prenom' , 'coutbudgets.titre as titre_cout' , 'typeprojets.titre as titre_type')
    ->get();

    $output = '';
    $nombre = 1;

    if ($services->count() > 0) {
      foreach ($services as $rs) {
        $output .= '<tr style="background-color:#F5F5F5">
               
                  <td><b>' . ucfirst($rs->numero) . '</b></td>
                  <td><b>' . ucfirst($rs->libelle) . '</b></td>
                  <td>' . ucfirst($rs->titre_type) . '</td>
                  <td>' . ucfirst($rs->titre_cout) . '</td>
                  <td>' . ucfirst($rs->personnel_prenom) . '</td>
                  <td>' . date('d-m-Y', strtotime($rs->created_at)) . '</td>
                  <td align="center" style="width:13%">
                  <div class="btn-group me-2 mb-2 mb-sm-0">
                      <a  data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="mdi mdi-dots-vertical ms-2"></i>
                      </a>
                      <div class="dropdown-menu">
                          <a class="dropdown-item  mx-1 savesc" id="' . $rs->id . '"  data-bs-toggle="modal" data-bs-target="#addDealModalSousCompte" title="Ajouter une sous ligne"><i class="fa fa-plus-circle"></i> Ajouter une sous ligne</a>
                          <a class="dropdown-item  mx-1 editGrand" id="' . $rs->id . '"  data-bs-toggle="modal" data-bs-target="#modifierLigneModal" title="Modifier le compte"><i class="far fa-edit"></i> Modifier la ligne</a>
                          <a class="dropdown-item text-danger mx-1 deleteIcon"  id="' . $rs->id . '"  href="#" title="Supprimer le compte"><i class="far fa-trash-alt"></i> Supprimer la ligne</a>
                      </div>
                  </div>
                  </td>
              </tr>';

              $sous_comptes = Compte::where('compteid', $rs->id)
              ->where('souscompteid', 0)
              ->where('projetid', $ID)
              ->join('users', 'comptes.userid', '=', 'users.id')
              ->join('personnels', 'users.personnelid', '=', 'personnels.id')
              ->leftJoin('coutbudgets', 'comptes.cle_cout', '=', 'coutbudgets.id')
              ->leftJoin('typeprojets', 'comptes.cle_type_projet', '=', 'typeprojets.id')
              ->select('comptes.*', 'personnels.prenom as personnel_prenom' , 'coutbudgets.titre as titre_cout' , 'typeprojets.titre as titre_type')
              ->get();
          

        $ndale = 1;
        foreach ($sous_comptes as $sc) {
          $output .= '<tr>
                     
                      <td>' . ucfirst($sc->numero) . '</td>
                      <td>' . ucfirst($sc->libelle) . '</td>
                      <td>' . ucfirst($sc->titre_type) . '</td>
                      <td>' . ucfirst($sc->titre_cout) . '</td>
                      <td>' . ucfirst($sc->personnel_prenom) . '</td>
                      <td>' . date('d-m-Y', strtotime($rs->created_at)) . '</td>
                      <td align="center">
                      <div class="btn-group me-2 mb-2 mb-sm-0">
                          <a  data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="mdi mdi-dots-vertical ms-2"></i>
                          </a>
                          <div class="dropdown-menu">
                              <a class="dropdown-item  mx-1 editsc" id="' . $sc->id . '"  data-bs-toggle="modal" data-bs-target="#EditModalSousCompte" title="Ajouter sous compte"><i class="far fa-edit"></i> Modifier la ligne</a>
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
                          <td><b>' . ucfirst($ssc->personnel_prenom) . '</b></td>
                          <td>' . date('d-m-Y', strtotime($ssc->created_at)) . '</td>
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
              <td colspan="7">
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
        $gc->cle_type_projet	 = $request->type_projet;
        $gc->cle_cout = $request->type_cout;
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
      } else 
      
      {

        $gl = new Compte();
        $gl->projetid = $request->projetid;
        $gl->compteid = $request->cid;
        $gl->numero = $request->code;
        $gl->libelle = $request->libelle;
        $gl->cle_type_projet	 = $request->scle_type_projet;
        $gl->cle_cout = $request->scle_cout;
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
    $fon = Compte::leftJoin('coutbudgets', 'comptes.cle_cout', '=', 'coutbudgets.id')
                    ->leftJoin('typeprojets', 'comptes.cle_type_projet', '=', 'typeprojets.id')
                    ->select('comptes.*', 'coutbudgets.id as cid', 'coutbudgets.titre as titre_cout', 'typeprojets.id as tid' , 'typeprojets.titre as titre_type')
                    ->find($id);
  
      if (!$fon) {
          return response()->json(['error' => 'Compte non trouvé'], 404);
      }
    return response()->json($fon);
  }

  public function addscr(Request $request)
  {
      // Récupération du compte avec la jointure left join sur coutbudgets et typeprojets
      $id = $request->id;
      $fon = Compte::leftJoin('coutbudgets', 'comptes.cle_cout', '=', 'coutbudgets.id')
                    ->leftJoin('typeprojets', 'comptes.cle_type_projet', '=', 'typeprojets.id')
                    ->select('comptes.*', 'coutbudgets.id as cid', 'coutbudgets.titre as titre_cout', 'typeprojets.id as tid' , 'typeprojets.titre as titre_type')
                    ->find($id);
  
      if (!$fon) {
          return response()->json(['error' => 'Compte non trouvé'], 404);
      }
  
      // Retourne les données du compte avec les informations de coutbudgets et typeprojets
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
        $emp->cle_cout = $request->type_cout_budget;

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

  public function updateGrandcompte(Request $request)
  {
    try {

      $emp = Compte::find($request->idgl);
      if ($emp->userid == Auth::id()) {
          $emp->numero = $request->numero_gl;
          $emp->libelle = $request->libelle_gr;
          $emp->cle_type_projet= $request->typeprojet;
          $emp->cle_cout= $request->coutbudget;
          $emp->update();

          if($emp) {
            $elements = Compte::where('compteid', '=', $request->idgl)->get();
            foreach ($elements as $element) {
              $element->cle_type_projet= $request->typeprojet;
              $element->cle_cout= $request->coutbudget;
              $element->update();
            }
    
            
          }

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
      DB::beginTransaction();
      try {
        $id = $request->id;
       $emp = Compte::find($id);
        
          if ($emp && $emp->userid == Auth::id()) {
              $id = $request->id;
  
              // Supprimer le projet
              Compte::destroy($id);
              Rallongebudget::where('souscompte', $id)->orWhere('compteid', $id)->delete();
              Activity::where('grandcompte', $id)->orWhere('compteidr', $id)->delete();
              Feb::where('ligne_bugdetaire', $id)->orWhere('sous_ligne_bugdetaire', $id)->delete();
              Elementfeb::where('eligne', $id)->orWhere('grandligne', $id)->delete();
              Elementdap::where('ligneided', $id)->delete();
              Elementdjas::where('ligneid', $id)->delete();

              Bonpetitcaisse::where('lignedecaisse', $id)->delete();
              Elementboncaisse::where('ligneid', $id)->delete();
             
             
  
              DB::commit();
  
              return response()->json([
                  'status' => 200,
              ]);
          } else {
              DB::rollBack();
              return response()->json([
                  'status' => 205,
                  'message' => 'Vous n\'avez pas l\'autorisation nécessaire pour supprimer cette ligne budgétaire. Veuillez contacter le créateur  pour procéder à la suppression.'
              ]);
          }
      } catch (\Exception $e) {
          DB::rollBack();
          return response()->json([
              'status' => 500,
              'message' => 'Erreur lors de la suppression du ligne bidgétaire.',
              'error' => $e->getMessage(), // Message d'erreur de l'exception
              'exception' => (string) $e // Détails de l'exception convertis en chaîne
          ]);
      }
  }
}
