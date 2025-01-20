<?php

namespace App\Http\Controllers;

use App\Models\Banque;
use App\Models\Caisse;
use App\Models\Comptepetitecaisse;
use App\Models\Dapbpc;
use App\Models\Elementdappc;
use App\Models\Febpetitcaisse;
use App\Models\Identification;
use App\Models\Project;
use App\Models\Service;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class DapbpcController extends Controller
{
  public function index()
  {
    $title = 'DAP Petit Caisse'; // Récupérer l'ID de la session
    $ID = session()->get('id');  // Vérifier si l'ID de la session n'est pas défini

    // Rediriger vers la route nommée 'dashboard'
    if (!$ID) {
      return redirect()->route('dashboard');
    }

    $feb = DB::table('febpetitcaisses')
      ->orderBy('numero', 'ASC')
      ->where('projet_id', $ID)
      ->where('statut', 0)
      ->get();

    $febpc =  Febpetitcaisse::all();
    $service = Service::all();
    $banque = Banque::all();

    $personnel = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
      ->orderBy('nom', 'ASC')
      ->get();



    return view(
      'bonpetitecaisse.dap.index',
      [
        'title'     => $title,
        'feb'       => $febpc,
        'personnel' => $personnel,
        'service'   => $service,
        'banque'    => $banque,
        'feb'       => $feb
      ]
    );
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
      $dap = new Dapbpc();

      $dap->serviceid       = $request->serviceid;
      $dap->projetid        = $request->projetid;
      $dap->numerodap       = $request->numerodap;
      $dap->lieu            = $request->lieu;
      $dap->comptebanque    = $request->comptebanque;
      $dap->ov              = $ov;
      $dap->cho             = $request->ch;

      $dap->demande_etablie = $request->demandeetablie;
      $dap->verifier        = $request->verifier;
      $dap->approuver       = $request->approuver;

      $dap->autoriser     = $request->autorisation;
      $dap->secretaire      = $request->secretairegenerale;
      $dap->chefprogramme   = $request->chefprogramme;

      $dap->etablie_aunom   = $request->paretablie;
      $dap->banque = $request->banque;

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
          $existingDapE = Elementdappc::where('referencefeb', $febid)->first();

          if (!$existingDapE) {
            $existingDapE = new Elementdappc();
            $existingDapE->dapid = $IDdap;
            $existingDapE->numerodap = $request->numerodap;
            $existingDapE->referencefeb = $febid;
            $existingDapE->projetid = $request->projetid;

            $existingDapE->save();

            // Mettre à jour le statut de l'élément Feb correspondant
            $element = Febpetitcaisse::where('id', $febid)->first();
            if ($element) {
              $element->statut = 1;
              $element->save();

              /*     if ($justifier == 1 ||  $justifier == 0) {
                    // Enregistrement des informations de justification
                    $justification = new Djapc();
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
  
                  */
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

  public function show($idd)
  {
    $title = 'Voir DAP Petit Caisse';

    $idd = Crypt::decrypt($idd);

    // Récupérer les données de la DAP avec les jointures nécessaires
    $data = DB::table('dapbpcs')
      ->join('users', 'dapbpcs.userid', '=', 'users.id')
      ->leftJoin('services', 'dapbpcs.serviceid', 'services.id')
      ->leftJoin('projects', 'dapbpcs.projetid', 'projects.id')
      ->select('dapbpcs.*', 'services.title as titres', 'projects.id as IDP', 'projects.budget as montantprojet', 'projects.title as projettitle', 'projects.devise as devise')
      ->where('dapbpcs.id', $idd)
      ->first();



    $datafebElems =  DB::table('febpetitcaisses')
      ->leftJoin('elementdappcs', 'febpetitcaisses.id', 'elementdappcs.referencefeb')
      ->select('febpetitcaisses.compte_id as compteids', 'febpetitcaisses.montant as montants')
      ->where('elementdappcs.dapid', $idd)
      ->first();


    $year = Carbon::parse($data->created_at)->format('Y');
    $datainfo = Identification::all()->first();

    $elementfeb = DB::table('febpetitcaisses')
      ->leftJoin('elementdappcs', 'febpetitcaisses.id', 'elementdappcs.referencefeb')
      ->select('elementdappcs.*',  'febpetitcaisses.*', 'febpetitcaisses.id as fid')
      ->where('elementdappcs.dapid', $idd)
      ->get();

    $Demandeetablie =  DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->Where('users.id', $data->demande_etablie)
      ->first();

    $verifierpar =  DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->Where('users.id', $data->verifier)
      ->first();

    $approuverpar =  DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->Where('users.id', $data->approuver)
      ->first();

    $responsable =  DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->Where('users.id', $data->autoriser)
      ->first();

    $secretaire =  DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'personnels.id as idp', 'users.signature', 'users.id as usersid')
      ->Where('users.id', $data->secretaire)
      ->first();

    $chefprogramme =  DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'personnels.id as idp', 'users.signature', 'users.id as usersid')
      ->Where('users.id', $data->chefprogramme)
      ->first();
    
     // RECUPERATION BU DUBGET DU PROJET
     $IDB = $data->IDP;
     $chec = Project::findOrFail($IDB);
     $budget = $chec->budget;
 
     // RECUPERATION DU MONTANT DEJA UTILISER DANS LE BUDJET
     $sommeallfeb = DB::table('elementfebs')
     ->where('projetids', $IDB)
     ->sum('montant');
 
     $SOMME_PETITE_CAISSE= DB::table('elementboncaisses')
     ->join('bonpetitcaisses', 'elementboncaisses.boncaisse_id', 'bonpetitcaisses.id')
     ->where('elementboncaisses.projetid', $IDB)
     ->where('bonpetitcaisses.approuve_par_signature', 1)
     ->sum('elementboncaisses.montant');
 
     $SOMMES_DEJA_UTILISE = $sommeallfeb + $SOMME_PETITE_CAISSE;
 
     $POURCENTAGE_GLOGALE = $budget ? round(($SOMMES_DEJA_UTILISE * 100) / $budget, 2) : 0;



    return view('bonpetitecaisse.dap.voir', [
      'title'          => $title,
      'data'           => $data,
      'dateinfo'       => $datainfo,
      'datafebElement' => $elementfeb,
      'Demandeetablie' => $Demandeetablie,
      'verifierpar' => $verifierpar,
      'approuverpar' => $approuverpar,
      'responsable'  => $responsable,
      'secretaire'   => $secretaire,
      'chefprogramme' => $chefprogramme,
      'datafebElems' =>  $datafebElems,
      'POURCENTAGE_GLOGALE' => $POURCENTAGE_GLOGALE
    ]);
  }

  public function updatesignature(Request $request)
  {
    try {

      if (
        !empty($request->demandeetabliesignature) || !empty($request->verifierparsignature) || !empty($request->approuverparsignature)
        || !empty($request->responsablesignature) || !empty($request->chefprogrammesignature) || !empty($request->secretairesignature)
      ) {
        $emp = Dapbpc::find($request->dapid);

        if ($request->has('demandeetabliesignature')) {
          $demandeetabliesignature = 1;
          if ($request->filled('dated')) {
            $dated = $request->dated;
          } else {
            $dated = date('j-m-Y');
          }
        } else {
          $demandeetabliesignature = $request->clone_demandeetabliesignature;
          $dated = $request->dated_an;
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
          $datev = $request->datev_an;
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
          $datea = $request->datea_an;
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
          $datesecretaire = date('d-m-Y');
         
        } else {
          $secretaure_general_signe = $request->clone_secretairesignature;
          $datesecretaire = $request->ancient_date_autorisation;
        }
        $approuverdate = $request->dateautorisation;

        $emp->demande_etablie_signe = $demandeetabliesignature;
        $emp->demande_etablie_date = $dated;
        $emp->verifier_signe = $verifierparsignature;
        $emp->verifier_date = $datev;

        $emp->approuver_signe = $approuverparsignature;
        $emp->approuver_date = $datea;

        $emp->autoriser_signe = $responsablesignature;
        $emp->chefprogramme_signe = $chefprogrammesignature;
        $emp->secretaire_signe = $secretaure_general_signe;

        $emp->dateautorisation = isset($approuverdate) ? $approuverdate : now();

        $do = $emp->update();

        if ($do) {

          if (!Caisse::where('dapid', $request->dapid)->exists()) {

            if ($emp->demande_etablie_signe == 1 && $emp->verifier_signe == 1 && $emp->approuver_signe == 1 && $emp->autoriser_signe == 1 && $emp->chefprogramme_signe == 1 && $emp->secretaire_signe == 1) {
              $petiteCaisse = Comptepetitecaisse::find($request->compteidsFeb);

              if ($petiteCaisse) {

                $idProjet = $emp->projetid;
                $solde = $petiteCaisse->solde + $request->montantsFeb;
                $petiteCaisse->solde = $solde;
                $petiteCaisse->save();
                // compte pour attribue le numero
                $numero = Caisse::where('projetid', $idProjet)->count();
                // compte where projet
                // Utilisation de save() au lieu de update() pour plus de simplicité
                // nouveau entrer dans la caisse.
                $caisse              = new Caisse();

                $caisse->date        = date('j-m-Y');
                $caisse->compteid    = $request->compteidsFeb;
                $caisse->projetid    = $idProjet;
                $caisse->numero      = $numero + 1;
                $caisse->description = "Approvisionnement de la caisse";
                $caisse->input       = "";
                $caisse->debit       = $request->montantsFeb;
                $caisse->credit      = "0";
                $caisse->solde       = $solde;
                $caisse->dapid       = $request->dapid;
                $caisse->userid      = Auth::id();

                $caisse->save();
              }
            }
          }



          return back()->with('success', 'Très bien! Vous avez poser la signature ');
        } else {
          return back()->with('failed', 'Echec ! la signature  n\'est pas put etre poser correctement ');
        }
      } else {
        return back()->with('failed', 'Echec ! la signature  dois etre poser');
      }
    } catch (Exception $e) {
      return redirect()->route('dappc')->with('failed', 'Echec ! la signature  dois etre poser' . $e);
    }
  }

  public function edit()
  {
    $title = 'Voir DAP Petit Caisse'; // Récupérer l'ID de la session
    $ID = session()->get('id');  // Vérifier si l'ID de la session n'est pas défini

    // Rediriger vers la route nommée 'dashboard'
    if (!$ID) {
      return redirect()->route('dashboard');
    }


    return view(
      'bonpetitecaisse.dap.modifier',
      [
        'title'     => $title

      ]
    );
  }

  public function fetchAll()
  {

    $ID = session()->get('id');

    $data = DB::table('dapbpcs')
      ->join('users', 'dapbpcs.userid', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('dapbpcs.*',   'personnels.prenom as user_prenom')
      ->where('dapbpcs.projetid', $ID)
      ->orderBy('dapbpcs.numerodap',  'asc')
      ->get();

    $output = '';
    if ($data->isNotEmpty()) {
      foreach ($data as $datas) {

        $cryptedId = Crypt::encrypt($datas->id);

        $dapId = $datas->id;

        $SommeFebs = $this->getTotalSomme($dapId);

        $SommeFebs = number_format($SommeFebs, 0, ',', ' ');

        $numerofeb =  DB::table('febpetitcaisses')
          ->leftJoin('elementdappcs', 'febpetitcaisses.id', 'elementdappcs.referencefeb')
          ->where('elementdappcs.dapid', $datas->id)
          ->get();


        $output .= '
            <tr>
                <td>
                    <center>
                     
                        <div class="btn-group me-2 mb-2 mb-sm-0">
                            <a  data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical ms-2"></i> Options
                            </a>
                            <div class="dropdown-menu">
                                <a href="dappc/' . $cryptedId . '/view" class="dropdown-item mx-1" id="' . $datas->id . '">
                                    <i class="fas fa-eye"></i> Voir 
                                </a>
                                
                                
                            </div>
                        </div>
                    </center>
                </td>
                <td align="center">' . $datas->numerodap . '</td>
                 <td align="center"> ';
                    /*<a href="dappc/' . $cryptedId . '/edit" class="dropdown-item mx-1" id="' . $datas->id . '" title="Modifier">
                    <i class="far fa-edit"></i> Modifier
                    </a>
                    <a href="dappc/' . $datas->id . '/generate-pdf-feb" class="dropdown-item mx-1">
                        <i class="fa fa-print"></i> Générer PDF
                    </a>
                    
                    <a class="dropdown-item text-white mx-1 deleteIcon" id="' . $datas->id . '" data-numero="' . $datas->numerodap . '" href="#" style="background-color:red">
                        <i class="far fa-trash-alt"></i> Supprimer
                    </a> */
        foreach ($numerofeb as $key => $numerofebs) {
          $output .= '[' . $numerofebs->numero . ']';
          if ($key < count($numerofeb) - 1) {
            $output .= ',';
          }
        }

        $output .= '</td>
                
                 <td align="right">' . $SommeFebs . '</td>
                <td>' . $datas->lieu . '</td> 	
                <td>' . $datas->comptebanque . '</td>
                <td>' . $datas->banque . '</td>
                <td>' . $datas->etablie_aunom . '</td>
                <td align="center">' . date('d-m-Y', strtotime($datas->created_at)) . '</td>
                <td  align="left" >' . ucfirst($datas->user_prenom) . '</td>
            
            </tr>';
      }
    } else {
      $output .= '
        <tr>
            <td colspan="15">
                <center>
                    <h6 style="margin-top:1%; color:#c0c0c0">
                        <center>
                            <font size="50px">
                                <i class="fas fa-info-circle"></i>
                            </font>
                            <br><br>
                            Ceci est vide !
                        </center>
                    </h6>
                </center>
            </td>
        </tr>';
    }
    echo $output;
  }

  // Fonction pour récupérer le montant total des DAP en fonction de plusieurs FEB
  public function getTotalSomme($dapId)
  {
    $febIds = DB::table('elementdappcs') // Suppose que vous avez une table de liaison entre DAP et FEB
      ->where('dapid', $dapId)
      ->pluck('referencefeb');

    return DB::table('febpetitcaisses')
      ->whereIn('id', $febIds)
      ->sum('montant');
  }

  public function findfebpc(Request $request)
  {
    $IDs = $request->ids; // Utilisez 'ids' pour obtenir tous les identifiants sélectionnés
    $devise = session()->get('devise');
    $budget = session()->get('budget');
    $IDP = session()->get('id');

    // Initialisez une variable pour stocker les sorties de tableau
    $output = '';
    $output .= '
    <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
    <tr>
      <th>Numéro du F.E.B</th>
      <th style="width:30%">Description de la demande </th>
      <th><center>AC/CE/CS </center> </th>
      <th><center>Comptable </center> </th>
      <th><center>Chef de Composante/Projet/Section </center> </th>
      <th><center>Montant du F.E.B P.C</center></th>
    </tr>';

    $totoglobale = 0; // Initialiser le total global à zéro
    $pourcentage_total = 0; // Initialiser le pourcentage total à zéro

    foreach ($IDs as $ID) {
      // Effectuez la recherche de données pour chaque identifiant sélectionné
      $data = DB::table('febpetitcaisses')
        ->where('febpetitcaisses.id', $ID)
        ->get();



      if ($data->count() > 0) {

        $totoSUM = DB::table('febpetitcaisses')
          ->orderBy('id', 'DESC')
          ->where('febpetitcaisses.id', $ID)
          ->sum('montant');

        // Ajouter $totoSUM au total global
        $totoglobale += $totoSUM;

        // Générer la sortie HTML pour chaque élément sélectionné
        foreach ($data as $datas) {

          $acc = $datas->etabli_par_signature == 1 
          ? '<i class="fa fa-check-circle text-primary"></i>' 
          : '<i class="fa fa-times-circle text-danger"></i>';
      
      $Comptable = $datas->verifie_par_signature == 1 
          ? '<i class="fa fa-check-circle text-primary"></i>' 
          : '<i class="fa fa-times-circle text-danger"></i>';
      
      $Chef = $datas->approuve_par_signature == 1 
          ? '<i class="fa fa-check-circle text-primary"></i>' 
          : '<i class="fa fa-times-circle text-danger"></i>';
      


          // Construire la sortie HTML pour chaque élément sélectionné
          $output .= '<input type="hidden"  name="febid[]" id="febid[]"  value="' . $datas->id . '" />
                      <input type="hidden"  name="compteid[]" value="' . $datas->compte_id . '"/>
                      <input type="hidden"  name="montant[]" value="' . $datas->montant . '">
          ';
          $output .= '<td> ' . $datas->numero . '</td>';
          $output .= '<td>' . $datas->description . '</td>';
          $output .= '<td align="center">' . $acc . '</td>';
          $output .= '<td align="center">' . $Comptable . '</td>';
          $output .= '<td align="center">' . $Chef . '</td>';
          $output .= '<td style="text-align:right" ">' . number_format($datas->montant, 0, ',', ' ') . '</td></tr>';
        }
      } else {
        $output = '<p style="background-color:red ; padding:4px; color:white"> <i class="fa fa-search"></i> Aucun élément trouvé, aucune valeur est en sélectionnée</p>';
      }
    }

    // Ajouter la ligne pour afficher le total global
    $output .= '
                </tr> 
        </table>';

    // Retournez la sortie HTML complète
    return $output;
  }

  public function checkDap(Request $request)
  {
    $ID = session()->get('id');
    $numero = $request->numerodap;
    $dap = Dapbpc::where('numerodap', $numero)
      ->where('projetiddap', $ID)
      ->exists();
    return response()->json(['exists' => $dap]);
  }

  public function delete(Request $request)
  {
    DB::beginTransaction();

    try {

      $id = $request->id;
      $emp =   Dapbpc::find($id);


      if ($emp && $emp->userid == Auth::id()) {


        // Trouver tous les enregistrements Elementdap associés au dap
        $elements = Elementdappc::where('dapid', $id)->get();
        // Collecter les ids des Feb à mettre à jour
        $febIds = $elements->pluck('referencefeb')->toArray();
        // Mettre à jour les enregistrements Feb en une seule fois
        Febpetitcaisse::whereIn('id', $febIds)->update(['statut' => 0]);

        Dapbpc::destroy($id);
        // Trouver tous les enregistrements Elementdap associés au dap
        Elementdappc::where('dapid', $id)->delete();
        //Elementdjas::where('idddap', $id)->delete();

        // Dja::where('numerodap',$id)->delete();

        DB::commit();

        return response()->json([
          'status' => 200,
        ]);
      } else {
        DB::rollBack();
        return response()->json([
          'status' => 205,
          'message' => 'Vous n\'avez pas l\'autorisation nécessaire pour supprimer le DAP. Veuillez contacter le créateur  pour procéder à la suppression.'
        ]);
      }
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'status' => 500,
        'message' => 'Erreur lors de la suppression du DAP.',
        'error' => $e->getMessage(), // Message d'erreur de l'exception
        'exception' => (string) $e // Détails de l'exception convertis en chaîne
      ]);
    }
  }
}
