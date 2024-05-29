<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\dap;
use App\Models\Dja;
use App\Models\Elementdap;
use App\Models\Elementdjas;
use App\Models\Feb;
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

  public function getFuelType()
  {
    $fuelTypes = Vehicule::pluck('matricule')->toArray(); // Supposons que votre table de carburant contient une colonne 'type'

    return response()->json($fuelTypes);
  }

  public function fetchAll()
  {
    $ID = session()->get('id');


    $datadap = DB::table('daps')
      ->join('users', 'daps.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('daps.*', 'personnels.prenom as user_prenom')
      ->where('daps.projetiddap', $ID)
      ->orderBy('daps.numerodp', 'asc') // Remplacez 'some_column' par la colonne que vous souhaitez utiliser pour le tri
      ->get();
      


    $output = '';

    if ($datadap->count() > 0) {
      $nombre = 1;
      foreach ($datadap as $datadaps) {


        if ($datadaps->ov == 1) {
          $ov = "checked";
        } else {
          $ov = "";
        }

        if ($datadaps->justifier == 1) {
          $justifier = "checked";
        } else {
          $justifier = "";
        }
        $numerofeb = DB::table('febs')
          ->join('elementdaps', 'febs.id', 'elementdaps.referencefeb')
          ->where('elementdaps.dapid', $datadaps->id)
          ->get();

        //   

        $cryptedId = Crypt::encrypt($datadaps->id);
        $output .= '
        <tr>
          <td> 
          <center>
          <div class="btn-group me-2 mb-2 mb-sm-0">
          <a  data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical ms-2"></i> Options
                            </a>
            <div class="dropdown-menu">
                <a href="dap/' . $cryptedId . '/view" class="dropdown-item  mx-1 voirIcon" ><i class="far fa-eye"></i> Voir </a>  
                <a href="dap/' . $cryptedId . '/edit" class="dropdown-item  mx-1 editIcon " title="Modifier"><i class="far fa-edit"></i> Modifier</a>
                <a href="dap/' . $datadaps->id . '/generate-pdf-dap" class="dropdown-item  mx-1"><i class="fa fa-print"> </i> Générer document PDF</a>
                <a class="dropdown-item text-danger mx-1 deleteIcon"  id="' . $datadaps->id . '"  href="#"><i class="far fa-trash-alt"></i> Supprimer</a>
            </div>
          </div>
          </center>
          </td>
          <td align="center"> ' . $datadaps->numerodp . '  </td>
          <td align="center">';

        foreach ($numerofeb  as $key =>  $numerofebs) {
          $output .= '[' . $numerofebs->numerofeb . ']';
          // Si ce n'est pas le dernier élément, ajoute une virgule
          if ($key < count($numerofeb) - 1) {
            $output .= ',';
          }
        }

        $output .= '
           </td>
           <td>' . $datadaps->lieu . '</td>
           <td align="center"><input type="checkbox"  ' . $ov . ' class="form-check-input" /> </td>
           <td align="center">' . $datadaps->cho . '</td>
           <td align="center">' . $datadaps->comptabiliteb . '</td>
           <td align="center"><input type="checkbox"  ' . $justifier . ' class="form-check-input" /> </td>
           <td align="center"> ' . date('d-m-Y', strtotime($datadaps->created_at)) . '  </td>
          
           <td align="center">' . ucfirst($datadaps->user_prenom) . '</td>
       
        </tr>
      ';
        $nombre++;
      }
      echo $output;
    } else {
      echo '<tr>
        <td colspan="10">
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

      // Détermination des valeurs pour les champs ov, justifier et nonjustifier
      $ov = $request->has('ov') ? 1 : 0;
      $justifier = $request->has('justifier') ? 1 : 0;
      $nonjustifier = $request->has('nonjustifier') ? 1 : 0;

      // Création d'une nouvelle instance de modèle Dap et attribution des valeurs
      $dap = new Dap();
      $dap->numerodp = $request->numerodap;
      $dap->serviceid = $request->serviceid;
      $dap->projetiddap = $request->projetid;
      $dap->lieu = $request->lieu;
      $dap->comptabiliteb = $request->comptebanque;
      $dap->soldecompte = $request->soldecompte;
      $dap->ov = $ov;
      $dap->cho = $request->ch;
      $dap->demandeetablie = $request->demandeetablie;
      $dap->verifierpar = $request->verifier;
      $dap->approuverpar = $request->approuver;
      $dap->responsable = $request->resposablefinancier;
      $dap->secretaire = $request->secretairegenerale;
      $dap->chefprogramme = $request->chefprogramme;
      $dap->observation = $request->observation;

      if ($justifier == 1) {
        $dap->beneficiaire = $request->filled('beneficiaire') ? $request->beneficiaire : NULL;
      }

      $dap->justifier = $justifier;
      $dap->nonjustifier = $nonjustifier;
      $dap->userid = Auth::id();
      $dap->save();
      $IDdap = $dap->id;

      if ($request->has('febid')) {
        foreach ($request->febid as $key => $febid) {
          // Vérifier si un enregistrement avec la même référencefeb existe déjà
          $existingDapE = Elementdap::where('referencefeb', $febid)->first();

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
              $dapE->descriptionn = $request->descriptionel[$key] ?? null;
            }

            $dapE->save();

            // Mettre à jour le statut de l'élément Feb correspondant
            $element = Feb::where('id', $febid)->first();
            if ($element) {
              $element->statut = 1;
              $element->save();


              if ($justifier == 1 ||  $justifier == 0) {
                // Enregistrement des informations de justification
                $justification = new Dja();
                $justification->numerodjas = $request->numerodap;
                $justification->projetiddja = $request->projetid;
                $justification->numerodap = $IDdap;  // numero dap est IDDAP
                $justification->numeroov = $ov;
               
                if ($justifier == 1) {
                  $justification->justifie = 1;
                } else {
                  $justification->justifie = 0;
                }
        
                $justification->userid = Auth::id();
                $justification->save();
              }
        





            }
          }
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
        'status' => 500,
        'error' => $e->getMessage()
      ]);
    }
  }

  // insert a new employee ajax request
  public function updatestore(Request $request)
  {
    try {
      $IDpp= session()->get('id');
      $dap = dap::where('id', $request->dapid)->first();
      $dja = Dja::where('numerodjas', $request->numerodap)->where('projetiddja',$IDpp)->first(); // change apres service


      if (!$dap  && !$dja) {
        return back()->with('failed', 'DAP non trouvé.');
      }

      $ov = $request->has('ov') ? 1 : 0;

      $dap->numerodp = $request->numerodap;
      $dap->serviceid = $request->serviceid;
      $dap->lieu = $request->lieu;
      $dap->comptabiliteb = $request->comptebanque;
      $dap->soldecompte = $request->soldecompte;
      $dap->ov = $ov;
      $dap->cho = $request->cho;
      $dap->dateautorisation = $request->datesecretairegenerale;
      $dap->demandeetablie = $request->demandeetablie;
      $dap->verifierpar = $request->verifier;
      $dap->approuverpar = $request->approuver;
      $dap->responsable = $request->resposablefinancier;
      $dap->secretaire = $request->secretairegenerale;
      $dap->chefprogramme = $request->chefprogramme;
      $dap->observation = $request->observation;
      $dap->update();

      $dja->numerodap = $request->dapid;
      $dja->numeroov = $ov;
      $dja->update();

      return back()->with('success', 'Mises à jour effectuées avec succès.');
    } catch (Exception $e) {
      return back()->with('failed', 'Échec ! ' . $e->getMessage());
    }
  }

  public function list()
  {
    // Récupérer les valeurs de la session
    $ID = session()->get('id');
    $budget = session()->get('budget');
    $devise = session()->get('devise');

    // Vérifier si l'une des variables de session n'est pas définie
    if (!$ID || !$budget || !$devise) {
      // Rediriger vers la route nommée 'dashboard'
      return redirect()->route('dashboard');
    }

    // Si les variables de session sont définies, continuer avec le reste de la fonction
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

    // Activite
    $activite = DB::table('activities')
      ->orderBy('id', 'DESC')
      ->where('projectid', $ID)
      ->get();

    // RECUPERETION FEB NUMERO
    $feb = DB::table('febs')
      ->orderBy('numerofeb', 'ASC')
      ->where('projetid', $ID)
      ->where('statut', 0)
      ->get();

    $somfeb = DB::table('elementfebs')
      ->orderBy('id', 'DESC')
      ->where('projetids', $ID)
      ->sum('montant');
    $somfeb = $budget - $somfeb;

    $somfeb = number_format($somfeb, 0, ',', ' ');

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
    DB::beginTransaction();

    try {
      // Trouver l'enregistrement dap par ID
      $dap = dap::find($request->id);

   

      // Vérifier si l'enregistrement dap existe
      if (!$dap) {
        return response()->json([
          'status' => 404,
          'message' => 'DAP not found',
        ]);
      }

      // Vérifier si l'utilisateur est autorisé à supprimer cet enregistrement
      if ($dap->userid != Auth::id()) {
        return response()->json([
          'status' => 403,
          'message' => 'Unauthorized action',
        ]);
      }

      // Créer un nouvel enregistrement dans l'historique
      $historique = new Historique();
      $historique->fonction = "Suppression";
      $historique->operation = "Suppression Dap et djas";
      $historique->userid = Auth::id();
      $historique->link = 'dap';
      $historique->save();

      // Trouver tous les enregistrements Elementdap associés au dap
      $elements = Elementdap::where('dapid', $request->id)->get();

      // Collecter les ids des Feb à mettre à jour
      $febIds = $elements->pluck('referencefeb')->toArray();

      // Mettre à jour les enregistrements Feb en une seule fois
      Feb::whereIn('id', $febIds)->update(['statut' => 0]);

      // Supprimer les enregistrements Elementdap
      Elementdap::where('dapid', $request->id)->delete();

       // Supprimer les enregistrements Elementdjas

      Elementdjas::where('idddap', $request->id)->delete();

      Dja::where('numerodap', $request->id)->delete();

      // Supprimer l'enregistrement dap
      $dap->delete();

      DB::commit();

      return response()->json([
        'status' => 200,
      ]);
    } catch (Exception $e) {
      DB::rollBack();

      return response()->json([
        'status' => 500,
        'message' => 'Internal Server Error',
      ]);
    }
  }

  public function show($idd)
  {
    $title = "Voir DAP";
    $dateinfo = Identification::all()->first();

    $idd = Crypt::decrypt($idd);

    $datadap = DB::table('daps')
      ->join('services', 'daps.serviceid', 'services.id')
      ->join('projects', 'daps.projetiddap', 'projects.id')
      ->select('daps.*', 'services.title as titres', 'projects.budget as montantprojet', 'projects.title as projettitle', 'projects.devise as devise')
      ->where('daps.id', $idd)
      ->first();

    $budget = $datadap->montantprojet;
    $ID = $datadap->projetiddap;
    $devise  = $datadap->devise;

    $elementfeb = DB::table('febs')
      ->join('elementdaps', 'febs.id', 'elementdaps.referencefeb')
      ->select('elementdaps.*', 'febs.id as fid', 'febs.numerofeb', 'febs.descriptionf')
      ->where('elementdaps.dapid', $datadap->id)
      ->get();

    $somme_gloable = DB::table('elementfebs')
      ->Where('projetids', $ID)
      ->SUM('montant');
    $pourcetage_globale = round(($somme_gloable * 100) / $budget, 2);

    $solde_comptable = $budget - $somme_gloable;



    $elementfebencours = DB::table('febs')
      ->join('elementdaps', 'febs.id', 'elementdaps.referencefeb')
      ->select('elementdaps.*', 'febs.id as fid', 'febs.numerofeb', 'febs.descriptionf')
      ->where('elementdaps.dapid', $datadap->id)
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
    $taux_execution_avant = max(0, $taux_execution_avant);



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
        'budget' => $budget,
        'pourcetage_globale' => $pourcetage_globale,
        'solde_comptable' => $solde_comptable,
        'taux_execution_avant' => $taux_execution_avant,
        'pourcentage_encours' => $pourcentage_encours,
        'devise' => $devise


      ]
    );
  }

  public function edit($idd)
  {

    $idd = Crypt::decrypt($idd);

    $datadap = DB::table('daps')
      ->join('services', 'daps.serviceid', 'services.id')
      ->join('projects', 'daps.projetiddap', 'projects.id')

      ->select('daps.*', 'daps.id as iddape', 'services.id as idss', 'services.title as titres', 'projects.budget as montantprojet', 'projects.devise as devise', 'daps.userid as iduser')
      ->where('daps.id', $idd)
      ->first();

    $budget = $datadap->montantprojet;
    $ID = $datadap->projetiddap;
    $devise  = $datadap->devise;

    $title = "Modification DAP";
    $service = Service::all();

    $compte = Compte::where('compteid', '=', NULL)->get();
    // utilisateur
    $personnel = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->orderBy('nom', 'ASC')
      ->get();


    $initiateur = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->where('users.id',  $datadap->userid)
      ->first();

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
   


    $elementdaps_feb  = DB::table('febs')
      ->join('elementdaps', 'febs.id', 'elementdaps.referencefeb')
      ->select('elementdaps.*', 'febs.id as fid', 'febs.numerofeb', 'febs.descriptionf')
      ->where('elementdaps.dapid', $idd)
      ->get();

    $sommefebs =   DB::table('elementdaps')
      ->join('elementfebs', 'elementdaps.referencefeb', 'elementfebs.febid')
      ->Where('elementdaps.dapid', $idd)
      ->SUM('elementfebs.montant');

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
        'datafeb'   => $elementdaps_feb,
        'sommefebs' => $sommefebs,
        'chefcomposant' => $chefcomposant,
        'chefcomptable' => $chefcomptable,
        'chefservice' =>  $chefservice,
        'responsable' => $responsable,
        'secretaire'  => $secretaire,
        'chefprogramme' => $chefprogramme,
        'initiateur' => $initiateur,
      
      ]
    );
  }

  public function generatePDFdap($id)
  {
    $dateinfo = Identification::all()->first();

    $datadap = DB::table('daps')
      ->join('services', 'daps.serviceid', 'services.id')
      ->join('projects', 'daps.projetiddap', 'projects.id')
      ->select('daps.*', 'services.title as titres', 'projects.budget as montantprojet', 'projects.devise as devise', 'daps.userid as iduser')
      ->where('daps.id', $id)
      ->first();



    $budget = $datadap->montantprojet;
    $IDb = $datadap->projetiddap;
    $devise  = $datadap->devise;

      // $idd = Crypt::decrypt($idd);

    ;

    $datafebElement = DB::table('febs')
      ->join('elementdaps', 'febs.id', 'elementdaps.referencefeb')
      ->select('elementdaps.*', 'febs.id as fid', 'febs.numerofeb', 'febs.descriptionf')
      ->where('elementdaps.dapid', $id)
      ->get();

    $somme_gloable = DB::table('elementfebs')
      ->Where('projetids', $IDb)
      ->SUM('montant');
    $pourcetage_globale = round(($somme_gloable * 100) / $budget, 2);

    



    $elementfebencours = DB::table('febs')
      ->join('elementdaps', 'febs.id', 'elementdaps.referencefeb')
      ->select('elementdaps.*', 'febs.id as fid', 'febs.numerofeb', 'febs.descriptionf')
      ->where('elementdaps.numerodap', $id)
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
    $taux_execution_avant = max(0, $taux_execution_avant);





    // Activite
    $activite = DB::table('activities')
      ->orderby('id', 'DESC')
      ->Where('projectid', $IDb)
      ->get();

    // feb
    $somfeb = DB::table('elementfebs')
      ->orderby('id', 'DESC')
      ->Where('projetids', $IDb)
      ->SUM('montant');
    $somfeb =  $budget - $somfeb;
    $somfeb =  $datadap->soldecompte;


    $infoglo = DB::table('identifications')->first();



    $etablienom =  DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->Where('users.id', $datadap->iduser)
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



    $pdf = FacadePdf::loadView('document.dap.dap', compact(
      'infoglo',
      'datafebElement',
      'budget',
      'pourcetage_globale',
     
      'taux_execution_avant',
      'pourcentage_encours',
      'datadap',
      'etablienom',
      'Demandeetablie',
      'verifierpar',
      'approuverpar',
      'responsable',
      'secretaire',
      'chefprogramme',
      'devise',

      'chefcomposant',
      'chefcomptable',
      'chefservice'
    ));

  

    $pdf->setPaper('A4', 'landscape'); // Format A4 en mode paysage

    // Nom du fichier PDF téléchargé avec numéro FEB et date actuelle
    $fileName = 'DAP_NUM_'.$datadap ->numerodp.'.pdf';

    // Télécharge le PDF
    return $pdf->download($fileName);
  }

}
