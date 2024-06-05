<?php

namespace App\Http\Controllers;

use App\Models\Banque;
use App\Models\Beneficaire;
use App\Models\Compte;
use App\Models\dap;
use App\Models\Dja;
use App\Models\Elementdap;
use App\Models\Elementdjas;
use App\Models\Elementfeb;
use App\Models\Feb;
use App\Models\Historique;
use App\Models\Identification;
use App\Models\Notification;
use App\Models\Project;
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
                <a href="dap/' . $datadaps->id . '/generate-pdf-dap" class="dropdown-item  mx-1"><i class="fa fa-print"> </i> Générer PDF</a>
                <a class="dropdown-item text-white mx-1 deleteIcon"  id="' . $datadaps->id . '"  href="#" style="background-color:red"><i class="far fa-trash-alt"></i> Supprimer</a>
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
           <td >' . $datadaps->cho . '</td>
           <td>' . $datadaps->comptabiliteb . '</td>
           <td>' . $datadaps->paretablie . '</td>
           <td align="center"><input type="checkbox"  ' . $justifier . ' class="form-check-input" /> </td>
           <td align="center"> ' . date('d-m-Y', strtotime($datadaps->created_at)) . '  </td>
          
           <td>' . ucfirst($datadaps->user_prenom) . '</td>
       
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
      $dap->ov = $ov;
      $dap->cho = $request->ch;
      $dap->soldecompte = $request->soldecompte;
      $dap->demandeetablie = $request->demandeetablie;
      $dap->verifierpar = $request->verifier;
      $dap->approuverpar = $request->approuver;
      $dap->responsable = $request->resposablefinancier;
      $dap->secretaire = $request->secretairegenerale;
      $dap->chefprogramme = $request->chefprogramme;
      $dap->paretablie = $request->paretablie;
      $dap->banque = $request->banque;
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
      $IDpp = session()->get('id');
      $dap = dap::where('id', $request->dapid)->first();
      $dja = Dja::where('numerodjas', $request->numerodap)->where('projetiddja', $IDpp)->first(); // change apres service


      if (!$dap  && !$dja) {
        return back()->with('failed', 'DAP non trouvé.');
      }

      $ov = $request->has('ov') ? 1 : 0;

      $dap->numerodp = $request->numerodap;
      $dap->serviceid = $request->serviceid;
      $dap->lieu = $request->lieu;
      $dap->comptabiliteb = $request->comptebanque;
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
      $dap->paretablie = $request->paretablie;
      $dap->banque = $request->banque;
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
    $banque = Banque::orderBy('libelle', 'ASC')->get();

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
        'somfeb'    => $somfeb,
        'banque'    => $banque
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
          return back()->with('success', 'Très bien! Vous avez poser la signature ');
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
    // identification
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
      ->select('elementdaps.*', 'febs.id as fid', 'febs.numerofeb', 'febs.descriptionf','febs.ligne_bugdetaire')
      ->where('elementdaps.dapid', $datadap->id)
      ->get();

    $somme_gloable = DB::table('elementfebs')
      ->Where('projetids', $ID)
      ->SUM('montant');
      
    $pourcetage_globale = round(($somme_gloable * 100) / $budget, 2);

    $solde_comptable = $budget - $somme_gloable;

    


    $elementfebencours = DB::table('febs')
      ->join('elementdaps', 'febs.id', 'elementdaps.referencefeb')
      ->select('elementdaps.*', 'febs.id as fid', 'febs.numerofeb', 'febs.descriptionf', 'febs.sous_ligne_bugdetaire', 'febs.ligne_bugdetaire')
      ->where('elementdaps.dapid', $datadap->id)
      ->first();


    $sommeGrand = DB::table('elementfebs')
      ->where('grandligne', $elementfebencours->ligne_bugdetaire)
      ->sum('montant');

    $somme_ligne_principale = DB::table('rallongebudgets')
      ->where('compteid', $elementfebencours->ligne_bugdetaire)
      ->sum('budgetactuel');

    $pourcentage_encours =  round(($sommeGrand * 100) / $somme_ligne_principale, 2);

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
        'budget'    => $budget,
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
        'pourcentage_encours' => $pourcentage_encours,
        'devise' => $devise,



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

    $feb = DB::table('febs')
      ->orderBy('numerofeb', 'ASC')
      ->where('projetid', $ID)
      ->where('statut', 0)
      ->get();


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
        'feb' => $feb

      ]
    );
  }

  public function generatePDFdap($id)
  {
    $datadap = DB::table('daps')
      ->join('services', 'daps.serviceid', '=', 'services.id')
      ->join('projects', 'daps.projetiddap', '=', 'projects.id')
      ->select('daps.*', 'services.title as titres', 'projects.budget as montantprojet', 'projects.devise as devise', 'daps.userid as iduser','projects.title as projettitle', 'projects.devise as devise')
      ->where('daps.id', $id)
      ->first();

    $budget = $datadap->montantprojet;
    $IDb = $datadap->projetiddap;
    $devise = $datadap->devise;

    $datafebElement = DB::table('febs')
      ->join('elementdaps', 'febs.id', '=', 'elementdaps.referencefeb')
      ->select('elementdaps.*', 'febs.id as fid', 'febs.numerofeb', 'febs.descriptionf','febs.ligne_bugdetaire')
      ->where('elementdaps.dapid', $id)
      ->get();

    $somme_gloable = DB::table('elementfebs')
      ->where('projetids', $IDb)
      ->sum('montant');

    $pourcetage_globale = round(($somme_gloable * 100) / $budget, 2);

    $elementfebencours = DB::table('febs')
      ->join('elementdaps', 'febs.id', 'elementdaps.referencefeb')
      ->select('elementdaps.*', 'febs.id as fid', 'febs.numerofeb', 'febs.descriptionf', 'febs.sous_ligne_bugdetaire', 'febs.ligne_bugdetaire')
      ->where('elementdaps.dapid', $datadap->id)
      ->first();


    $sommelign = DB::table('elementfebs')
      ->where('grandligne', $elementfebencours->ligne_bugdetaire)
      ->sum('montant');

    $somme_ligne_principale = DB::table('rallongebudgets')
      ->where('compteid', $elementfebencours->ligne_bugdetaire)
      ->sum('budgetactuel');

    $pourcentage_encours = round(($sommelign * 100) / $somme_ligne_principale, 2);

    $activite = DB::table('activities')
      ->orderBy('id', 'DESC')
      ->where('projectid', $IDb)
      ->get();

    $relicat = $budget - $somme_gloable;

    $infoglo = DB::table('identifications')->first();

    $etablienom = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->where('users.id', $datadap->iduser)
      ->first();

    $Demandeetablie = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->where('users.id', $datadap->demandeetablie)
      ->first();

    $verifierpar = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->where('users.id', $datadap->verifierpar)
      ->first();

    $approuverpar = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->where('users.id', $datadap->approuverpar)
      ->first();

    $responsable = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->where('users.id', $datadap->responsable)
      ->first();

    $secretaire = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'personnels.id as idp', 'users.signature', 'users.id as usersid')
      ->where('users.id', $datadap->secretaire)
      ->first();

    $chefprogramme = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'personnels.id as idp', 'users.signature', 'users.id as usersid')
      ->where('users.id', $datadap->chefprogramme)
      ->first();

    $chefservice = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as idus', 'users.signature')
      ->where('users.id', $datadap->approuverpar)
      ->first();

    $chefcomposant = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as idus', 'users.signature')
      ->where('users.id', $datadap->demandeetablie)
      ->first();

    $chefcomptable = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as idus', 'users.signature')
      ->where('users.id', $datadap->verifierpar)
      ->first();

    $pdf = FacadePdf::loadView('document.dap.dap', compact(
      'infoglo',
      'datafebElement',
      'budget',
      'pourcetage_globale',
      'relicat',
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
      'chefservice',
      'somme_ligne_principale'
    ));

    $pdf->setPaper('A4', 'landscape');

    $fileName = 'DAP_NUM_' . $datadap->numerodp . '.pdf';

    return $pdf->download($fileName);
  }

  public function getFebDetails(Request $request)
{
    $id = $request->input('id');
    $dataFeb = $check = Feb::findOrFail($id);

    // Récupérer les ID et les détails associés
    $idl = $check->sous_ligne_bugdetaire;
    $id_gl = $check->ligne_bugdetaire;
    $idfeb = $check->id;

    $datElement = Elementfeb::where('febid', $idfeb)->get();

    $IDB = $check->projetid;
    $project = Project::findOrFail($IDB);
    $budget = $project->budget;

    $somme_ligne_principale = DB::table('rallongebudgets')
        ->where('compteid', $id_gl)
        ->sum('budgetactuel');

    $onebeneficaire = Beneficaire::find($check->beneficiaire);

    $sommeallfeb = DB::table('elementfebs')
        ->where('projetids', $IDB)
        ->sum('montant');

    $dataLigne = Compte::find($idl);

    $sommelign = DB::table('elementfebs')
        ->where('grandligne', $id_gl)
        ->sum('montant');

    $sommelignpourcentage = round(($sommelign * 100) / $somme_ligne_principale, 2);

    $sommefeb = DB::table('elementfebs')
        ->where('febid', $idfeb)
        ->where('projetids', $IDB)
        ->sum('montant');

    $POURCENTAGE_GLOGALE = round(($sommeallfeb * 100) / $budget, 2);

    // Récupérer les informations sur l'utilisateur
    $createur = DB::table('users')
        ->join('personnels', 'users.personnelid', '=', 'personnels.id')
        ->select('personnels.nom', 'personnels.prenom', 'users.id as useridp')
        ->where('users.id', $check->userid)
        ->first();

    $etablienom = DB::table('users')
        ->join('personnels', 'users.personnelid', '=', 'personnels.id')
        ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as userid')
        ->where('users.id', $check->acce)
        ->first();

    $comptable_nom = DB::table('users')
        ->join('personnels', 'users.personnelid', '=', 'personnels.id')
        ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
        ->where('users.id', $check->comptable)
        ->first();

    $checcomposant_nom = DB::table('users')
        ->join('personnels', 'users.personnelid', '=', 'personnels.id')
        ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
        ->where('users.id', $check->chefcomposante)
        ->first();

    // Initialiser la variable de sortie
    $output = '';

    if ($dataFeb) {
        $datElementFeb = Elementfeb::where('febid', $id)->get();
        $n = 1;
        $sommefeb = 0;

        // Créer l'en-tête du tableau
        $output .= '
            <div class="row">
                <h5><center>FICHE D’EXPRESSION DES BESOINS (FEB) N° ' . $dataFeb->numerofeb . '</center></h5>
                <div class="col-sm-12">
                    <table class="table table-bordered table-sm fs--1 mb-0">
                        <tr>
                            <td>Composante/ Projet/Section: ' . ucfirst($project->title) . '</td>
                            <td>Période: ' . $dataFeb->periode . '</td>
                        </tr>
                        <tr>
                            <td style="width:50%">Activité: ' . $dataFeb->descriptionf . '</td>
                            <td>Date FEB: ' . date('d-m-Y', strtotime($dataFeb->datefeb)) . '</td>
                        </tr>
                        <tr>
                            <td>Code: ' . $dataLigne->numero . ' Ligne budgétaire: ' . $dataLigne->libelle . '</td>
                            <td>';

        // Créer la section des cases à cocher avec les descriptions dans les titres
        $output .= '<label title="Bon de commande">';

        $bc_ur = $dataFeb->url_bon_commande;
        $imagePath_bc = public_path($bc_ur);
        
        $output .= '<label title="Bon de commande">';
        if (file_exists($imagePath_bc)) {
            $output .= '<a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="' . asset($bc_ur) . '"> BC:</a>';
        } else {
            $output .= 'BC ';
        }
        $output .= '</label>';
        $output .= ' <input type="checkbox" class="form-check-input" disabled ' . ($dataFeb->bc == 1 ? 'checked' : '') . ' /> &nbsp;&nbsp;';
        
        $facture_ur = $dataFeb->url_facture;
        $imagePath_facture = public_path($facture_ur);
        
        $output .= '<label title="Facture">';
        if (file_exists($imagePath_facture)) {
            $output .= '<a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="' . asset($facture_ur) . '"> Facture:</a>';
        } else {
            $output .= 'Facture ';
        }
        $output .= '</label>';
        $output .= ' <input type="checkbox" class="form-check-input" disabled ' . ($dataFeb->facture == 1 ? 'checked' : '') . ' /> &nbsp;&nbsp;';
        
        $om_ur = $dataFeb->url_ordre_mission;
        $imagePath_om = public_path($om_ur);
        
        $output .= '<label title="Ordre de mission">';
        if (file_exists($imagePath_om)) {
            $output .= '<a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="' . asset($om_ur) . '"> O.M:</a>';
        } else {
            $output .= 'O.M ';
        }
        $output .= '</label>';
        $output .= ' <input type="checkbox" class="form-check-input" disabled ' . ($dataFeb->om == 1 ? 'checked' : '') . ' /> &nbsp;&nbsp;';
        
        $pva_ur = $dataFeb->url_pva;
        $imagePath_pva = public_path($pva_ur);
        
        $output .= '<label title="Procès-verbal d\'analyse">';
        if (file_exists($imagePath_pva)) {
            $output .= '<a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="' . asset($pva_ur) . '">  P.V.A:</a>';
        } else {
            $output .= 'P.V.A ';
        }
        $output .= '</label>';
        $output .= ' <input type="checkbox" class="form-check-input" disabled ' . ($dataFeb->nec == 1 ? 'checked' : '') . ' /> &nbsp;&nbsp;';
        
        $fpdevis_ur = $dataFeb->url_fpdevis;
        $imagePath_fpdevis = public_path($fpdevis_ur);
        
        $output .= '<label title="Facture proformat">';
        if (file_exists($imagePath_fpdevis)) {
            $output .= '<a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="' . asset($fpdevis_ur) . '"> FP/Dévis/Liste:</a>';
        } else {
            $output .= 'FP/Dévis/Liste ';
        }
        $output .= '</label>';
        $output .= ' <input type="checkbox" class="form-check-input" disabled ' . ($dataFeb->fpdevis == 1 ? 'checked' : '') . ' /> &nbsp;&nbsp;';
        
        $rm_ur = $dataFeb->url_rm;
        $imagePath_rm = public_path($rm_ur);
        
        $output .= '<label title="Rapport de mission">';
        if (file_exists($imagePath_rm)) {
            $output .= '<a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="' . asset($rm_ur) . '"> R.M:</a>';
        } else {
            $output .= 'R.M ';
        }
        $output .= '</label>';
        $output .= ' <input type="checkbox" class="form-check-input" disabled ' . ($dataFeb->rm == 1 ? 'checked' : '') . ' /> &nbsp;&nbsp;';
        
        $tdr_ur = $dataFeb->url_tdr;
        $imagePath_tdr = public_path($tdr_ur);
        
        $output .= '<label title="Termes de Référence">';
        if (file_exists($imagePath_tdr)) {
            $output .= '<a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="' . asset($tdr_ur) . '"> T.D.R:</a>';
        } else {
            $output .= 'T.D.R ';
        }
        $output .= '</label>';
        $output .= ' <input type="checkbox" class="form-check-input" disabled ' . ($dataFeb->tdr == 1 ? 'checked' : '') . ' /> &nbsp;&nbsp;';
        
        $bv_ur = $dataFeb->url_bv;
        $imagePath_bv = public_path($bv_ur);
        
        $output .= '<label title="Bordereau de versement">';
        if (file_exists($imagePath_bv)) {
            $output .= '<a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="' . asset($bv_ur) . '"> B.V:</a>';
        } else {
            $output .= 'B.V ';
        }
        $output .= '</label>';
        $output .= ' <input type="checkbox" class="form-check-input" disabled ' . ($dataFeb->bv == 1 ? 'checked' : '') . ' /> &nbsp;&nbsp;';
        
        $recu_ur = $dataFeb->url_recu;
        $imagePath_recu = public_path($recu_ur);
        
        $output .= '<label title="Reçu">';
        if (file_exists($imagePath_recu)) {
            $output .= '<a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="' . asset($recu_ur) . '"> Reçu:</a>';
        } else {
            $output .= 'Reçu ';
        }
        $output .= '</label>';
        $output .= ' <input type="checkbox" class="form-check-input" disabled ' . ($dataFeb->recu == 1 ? 'checked' : '') . ' /> &nbsp;&nbsp;';
        
        $ar_ur = $dataFeb->url_ar;
        $imagePath_ar = public_path($ar_ur);
        
        $output .= '<label title="Accusé de réception">';
        if (file_exists($imagePath_ar)) {
            $output .= '<a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="' . asset($ar_ur) . '"> A.R:</a>';
        } else {
            $output .= 'A.R ';
        }
        $output .= '</label>';
        $output .= ' <input type="checkbox" class="form-check-input" disabled ' . ($dataFeb->ar == 1 ? 'checked' : '') . ' /> &nbsp;&nbsp;';
        
        $be_ur = $dataFeb->url_be;
        $imagePath_be = public_path($be_ur);
        
        $output .= '<label title="Bordereau d\'expédition">';
        if (file_exists($imagePath_be)) {
          $output .= '<a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="' . asset($be_ur) . '"> B.E:</a>';
      } else {
          $output .= 'B.E ';
      }
      $output .= '</label>';
      $output .= ' <input type="checkbox" class="form-check-input" disabled ' . ($dataFeb->be == 1 ? 'checked' : '') . ' /> &nbsp;&nbsp;';

      // Vérification pour Appel à la participation à la construction au CFK
      $apc_ur = $dataFeb->url_appel_cfk;
      $imagePath_apc = public_path($apc_ur);

      $output .= '<label title="Appel à la participation à la construction au CFK">';
      if (file_exists($imagePath_apc)) {
          $output .= '<a href="javascript:void(0)" onclick="openPopup(this)" data-document-url="' . asset($apc_ur) . '"> A.P.C:</a>';
      } else {
          $output .= 'A.P.C ';
      }
      $output .= '</label>';
      $output .= ' <input type="checkbox" class="form-check-input" disabled ' . ($dataFeb->apc == 1 ? 'checked' : '') . ' />';

        



        $output .= '</td>
                        </tr>
                        <tr>
                            <td>Taux d’exécution globale de la ligne et sous ligne budgétaire: ' . $sommelignpourcentage . ' %</td>
                            <td>Taux d’exécution globale sur le projet: ' . $POURCENTAGE_GLOGALE . ' %</td>
                        </tr>
                        <tr>
                            <td>Créé par: ' . $createur->nom . ' ' . $createur->prenom . '</td>
                            <td>Bénéficiaire: ' . ($onebeneficaire->libelle ?? '') . '</td>
                        </tr>
                    </table>
                </div>
            </div>';

        // Ajouter les éléments de la FEB
        $output .= '
            <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
                <thead style="background-color:#3CB371; color:white">
                    <tr>
                        <th style="color:white"><b>N<sup>o</sup></b></th>
                        <th style="color:white"><b>Désignation des activités de la ligne</b></th>
                        <th style="color:white"><b>Description</b></th>
                        <th style="color:white"><b><center>Unité</center></b></th>
                        <th style="color:white"><b><center>Quantité</center></b></th>
                        <th style="color:white"><color:white"><b><center>Fréquence</center></b></th>
                        <th style="color:white"><b><center>Prix Unitaire</center></b></th>
                        <th style="color:white"><b><center>Prix Total</center></b></th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($datElementFeb as $data) {
            $activite = DB::table('activities')->where('id', $data->libellee)->first();
            $titreActivite = $activite ? ucfirst($activite->titre) : '';

            $sommefeb += $data->montant;

            $output .= '
                <tr>
                    <td style="width:3%">' . $n . '</td>
                    <td style="width:40%">' . $titreActivite . '</td>
                    <td style="width:10%">' . ucfirst($data->libelle_description) . '</td>
                    <td style="width:10%" align="center">' . $data->unite . '</td>
                    <td style="width:8%" align="center">' . $data->quantite . '</td>
                    <td style="width:8%" align="center">' . $data->frequence . '</td>
                    <td style="width:10%" align="center">' . number_format($data->pu, 0, ',', ' ') . '</td>
                    <td style="width:20%" align="center">' . number_format($data->montant, 0, ',', ' ') . '</td>
                </tr>';
            $n++;
        }

        // Ajouter la ligne de total
        $output .= '
                <tr>
                    <td colspan="7"><b>Total général</b></td>
                    <td align="center"><b>' . number_format($sommefeb, 0, ',', ' ') . '</b></td>
                </tr>
                </tbody>
            </table>';

        // Ajouter la section de signature
        $output .= '
            <table style="width:100%; margin:auto">
                <tr>
                    <td>
                        <center>
                            <u>Etablie par (AC/CE/CS)</u> :
                            <br>
                            ' . ucfirst($etablienom->nom) . ' ' . ucfirst($etablienom->prenom) . '
                            <br>';

        if ($dataFeb->acce_signe == 1) {
            $output .= '
                            <br>
                            <img src="' . asset($etablienom->signature) . '" width="200px" />';
        } else {
            $output .= '<p>Signature non disponible</p>';
        }

        $output .= '
                        </center>
                    </td>
                    <td>
                        <center>
                            <u>Vérifiée par (Comptable)</u> :
                            <br>
                            ' . $comptable_nom->nom . ' ' . $comptable_nom->prenom . '
                            <br>';

        if ($dataFeb->comptable_signe == 1) {
            $output .= '
                            <br>
                            <img src="' . asset($comptable_nom->signature) . '" width="200px" />';
        } else {
            $output .= '<p>Signature non disponible</p>';
        }

        $output .= '
                        </center>
                    </td>
                    <td>
                        <center>
                            <u>Approuvée par (Chef de Composante/Projet/Section)</u> :
                            <br>
                            ' . $checcomposant_nom->nom . ' ' . $checcomposant_nom->prenom . '
                            <br>';

        if ($dataFeb->chef_signe == 1) {
            $output .= '
                            <br>
                            <img src="' . asset($checcomposant_nom->signature) . '" width="200px" />';
        } else {
            $output .= '<p>Signature non disponible</p>';
        }

        $output .= '
                        </center>
                    </td>
                </tr>
            </table>';
    } else {
        $output .= '
            <tr>
                <td colspan="8">
                    <h5 class="text-center text-secondary my-5">
                        <center>Ceci est vide !</center>
                    </h5>
                </td>
            </tr>';
    }

    // Retourne la réponse JSON contenant le code HTML généré
    return response()->json($output);
}


  
  
  
}
