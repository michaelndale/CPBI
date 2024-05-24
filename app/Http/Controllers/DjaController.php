<?php

namespace App\Http\Controllers;

use App\Models\Beneficaire;
use App\Models\Compte;
use App\Models\Dja;
use App\Models\Elementdjas;
use App\Models\Historique;
use App\Models\Identification;
use App\Models\Notification;
use App\Models\Personnel;
use App\Models\User;
use App\Models\Vehicule;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Exception;
use Illuminate\Support\Facades\Crypt;


class DjaController extends Controller
{

  public function fetchAll()
  {
    $ID = session()->get('id');
    $data = DB::table('djas')
      ->orderby('id', 'DESC')
      ->Where('projetiddja', $ID)
      ->get();

    $output = '';
    if ($data->count() > 0) {
      $nombre = 1;
      foreach ($data as $datas) {
        $cryptedId = Crypt::encrypt($datas->id);
        if ($datas->numeroov == 1) {
          $ov = "checked";
        } else {
          $ov = "";
        }

        if ($datas->justifie == 1) {
          $jus = "checked";
        } else {
          $jus = "";
        }

        $output .= '
        <tr>
          <td> 
          <center>
          <div class="btn-group me-2 mb-2 mb-sm-0">
            <button class="btn btn-primary btn-sm dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-dots-vertical ms-2"></i> Action
            </button>
            <div class="dropdown-menu">
                <a href="#" class="dropdown-item text-success mx-1 voirdja" id="' . $datas->numerodap . '"  data-bs-toggle="modal" data-bs-target="#djaModale" ><i class="far fa-edit"></i> Justificatif DJA </a>
                <a href="dja/'.$cryptedId.'/view" class="dropdown-item text-success mx-1"><i class="far fa-eye"></i> Voir DJA </a>
                <a href="dja/'.$cryptedId.'/edit" class="dropdown-item text-success mx-1" ><i class="far fa-edit"></i> Modifier DJA</a>
                <a class="dropdown-item text-danger mx-1 deleteIcon"  id="' . $datas->id . '"  href="#"><i class="far fa-trash-alt"></i> Supprimer DJA</a>
            </div>
          </div>
          </center>
          </td>
          <td> ' . $datas->numerodjas . '  </td>
          <td> ' . $datas->numerodap . ' </td>
          <td> <input type="checkbox" ' . $ov . ' class="form-check-input" />  </td>
          <td><input type="checkbox" ' . $jus . ' class="form-check-input" /></td>
          <td> ' .date('d-m-Y', strtotime($datas->created_at)). '  </td>
         
        </tr>
      ';
        $nombre++;
      }
      echo $output;
    } else {
      echo '<tr>
        <td colspan="9">
        <center>
          <h6 style="margin-top:1% ;color:#c0c0c0"> 
          <center><font size="10px"><i class="fa fa-info-circle"  ></i> </font><br><br>
          Ceci est vide  !</center> </h6>
        </center>
        </td>
        </tr>
        ';
    }
  }
  // insert a new employee ajax request
  public function list()
  {
    $title = "DJA";
    $data = Dja::all();
    $total = Dja::all()->count();
    $active = 'Project';
    $compte = Compte::where('compteid', '=', NULL)->get();
    $personnel = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->orWhere('fonction', '!=', 'Chauffeur')
      ->orderBy('nom', 'ASC')
      ->get();
    return view(
      'document.dja.list',
      [
        'title' => $title,
        'data' => $data,
        'total' => $total,
        'active' => $active,
        'personnel' => $personnel,
        'compte'    => $compte
      ]
    );
  }

