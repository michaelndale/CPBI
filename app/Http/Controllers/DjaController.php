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
    $data =  DB::table('djas')
    ->orderBy('numerodjas', 'asc')
    ->join('users', 'djas.userid', '=', 'users.id')
    ->join('personnels', 'users.personnelid', '=', 'personnels.id')
    ->join('daps','djas.dapid' ,'daps.id')
    ->select('djas.*', 'djas.id as iddjas', 'personnels.prenom as user_prenom', 'daps.numerodp as nume_dap', 'daps.id as iddap', 'daps.cho')
    ->where('djas.projetiddja', $ID)
    ->get();

    $output = '';
    if ($data->count() > 0) {
      $nombre = 1;
      foreach ($data as $datas) {
        $cryptedId = Crypt::encrypt($datas->id);

        $numerofeb = DB::table('febs')
        ->leftJoin('elementdaps', 'febs.id', 'elementdaps.referencefeb')
        ->where('elementdaps.dapid', $datas->iddap)
        ->get();

        $cryptedId = Crypt::encrypt($datas->iddap);
        $totalMontant = $this->getTotalDap($datas->iddap); // Récupérer le montant total pour chaque DAP

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
            <a   data-bs-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-dots-vertical ms-2"></i> Options
            </a>
            <div class="dropdown-menu">
              
               <a href="dja/'.$datas->iddjas.'/nouveau" class="dropdown-item mx-1"><i class="fa fa-plus-circle"></i> Modifier  DJA  </a>
               <a href="dja/'.$datas->iddjas.'/voir" class="dropdown-item mx-1"><i class="fa fa-eye"></i> Voir  DJA  </a>
                </div>
          </div>
          </center>
          </td>
          <td align="center"> ' . $datas->numerodjas . '  </td>
       
          <td align="center"> ' . $datas->nume_dap . ' </td>
            <td align="center">';
  
              foreach ($numerofeb as $key => $numerofebs) {
                  $output .= '[' . $numerofebs->numerofeb . ']';
                  if ($key < count($numerofeb) - 1) {
                      $output .= ',';
                  }
              }
  
              $output .= '
            </td>
              <td align="right"><b>' . number_format($totalMontant, 0, ',', ' ') . '</b> </td> 

           <td > ' . $datas->fond_recu_le . ' </td>
          <td> '. $datas->cho .' </td>
          <td align="center"> <input type="checkbox" ' . $jus . ' class="form-check-input" disabled /></td>
        
          <td> ' .date('d-m-Y', strtotime($datas->created_at)).'  </td>
          <td> ' .ucfirst($datas->user_prenom) . ' </td>
        </tr>
      ';
        $nombre++;
      }
      echo $output;
    } else {
      echo '<tr>
        <td colspan="11">
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

  public function getTotalDap($dapId)
  {
      $febIds = DB::table('elementdaps') // Suppose que vous avez une table de liaison entre DAP et FEB
          ->where('dapid', $dapId)
          ->pluck('referencefeb');
      
      return DB::table('elementfebs')
          ->whereIn('febid', $febIds)
          ->sum('montant');
  }
  // insert a new employee ajax request
  public function list()
  {
      // Get the session ID
      $ID = session()->get('id');
  
      // Check if the session ID is not set
      if (!$ID) {
          // Redirect to the dashboard if the session ID is not set
          return redirect()->route('dashboard');
      }
  
      // Continue with the rest of the method if session ID is set
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
              'compte' => $compte
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
    try {

      $emp = Dja::find($request->id);
      if ($emp->userid == Auth::id()) {
        $id = $request->id;
        Dja::destroy($id);
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
              ->select('elementdaps.*', 'elementdaps.dapid as idedaps', 'febs.ligne_bugdetaire', 'febs.numerofeb', 'febs.id as idfb','febs.sous_ligne_bugdetaire')
              ->where('elementdaps.dapid', $IDn)
              ->where('projetidda', $IDP)
              ->get();

          $iddja = DB::table('djas')
              ->where('numerodap', $IDn)
              ->first();

          $personnel = Personnel::all();
          $vehicules = Vehicule::all();

          if($iddja->justifie == 1){

              if ($data->count() > 0) {
                  // Générer la sortie HTML pour chaque élément sélectionné

                  $output .= '<table class="table table-striped table-sm fs--1 mb-0 table-bordered" style="width:100%;">';
                  $output.='
                      <tr> 
                          <td colspan="3">Fonds payés à  <input type="" name="fond_paye" id="fond_paye" class="form-control form-control-sm" /></td>
                          <td>Addresse: <input type="text" name="addresse" id="addresse"  class="form-control form-control-sm" /></td>
                          <td>Téléphone 1: <input type="text"  name="telephone_un" id="telephone_un" class="form-control form-control-sm" /></td>
                          <td>Téléphone 2: <input type="text"  name="telephone_deux" id="telephone_deux" class="form-control form-control-sm"  /></td>
                          <td>Date de justification : <input type="date" name="date_avance" id="date_avance"   class="form-control form-control-sm" /></td>
                          <td>Description /Motif :   <input type="description_avance"   class="form-control form-control-sm" /></td>
                      </tr>
                      </table> <br>';
                  foreach ($data as $datas) {
                      // sommes element
                      $sommefeb = DB::table('elementfebs')
                          ->where('febid', $datas->referencefeb)
                          ->where('projetids', $IDP)
                          ->sum('montant');

                      $ligneinfo = Compte::where('id', $datas->ligne_bugdetaire)->first();
                      // Construire la sortie HTML pour chaque élément sélectionné
                  
                    
                      $output .= '<input type="hidden" name="febid[]" id="febid[]" value="'.$datas->idfb.'">
                                  <input type="hidden" name="iddjas[]" id="iddjas[]" value="'.$iddja->id.'">
                                  <input type="hidden" name="dpasid[]" id="dpasid[]" value="'.$datas->idedaps.'">';

                      $output .= '<input type="hidden" id="ligneid[]" name="ligneid[]" value="'. $datas->sous_ligne_bugdetaire.'" />';
                      if ($datas->montantavance == NULL) {
                          $montantavance = 0;
                      } else {
                          $montantavance = $datas->montantavance;
                          $descriptionAvance = $datas->descriptionn;
                      }
                      


                      $output .='<table class="table table-striped table-sm fs--1 mb-0 table-bordered" style="width:100%;">';
                      $output .= '<tr>';
                          $output .= '<td width="10%"> <labele title="FEB">Numéro F.E.B :</labele>  <input type="number" value="'. $datas->numerofeb . '" class="form-control form-control-sm"  style="background-color: #c0c0c0" disabled/></td>';
                          $output .= '<td>Montant de l\'Avance :    <input type="number" name="montantavance[]" id="montantavance[]" value="' .$montantavance . '"  class="form-control form-control-sm"  required/></td>';
                          $output .= '<td>Montant utilisé :         <input type="number" name="montant_utiliser[]" id="montant_utiliser[]"  class="form-control form-control-sm"  required/></td>';
                          $output .= '<td>Surplus/Manque :          <input type="text" name="surplus[]" id="surplus[]"   class="form-control form-control-sm" required /></td>';
                          $output .= '<td>Montant Retourné à la caisse au compte(Si Surplus)<input type="text" name="montant_retourne[]" id="montant_retourne[]"  class="form-control form-control-sm" required  />   <div class="error-message" style="color: red;"></div></td>';
                          $output .= '<td colspan="3">Description / Motif <input type="text" id="description[]" name="description[]" value="' .$descriptionAvance . '"  class="form-control form-control-sm description-input"  required/> </td> ';
                          $output .= '<td style="display: none" colspan="4"> Plaque  
                                          <select type="text" name="plaque[]" id="plaque[]" class="form-control form-control-sm plaque-input" > 
                                              <option disabled="true" selected="true"> Aucun</option>';
                                                  foreach ($vehicules as $vehicule) 
                                                  {
                                                      $output .= '<option value="'. $vehicule->matricule.'">' . $vehicule->matricule . '</option>';
                                                  }
                          $output .= '</select></td>';
                      $output .='</tr>';
                      $output .='</table> ';
                    
                  }

                    
                  $output .='<br><table class="table table-striped table-sm fs--1 mb-0 table-bordered" style="width:100%;">';
                  $output .= '
                      <td class="align-middle ps-3 name" >
                      <b>Réception des fonds retournés à la caisse </b>
                      <select type="text"  class="form-control form-control-sm" name="reception_fond" id="reception_fond" style="width:100%">
                          <option disabled="true" selected="true" value="">--Choisissez le personnel--</option>';
                          foreach ($personnel as $personnels) {
                              $output .= '<option value="'.$personnels->id.'">' . $personnels->nom . ' ' . $personnels->prenom . '</option>';
                          }
                  $output .= '
                      </select>
                      </td>
                  ';  
              $output .='<td width="20%">Bordereau de versement N<sup>o</sup> <input type="text"  name="bordereau" id="bordereau"  class="form-control form-control-sm"  /></td>
                        <td width="20%">Date de bordereau <input type="date" name="date_bordereau" id="date_bordereau"  class="form-control form-control-sm"  /></td>';
            $output .='</tr> </table>';
            

                  $output .='<table class="table table-striped table-sm fs--1 mb-0 table-bordered" style="width:100%;">';
                  $output .= '
                
                          <td class="align-middle ps-3 name">
                              <b>Réception des pièces justificatives de l\'utilisation de l\'avance par: </b>
                              <select type="text"  class="form-control form-control-sm" name="receptionpar" id="receptionpar" style="width:100%">
                                  <option disabled="true" selected="true" value="">--Choisissez le personnel--</option>';
                                  foreach ($personnel as $personnels) {
                                      $output .= '<option value="'.$personnels->id.'">' . $personnels->nom . ' ' . $personnels->prenom . '</option>';
                                  }
                  $output .= '
                              </select>
                          </td>
                      </tr>
                  </table><br>';

              
              } 
          } else {
                  // Si aucune donnée n'est trouvée, retournez un message d'erreur avec une classe "danger"
                  $output .= '<table class="table table-striped table-sm fs--1 mb-0 table-bordered" style="width:100%;">
                                  <tr class="table-danger"><td colspan="7">Aucune donnée trouvée sur la justification. Ceci est une DJA non justifiée</td>
                                  </tr>
                              </table>';
          }

          return $output;
      } catch (\Exception $e) {
          // Retourner un message d'erreur en cas d'exception
          return response()->json(['error' => 'Une erreur est survenue : ' . $e->getMessage()], 500);
      }
  }

  public function getdjasto(Request $request)
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
              ->select('elementdaps.*', 'elementdaps.dapid as idedaps', 'febs.ligne_bugdetaire', 'febs.numerofeb', 'febs.id as idfb','febs.sous_ligne_bugdetaire')
              ->where('elementdaps.dapid', $IDn)
              ->where('projetidda', $IDP)
              ->get();

          $iddja = DB::table('djas')
              ->where('numerodap', $IDn)
              ->first();

          $personnel = Personnel::all();
          $vehicules = Vehicule::all();

          if($iddja->justifie == 1){

              if ($data->count() > 0) {
                  // Générer la sortie HTML pour chaque élément sélectionné

                  $output .= '<table class="table table-striped table-sm fs--1 mb-0 table-bordered" style="width:100%;">';
                  $output.='
                      <tr> 
                          <td colspan="3">Fonds payés à  <input type="" name="fond_paye" value="'.$iddja->fond_paye.'"  id="fond_paye" class="form-control form-control-sm" /></td>
                          <td>Addresse: <input type="text" name="addresse" id="addresse" value="'.$iddja->addresse.'"  class="form-control form-control-sm" /></td>
                          <td>Téléphone 1: <input type="text"  name="telephone_un" id="telephone_un"  value="'.$iddja->telephone_un.'" class="form-control form-control-sm" /></td>
                          <td>Téléphone 2: <input type="text"  name="telephone_deux" id="telephone_deux" value="'.$iddja->telephone_deux.'" class="form-control form-control-sm"  /></td>
                          <td>Date de justification : <input type="date" name="date_avance" id="date_avance" value="'.$iddja->date_avance.'"   class="form-control form-control-sm" /></td>
                          <td>Description /Motif :   <input type="description_avance"  value="'.$iddja->description_avance.'"  class="form-control form-control-sm" /></td>
                      </tr>
                      </table> <br>';
                  foreach ($data as $datas) {
                      // sommes element
                      $sommefeb = DB::table('elementfebs')
                          ->where('febid', $datas->referencefeb)
                          ->where('projetids', $IDP)
                          ->sum('montant');

                      $ligneinfo = Compte::where('id', $datas->ligne_bugdetaire)->first();
                      // Construire la sortie HTML pour chaque élément sélectionné
                  
                    
                      $output .= '<input type="hidden" name="febid[]" id="febid[]" value="'.$datas->idfb.'">
                                  <input type="hidden" name="iddjas[]" id="iddjas[]" value="'.$iddja->id.'">
                                  <input type="hidden" name="dpasid[]" id="dpasid[]" value="'.$datas->idedaps.'">';

                      $output .= '<input type="hidden" id="ligneid[]" name="ligneid[]" value="'. $datas->sous_ligne_bugdetaire.'" />';
                      if ($datas->montantavance == NULL) {
                          $montantavance = 0;
                      } else {
                          $montantavance = $datas->montantavance;
                          $descriptionAvance = $datas->descriptionn;
                      }
                      


                      $output .='<table class="table table-striped table-sm fs--1 mb-0 table-bordered" style="width:100%;">';
                      $output .= '<tr>';
                          $output .= '<td width="10%"> <labele title="FEB">Numéro F.E.B :</labele>  <input type="number" value="'. $datas->numerofeb . '" class="form-control form-control-sm"  style="background-color: #c0c0c0" disabled/></td>';
                          $output .= '<td>Montant de l\'Avance :    <input type="number" name="montantavance[]" id="montantavance[]" value="' .$montantavance . '"  class="form-control form-control-sm"  required/></td>';
                          $output .= '<td>Montant utilisé :         <input type="number" name="montant_utiliser[]" id="montant_utiliser[]"  value="'. $datas->montant_utiliser. '" class="form-control form-control-sm"  required/></td>';
                          $output .= '<td>Surplus/Manque :          <input type="text" name="surplus[]" id="surplus[]"   value="'. $datas->surplus . '" class="form-control form-control-sm" required /></td>';
                          $output .= '<td>Montant Retourné à la caisse au compte(Si Surplus)<input type="text" value="'. $datas->montant_retourne . '"  name="montant_retourne[]" id="montant_retourne[]"  class="form-control form-control-sm" required  />   <div class="error-message" style="color: red;"></div></td>';
                          $output .= '<td colspan="3">Description / Motif <input type="text" id="description[]"  name="description[]" value="' .$descriptionAvance . '"  class="form-control form-control-sm description-input"  required/> </td> ';
                          $output .= '<td style="display: none" colspan="4"> Plaque  
                                          <select type="text" name="plaque[]" id="plaque[]" class="form-control form-control-sm plaque-input" > 
                                              <option disabled="true" selected="true"> Aucun</option>';
                                                  foreach ($vehicules as $vehicule) 
                                                  {
                                                      $output .= '<option value="'. $vehicule->matricule.'">' . $vehicule->matricule . '</option>';
                                                  }
                          $output .= '</select></td>';
                      $output .='</tr>';
                      $output .='</table> ';
                    
                  }

                    
                  $output .='<br><table class="table table-striped table-sm fs--1 mb-0 table-bordered" style="width:100%;">';
                  $output .= '
                      <td class="align-middle ps-3 name" >
                      <b>Réception des fonds retournés à la caisse </b>
                      <select type="text"  class="form-control form-control-sm" name="reception_fond" id="reception_fond" style="width:100%">
                          <option disabled="true" selected="true" value="">--Choisissez le personnel--</option>';
                          foreach ($personnel as $personnels) {
                              $output .= '<option value="'.$personnels->id.'">' . $personnels->nom . ' ' . $personnels->prenom . '</option>';
                          }
                  $output .= '
                      </select>
                      </td>
                  ';  
              $output .='<td width="20%">Bordereau de versement N<sup>o</sup> <input type="text"  name="bordereau" id="bordereau"  class="form-control form-control-sm"  /></td>
                        <td width="20%">Date de bordereau <input type="date" name="date_bordereau" id="date_bordereau"  class="form-control form-control-sm"  /></td>';
            $output .='</tr> </table>';
            

                  $output .='<table class="table table-striped table-sm fs--1 mb-0 table-bordered" style="width:100%;">';
                  $output .= '
                
                          <td class="align-middle ps-3 name">
                              <b>Réception des pièces justificatives de l\'utilisation de l\'avance par: </b>
                              <select type="text"  class="form-control form-control-sm" name="receptionpar" id="receptionpar" style="width:100%">
                                  <option disabled="true" selected="true" value="">--Choisissez le personnel--</option>';
                                  foreach ($personnel as $personnels) {
                                      $output .= '<option value="'.$personnels->id.'">' . $personnels->nom . ' ' . $personnels->prenom . '</option>';
                                  }
                  $output .= '
                              </select>
                          </td>
                      </tr>
                  </table><br>';

              
              } 
          } else {
                  // Si aucune donnée n'est trouvée, retournez un message d'erreur avec une classe "danger"
                  $output .= '<table class="table table-striped table-sm fs--1 mb-0 table-bordered" style="width:100%;">
                                  <tr class="table-danger"><td colspan="7">Aucune donnée trouvée sur la justification. Ceci est une DJA non justifiée</td>
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
      DB::beginTransaction(); // Start a transaction

      try {
          $iddja = $request->djaid;
          $onedja = Dja::find($iddja);

          // Check if the Dja object exists
          if (!$onedja) {
              return response()->json([
                  'status' => 404,
                  'error' => 'Dja not found.'
              ]);
          }

          // Update properties of the Dja object
          $onedja->projetiddja = $iddja;
          $onedja->projetid = $iddja;

          // Save the changes to the database
          $onedja->save();

          // Commit the transaction
          DB::commit();

          return response()->json([
              'status' => 200,
              'message' => 'Dja updated successfully.'
          ]);
      } catch (Exception $e) {
          // Rollback the transaction in case of error
          DB::rollback();

          return response()->json([
              'status' => 500,
              'error' => $e->getMessage()
          ]);
      }
  }


  public function nouveau($id)
  {

      $IDP = session()->get('id');
      $devise = session()->get('devise');
      $title = "Nouveau DJA";

      // Vérifier si l'une des variables de session n'est pas définie
    if (!$IDP ) {
      // Rediriger vers la route nommée 'dashboard'
      return redirect()->route('dashboard');
    }

      $data = DB::table('djas')
      ->orderBy('daps.numerodp', 'asc')
      ->join('users', 'djas.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->join('daps', 'djas.dapid', '=', 'daps.id')
    
      ->leftJoin('users as user_fonds_demandes', 'user_fonds_demandes.id', '=', 'djas.fonds_demande_par')
      ->leftJoin('personnels as personnel_fonds_demandes', 'user_fonds_demandes.personnelid', '=', 'personnel_fonds_demandes.id')

      ->leftJoin('users as user_avance_approuver_un', 'user_avance_approuver_un.id', '=', 'djas.avance_approuver_par')
      ->leftJoin('personnels as personnel_avance_approuver_un', 'user_avance_approuver_un.personnelid', '=', 'personnel_avance_approuver_un.id')

      ->leftJoin('users as user_avance_approuver_par_deux', 'user_avance_approuver_par_deux.id', '=', 'djas.avance_approuver_par_deux')
      ->leftJoin('personnels as personnel_avance_approuver_par_deux', 'user_avance_approuver_par_deux.personnelid', '=', 'personnel_avance_approuver_par_deux.id')
      
      ->leftJoin('users as user_fond_debourser_par', 'user_fond_debourser_par.id', '=', 'djas.fond_debourser_par')
      ->leftJoin('personnels as personnel_fond_debourser_par', 'user_fond_debourser_par.personnelid', '=', 'personnel_fond_debourser_par.id')

      ->leftJoin('users as user_fonds_retournes_caisse', 'user_fonds_retournes_caisse.id', '=', 'djas.fonds_retournes_caisse_par')
      ->leftJoin('personnels as personnel_fonds_retournes_caisse', 'user_fonds_retournes_caisse.personnelid', '=', 'personnel_fonds_retournes_caisse.id')

      ->leftJoin('users as user_reception_pieces', 'user_reception_pieces.id', '=', 'djas.reception_pieces_justificatives')
      ->leftJoin('personnels as personnel_reception_pieces', 'user_reception_pieces.personnelid', '=', 'personnel_reception_pieces.id')

      ->leftJoin('users as user_pfond_paye', 'user_pfond_paye.id', '=', 'djas.pfond_paye')
      ->leftJoin('personnels as personnel_pfond_paye', 'user_pfond_paye.personnelid', '=', 'personnel_pfond_paye.id')


      ->select(
          'djas.*',
          'djas.id as iddjas',
          'personnels.prenom as user_prenom',
          'djas.numerodjas as numerudja',
          'daps.numerodp as nume_dap',
          'daps.id as iddap',
          'daps.cho',

          'personnel_fonds_demandes.nom as fonds_demandes_nom',
          'personnel_fonds_demandes.prenom as fonds_demandes_prenom',
          'user_fonds_demandes.id as fonds_signe_fonds_demande_par',
          'user_fonds_demandes.id as fonds_demandes_userid',

          'personnel_avance_approuver_un.nom as avance_approuver_un_nom',
          'personnel_avance_approuver_un.prenom as avance_approuver_un_prenom',
          'user_avance_approuver_un.id as fonds_signe_avance_approuver_par',
          'user_avance_approuver_un.id as avance_approuver_un_userid',

          'personnel_avance_approuver_par_deux.nom as avance_approuver_par_deux_nom',
          'personnel_avance_approuver_par_deux.prenom as avance_approuver_par_deux_prenom',

          'personnel_fond_debourser_par.nom as fond_debourser_nom',
          'personnel_fond_debourser_par.prenom as fond_debourser_prenom',

          'personnel_fonds_retournes_caisse.nom as fonds_retournes_caisse_nom',
          'personnel_fonds_retournes_caisse.prenom as fonds_retournes_caisse_prenom',

          'personnel_reception_pieces.nom as reception_pieces_nom',
          'personnel_reception_pieces.prenom as reception_pieces_prenom',

          'personnel_pfond_paye.nom as pfond_paye_nom',
          'personnel_pfond_paye.prenom as pfond_paye_prenom',

      )
      ->where('djas.projetiddja', $IDP)
      ->where('djas.id', $id)
      ->first();


      $numerofeb = DB::table('febs')
          ->leftJoin('elementdaps', 'febs.id', 'elementdaps.referencefeb')
          ->leftJoin('comptes','febs.sous_ligne_bugdetaire','comptes.id')
          ->leftjoin('beneficaires', 'febs.beneficiaire', 'beneficaires.id')
          ->join('daps', 'elementdaps.dapid', 'daps.id')
          ->join('djas','daps.id','djas.dapid')
          ->select('febs.*', 'comptes.libelle as libelle_compte', 'beneficaires.libelle as beneficiaireNom','beneficaires.telephoneone','beneficaires.adresse', 'beneficaires.telephonedeux','beneficaires.description')
          ->where('elementdaps.dapid', $data->iddap)
          ->get();

      $personnel = DB::table('users')
          ->join('personnels', 'users.personnelid', '=', 'personnels.id')
          ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
          ->orderBy('nom', 'ASC')
          ->get();
        

      
      $vehicules = Vehicule::all();
      


      return view(
        'document.dja.new',

        [
          'title'     => $title,
          'data'      => $data,
          'numerofeb' => $numerofeb,
          'devise'    => $devise,
          'personnel' => $personnel,
          'vehicule'  => $vehicules
      
          
        ]
      );
  }

  public function UpDjas(Request $request, $id)
  {
      DB::beginTransaction(); // Start a transaction

      try {
          // Find the Dja object
          $dja = Dja::find($id);

          // Check if the Dja object exists
          if (!$dja) {
              return response()->json([
                  'status' => 404,
                  'error' => 'Dja not found.'
              ]);
          }

          // Update properties of the Dja object only if they are present in the request
          if ($request->has('fond_recu_le')) $dja->fond_recu_le = $request->fond_recu_le;
          if ($request->has('montant_avance_un')) $dja->montant_avance_un = $request->montant_avance_un;
          if ($request->has('dure_avance')) $dja->duree_avance = $request->dure_avance;
          if ($request->has('fond_demander_par')) $dja->fonds_demande_par = $request->fond_demander_par;

          if ($request->has('date_fond_demande_par')) $dja->date_fonds_demande_par = $request->date_fond_demande_par;
          if ($request->has('avance_approuver_par_un')) $dja->avance_approuver_par = $request->avance_approuver_par_un;

          if ($request->has('date_signature_avance_approuver_un')) $dja->date_avance_approuver_par= $request->date_signature_avance_approuver_un;
          if ($request->has('avance_approuver_par_deux')) $dja->avance_approuver_par_deux = $request->avance_approuver_par_deux;

          if ($request->has('date_signature_avance_approuver_deux')) $dja->date_avance_approuver_par_deux = $request->date_signature_avance_approuver_deux;
          if ($request->has('fond_debourse_par')) $dja->fond_debourser_par = $request->fond_debourse_par;

          if ($request->has('date_signe_fond_debourses')) $dja->date_fond_debourser_par = $request->date_signe_fond_debourses;
          if ($request->has('fondPayea')) $dja->pfond_paye = $request->fondPayea;
        
          if ($request->has('fondPayeDescription')) $dja->description_avance = $request->fondPayeDescription;

          if ($request->has('plaque')) $dja->plaque = $request->plaque;

          if ($request->has('montantAvancedeux')) $dja->montant_avance = $request->montantAvancedeux;
          if ($request->has('montantUtilise')) $dja->montant_utiliser = $request->montantUtilise;
          if ($request->has('surplusManque')) $dja->montant_surplus = $request->surplusManque;
          if ($request->has('montantRetourne')) $dja->montant_retourne = $request->montantRetourne;
          if ($request->has('fond_retourne')) $dja->fonds_retournes_caisse_par = $request->fond_retourne;
          if ($request->has('bordereauVersement')) $dja->bordereau_versement = $request->bordereauVersement;
          if ($request->has('du')) $dja->du_num = $request->du;
          if ($request->has('reception_pieces_par')) $dja->reception_pieces_justificatives = $request->reception_pieces_par;
          //if ($request->has('reception_pieces_justificatives')) $dja->reception_pieces_justificatives = $request->reception_pieces_justificatives;
        // if ($request->has('date_reception_pieces_justificatives')) $dja->date_reception_pieces_justificatives = $request->date_reception_pieces_justificatives;
          //if ($request->has('justifie')) $dja->justifie = $request->justifie;

          // Save the changes to the database
          $dja->save();

          // Commit the transaction
          DB::commit();

          return response()->json([
              'status' => 200,
              'message' => 'Dja updated successfully.'
          ]);
      } catch (\Exception $e) {
          // Rollback the transaction in case of error
          DB::rollback();

          return response()->json([
              'status' => 500,
              'error' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
          ]);
      }
  }

  public function voir($id)
  {

      $IDP = session()->get('id');
      $devise = session()->get('devise');
      $title = "Nouveau DJA";

      // Vérifier si l'une des variables de session n'est pas définie
    if (!$IDP ) {
      // Rediriger vers la route nommée 'dashboard'
      return redirect()->route('dashboard');
    }

      $data = DB::table('djas')
      ->orderBy('daps.numerodp', 'asc')
      ->join('users', 'djas.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->join('daps', 'djas.dapid', '=', 'daps.id')
    
      ->leftJoin('users as user_fonds_demandes', 'user_fonds_demandes.id', '=', 'djas.fonds_demande_par')
      ->leftJoin('personnels as personnel_fonds_demandes', 'user_fonds_demandes.personnelid', '=', 'personnel_fonds_demandes.id')

      ->leftJoin('users as user_avance_approuver_un', 'user_avance_approuver_un.id', '=', 'djas.avance_approuver_par')
      ->leftJoin('personnels as personnel_avance_approuver_un', 'user_avance_approuver_un.personnelid', '=', 'personnel_avance_approuver_un.id')

      ->leftJoin('users as user_avance_approuver_par_deux', 'user_avance_approuver_par_deux.id', '=', 'djas.avance_approuver_par_deux')
      ->leftJoin('personnels as personnel_avance_approuver_par_deux', 'user_avance_approuver_par_deux.personnelid', '=', 'personnel_avance_approuver_par_deux.id')
      
      ->leftJoin('users as user_fond_debourser_par', 'user_fond_debourser_par.id', '=', 'djas.fond_debourser_par')
      ->leftJoin('personnels as personnel_fond_debourser_par', 'user_fond_debourser_par.personnelid', '=', 'personnel_fond_debourser_par.id')

      ->leftJoin('users as user_fonds_retournes_caisse', 'user_fonds_retournes_caisse.id', '=', 'djas.fonds_retournes_caisse_par')
      ->leftJoin('personnels as personnel_fonds_retournes_caisse', 'user_fonds_retournes_caisse.personnelid', '=', 'personnel_fonds_retournes_caisse.id')

      ->leftJoin('users as user_reception_pieces', 'user_reception_pieces.id', '=', 'djas.reception_pieces_justificatives')
      ->leftJoin('personnels as personnel_reception_pieces', 'user_reception_pieces.personnelid', '=', 'personnel_reception_pieces.id')

      ->leftJoin('users as user_pfond_paye', 'user_pfond_paye.id', '=', 'djas.pfond_paye')
      ->leftJoin('personnels as personnel_pfond_paye', 'user_pfond_paye.personnelid', '=', 'personnel_pfond_paye.id')


      ->select(
          'djas.*',
          'djas.id as iddjas',
          'personnels.prenom as user_prenom',
          'djas.numerodjas as numerudja',
          'daps.numerodp as nume_dap',
          'daps.id as iddap',
          'daps.cho',

          'personnel_fonds_demandes.nom as fonds_demandes_nom',
          'personnel_fonds_demandes.prenom as fonds_demandes_prenom',
          'user_fonds_demandes.id as fonds_signe_fonds_demande_par',
          'user_fonds_demandes.id as fonds_demandes_userid',

          'personnel_avance_approuver_un.nom as avance_approuver_un_nom',
          'personnel_avance_approuver_un.prenom as avance_approuver_un_prenom',
          'user_avance_approuver_un.id as fonds_signe_avance_approuver_par',
          'user_avance_approuver_un.id as avance_approuver_un_userid',

          'personnel_avance_approuver_par_deux.nom as avance_approuver_par_deux_nom',
          'personnel_avance_approuver_par_deux.prenom as avance_approuver_par_deux_prenom',

          'personnel_fond_debourser_par.nom as fond_debourser_nom',
          'personnel_fond_debourser_par.prenom as fond_debourser_prenom',

          'personnel_fonds_retournes_caisse.nom as fonds_retournes_caisse_nom',
          'personnel_fonds_retournes_caisse.prenom as fonds_retournes_caisse_prenom',

          'personnel_reception_pieces.nom as reception_pieces_nom',
          'personnel_reception_pieces.prenom as reception_pieces_prenom',

          'personnel_pfond_paye.nom as pfond_paye_nom',
          'personnel_pfond_paye.prenom as pfond_paye_prenom',

      )
      ->where('djas.projetiddja', $IDP)
      ->where('djas.id', $id)
      ->first();


      $numerofeb = DB::table('febs')
          ->leftJoin('elementdaps', 'febs.id', 'elementdaps.referencefeb')
          ->leftJoin('comptes','febs.sous_ligne_bugdetaire','comptes.id')
          ->leftjoin('beneficaires', 'febs.beneficiaire', 'beneficaires.id')
          ->join('daps', 'elementdaps.dapid', 'daps.id')
          ->join('djas','daps.id','djas.dapid')
          ->select('febs.*', 'comptes.libelle as libelle_compte', 'beneficaires.libelle as beneficiaireNom','beneficaires.telephoneone','beneficaires.adresse', 'beneficaires.telephonedeux','beneficaires.description')
          ->where('elementdaps.dapid', $data->iddap)
          ->get();

      $personnel = DB::table('users')
          ->join('personnels', 'users.personnelid', '=', 'personnels.id')
          ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
          ->orderBy('nom', 'ASC')
          ->get();
        

      
      $vehicules = Vehicule::all();
      


      return view(
        'document.dja.voir',

        [
          'title'     => $title,
          'data'      => $data,
          'numerofeb' => $numerofeb,
          'devise'    => $devise,
          'personnel' => $personnel,
          'vehicule'  => $vehicules
      
          
        ]
      );
  }



}







//   <a href="dja/'.$cryptedId.'/edit" class="dropdown-item text-success mx-1" ><i class="far fa-edit"></i> Modifier DJA</a>