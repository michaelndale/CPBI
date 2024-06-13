<?php

namespace App\Http\Controllers;

use App\Models\Carburant;
use App\Models\Fournisseur;
use App\Models\Historique;
use App\Models\Status;
use App\Models\Statutvehicule;
use App\Models\Typevehicule;
use App\Models\Vehicule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehiculeController extends Controller
{
  public function index()
  {
    $active = 'Parc';
    $title = 'Vehicule';
    $menu = 'vehicule';

    $carburent = Carburant::all();
    $type = Typevehicule::all();
    $statut = Statutvehicule::all();
    $vehicule = Vehicule::all();
    $founisseur = Fournisseur::all();

    return view(
      'vehicule.index',
      [
        'title' => $title,
        'active' => $active,
        'menu' => $menu,
        'carburent' => $carburent,
        'type' => $type,
        'statut' => $statut,
        'vehicules' => $vehicule,
        'founisseurs' => $founisseur
      ]
    );
  }

  public function fetchAll()
  {
    $vehicule = Vehicule::orderBy('id', 'DESC')->get();
    $output = '';
    if ($vehicule->count() > 0) {

      $nombre = 1;
      foreach ($vehicule as $rs) {
        $output .= '<tr>
              <td class="align-middle ps-3 name">' . $nombre . '</td>
              <td>' . ucfirst($rs->matricule) . '</td>
              <td>' . ucfirst($rs->marque) . '</td>
              <td>' . ucfirst($rs->modele) . '</td>
              <td>' . ucfirst($rs->numeroserie) . '</td>
              <td>' . ucfirst($rs->couleur) . '</td>
              <td>' . ucfirst($rs->type) . '</td>
              <td>' . ucfirst($rs->carburent) . '</td>
              <td>' . ucfirst($rs->annee) . '</td>
              <td>' . ucfirst($rs->numero_chassis) . '</td>
              <td>' . ucfirst($rs->statut) . '</td>
              <td>' . date('d.m.Y', strtotime($rs->created_at)) . '</td>
              <td>
              <center>
                  <div class="btn-group me-2 mb-2 mb-sm-0">
                  <a  data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="mdi mdi-dots-vertical ms-2"></i>
                  </a>
                  <div class="dropdown-menu">
                      <a class="dropdown-item  mx-1 voirvehicule" id="'.$rs->id.'"  data-bs-toggle="modal" data-bs-target="#voir_vehiculeModal" title="Modifier"><i class="far fa-eye"></i> Voir</a>
                      <a class="dropdown-item  mx-1 editvehicule" id="'.$rs->id.'"  data-bs-toggle="modal" data-bs-target="#edit_vehiculeModal" title="Modifier"><i class="far fa-edit"></i> Modifier</a>
                      <a class="dropdown-item text-white mx-1 deleteIcon"  id="'.$rs->id.'"  href="#" style="background-color:red"><i class="far fa-trash-alt"></i> Supprimer</a>
                  </div>
              </div>
                </center>
                </td>
            </tr>';
        $nombre++;
      }

      echo $output;
    } else {
      echo '
        <tr>
        <td colspan="11">
        <center>
          <h6 style="margin-top:1% ;color:#c0c0c0"> 
          <center><font size="50px"><i class="fa fa-info-circle"  ></i> </font><br><br>
              Ceci est vide  !</center> </h6>
        </center>
        </td>
        </tr>';
    }
  }

  // insert a new vehicule request
  public function store(Request $request)
  {

    try {
      $title = $request->matricule;
      $check = Vehicule::where('matricule', $title)->first();
      if ($check) {
        return response()->json([
          'status' => 201,
        ]);
      } else {


        $vehicule = new Vehicule();

        $vehicule->matricule = $request->matricule;
        $vehicule->marque = $request->marque;
        $vehicule->modele = $request->modele;
        $vehicule->couleur = $request->couleur;
        $vehicule->numeroserie = $request->numserie;
        $vehicule->type = $request->type;
        $vehicule->carburent = $request->carburent;
        $vehicule->annee = $request->annee;
        $vehicule->numero_chassis = $request->numero_chassis;
        $vehicule->statut = $request->statut;
        $vehicule->userid = Auth()->user()->id;
        $vehicule->save();

        $his = new Historique();
        $function = "Creation";
        $operation = "Nouveau véhicule " . $request->title;
        $link = 'vehicule';
        $his->fonction = $function;
        $his->operation = $operation;
        $his->link = $link;
        $his->userid = Auth()->user()->id;
        $his->save();

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

  // edit an vehicule request
  public function edit(Request $request)
  {
    $id = $request->id;
    $fon = Vehicule::find($id);
    return response()->json($fon);
  }

  // update an vehicule request
  public function update(Request $request)
  {

    try {
      

        $emp = Vehicule::find($request->idv);
        $emp->matricule = $request->matriculev;
        $emp->marque = $request->marquev;
        $emp->modele = $request->modelev;
        $emp->couleur = $request->couleurv;
        $emp->numeroserie = $request->numseriev;
        $emp->type = $request->typev;
        $emp->carburent = $request->carburentv;
        $emp->annee = $request->cannee;
        $emp->numero_chassis = $request->cnumero_chassis;
        $emp->statut = $request->statutv;

        $emp->update();

        $his = new Historique();
        $function = "Mises a jours";
        $operation = "Nouveau véhicule: " . $request->blaquev;
        $link = 'vehicule';
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

  // supresseion
  public function deleteall(Request $request)
  {
    try {
      $emp = Vehicule::find($request->id);
      if ($emp->userid == Auth::id()) {
        $id = $request->id;
        Vehicule::destroy($id);
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