  public function show($idd)
  {

    $ID = session()->get('id');
    $budget = session()->get('budget');
    $devise = session()->get('devise');
    $title = "Voir DJA";
    $ID = session()->get('id');
    $dateinfo = Identification::all()->first();

    $idd = Crypt::decrypt($idd);

    $datadap = DB::table('djas')
      ->join('daps', 'djas.numerodap', 'daps.numerodp')
      ->join('services', 'daps.serviceid', 'services.id')
      ->select('djas.*', 'djas.id as idjas', 'daps.*', 'daps.id as iddap', 'services.title as titres')
      ->Where('djas.projetiddja', $ID)
      ->Where('djas.id', $idd)
      ->first();

    $datadapid = $datadap->iddap;
    $liste_justification = DB::table('elementdaps')
      ->Where('projetidda', $ID)
      ->Where('dapid', $datadapid)
      ->get();

    //dd($datadap);
    //dd($idd);


    $ID_DAP = $datadap->iddap;


    //dd($ID_DAP);

    $elementfeb = DB::table('febs')
      ->join('elementdaps', 'febs.id', 'elementdaps.referencefeb')
      ->select('elementdaps.*', 'febs.id as fid', 'febs.numerofeb', 'febs.descriptionf')
      ->where('elementdaps.dapid', $ID_DAP)
      ->get();

    $somme_gloable = DB::table('elementfebs')
      ->Where('projetids', $ID)
      ->SUM('montant');
    $pourcetage_globale = round(($somme_gloable * 100) / $budget, 2);

    $solde_comptable = $budget - $somme_gloable;

    //beneficaire commce



    $elementfebencours = DB::table('febs')
      ->join('elementdaps', 'febs.id', 'elementdaps.referencefeb')
      ->select('elementdaps.*', 'febs.id as fid', 'febs.numerofeb', 'febs.descriptionf')
      ->where('elementdaps.numerodap', $ID_DAP)
      ->get();

    $somme_element_encours = 0;
    foreach ($elementfebencours as $key => $elementfebencourss) {
      $totoSUM = DB::table('elementfebs')
        ->orderBy('id', 'DESC')
        ->where('febid', $elementfebencourss->fid)
        ->sum('montant');
      $somme_element_encours += $totoSUM;
    }


    $pourcentage_encours =  round(($somme_element_encours * 100) / $budget, 2);

    $taux_execution_avant = $pourcetage_globale - $pourcentage_encours;



    $allmontant = DB::table('elementfebs')
      ->Where('projetids', $ID)
      ->SUM('montant');
    $solder_dap = $budget - $allmontant;

    $pourcentage_global_b = round(($allmontant * 100) / $budget, 2);

    //etablie par 
    $etablienom =  DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->Where('users.id', $datadap->userid)
      ->first();

    $Demandeetablie =  DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->Where('users.id', $datadap->demandeetablie)
      ->first();

    $verifierpar =  DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->Where('users.id', $datadap->verifierpar)
      ->first();

    $approuverpar =  DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->Where('users.id', $datadap->approuverpar)
      ->first();

    $responsable =  DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->Where('users.id', $datadap->responsable)
      ->first();



    $secretaire =  DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'personnels.id as idp', 'users.signature', 'users.id as usersid')
      ->Where('users.id', $datadap->secretaire)
      ->first();

