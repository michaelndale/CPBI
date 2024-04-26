<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\dap;
use App\Models\Elementdap;
use App\Models\Folder;
use App\Models\Historique;
use App\Models\Identification;
use App\Models\Notification;
use App\Models\Service;
use App\Models\User;

use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class DapController extends Controller
{

  public function fetchAll()
  {
    $ID = session()->get('id');

    $budget = session()->get('budget');

    $devise = session()->get('devise');

    $data = DB::table('daps')
      ->orderby('numerodap', 'DESC')
      ->join('febs','daps.referencefeb','febs.id')
      ->select('daps.*','febs.numerofeb')
      ->Where('projetiddap', $ID)
      ->get();

    $output = '';

    if ($data->count() > 0) {
      $nombre = 1;
      foreach ($data as $datas) {
        $usecode = $datas->userid;

        $persone = DB::table('users')
          ->join('personnels', 'personnels.userid', 'users.id')
          ->select('personnels.nom','personnels.prenom')
          ->Where('users.id', $usecode)
          ->first();
          
       // $userdata = ucfirst($persone->nom) . ' ' . ucfirst($persone->prenom);

        if ($datas->ov == 1) {
          $ov = "checked";
        } else {
          $ov = "";
        }
        if ($datas->cho == 1) {
          $cho = "checked";
        } else {
          $cho = "";
        }

        $cryptedId = Crypt::encrypt($datas->id);
        $output .= '
        <tr>
          <td> 
          <center>
          <div class="btn-group me-2 mb-2 mb-sm-0">
            <button class="btn btn-primary btn-sm dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false"> <i class="mdi mdi-dots-vertical ms-2"></i> Actions </button>
            <div class="dropdown-menu">
                <a href="dap/' . $cryptedId . '/view" class="dropdown-item text-success mx-1 voirIcon" ><i class="far fa-edit"></i> Voir dap</a>
                <a href="dap/' . $cryptedId . '/edit" class="dropdown-item text-primary mx-1 editIcon " title="Modifier"><i class="far fa-edit"></i> Modifier</a>
                <a href="dap/' . $datas->id . '/generate-pdf-dap" class="dropdown-item  mx-1"><i class="fa fa-print"> </i> Générer document PDF</a>
                <a class="dropdown-item text-danger mx-1 deleteIcon"  id="' . $datas->id . '"  href="#"><i class="far fa-trash-alt"></i> Supprimer</a>
            </div>
          </div>
          </center>
          </td>
          <td align="center"> ' . $datas->numerodap . '  </td>
          <td align="center"> ' . $datas->numerofeb . '  </td>
          <td> ' . $datas->lieu . ' </td>
          <td align="center"> <input type="checkbox"  ' . $ov . ' class="form-check-input" />  </td>
          <td align="center"> <input type="checkbox"  ' . $cho . ' class="form-check-input" />  </td>
          <td> ' . $datas->comptabiliteb . ' </td>
       
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
  public function store(Request $request)
  {
    try {

      /* $numerodap = $request->numerodap;
        $check = dap::where('numerodap',$numerodap)->first();
        if($check){
          return response()->json([
            'status' => 201,
          ]);
        }else{ */

      if ($request->has('ov')) {
        $ov = 1;
      } else {
        $ov = 0;
      }
      if ($request->has('ch')) {
        $ch = 1;
      } else {
        $ch = 0;
      }


      $dap = new dap();

      $dap->numerodap      = $request->numerodap;
      $dap->serviceid      = $request->serviceid;
      $dap->projetiddap    = $request->projetid;
      $dap->referencefeb   = $request->febid;
      $dap->lieu           = $request->lieu;
      $dap->comptabiliteb  = $request->comptebanque;
      $dap->ov             = $ov;
      $dap->cho            = $ch;
      $dap->demandeetablie = $request->demandeetablie;
      $dap->verifierpar    = $request->verifier;
      $dap->approuverpar   = $request->approuver;
      $dap->responsable    = $request->resposablefinancier;
      $dap->secretaire     = $request->secretairegenerale;
      $dap->chefprogramme  = $request->chefprogramme;
      $dap->observation    = $request->observation;
      $dap->userid = Auth::id();

      $dap->save();

      if ($dap) {
        return response()->json([
          'status' => 200,

        ]);
      } else {
        return response()->json([
          'status' => 202,

        ]);
      }
    } catch (Exception $e) {
      return response()->json([
        'status' => 203,

      ]);
    }
  }

  // insert a new employee ajax request
  public function updatestore(Request $request)
  {
    try {

      

      $dap = dap::where('id', $request->dapid)->first();

      if ($request->has('ov')) {
        $ov = 1;
      } else {
        $ov = 0;
      }
      if ($request->has('ch')) {
        $ch = 1;
      } else {
        $ch = 0;
      }

      $dap->numerodap      = $request->numerodap;
      $dap->serviceid      = $request->serviceid;
      $dap->lieu           = $request->lieu;
      $dap->comptabiliteb  = $request->comptebanque;
      $dap->ov             = $ov;
      $dap->cho            = $ch;
      $dap->dateautorisation    = $request->datesecretairegenerale;
      $dap->demandeetablie = $request->demandeetablie;
      $dap->verifierpar    = $request->verifier;
      $dap->approuverpar   = $request->approuver;
      $dap->responsable    = $request->resposablefinancier;
      $dap->secretaire     = $request->secretairegenerale;
      $dap->chefprogramme  = $request->chefprogramme;
      $dap->observation    = $request->observation;

      $dap->update();

      if ($dap) {
        return back()->with('success', 'Très bien ! Mises à jour effectuées avec succès  ');
      } else {
        return back()->with('failed', 'Échec ! Les mises à jour n\'ont pas réussi.');
      }
    } catch (Exception $e) {
      return back()->with('failed', 'Échec ! Les mises à jour n\'ont pas réussi.');
    }
  }

  public function list()
  {
    $title = "DAP";

    $service = Service::all();
    $compte = Compte::where('compteid', '=', NULL)->get();
    // utilisateur
    $personnel = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
      ->orWhere('fonction', '!=', 'Chauffeur')
      ->orderBy('nom', 'ASC')
      ->get();

    // projet encours
    $ID = session()->get('id');
    $budget = session()->get('budget');
    $devise = session()->get('devise');

    // Activite
    $activite = DB::table('activities')
      ->orderby('id', 'DESC')
      ->Where('projectid', $ID)
      ->get();

    // feb
    $feb = DB::table('febs')
      ->orderby('id', 'DESC')
      ->Where('projetid', $ID)
      ->get();

    $somfeb = DB::table('elementfebs')
      ->orderby('id', 'DESC')
      ->Where('projetids', $ID)
      ->SUM('montant');
    $somfeb =  $budget - $somfeb;
    $somfeb = number_format($somfeb, 0, ',', ' ') . ' ' . $devise;


    return view(
      'document.dap.list',
      [
        'title'     => $title,
        'activite'  => $activite,
        'personnel' => $personnel,
        'service'   => $service,
        'feb'       => $feb,
        'compte'    => $compte,
        'somfeb'    => $somfeb
      ]
    );
  }

  public function updatesignature(Request $request)
  {
    try {

      if (
        !empty($request->demandeetabliesignature) || !empty($request->verifierparsignature) || !empty($request->approuverparsignature)
        || !empty($request->responsablesignature) || !empty($request->chefprogrammesignature) || !empty($request->secretairesignature)
      ) {
        $emp = dap::find($request->dapid);

        if ($request->has('demandeetabliesignature')) {
          $demandeetabliesignature = 1;
          if ($request->filled('dated')) {
            $dated = $request->dated;
          } else {
            $dated = date('j-m-Y');
          }
        } else {
          $demandeetabliesignature = $request->clone_demandeetabliesignature;
          $dated = '';
        }
        if ($request->has('verifierparsignature')) {
          $verifierparsignature = 1;
          if ($request->filled('datev')) {
            $datev = $request->datev;
          } else {
            $datev = date('j-m-Y');
          }
        } else {
          $verifierparsignature = $request->clone_verifierparsignature;
          $datev = '';
        }
        if ($request->has('approuverparsignature')) {
          $approuverparsignature = 1;
          if ($request->filled('datea')) {
            $datea = $request->datea;
          } else {
            $datea = date('j-m-Y');
          }
        } else {
          $approuverparsignature = $request->clone_approuverparsignature;
          $datea = '';
        }

        if ($request->has('responsablesignature')) {
          $responsablesignature = 1;
        } else {
          $responsablesignature = $request->clone_responsablesignature;
        }
        if ($request->has('chefprogrammesignature')) {
          $chefprogrammesignature = 1;
        } else {
          $chefprogrammesignature = $request->clone_chefprogrammesignature;
        }
        if ($request->has('secretairesignature')) {
          $secretaure_general_signe = 1;
        } else {
          $secretaure_general_signe = $request->clone_secretairesignature;
        }

        $emp->demandeetablie_signe = $demandeetabliesignature;
        $emp->demandeetablie_signe_date = $dated;
        $emp->verifierpar_signe = $verifierparsignature;
        $emp->verifierpar_signe_date = $datev;

        $emp->approuverpar_signe = $approuverparsignature;
        $emp->approuverpar_signe_date = $datea;
        $emp->responsable_signe = $responsablesignature;
        $emp->chefprogramme_signe = $chefprogrammesignature;
        $emp->secretaure_general_signe = $secretaure_general_signe;


        $do = $emp->update();

        if ($do) {


          return redirect()->route('listdap')->with('success', 'Très bien! Vous avez poser la signature ');
        } else {
          return back()->with('failed', 'Echec ! la signature  n\'est pas put etre poser correctement ');
        }
      } else {
        return back()->with('failed', 'Echec ! la signature  dois etre poser');
      }
    } catch (Exception $e) {
      return redirect()->route('listdap')->with('success', 'Très bien! Vous avez poser la signature ');
    }
  }

  public function updateautorisactiondap(Request $request)
  {
    try {
      $emp = dap::find($request->dapid);

      $emp->dateautorisation = $request->dateau;
      $do = $emp->update();

      if ($do) {
        //$route='dap/'.$request->dapid.'/view' ;

        return redirect()->route('listdap')->with('success', 'Très bien! Vous avez autoriser la date ');
      } else {
        return back()->with('failed', 'Echec ! la date  n\'est pas etes envoyez');
      }
    } catch (Exception $e) {
      return redirect()->route('dap')->with('success', 'Très bien! Vous avez autoriser la date ');
    }
  }

  public function update_autorisation_dap(Request $request)
  {
    try {
      $emp = dap::find($request->dapid);

      $emp->observation = $request->observation_text;
      $do = $emp->update();

      if ($do) {


        return redirect()->route('listdap')->with('success', 'Très bien! Vous avez autoriser la date ');
      } else {
        return back()->with('failed', 'Echec ! la date  n\'est pas etes envoyez');
      }
    } catch (Exception $e) {
      return redirect()->route('listdap')->with('success', 'Très bien! Vous avez autoriser la date ');
    }
  }



  public function delete(Request $request)
  {

    try {
      $emp = dap::find($request->id);
      if ($emp->userid == Auth::id()) {
          $id = $request->id;
          $his = new Historique;
          $function = "Suppression";
          $operation = "Suppression Dap";
          $link = 'dap';
          $his->fonction = $function;
          $his->operation = $operation;
          $his->userid = Auth()->user()->id;
          $his->link = $link;
          $his->save();

          $id = $request->id;
          dap::destroy($id);

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

  

  public function show($idd)
  {

    $ID = session()->get('id');

    $budget = session()->get('budget');

    $devise = session()->get('devise');

    $title = "Voir DAP";
    $ID = session()->get('id');
    $dateinfo = Identification::all()->first();

    $idd = Crypt::decrypt($idd);

   



    $datadap = DB::table('daps')
      ->join('services', 'daps.serviceid', 'services.id')
      ->join('febs', 'daps.referencefeb', 'febs.id')
      ->select('daps.*', 'daps.id as iddape', 'services.title as titres',  'febs.id as idf', 'febs.ligne_bugdetaire', 'febs.descriptionf', 'febs.numerofeb', 'febs.comptable')
      ->Where('projetiddap', $ID)
      ->Where('daps.id', $idd)
      ->first();

    $idl = $datadap->ligne_bugdetaire;

    // total consommation sur la ligne
    $totoSUM = DB::table('elementfebs')
      ->Where('eligne', $idl)
      ->Where('projetids', $ID)
      ->SUM('montant');

  $dataLigne = Compte::where('id', $idl)->first();

    $sommefebs = DB::table('elementfebs')
      ->Where('febid', $datadap->idf)
      ->SUM('montant');

    // dd($sommefebs);

    $pourcentageligne = round(($totoSUM * 100) / $budget,2);
    // $sommefeb = number_format($sommefebs, 0, ',', ' ');

    $allmontant = DB::table('elementfebs')
      ->Where('projetids', $ID)
      ->SUM('montant');
    $solder_dap = $budget - $allmontant;
    $pourcentage_global_b = round(($allmontant * 100) / $budget,2);

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

    //chef composant


    $dataElementfeb = DB::table('elementfebs')
      ->join('activities', 'elementfebs.libellee', 'activities.id')
      ->select('elementfebs.*', 'activities.id as ida', 'activities.titre as titrea')
      ->Where('febid', $datadap->idf)
      ->get();


    return view(
      'document.dap.voir',
      [
        'title'     => $title,
        'dateinfo'  => $dateinfo,
        'datadap'   => $datadap,
        'pourcentageligne' => $pourcentageligne,
        'pourcentage_global_b' => $pourcentage_global_b,
        'solder_dap' => $solder_dap,
        'etablienom' => $etablienom,
        'dataElementfeb' => $dataElementfeb,
        'sommefeb' => $sommefebs,
        'Demandeetablie' => $Demandeetablie,
        'verifierpar' => $verifierpar,
        'approuverpar' => $approuverpar,
        'responsable'  => $responsable,
        'secretaire'   => $secretaire,
        'chefprogramme' => $chefprogramme,
        'dataLigne'   =>  $dataLigne

      ]
    );
  }


  public function edit($idd)
  {

    $title = "Modification DAP";
    $service = Service::all();

    $compte = Compte::where('compteid', '=', NULL)->get();
    // utilisateur
    $personnel = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->orderBy('nom', 'ASC')
      ->get();

    // projet encours
    $ID = session()->get('id');
    $budget = session()->get('budget');
    $devise = session()->get('devise');

    // Activite
    $activite = DB::table('activities')
      ->orderby('id', 'DESC')
      ->Where('projectid', $ID)
      ->get();

    // feb
    $somfeb = DB::table('elementfebs')
      ->orderby('id', 'DESC')
      ->Where('projetids', $ID)
      ->SUM('montant');
    $somfeb =  $budget - $somfeb;
    $somfeb = number_format($somfeb, 0, ',', ' ') . ' ' . $devise;

    $idd = Crypt::decrypt($idd);

    $datadap = DB::table('daps')
      ->join('services', 'daps.serviceid', 'services.id')
      ->join('febs', 'daps.referencefeb', 'febs.id')
      ->select('daps.*', 'daps.id as iddape', 'services.title as titres', 'febs.*', 'febs.id as idf', 'services.id as idss')
      ->Where('projetiddap', $ID)
      ->Where('daps.id', $idd)
      ->first();

    $datafeb = DB::table('febs')
      ->join('comptes', 'febs.ligne_bugdetaire', '=', 'comptes.id')
      ->join('personnels', 'febs.acce', '=', 'personnels.id')
      ->join('rallongebudgets', 'febs.ligne_bugdetaire', '=', 'rallongebudgets.compteid')
      ->select('febs.*', 'comptes.libelle', 'personnels.nom', 'personnels.prenom', 'rallongebudgets.budgetactuel')
      ->Where('febs.id', $datadap->idf)
      ->Where('febs.projetid', $ID)
      ->first();

    $sommefebs = DB::table('elementfebs')
      ->Where('febid', $datadap->idf)
      ->SUM('montant');
    $sommefebs = number_format($sommefebs, 0, ',', ' ') . ' ' . $devise;

    $chefcomposant = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as idus', 'users.signature')
      ->Where('users.id', $datadap->demandeetablie)
      ->first();

    $chefcomptable = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as idus', 'users.signature')
      ->Where('users.id', $datadap->verifierpar)
      ->first();

    $chefservice = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as idus', 'users.signature')
      ->Where('users.id', $datadap->approuverpar)
      ->first();

    $responsable = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as idus', 'users.signature')
      ->Where('users.id', $datadap->responsable)
      ->first();

    $secretaire = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as idus', 'users.signature')
      ->Where('users.id', $datadap->secretaire)
      ->first();

    $chefprogramme = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as idus', 'users.signature')
      ->Where('users.id', $datadap->chefprogramme)
      ->first();


    return view(
      'document.dap.edit',
      [
        'title'     => $title,
        'activite'  => $activite,
        'personnel' => $personnel,
        'service'   => $service,
        'compte'    => $compte,
        'somfeb'    => $somfeb,
        'datadap'   => $datadap,
        'datafeb'   => $datafeb,
        'sommefebs' => $sommefebs,
        'chefcomposant' => $chefcomposant,
        'chefcomptable' => $chefcomptable,
        'chefservice' =>  $chefservice,
        'responsable' => $responsable,
        'secretaire'  => $secretaire,
        'chefprogramme' => $chefprogramme
      ]
    );
  }

  public function generatePDFdap($id)
  {
    $budget = session()->get('budget');
    $IDB = session()->get('id');
    $dompdf = new Dompdf();

    $ID = session()->get('id');
    $budget = session()->get('budget');
    $devise = session()->get('devise');

   


    // Activite
    $activite = DB::table('activities')
      ->orderby('id', 'DESC')
      ->Where('projectid', $ID)
      ->get();

    // feb
    $somfeb = DB::table('elementfebs')
      ->orderby('id', 'DESC')
      ->Where('projetids', $ID)
      ->SUM('montant');
    $somfeb =  $budget - $somfeb;
    $somfeb = number_format($somfeb, 0, ',', ' ') . ' ' . $devise;


    $infoglo = DB::table('identifications')->first();

    $datadap = DB::table('daps')
      ->join('services', 'daps.serviceid', 'services.id')
      ->join('febs', 'daps.referencefeb', 'febs.id')
      ->select('daps.*', 'daps.id as iddape', 'services.title as titres', 'febs.*', 'febs.id as idf', 'services.id as idss')
      ->Where('projetiddap', $IDB)
      ->Where('daps.id', $id)
      ->first();
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

      $chefservice = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as idus', 'users.signature')
      ->Where('users.id', $datadap->approuverpar)
      ->first();

    //chef composant


    $dataElementfeb = DB::table('elementfebs')
      ->join('activities', 'elementfebs.libellee', 'activities.id')
      ->select('elementfebs.*', 'activities.id as ida', 'activities.titre as titrea')
      ->Where('febid', $datadap->idf)
      ->get();

      $datafeb = DB::table('febs')
      ->join('comptes', 'febs.ligne_bugdetaire', '=', 'comptes.id')
      ->join('personnels', 'febs.acce', '=', 'personnels.id')
      ->join('rallongebudgets', 'febs.ligne_bugdetaire', '=', 'rallongebudgets.compteid')
      ->select('febs.*', 'comptes.libelle', 'personnels.nom', 'personnels.prenom', 'rallongebudgets.budgetactuel')
      ->Where('febs.id', $datadap->idf)
      ->Where('febs.projetid', $ID)
      ->first();

      $chefcomposant = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as idus', 'users.signature')
      ->Where('users.id', $datadap->demandeetablie)
      ->first();

      $chefcomptable = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as idus', 'users.signature')
      ->Where('users.id', $datadap->verifierpar)
      ->first();

  

    // total consommation sur la ligne
    $totoSUM = DB::table('elementfebs')
    ->Where('eligne', $datadap->ligne_bugdetaire)
    ->Where('projetids', $ID)
    ->SUM('montant');

  $sommefebs = DB::table('elementfebs')
    ->Where('febid', $datadap->idf)
    ->SUM('montant');

  // dd($sommefebs);

  $pourcentageligne = round(($totoSUM * 100) / $budget,2);
  // $sommefeb = number_format($sommefebs, 0, ',', ' ');

  $allmontant = DB::table('elementfebs')
    ->Where('projetids', $ID)
    ->SUM('montant');
  $solder_dap = $budget - $allmontant;
  $pourcentage_global_b = round(($allmontant * 100) / $budget,2);



    $pdf = FacadePdf::loadView('document.dap.dap', compact('infoglo', 'datadap','somfeb','datafeb','etablienom','Demandeetablie','verifierpar','approuverpar','responsable','secretaire','chefprogramme','dataElementfeb','pourcentage_global_b','solder_dap','sommefebs','chefcomposant','chefcomptable','chefservice'));

    $pdf->setPaper('A4', 'landscape'); // Définit le format A4 en mode paysage

    return $pdf->download('invoice.pdf');
  }
}
