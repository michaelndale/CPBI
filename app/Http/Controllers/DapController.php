<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\dap;
use App\Models\Dja;
use App\Models\Elementdap;
use App\Models\Feb;
use App\Models\Folder;
use App\Models\Historique;
use App\Models\Identification;
use App\Models\Notification;
use App\Models\Service;
use App\Models\User;
use App\Models\Vehicule;
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

  public function getFuelType(){
    $fuelTypes = Vehicule::pluck('matricule')->toArray(); // Supposons que votre table de carburant contient une colonne 'type'

    return response()->json($fuelTypes);
  }

  public function fetchAll()
  {
    $ID = session()->get('id');


    $data =  DB::table('elementdaps')
    ->select('numerodap', DB::raw('MIN(id) as id'), DB::raw('MIN(dapid) as dapid') , DB::raw('MIN(referencefeb) as referencefeb')) // Sélectionnez numerodap et l'ID minimum
    ->where('projetidda', $ID)
    ->groupBy('numerodap') // Grouper par numerodap pour obtenir des valeurs uniques
    ->orderBy('numerodap', 'ASC')
    ->get();

    $output = '';

    if ($data->count() > 0) {
      $nombre = 1;
      foreach ($data as $datas) {

      
        $infodap = DB::table('daps')
                ->where('id', $datas->dapid)
                ->first();
            if($infodap->ov==1){ $ov="checked" ; } else{ $ov=""; }
            if($infodap->cho==1){ $cho="checked" ; } else{ $cho=""; }
            if($infodap->justifier==1){ $justifier="checked" ; } else{ $justifier=""; }


            $numerofeb = DB::table('febs')
                ->join('elementdaps','febs.id' , 'elementdaps.referencefeb')
                ->where('elementdaps.numerodap', $datas->numerodap)
                ->get();
      
//   <a href="dap/' . $cryptedId . '/edit" class="dropdown-item text-primary mx-1 editIcon " title="Modifier"><i class="far fa-edit"></i> Modifier</a>

        $cryptedId = Crypt::encrypt($datas->numerodap);
        $output .= '
        <tr>
          <td> 
          <center>
          <div class="btn-group me-2 mb-2 mb-sm-0">
            <button class="btn btn-primary btn-sm dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false"> <i class="mdi mdi-dots-vertical ms-2"></i> Actions </button>
            <div class="dropdown-menu">
                <a href="dap/' . $cryptedId . '/view" class="dropdown-item text-success mx-1 voirIcon" ><i class="far fa-edit"></i> Voir dap</a>
             
                <a href="dap/' . $datas->id . '/generate-pdf-dap" class="dropdown-item  mx-1"><i class="fa fa-print"> </i> Générer document PDF</a>
                <a class="dropdown-item text-danger mx-1 deleteIcon"  id="' . $datas->id . '"  href="#"><i class="far fa-trash-alt"></i> Supprimer</a>
            </div>
          </div>
          </center>
          </td>
          <td align="center"> ' . $datas->numerodap . '  </td>
          <td align="center">';

          foreach ($numerofeb  as $key =>  $numerofebs) { 
            $output .= '['.$numerofebs->numerofeb.']';
            // Si ce n'est pas le dernier élément, ajoute une virgule
            if ($key < count($numerofeb) - 1) {
                $output .= ',';
            }

           }

           
            
           
            $output .='

           </td>
           <td>'.$infodap->lieu.'</td>
           <td align="center"><input type="checkbox"  '. $ov .' class="form-check-input" /> </td>
           <td align="center"><input type="checkbox"  '. $cho .' class="form-check-input" /> </td>
           <td align="center">'.$infodap->comptabiliteb.'</td>
           <td align="center"><input type="checkbox"  '. $justifier .' class="form-check-input" /> </td>
           <td align="center"> ' .date('d-m-Y', strtotime($infodap->created_at)). '  </td>
         
       
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


  public function checkDap(Request $request)
    {
        $ID = session()->get('id');
        $numero = $request->numerodap;

        $dap = Dap::where('numerodp', $numero)
        ->where('projetiddap', $ID)
        ->exists();

        return response()->json(['exists' => $dap]);
      
    }

 

  // insert a new employee ajax request
  public function store(Request $request)
  {
      try {
          // Commencer une transaction de base de données
          DB::beginTransaction();
  
          // Détermination des valeurs pour les champs ov, ch, justifier et nonjustifier
          $ov = $request->has('ov') ? 1 : 0;
          $ch = $request->has('ch') ? 1 : 0;
          $justifier = $request->has('justifier') ? 1 : 0;
          $nonjustifier = $request->has('nonjustifier') ? 1 : 0;
  
          // Création d'une nouvelle instance de modèle Dap et attribution des valeurs
          $dap = new dap();
          $dap->numerodp      = $request->numerodap;
          $dap->serviceid      = $request->serviceid;
          $dap->projetiddap    = $request->projetid;
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
          $dap->justifier      = $justifier;
          $dap->nonjustifier   = $nonjustifier;
          $dap->userid         = Auth::id();
  
          // Sauvegarde du modèle Dap
          $do = $dap->save();
          $IDdap = $dap->id;
  
          if ($do) {
              // Récupérer les valeurs de febid
              if ($request->has('febid')) {
                  $febidArray = $request->febid;
  
                  // Itérer sur chaque febid et enregistrer les données
                  foreach ($febidArray as $key => $febid) {
                      // Vérifier si un enregistrement avec la même référencefeb existe déjà
                      $existingDapE = Elementdap::where('referencefeb', $febid)->first();
  
                      // Si aucun enregistrement existant n'est trouvé, procéder à la sauvegarde
                      if (!$existingDapE) {
                          $dapE = new Elementdap();

                      
                          $dapE->dapid = $IDdap;
                          $dapE->numerodap = $request->numerodap;
                          $dapE->referencefeb = $febid;
                          $dapE->projetidda = $request->projetid;
                          if ($justifier == 1) {
                          $dapE->ligneided = $request->ligneid[$key] ?? null;
                          $dapE->montantavance = $request->montantavance[$key] ?? null;
                          $dapE->duree_avance = $request->duree_avance[$key] ?? null;
                          $dapE->montantutiliser = $request->montantutiliser[$key] ?? null;
                          $dapE->surplus = $request->surplus[$key] ?? null;
                          $dapE->matriculenum = $request->matriculenum[$key] ?? null;
                          $dapE->numfacture = $request->facture[$key] ?? null;
                          $dapE->montantretour = $request->montantretour[$key] ?? null;
                          $dapE->descriptionn = $request->descriptionel[$key] ?? null;
                          $dapE->bordereau = $request->bordereau[$key] ?? null;
                          $dapE->datedu = $request->datedu[$key] ?? null;
                          }
  
                          $dapE->save();
  
                          // Mettre à jour le statut de l'élément Feb correspondant
                          $element = Feb::where('id', $febid)->first();
                          if ($element) {
                              $element->statut = 1;
                              $element->save();
                          }
                      }
                  }
              }
  
              if ($justifier == 1) {
                  // Exécutez les nouvelles informations
                  $justification = new Dja();
  
                  $justification->numerodjas = $request->numerodap;
                  $justification->projetiddja = $request->projetid;
                  $justification->numerodap = $request->numerodap;
                  $justification->numeroov = $ov;
                  $justification->userid = Auth::id();
  
                  $justification->save();
              }
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

    $ID = session()->get('id');
    $budget = session()->get('budget');
    $devise = session()->get('devise');

    $service = Service::all();
    $compte = Compte::where('compteid', '=', NULL)->get();
    // utilisateur
    $personnel = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
      ->orWhere('fonction', '!=', 'Chauffeur')
      ->orderBy('nom', 'ASC')
      ->get();
  
    // Activite
    $activite = DB::table('activities')
      ->orderby('id', 'DESC')
      ->Where('projectid', $ID)
      ->get();

    // RECUPERETION FEB NUMERO
    $feb = DB::table('febs')
      ->orderby('numerofeb', 'ASC')
      ->Where('projetid', $ID)
      ->Where('statut',0)
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
          
          $elements = Elementdap::where('dapid', '=', $id )->get();

          foreach ($elements as $element) {

              $idf = $element->referencefeb	;
              $Up = Feb::where('id', $idf)->first();
              $Up->statut = 0;
              $U=$Up->update();

              if($U){
                $element->delete();
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
      ->join('elementdaps', 'daps.id' , 'elementdaps.dapid') 
      ->select('daps.*', 'daps.id as iddape', 'services.title as titres','elementdaps.numerodap')
      ->Where('projetiddap', $ID)
      ->Where('elementdaps.numerodap', $idd)
      ->first();

      $elementfeb = DB::table('febs')
      ->join('elementdaps','febs.id' , 'elementdaps.referencefeb')
      ->select('elementdaps.*','febs.id as fid','febs.numerofeb','febs.descriptionf')
      ->where('elementdaps.numerodap', $idd)
      ->get();

      $somme_gloable = DB::table('elementfebs')
      ->Where('projetids', $ID)
      ->SUM('montant');
      $pourcetage_globale =round(($somme_gloable* 100) / $budget,2);

      $solde_comptable = $budget-$somme_gloable;


   
      $elementfebencours = DB::table('febs')
      ->join('elementdaps','febs.id' , 'elementdaps.referencefeb')
      ->select('elementdaps.*','febs.id as fid','febs.numerofeb','febs.descriptionf')
      ->where('elementdaps.numerodap', $idd)
      ->get();

      $somme_element_encours= 0;
      foreach ($elementfebencours as $key => $elementfebencourss) {
        $totoSUM = DB::table('elementfebs')
        ->orderBy('id', 'DESC')
        ->where('febid', $elementfebencourss->fid)
        ->sum('montant');
        $somme_element_encours += $totoSUM;
      }


     $pourcentage_encours=  round(($somme_element_encours* 100) / $budget,2);

     $taux_execution_avant = $pourcetage_globale-$pourcentage_encours;

 

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

    return view(
      'document.dap.voir',
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
        'budget'=>$budget,
        'pourcetage_globale' => $pourcetage_globale,
        'solde_comptable' => $solde_comptable,
        'taux_execution_avant' => $taux_execution_avant,
        'pourcentage_encours' => $pourcentage_encours

      
      ]
    );
  }


  public function edit($idd)
  {
$ID = session()->get('id');
    $budget = session()->get('budget');
    $devise = session()->get('devise');

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
    $devise = session()->get('devise');

    $dateinfo = Identification::all()->first();

    // $idd = Crypt::decrypt($idd);
 
    $datadap = DB::table('daps')
    ->join('services', 'daps.serviceid', 'services.id')
    ->join('elementdaps', 'daps.id' , 'elementdaps.dapid') 
    ->select('daps.*', 'daps.id as iddape', 'services.title as titres','elementdaps.numerodap')
    ->Where('projetiddap', $IDB)
    ->Where('elementdaps.numerodap', $id)
    ->first();
 
       $datafebElement = DB::table('febs')
       ->join('elementdaps','febs.id' , 'elementdaps.referencefeb')
       ->select('elementdaps.*','febs.id as fid','febs.numerofeb','febs.descriptionf')
       ->where('elementdaps.numerodap', $id)
       ->get();
 
       $somme_gloable = DB::table('elementfebs')
       ->Where('projetids', $IDB)
       ->SUM('montant');
       $pourcetage_globale =round(($somme_gloable* 100) / $budget,2);
 
       $solde_comptable = $budget-$somme_gloable;
 
 
    
       $elementfebencours = DB::table('febs')
       ->join('elementdaps','febs.id' , 'elementdaps.referencefeb')
       ->select('elementdaps.*','febs.id as fid','febs.numerofeb','febs.descriptionf')
       ->where('elementdaps.numerodap', $id)
       ->get();
 
       $somme_element_encours= 0;
       foreach ($elementfebencours as $key => $elementfebencourss) {
         $totoSUM = DB::table('elementfebs')
         ->orderBy('id', 'DESC')
         ->where('febid', $elementfebencourss->fid)
         ->sum('montant');
         $somme_element_encours += $totoSUM;
       }
 
 
      $pourcentage_encours=  round(($somme_element_encours* 100) / $budget,2);
 
      $taux_execution_avant = $pourcetage_globale-$pourcentage_encours;

   


    // Activite
    $activite = DB::table('activities')
      ->orderby('id', 'DESC')
      ->Where('projectid', $IDB)
      ->get();

    // feb
    $somfeb = DB::table('elementfebs')
      ->orderby('id', 'DESC')
      ->Where('projetids', $IDB)
      ->SUM('montant');
    $somfeb =  $budget - $somfeb;
    $somfeb = number_format($somfeb, 0, ',', ' ') . ' ' . $devise;


    $infoglo = DB::table('identifications')->first();

   

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



    $pdf = FacadePdf::loadView('document.dap.dap', compact('infoglo',
    'datafebElement',
    'budget','pourcetage_globale','solde_comptable',
    'taux_execution_avant','pourcentage_encours' ,
    'datadap','etablienom','Demandeetablie','verifierpar',
    'approuverpar','responsable','secretaire','chefprogramme',
   
 'chefcomposant','chefcomptable','chefservice'));

    $pdf->setPaper('A4', 'landscape'); // Définit le format A4 en mode paysage

    return $pdf->download('invoice.pdf');
  }
  
}