    $chefprogramme =  DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'personnels.id as idp', 'users.signature', 'users.id as usersid')
      ->Where('users.id', $datadap->chefprogramme)
      ->first();

    return view(
      'document.dja.voir',

      [
        'title'     => $title,
        'dateinfo'  => $dateinfo,
        'datadap'   => $datadap,

        'pourcentage_global_b' => $pourcentage_global_b,
        'solder_dap' => $solder_dap,
        'etablienom' => $etablienom,
        'Demandeetablie' => $Demandeetablie,
        'verifierpar' => $verifierpar,
        'approuverpar' => $approuverpar,
        'responsable'  => $responsable,
        'secretaire'   => $secretaire,
        'chefprogramme' => $chefprogramme,
        'datafebElement' => $elementfeb,
        'budget' => $budget,
        'pourcetage_globale' => $pourcetage_globale,
        'solde_comptable' => $solde_comptable,
        'taux_execution_avant' => $taux_execution_avant,
        'pourcentage_encours' => $pourcentage_encours,
        'liste_justification' => $liste_justification


      ]
    );
  }


  public function edit($id)
  {

    $title = "Modification DJA";
    $ID = session()->get('id');

    $Jsondja = DB::table('djas')
      ->orderby('id', 'DESC')
      ->Where('projetiddja', $ID)
      ->Where('djas.id', $id)
      ->first();

    $total = Dja::all()->count();
    $active = 'Project';
    $compte = Compte::where('compteid', '=', NULL)->get();
    $personnel = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->orWhere('fonction', '!=', 'Chauffeur')
      ->orderBy('nom', 'ASC')
      ->get();

    return view(
      'document.dja.edit',
      [
        'title'     => $title,
        'Jsondja' => $Jsondja,
        'total' => $total,
        'active' => $active,
        'personnel' => $personnel,
        'compte'    => $compte
      ]
    );
  }

  public function generatePDFdja($id)
  {
    $IDB = session()->get('id');
    $budget = session()->get('budget');
    $devise = session()->get('devise');
    $dompdf = new Dompdf();

    $id = Crypt::decrypt($id); // bd

    $Jsondja = DB::table('djas')
      ->orderby('id', 'DESC')
      ->Where('projetiddja', $IDB)
      ->Where('djas.id', $id)
      ->first();

    $infoglo = DB::table('identifications')->first();

    $pdf = FacadePdf::loadView('document.dja.doc', compact('infoglo', 'Jsondja'));

    $pdf->setPaper('A4', 'landscape'); // Définit le format A4 en mode paysage

    $lien_download = 'dja' . $id . '.pdf';

    return $pdf->download($lien_download);
  }

  public function delete(Request $request)
  {
    $his = new Historique;
    $function = "Suppression";
    $operation = "Suppression DJA";
    $link = 'dja';
    $his->fonction = $function;
    $his->operation = $operation;
    $his->userid = Auth()->user()->id;
    $his->link = $link;
    $his->save();

    $id = $request->id;
    Dja::destroy($id);
  }

  public function getdjas(Request $request)
  {
    try {
      $IDn = $request->id;
      $budget = session()->get('budget');
      $IDP = session()->get('id');
      $output = '';
      // Initialisez une variable pour stocker les sorties de tableau
   
      // Effectuez la recherche de données pour chaque identifiant sélectionné
      $data = DB::table('elementdaps')
        ->join('febs', 'elementdaps.referencefeb', 'febs.id')
        ->select('elementdaps.*', 'elementdaps.id as idedaps', 'febs.ligne_bugdetaire', 'febs.numerofeb', 'febs.id as idfb')
        ->where('numerodap', $IDn)
        ->get();

      $iddja = DB::table('djas')
              ->where('numerodap', $IDn)
              ->first();

      $personnel = Personnel::all();
      $vehicules = Vehicule::all();

      if ($data->count() > 0) {
        // Générer la sortie HTML pour chaque élément sélectionné
        foreach ($data as $datas) {
          // sommes element
          $sommefeb = DB::table('elementfebs')
            ->Where('febid', $datas->referencefeb)
            ->Where('projetids', $IDP)
            ->SUM('montant');

          $ligneinfo = Compte::where('id', $datas->ligne_bugdetaire)->first();
          // Construire la sortie HTML pour chaque élément sélectionné
          $output .= '<table class="table table-striped table-sm fs--1 mb-0 table-bordered" style="width:100%;">';
          $output .= '<input type="hidden" name="febid[]" id="febid[]" value="' . $datas->idfb . '" / > 
                      <input type="hidden" name="iddjas[]" id="iddjas[]" value="' . $iddja->id . '" /> 
                      <input type="hidden" name="dpasid[]" id="dpasid[]" value="'.$datas->idedaps.'" />';

          $output .= '<input type="hidden" id="ligneid[]" name="ligneid[]" value="' . $datas->ligne_bugdetaire . '" />';
          $output .= '<tr>';
          $output .= '<td width="10%">Numéro FEB : ' . $datas->numerofeb . '</td>';
          $output .= '<td width="13%">Montant de l\'Avance <input type="number" name="montantavance[]" id="montantavance[]" value="' . $sommefeb . '" style="width: 100%; border:1px solid #c0c0c0" /></td>';
          $output .= '<td width="13%">Montant utilise      <input type="number" name="montant_utiliser[]" id="montant_utiliser[]" style="width: 100%; border:1px solid #c0c0c0" /></td>';
          $output .= '<td width="13%">Surplus/Manque       <input type="text" name="surplus[]" id="surplus[]" style="width: 100%; border:1px solid #c0c0c0" /></td>';
          $output .= '<td width="13%">Montant Retourne     <input type="text" name="montant_retourne[]" id="montant_retourne[]" style="width: 100%; border:1px solid #c0c0c0" />   <div class="error-message" style="color: red;"></div></td>';
          $output .= '<td width="13%">Bordereau            <input type="text"  name="bordereau[]" id="bordereau[]" style="width: 100%; border:1px solid #c0c0c0" /></td>';
          $output .= '<td width="13%">Description           <input type="text" id="description[]" name="description[]" class="description-input" style="width: 100%; border:1px solid #c0c0c0" /></td>                    ';
          $output .= '<td width="13%" style="display: none;"> Plaque  
                        <select type="text" name="plaque[]" id="plaque[]" class="plaque-input" style="width: 100%; border:1px solid #c0c0c0"> 
                        <option value="">Aucun</option>';
                          foreach ($vehicules as $vehicule) 
                          {
                            $output .= '<option value="'. $vehicule->matricule.'">' . $vehicule->matricule . '</option>';
                          }
          $output .= '</select> </td>';
          $output .= '</tr></table>';
        }


      $output .= '
      <table class="table table-striped table-sm fs--1 mb-0 table-bordered" style="width:100%;">
          <tr>
              <td class="align-middle ps-3 name" colspan="7">
                  <b>Réception des pièces justificatives de l\'utilisation de l\'avance par: </b>
                  <select type="text" class="form-control form-control-sm" name="receptionpar" id="receptionpar" style="width:40%">
                    <option value="">--Choisissez le personnel--</option>';
                      
      foreach ($personnel as $personnels) {
          $output .= '<option value="' . $personnels->id . '">' . $personnels->nom . ' ' . $personnels->prenom . '</option>';
      }
      
      $output .= '
                  </select>
              </td>
          </tr>
      </table>';


      } else {
        // Si aucune donnée n'est trouvée, retournez un message d'erreur avec une classe "danger"
        $output .= '<table class="table table-striped table-sm fs--1 mb-0 table-bordered" style="width:100%;">
                        <tr class="table-danger"><td colspan="7">Aucune donnée trouvée sur la justification. ceci est une DJA non justifier</td>
                        </tr>
                    </table>';
      }

     

    
      return $output;
    } catch (\Exception $e) {
      // Retourner un message d'erreur en cas d'exception
      return response()->json(['error' => 'Une erreur est survenue : ' . $e->getMessage()], 500);
    }
  }

 
  public function saveDjas(Request $request)
  {
      try {
          // Récupérer les données du formulaire
          $febidArray =  $request->febid;
          $djasidArray = $request->iddjas;
          $dapsidArray = $request->dpasid;
          $ligneidArray = $request->ligneid;
          $montantAvanceArray = $request->montantavance;
          $montantUtiliserArray = $request->montant_utiliser;
          $surplusArray = $request->surplus;
          $montantRetourneArray = $request->montant_retourne;
          $bordereauArray = $request->bordereau;
          $descriptionArray = $request->description;
          $plaqueArray = $request->has('plaque') ? $request->plaque : "";
          $receptionpar = $request->receptionpar;
  
          // Initialiser la liste des champs vides
          $emptyFields = [];
  
          // Vérifier si tous les champs sont remplis
          if (empty($febidArray)) {
              $emptyFields[] = 'febid';
          }
          if (empty($djasidArray)) {
              $emptyFields[] = 'iddjas';
          }
          if (empty($dapsidArray)) {
              $emptyFields[] = 'dpasid';
          }
          if (empty($ligneidArray)) {
              $emptyFields[] = 'ligneid';
          }
          if (empty($montantAvanceArray)) {
              $emptyFields[] = 'montantavance';
          }
          if (empty($montantUtiliserArray)) {
              $emptyFields[] = 'montant_utiliser';
          }
          if (empty($surplusArray)) {
              $emptyFields[] = 'surplus';
          }
          if (empty($montantRetourneArray)) {
              $emptyFields[] = 'montant_retourne';
          }
          if (empty($bordereauArray)) {
              $emptyFields[] = 'bordereau';
          }
          if (empty($descriptionArray)) {
              $emptyFields[] = 'description';
          }
          if (empty($receptionpar)) {
              $emptyFields[] = 'receptionpar';
          }
  
          // Si des champs sont vides, renvoyer une erreur
          if (!empty($emptyFields)) {
              return response()->json([
                  'status' => 203,
                  'error' => "Les champs suivants sont obligatoires : " . implode(", ", $emptyFields)
              ]);
          }
  
          // Parcourir les données et les enregistrer dans la base de données
          foreach ($febidArray as $key => $febid) {
              $dja = new Elementdjas();
              $dja->febid = $febid;
              $dja->iddjas = $djasidArray[$key];
              $dja->idddap = $dapsidArray[$key];
              $dja->ligneid = $ligneidArray[$key];
              $dja->montant_avance = $montantAvanceArray[$key];
              $dja->montant_utiliser = $montantUtiliserArray[$key];
              $dja->surplus = $surplusArray[$key];
              $dja->montant_retourne = $montantRetourneArray[$key];
              $dja->bordereau = $bordereauArray[$key];
              $dja->description = $descriptionArray[$key];
              $dja->plaque = $plaqueArray[$key];
              $dja->receptionpar = $receptionpar;
              $dja->save();
          }
  
          // Confirmer la transaction
          DB::commit();
  
          return response()->json([
              'status' => 200,
          ]);
      } catch (Exception $e) {
          // En cas d'erreur, annuler la transaction
          DB::rollback();
  
          return response()->json([
              'status' => 203,
              'error' => $e->getMessage()
          ]);
      }
  }
 
}


// <a href="dja/'.$cryptedId.'/view" class="dropdown-item text-success mx-1 voirIcon"  ><i class="far fa-edit"></i> Voir dja</a>
//<a href="dja/'.$cryptedId.'/edit" class="dropdown-item text-primary mx-1 editIcon " title="Modifier"><i class="far fa-edit"></i> Modifier dja</a>
//<a href="dja/'.$cryptedId. '/generate-pdf-dja" class="dropdown-item  mx-1"><i class="fa fa-print"> </i> Générer document PDF</a>