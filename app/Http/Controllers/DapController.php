<?php

namespace App\Http\Controllers;

use App\Models\attache_feb;
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
use App\Models\Sigaledap;
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
use Illuminate\Support\Facades\Log;


class DapController extends Controller
{

  public function getFuelType()
  {
    $fuelTypes = Vehicule::pluck('matricule')->toArray(); // Supposons que votre table de carburant contient une colonne 'type'

    return response()->json($fuelTypes);
  }

  public function creer()
  {
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
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
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
      'document.dap.nouveau',
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


  public function fetchAll(Request $request)
  {
      $ID = session()->get('id'); // Récupérer l'ID de session
      $search = $request->input('search_dap'); // Valeur de recherche
      $pageSize = 25; // Nombre d'éléments par page

      $exerciceId = session()->get('exercice_id');
  
      // Construire la requête principale
      $query = DB::table('daps')
          ->leftJoin('users', 'daps.userid', '=', 'users.id')
          ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
          ->leftJoin('djas', 'daps.id', '=', 'djas.dapid')
          ->select(
              'daps.*',
              'personnels.prenom as user_prenom',
              'djas.montant_avance_un as avance'
          )
          ->where('daps.exerciceids', $exerciceId)
          ->where('daps.projetiddap', $ID);
  
      // Appliquer la recherche si un terme est saisi
      if (!empty($search)) {
          $query->where('daps.numerodp', '=', $search);
      }
  
      // Paginer les résultats
      $datadap = $query->orderBy('daps.numerodp', 'asc')->paginate($pageSize);
  
      // Initialiser le tableau de rendu HTML
      $output = "";
      if ($datadap->isNotEmpty()) {
      foreach ($datadap->items() as $datadaps) {
          // Gestion du signal DAP
          $message = $datadaps->signaledap == 1
              ? '<div class="spinner-grow text-danger" role="status" style="width: 0.5rem; height: 0.5rem;"></div>'
              : ' ';
  
          // Récupérer les numéros FEB associés
          $numerofeb = DB::table('febs')
              ->leftJoin('elementdaps', 'febs.id', '=', 'elementdaps.referencefeb')
              ->where('elementdaps.dapid', $datadaps->id)
              ->where('febs.execiceid', $exerciceId)
              ->pluck('numerofeb')
              ->toArray();
  
          // Crypter l'ID pour les liens
          $cryptedId = Crypt::encrypt($datadaps->id);
  
          // Calculer le montant total pour chaque DAP
          $totalMontant = $this->getTotalDap($datadaps->id);
  
          // Construire une ligne du tableau
          $output .= "<tr>";
          $output .= '<td><center>' . $message . '</center></td>';
          $output .= '<td><center>';
          $output .= '<div class="btn-group me-2 mb-2 mb-sm-0">
                          <a data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="mdi mdi-dots-vertical ms-2"></i> Options
                          </a>
                          <div class="dropdown-menu">
                              <a href="dap/' . $cryptedId . '/view" class="dropdown-item mx-1 voirIcon"><i class="far fa-eye"></i> Voir</a>
                              <a href="dap/' . $cryptedId . '/edit" class="dropdown-item mx-1 editIcon"><i class="far fa-edit"></i> Modifier</a>
                              <a href="dap/' . $cryptedId . '/generate-pdf-dap" class="dropdown-item mx-1"><i class="fa fa-print"></i> Générer PDF</a>'
                              . ($datadaps->signaledap == 1
                                  ? '<a class="dropdown-item desactiversignale" id="' . $datadaps->id . '" href="#"><i class="fas fa-random"></i> Désactiver le signal</a>'
                                  : '') . '
                              <a class="dropdown-item text-white mx-1 deleteIcon" id="' . $datadaps->id . '" data-numero="' . $datadaps->numerodp . '" href="#" style="background-color:red"><i class="far fa-trash-alt"></i> Supprimer</a>
                          </div>
                      </div>';
          $output .= '</center></td>';
          
          $output .= '<td>' . $datadaps->numerodp . '</td>';
          $output .= '<td>' . implode(', ', $numerofeb) . '</td>';
          $output .= '<td align="right"><b>' . number_format($totalMontant, 0, ',', ' ') . '</b></td>';
          $output .= '<td>' . (strlen($datadaps->lieu) > 15 ? substr($datadaps->lieu, 0, 15) . '...' : $datadaps->lieu) . '</td>';
          $output .= '<td>' . (strlen($datadaps->cho) > 8 ? substr($datadaps->cho, 0, 8) . '...' : $datadaps->cho) . '</td>';
          $output .= '<td>' . $datadaps->comptabiliteb . '</td>';
          $output .= '<td>' . $datadaps->banque . '</td>';
          
          $output .= '<td>' .$datadaps->paretablie. '</td>';
          $output .= '<td align="right"><b>' . number_format($datadaps->avance ?? 0, 0, ',', ' ') . '</b></td>';
          $output .= '<td align="center">' . ($datadaps->justifier == 1 ? 
                      '<input class="form-check-input" type="checkbox" checked disabled />' : '<input id="radioDanger" class="form-check-input" type="checkbox" disabled />') . '</td>';
          $output .= '<td>' . date('d-m-Y', strtotime($datadaps->created_at)) . '</td>';
          $output .= '<td>' . ucfirst($datadaps->user_prenom) . '</td>';
          
          $output .= '</tr>';
      }
    } else {
      $output .= '
            <tr>
                <td colspan="14">
                    <center>
                        <h6 style="margin-top:1%; color:#c0c0c0">
                            <font size="50px"><i class="fas fa-info-circle"></i></font>
                            <br><br>Aucun résultat trouvé.
                        </h6>
                    </center>
                </td>
            </tr>';
    }

  
      // Ajouter la pagination
      $pagination = $datadap->links('pagination::bootstrap-4')->toHtml();
  
      // Retourner la réponse JSON avec le tableau HTML et la pagination
      return response()->json([
          'table' => $output,
          'pagination' => $pagination
      ]);
  }
  

  // Fonction pour récupérer le montant total des DAP en fonction de plusieurs FEB
  public function getTotalDap($dapId)
  {
    $febIds = DB::table('elementdaps') // Suppose que vous avez une table de liaison entre DAP et FEB
      ->where('dapid', $dapId)
      ->pluck('referencefeb');

    return DB::table('elementfebs')
      ->whereIn('febid', $febIds)
      ->sum('montant');
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
         
          $justifier = $request->has('justifier') ? 1 : 0;
          $nonjustifier = $request->has('nonjustifier') ? 1 : 0;
  
          // Création d'une nouvelle instance de modèle Dap et attribution des valeurs
          $dap = new Dap();
          $dap->numerodp = $request->numerodap;
          $dap->serviceid = $request->serviceid;
          $dap->projetiddap = $request->projetid;
          $dap->lieu = $request->lieu;
          $dap->comptabiliteb = $request->comptebanque;
          $dap->cho = $request->ch;
          $dap->demandeetablie = $request->demandeetablie;
          $dap->verifierpar = $request->verifier;
          $dap->approuverpar = $request->approuver;
          $dap->responsable = $request->resposablefinancier;
          $dap->secretaire = $request->secretairegenerale;
          $dap->chefprogramme = $request->chefprogramme;
          $dap->paretablie = $request->paretablie;
          $dap->banque = $request->banque;
  
          if ($justifier == 1) {
              

              if ($request->beneficiaire == 'autres') {
                $dap->autresBeneficiaire = $request->beneficiaire;
            } else {
                 $dap->beneficiaire = $request->filled('beneficiaire') ? $request->beneficiaire : null;
            }

          }
  
          $dap->justifier = $justifier;
          $dap->nonjustifier = $nonjustifier;
          $dap->userid = Auth::id();
          $dap->save();
          $IDdap = $dap->id;
  
          if ($request->has('febid')) {
              foreach ($request->febid as $key => $febid) {
                  $existingDapE = Elementdap::where('referencefeb', $febid)->first();
  
                  if (!$existingDapE) {
                      $existingDapE = new Elementdap();
                      $existingDapE->dapid = $IDdap;
                      $existingDapE->numerodap = $request->numerodap;
                      $existingDapE->referencefeb = $febid;
                      $existingDapE->projetidda = $request->projetid;
                      $existingDapE->save();
  
                      $element = Feb::where('id', $febid)->first();
                      if ($element) {
                          $element->statut = 1;
                          $element->save();
                      }
                  }
              }
          }
  
          if ($justifier == 1 || $justifier == 0) {
              $justification = new Dja();
              $justification->projetiddja = $request->projetid;
              $justification->dapid = $IDdap;
              $justification->numerodjas = $request->numerodap;
              $justification->montant_avance_un = $request->montantavance;
              $justification->montant_avance = $request->montantavance;
              $justification->duree_avance = $request->duree_avance;
  
              if ($request->beneficiaire == 'autres') {
                  $justification->autresBeneficiaireFond = $request->autresBeneficiaire;
              } else {
                  $justification->fonds_demande_par = $request->beneficiaire;
              }
  
              $justification->description_avance = $request->descriptionel;
              $justification->justifie = $justifier == 1 ? 1 : 0;
              $justification->userid = Auth::id();
              $justification->save();
          }
  
          DB::commit();
  
          return response()->json([
              'status' => 200,
              'message' => 'Données enregistrées avec succès.'
          ]);
  
      } catch (\Exception $e) {
          DB::rollback();
  
          // Logging l'exception pour un suivi plus détaillé
          Log::error('Erreur lors de l\'enregistrement des données DAP : ' . $e->getMessage(), [
              'stackTrace' => $e->getTraceAsString()
          ]);
  
          return response()->json([
              'status' => 500,
              'error' => $e->getMessage(),
              'trace' => $e->getTraceAsString()
          ]);
      }
  }
  
  // insert a new employee ajax request
  public function updatestore(Request $request)
  {
    try {
      // Début de la transaction
      DB::beginTransaction();

      $IDpp = session()->get('id');
      $lead = session()->get('lead');

      $dap = Dap::where('id', $request->dapid)->first();
  

      // Vérifier si les enregistrements DAP et DJA existent
      if (!$dap ) {
        return back()->with('failed', 'DAP non trouvé.');
      }

      // Vérifier si l'utilisateur a le droit de modifier le DAP

      $get_lead =  DB::table('daps')
        ->join('projects', 'daps.projetiddap', '=', 'projects.id')
        ->select('projects.lead as lead')
        ->where('daps.id', $request->dapid)
        ->first();


      $projet_lead = $get_lead->lead;


      $justifier = $request->has('justifierChoice') ? 1 : 0;
      $nonjustifier = $request->has('nonjustifierChoice') ? 1 : 0;


      // Mettre à jour les champs du DAP
      $dap->numerodp = $request->numerodap;
      $dap->serviceid = $request->serviceid;
      $dap->lieu = $request->lieu;
      $dap->comptabiliteb = $request->comptebanque;
     
      $dap->cho = $request->ch;

      $dap->demandeetablie = $request->demandeetablie;
      $dap->verifierpar = $request->verifier;
      $dap->approuverpar = $request->approuver;
      $dap->responsable = $request->resposablefinancier;
      $dap->secretaire = $request->secretairegenerale;
      $dap->chefprogramme = $request->chefprogramme;
      $dap->observation = $request->observation;
      $dap->paretablie = $request->paretablie;
      $dap->banque = $request->banque;

      $dap->statut = 1;
      
      if ($justifier == 1) {
        $dap->beneficiaire = $request->filled('beneficiaire') ? $request->beneficiaire : NULL;
      }
      $dap->justifier = $justifier;
      $dap->nonjustifier = $nonjustifier;

      $dap->update();


      $dja  = Dja::where('id', $request->iddjass)->first();

      if($dja) {
        // Mettre à jour les champs du DJA
                $dja->numerodjas         = $request->numerodap;

                if ($justifier == 1) {
                  $dja->montant_avance_un  = $request->montantavance;
                  $dja->montant_avance     = $request->montantavance;
                  $dja->duree_avance       = $request->duree_avance;
                  $dja->description_avance = $request->descriptionel;
                  $dja->fonds_demande_par  = $request->beneficiaire;
                }else{
                  $dja->montant_avance_un  = 0;
                  $dja->montant_avance     = 0;
                  $dja->duree_avance       = 0;
                  $dja->description_avance  = '';
                  $dja->fonds_demande_par   = NULL;
                }
              
                $dja->justifie           = $justifier;

                $dja->update();

        }else{

          // creer Nouveau
          $New_dja = new Dja();
          $New_dja->projetiddja         = $IDpp;
          $New_dja->dapid               = $request->dapid;
          $New_dja->numerodjas          = $request->numerodap;
          if ($justifier == 1) {
            $New_dja->montant_avance_un   = $request->montantavance;
            $New_dja->montant_avance      = $request->montantavance;
            $New_dja->duree_avance        = $request->duree_avance;
            $New_dja->description_avance  = $request->descriptionel;
            $New_dja->fonds_demande_par   = $request->beneficiaire;
          }else{
            $New_dja->montant_avance_un   = 0;
            $New_dja->montant_avance      = 0;
            $New_dja->duree_avance        = 0;
            $New_dja->description_avance  = '';
            $New_dja->fonds_demande_par   = NULL;
          }
         
          $New_dja->justifie            = $justifier;
          $New_dja->userid              = Auth::id();
          $New_dja->save();

      }


      if ($request->has('febid')) {
        foreach ($request->febid as $key => $febid) {
          // Vérifier si un enregistrement avec la même référencefeb existe déjà
          $existingDapE = Elementdap::where('referencefeb', $febid)->first();

          if ($existingDapE) {

            $existingDapE->dapid = $request->dapid;
            $existingDapE->numerodap = $request->numerodap;
            $existingDapE->referencefeb = $febid;

            $existingDapE->update();

            // Mettre à jour le statut de l'élément Feb correspondant

          }
        }
      }

      // Valider la transaction
      DB::commit();

      return back()->with('success', 'Mises à jour effectuées avec succès.');
    } catch (Exception $e) {
      // En cas d'erreur, annuler la transaction
      DB::rollBack();
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
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
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
          $datesecretaire = date('Y-m-d');
        } else {
          $secretaure_general_signe = $request->clone_secretairesignature;
          $datesecretaire = $request->ancient_date_autorisation;
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
        $emp->dateautorisation = $datesecretaire;


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
        $id = $request->id;
        $dap = Dap::find($id);

        // Vérification de l'existence du DAP et des autorisations utilisateur
        if ($dap && $dap->userid == Auth::id()) {
            // 1. Mise à jour des FEB associés (si des éléments DAP existent)
            $elements = Elementdap::where('dapid', $id)->get();

            if ($elements->isNotEmpty()) {
                $febIds = $elements->pluck('referencefeb')->toArray();
                Feb::whereIn('id', $febIds)->update(['statut' => 0]);
            }

            // 2. Suppression des DJA associés (si présents)
            $djas = Dja::where('dapid', $id);
            if ($djas->exists()) {
                $djas->delete();
            }

            // 3. Suppression des Elementdap associés (si présents)
            $elementDaps = Elementdap::where('dapid', $id);
            if ($elementDaps->exists()) {
                $elementDaps->delete();
            }

            // 5. Suppression du DAP lui-même
            $dap->delete();

            // Validation de la transaction
            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'DAP et DJA supprimés avec succès, et les FEB associés ont été mis à jour pour la réutilisation.'
            ]);
        } else {
            // Annulation de la transaction en cas de problème
            DB::rollBack();
            return response()->json([
                'status' => 205,
                'message' => 'Vous n\'avez pas l\'autorisation nécessaire pour supprimer le DAP. Veuillez contacter le créateur pour procéder à la suppression.'
            ]);
        }
    } catch (\Exception $e) {
        // Gestion de l'erreur et annulation de la transaction
        DB::rollBack();
        return response()->json([
            'status' => 500,
            'message' => 'Erreur lors de la suppression du DAP.',
            'error' => $e->getMessage()
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
      ->leftJoin('services', 'daps.serviceid', 'services.id')
      ->leftJoin('projects', 'daps.projetiddap', 'projects.id')
      ->select('daps.*', 'services.title as titres', 'projects.budget as montantprojet', 'projects.title as projettitle', 'projects.devise as devise')
      ->where('daps.id', $idd)
      ->first();

    $dajshow = Dja::where('dapid', $idd)->first();


    $budget = $datadap->montantprojet;
    $ID = $datadap->projetiddap;
    $devise  = $datadap->devise;

    $elementfeb = DB::table('febs')
      ->leftJoin('elementdaps', 'febs.id', 'elementdaps.referencefeb')
      ->select('elementdaps.*', 'febs.id as fid', 'febs.numerofeb', 'febs.descriptionf', 'febs.ligne_bugdetaire',  'febs.acce_signe', 'febs.comptable_signe', 'febs.chef_signe')
      ->where('elementdaps.dapid', $datadap->id)
      ->get();



    $elementfebencours = DB::table('febs')
      ->leftJoin('elementdaps', 'febs.id', 'elementdaps.referencefeb')
      ->select('elementdaps.*', 'febs.id as fid', 'febs.numerofeb', 'febs.descriptionf', 'febs.sous_ligne_bugdetaire', 'febs.ligne_bugdetaire')
      ->where('elementdaps.dapid', $datadap->id)
      ->first();

    $numero_classe_feb = $elementfebencours->numerofeb;
    $id_gl = $elementfebencours->ligne_bugdetaire;

    $somme_ligne_principale = DB::table('rallongebudgets')
      ->where('compteid', $id_gl)
      ->sum('budgetactuel');

    $sommeGrandLigne = DB::table('elementfebs')
      ->where('numero', '<=', $numero_classe_feb)
      ->where('grandligne', $id_gl)
      ->where('projetids', $ID)
      ->sum('montant');

    $somme_gloable = DB::table('elementfebs')
      ->where('numero', '<=', $numero_classe_feb)
      ->Where('projetids', $ID)
      ->SUM('montant');

    $SOMME_PETITE_CAISSE = DB::table('elementboncaisses')
      ->join('bonpetitcaisses', 'elementboncaisses.boncaisse_id', 'bonpetitcaisses.id')
      ->where('elementboncaisses.projetid', $ID)
      ->where('bonpetitcaisses.approuve_par_signature', 1)
      ->sum('elementboncaisses.montant');

    $SOMMES_DEJA_UTILISE = $somme_gloable + $SOMME_PETITE_CAISSE;

    if ($budget != 0) {
      $pourcentage_globale = round(($SOMMES_DEJA_UTILISE * 100) / $budget, 2);
    } else {
      $pourcentage_globale = 0;
    }


    // Calcul du solde comptable
    $solde_comptable = $budget - $SOMMES_DEJA_UTILISE;



    // Calcul du pourcentage en cours
    if ($somme_ligne_principale != 0) {
      $pourcentage_encours = round(($sommeGrandLigne * 100) / $somme_ligne_principale, 2);
    } else {
      $pourcentage_encours = 0;
    }

    //etablie par 
    $etablienom =  DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->Where('users.id', $datadap->userid)
      ->first();

    $fond_reussi = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->Where('users.id', $datadap->beneficiaire)
      ->first();



    $Demandeetablie =  DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->Where('users.id', $datadap->demandeetablie)
      ->first();

    $verifierpar =  DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->Where('users.id', $datadap->verifierpar)
      ->first();

    $approuverpar =  DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->Where('users.id', $datadap->approuverpar)
      ->first();

    $responsable =  DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->Where('users.id', $datadap->responsable)
      ->first();

    $secretaire =  DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'personnels.id as idp', 'users.signature', 'users.id as usersid')
      ->Where('users.id', $datadap->secretaire)
      ->first();

    $chefprogramme =  DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
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
        'pourcetage_globale' => $pourcentage_globale,
        'solde_comptable' => $solde_comptable,
        'pourcentage_encours' => $pourcentage_encours,
        'devise' => $devise,
        'fond_reussi' => $fond_reussi,
        'dajshow' => $dajshow



      ]
    );
  }

  public function edit($idd)
  {

    $idd = Crypt::decrypt($idd);

    $title = "Modification DAP";
    $service = Service::all();

    $banque = Banque::all();

    $datadap = DB::table('daps')
      ->leftJoin('services', 'daps.serviceid', 'services.id')
      ->leftJoin('projects', 'daps.projetiddap', 'projects.id')
      ->select('daps.*', 'daps.id as iddape', 'services.id as idss', 'services.title as titres', 'projects.budget as montantprojet', 'projects.devise as devise', 'daps.userid as iduser')
      ->where('daps.id', $idd)
      ->first();

    $dajshow = Dja::where('dapid', $idd)->first();

    $budget = $datadap->montantprojet;
    $ID = $datadap->projetiddap;
    $devise  = $datadap->devise;

    $fond_reussi = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as userid')
      ->Where('users.id', $datadap->beneficiaire)
      ->first();

    // dd($fond_reussi);

    $compte =  DB::table('comptes')
      ->where('comptes.projetid', $ID)
      ->where('compteid', '=', 0)
      ->get();
    // utilisateur
    $personnel = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
      ->orderBy('nom', 'ASC')
      ->get();


    $initiateur = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
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
      ->leftJoin('elementdaps', 'febs.id', 'elementdaps.referencefeb')
      ->select('elementdaps.*', 'febs.id as fid', 'febs.numerofeb', 'febs.descriptionf')
      ->where('elementdaps.dapid', $idd)
      ->get();

    $sommefebs =   DB::table('elementdaps')
      ->leftJoin('elementfebs', 'elementdaps.referencefeb', 'elementfebs.febid')
      ->Where('elementdaps.dapid', $idd)
      ->SUM('elementfebs.montant');

    $sommefebs = number_format($sommefebs, 0, ',', ' ') . ' ' . $devise;

    $chefcomposant = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as idus', 'users.signature')
      ->Where('users.id', $datadap->demandeetablie)
      ->first();

    $chefcomptable = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as idus', 'users.signature')
      ->Where('users.id', $datadap->verifierpar)
      ->first();

    $chefservice = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as idus', 'users.signature')
      ->Where('users.id', $datadap->approuverpar)
      ->first();

    $responsable = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as idus', 'users.signature')
      ->Where('users.id', $datadap->responsable)
      ->first();

    $secretaire = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as idus', 'users.signature')
      ->Where('users.id', $datadap->secretaire)
      ->first();

    $chefprogramme = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as idus', 'users.signature')
      ->Where('users.id', $datadap->chefprogramme)
      ->first();

    $feb = DB::table('febs')
      ->orderBy('numerofeb', 'ASC')
      ->where('projetid', $ID)
      ->where('statut', 0)
      ->get();

    $elementfeb = DB::table('febs')
      ->leftJoin('elementdaps', 'febs.id', 'elementdaps.referencefeb')
      ->select('elementdaps.*', 'febs.id as fid', 'febs.numerofeb', 'febs.descriptionf', 'febs.ligne_bugdetaire')
      ->where('elementdaps.dapid', $datadap->id)
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
        'feb' => $feb,
        'banque' => $banque,
        'fond_reussi' => $fond_reussi,
        'elementfeb' => $elementfeb,
        'dajshow'  => $dajshow

      ]
    );
  }

  public function generatePDFdap($id)
  {
    $id = Crypt::decrypt($id);

    $datadap = DB::table('daps')
      ->leftJoin('services', 'daps.serviceid', '=', 'services.id')
      ->leftJoin('projects', 'daps.projetiddap', '=', 'projects.id')
      ->select('daps.*', 'services.title as titres', 'projects.budget as montantprojet', 'projects.devise as devise', 'daps.userid as iduser', 'projects.title as projettitle', 'projects.devise as devise')
      ->where('daps.id', $id)
      ->first();

      $dajshow = Dja::where('dapid', $id)->first();

    $budget = $datadap->montantprojet;
    $IDb = $datadap->projetiddap;
    $devise = $datadap->devise;


    $datafebElement = DB::table('febs')
      ->leftJoin('elementdaps', 'febs.id', '=', 'elementdaps.referencefeb')
      ->select('elementdaps.*', 'febs.id as fid', 'febs.numerofeb', 'febs.descriptionf', 'febs.ligne_bugdetaire')
      ->where('elementdaps.dapid', $id)
      ->get();



    $elementfebencours = DB::table('febs')
      ->leftJoin('elementdaps', 'febs.id', 'elementdaps.referencefeb')
      ->select('elementdaps.*', 'febs.id as fid', 'febs.numerofeb', 'febs.descriptionf', 'febs.sous_ligne_bugdetaire', 'febs.ligne_bugdetaire')
      ->where('elementdaps.dapid', $datadap->id)
      ->first();

    $numero_classe_feb =  $elementfebencours->numerofeb;
    $id_gl = $elementfebencours->ligne_bugdetaire;


    $somme_ligne_principale = DB::table('rallongebudgets')
      ->where('compteid', $id_gl)
      ->sum('budgetactuel');

    $sommeGrandLigne = DB::table('elementfebs')
      ->where('numero', '<=', $numero_classe_feb)
      ->where('grandligne', $id_gl)
      ->where('projetids', $IDb)
      ->sum('montant');


    $somme_gloable = DB::table('elementfebs')
      ->where('numero', '<=', $numero_classe_feb)
      ->where('projetids', $IDb)
      ->sum('montant');


    $SOMME_PETITE_CAISSE = DB::table('elementboncaisses')
      ->join('bonpetitcaisses', 'elementboncaisses.boncaisse_id', 'bonpetitcaisses.id')
      ->where('elementboncaisses.projetid', $IDb)
      ->where('bonpetitcaisses.approuve_par_signature', 1)
      ->sum('elementboncaisses.montant');

    $SOMMES_DEJA_UTILISE = $somme_gloable + $SOMME_PETITE_CAISSE;

    $pourcetage_globale = $budget ? round(($SOMMES_DEJA_UTILISE * 100) / $budget, 2) : 0;

    // Calcul du solde comptable

    $relicat = $budget - $SOMMES_DEJA_UTILISE;

    // Calcul du pourcentage en cours

    $pourcentage_encours = $somme_ligne_principale ? round(($sommeGrandLigne * 100) / $somme_ligne_principale, 2) : 0;

    $infoglo = DB::table('identifications')->first();

    $fond_reussi = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->where('users.id', $datadap->beneficiaire)
      ->first();


    $etablienom = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->where('users.id', $datadap->iduser)
      ->first();

    $Demandeetablie = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->where('users.id', $datadap->demandeetablie)
      ->first();

    $verifierpar = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->where('users.id', $datadap->verifierpar)
      ->first();

    $approuverpar = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->where('users.id', $datadap->approuverpar)
      ->first();

    $responsable = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as usersid')
      ->where('users.id', $datadap->responsable)
      ->first();

    $secretaire = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'personnels.id as idp', 'users.signature', 'users.id as usersid')
      ->where('users.id', $datadap->secretaire)
      ->first();

    $chefprogramme = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'personnels.id as idp', 'users.signature', 'users.id as usersid')
      ->where('users.id', $datadap->chefprogramme)
      ->first();

    $chefservice = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as idus', 'users.signature')
      ->where('users.id', $datadap->approuverpar)
      ->first();

    $chefcomposant = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as idus', 'users.signature')
      ->where('users.id', $datadap->demandeetablie)
      ->first();

    $chefcomptable = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
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
      'somme_ligne_principale',
      'fond_reussi',
      'dajshow'
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
    $numero_classe_feb =  $check->numerofeb;

    $datElement = Elementfeb::where('febid', $idfeb)->get();

    $IDB = $check->projetid;
    $project = Project::findOrFail($IDB);
    $budget = $project->budget;

    $somme_ligne_principale = DB::table('rallongebudgets')
      ->where('compteid', $id_gl)
      ->sum('budgetactuel');

    $onebeneficaire = Beneficaire::find($check->beneficiaire);

    $sommeallfeb = DB::table('elementfebs')
      ->where('numero', '<=', $numero_classe_feb)
      ->where('projetids', $IDB)
      ->sum('montant');

    $dataLigne = Compte::find($idl);

    $sommelign = DB::table('elementfebs')
      ->where('grandligne', $id_gl)
      ->where('numero', '<=', $numero_classe_feb)
      ->where('projetids', $IDB)
      ->sum('montant');

    if ($somme_ligne_principale != 0) {
      $sommelignpourcentage = round(($sommelign * 100) / $somme_ligne_principale, 2);
    } else {
      $sommelignpourcentage = 0;
    }

    $sommefeb = DB::table('elementfebs')
      ->where('febid', $idfeb)
      ->where('projetids', $IDB)
      ->sum('montant');

    $SOMME_PETITE_CAISSE = DB::table('elementboncaisses')
      ->join('bonpetitcaisses', 'elementboncaisses.boncaisse_id', 'bonpetitcaisses.id')
      ->where('elementboncaisses.projetid', $IDB)
      ->where('bonpetitcaisses.approuve_par_signature', 1)
      ->sum('elementboncaisses.montant');

    $SOMMES_DEJA_UTILISE = $sommeallfeb + $SOMME_PETITE_CAISSE;

    if ($budget != 0) {
      $POURCENTAGE_GLOGALE = round(($SOMMES_DEJA_UTILISE * 100) / $budget, 2);
    } else {
      $POURCENTAGE_GLOGALE = 0;
    }

    // Récupérer les informations sur l'utilisateur
    $createur = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'users.id as useridp')
      ->where('users.id', $check->userid)
      ->first();

    $etablienom = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as userid')
      ->where('users.id', $check->acce)
      ->first();

    $comptable_nom = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
      ->where('users.id', $check->comptable)
      ->first();

    $checcomposant_nom = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
      ->where('users.id', $check->chefcomposante)
      ->first();

    // Fetch attached documents
    $documents  = attache_feb::join('apreviations', 'attache_febs.annexid', 'apreviations.id')
      ->select('apreviations.abreviation', 'apreviations.libelle', 'attache_febs.urldoc')
      ->where('attache_febs.febid',  $id)
      ->get();

    // Initialiser la variable de sortie
    $output = '';

    if ($dataFeb) {
      $datElementFeb = Elementfeb::where('febid', $id)->get();
      $n = 1;
      $sommefeb = 0;

      // Créer l'en-tête du tableau
      $output .= '
              <div class="row">
                  <h5><center>FICHE D’EXPRESSION DES BESOINS (FEB) N° ' . $dataFeb->numerofeb . '
                  <a href="' . route('generate-pdf-feb', $dataFeb->id) . '" class="btn btn-primary waves-light waves-effect" title="Générer PDF">
                  <i class="fa fa-print"></i> 
                </a></center>
                  </h5>
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
                             <td>Documents attachés: <br>';


      if ($documents->isNotEmpty()) {
        foreach ($documents as $doc) {
          if ($doc->urldoc !== null) {
            // Lien cliquable si `urldoc` est disponible
            $output .= '<i class="fa fa-check-circle" style="color: green;" title="' . $doc->libelle . '"></i>  <a href="' . asset($doc->urldoc) . '" target="_blank" title="' . $doc->libelle . '">'
              . $doc->abreviation .
              '</a>, ';
          } else {
            // Icône rouge si aucun document n'est disponible
            $output .= '<i class="fa fa-times-circle" style="color: red;" title="Aucun document disponible"></i> '
              . $doc->abreviation . ', ';
          }
        }
        // Suppression de la virgule finale
        $output = rtrim($output, ', ');
      } else {
        // Message si aucun document n'est disponible
        $output .= '<i class="fa fa-times-circle" style="color: red;" title="Aucun fichier attaché disponible"></i>';
      }

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

  public function fetchAllsignaledap($dapid)
  {
    $signale = Sigaledap::where('dapid', $dapid)
      ->orderBy('id', 'ASC')
      ->leftJoin('users', 'sigaledaps.userid', '=', 'users.id')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('sigaledaps.*', 'personnels.nom as user_nom', 'personnels.prenom as user_prenom', 'users.avatar as avatar')
      ->get();

    $output = '';

    if ($signale->count() > 0) {
      foreach ($signale as $rs) {
        if ($rs->userid ==  Auth::id()) {
          $supprimerMOi =  '<a class="dropdown-item text-danger mx-1 deleteMessageSend" id="' . $rs->id . '" href="#" ><i class="far fa-trash-alt"></i> Supprimer</a>';
        } else {
          $supprimertoi =  '<a class="dropdown-item text-danger mx-1 deleteMessageSend" id="' . $rs->id . '" href="#" ><i class="far fa-trash-alt"></i> Supprimer</a>';
        }
        if ($rs->userid == $rs->notisid) {
          $output .= '
                      <li class="right" >
                          <div class="conversation-list">
                              <div class="chat-avatar">
                                  <img src="' . asset($rs->avatar) . '" alt="avatar">
                              </div>
                              <div class="ctext-wrap">
                                  <div class="conversation-name">' . ucfirst($rs->user_nom) . ' ' . ucfirst($rs->user_prenom) . '</div>
                                  
                                  <div class="ctext-wrap-content">
                                  
                                      <p class="mb-0">' . ucfirst($rs->message) . '</p>
                                  </div>
                                  <p class="chat-time mb-0">
                                  <i class="mdi mdi-clock-outline align-middle me-1"></i> ' . date(' H:i:s d-m-Y', strtotime($rs->created_at)) . ' 
                                    ' . @$supprimerMOi . '
                                  </p>
                              </div>
                          </div>
                      </li>';
        } else {
          $output .= '
                      <li data-simplebar>
                          <div class="conversation-list">
                              <div class="chat-avatar">
                                  <img src="' . asset($rs->avatar) . '" alt="avatar">
                              </div>
                              <div class="ctext-wrap">
                                  <div class="conversation-name">' . ucfirst($rs->user_nom) . ' ' . ucfirst($rs->user_prenom) . '</div>
                                  <div class="ctext-wrap-content">
                                      <p class="mb-0">' . ucfirst($rs->message) . '
                                      </p>
                                  </div>
                                  <p class="chat-time mb-0"><i class="mdi mdi-clock-outline me-1"></i> ' . date(' H:i:s d-m-Y', strtotime($rs->created_at)) . '
                                  ' . @$supprimertoi . '
                                  </p>
                              </div>
                          </div>
                      </li>';
        }
      }
    } else {
      $output = '<li>No data available</li>';
    }

    return $output;
  }

  public function storeSignaleDap(Request $request)
  {
    DB::beginTransaction(); // Démarre la transaction

    try {
      $signale = new Sigaledap();
      $signale->userid = Auth()->user()->id;
      $signale->notisid = $request->createdaps;
      $signale->dapid = $request->dapids;
      $signale->message = $request->messagesignale;

      $do = $signale->save();

      if ($do) {
        $checkfeb = Dap::find($request->dapids);
        $checkfeb->signaledap = 1;
        $checkfeb->update();

        DB::commit(); // Valide la transaction si tout réussit

        return response()->json([
          'status' => 200,
          'dapid' => $request->dapids,
        ]);
      }
    } catch (Exception $e) {
      DB::rollback(); // Annule la transaction en cas d'erreur
      return response()->json([
        'status' => 202,
        'error' => $e->getMessage(), // Retourne l'erreur spécifique
      ]);
    }
  }

  public function desacctiveSignale(Request $request)
  {

    try {

      $emp = dap::find($request->id);
      if ($emp->userid == Auth::id()) {

        $id = $request->id;
        $emp->signaledap = 2;
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

  public function deleteSignale(Request $request)
  {
    try {

      $emp = Sigaledap::find($request->id);
      if ($emp->userid == Auth::id()) {
        $id = $request->id;
        Sigaledap::destroy($id);
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

  public function deleteElement(Request $request)
  {
      DB::beginTransaction();
  
      try {
          $id = $request->id;
  
          // Vérifier s'il existe des enregistrements Elementdap associés au dap
          $elements = Elementdap::where('referencefeb', $id)->get();
  
          // Supprimer les enregistrements Feb si des éléments sont trouvés
          if ($elements->isNotEmpty()) {
              // Collecter les IDs des Feb à mettre à jour
              $febIds = $elements->pluck('referencefeb')->toArray();
              
              // Mettre à jour les enregistrements Feb en une seule fois
              if (!empty($febIds)) {
                  Feb::whereIn('id', $febIds)->update(['statut' => 0]);
              }
  
              // Supprimer les enregistrements dans Elementdap s'ils existent
              if (Elementdap::where('referencefeb', $id)->exists()) {
                  Elementdap::where('referencefeb', $id)->delete();
              }
  
              // Supprimer les enregistrements dans Elementdjas s'ils existent
              if (Elementdjas::where('febid', $id)->exists()) {
                  Elementdjas::where('febid', $id)->delete();
              }
  
              DB::commit();
  
              return response()->json([
                  'status' => 200,
                  'message' => 'Élément supprimé avec succès.'
              ]);
          } else {
              // Si aucun élément trouvé, ne pas bloquer l'opération, simplement retourner un message d'avertissement
              DB::rollBack();
              return response()->json([
                  'status' => 404,
                  'message' => 'Aucun élément trouvé à supprimer.'
              ]);
          }
      } catch (\Exception $e) {
          DB::rollBack();
          return response()->json([
              'status' => 500,
              'message' => 'Erreur lors de la suppression de l\'élément.',
              'error' => $e->getMessage(),
              'exception' => (string) $e
          ]);
      }
  }

  public function printDapList()
  {
      $ID = session()->get('id');
  
      // Récupérer les données DAP
      $datadap = DB::table('daps')
          ->leftJoin('users', 'daps.userid', '=', 'users.id')
          ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
          ->leftJoin('djas', 'daps.id', 'djas.dapid')
          ->select('daps.*', 'personnels.prenom as user_prenom', 'djas.montant_avance as avance')
          ->where('daps.projetiddap', $ID)
          ->orderBy('daps.numerodp', 'asc')
          ->get();
  
      // Initialisation du contenu de la liste à afficher

      $dateinfo = Identification::all()->first();
      $output = '';
  
      if ($datadap->count() > 0) {
          foreach ($datadap as $datadaps) {
              // Déterminer les états
              $ov = $datadaps->ov == 1 ? "checked" : "";
              $justifier = $datadaps->justifier == 1 ? "checked" : "";
              $nonjustifier = $datadaps->justifier == 0 ? "checked" : "";
  
              // Message d'alerte si signalé
              $message = $datadaps->signaledap == 1 ? 
                  '<div class="spinner-grow text-danger" role="status" style="width: 0.5rem; height: 0.5rem;">
                      <span class="sr-only">Loading...</span>
                  </div>' : '';
  
              // Récupérer les numéros FEB associés à chaque DAP
              $numerofeb = DB::table('febs')
                  ->leftJoin('elementdaps', 'febs.id', '=', 'elementdaps.referencefeb')
                  ->where('elementdaps.dapid', $datadaps->id)
                  ->get();
  
              // Initialisation des variables pour les numéros FEB
              $febNumbers = [];
              foreach ($numerofeb as $feb) {
                  $febNumbers[] = $feb->numerofeb;  // Ajouter le numéro FEB
              }
  
              // Crypter l'ID du DAP pour l'utiliser dans les liens
              $cryptedId = Crypt::encrypt($datadaps->id);
  
              // Calculer le montant total pour ce DAP
              $totalMontant = $this->getTotalDap($datadaps->id);
  
              // Générer la ligne de la liste
              $output .= '
                  <tr>
                  <td align="center">' . $datadaps->numerodp . '</td>
                      <td align="center">';

                        foreach ($numerofeb as $key => $numerofebs) {
                          $output .= '[' . $numerofebs->numerofeb . ']';
                          if ($key < count($numerofeb) - 1) {
                            $output .= ',';
                          }
                        }

                        $output .= '
                    </td>
                    <td style="text-align: right;"><b>' . number_format($totalMontant, 0, ',', ' ') . '</b></td>
                    <td>' . (strlen($datadaps->lieu) > 15 ? substr($datadaps->lieu, 0, 15) . '...' : $datadaps->lieu) . '</td>
                    <td><span title="' . $datadaps->cho . '">' . $datadaps->cho. '</span></td>
                    <td align="right">'. $datadaps->comptabiliteb . '</td>
                    <td align="left">'. $datadaps->banque . '</td>
                    <td><span title="'. $datadaps->paretablie . '">' . $datadaps->paretablie. '</span></td>
                    <td style="text-align: right;"><b>'. number_format(isset($datadaps->avance) ? $datadaps->avance : 0, 0, ',', ' ') . '</b></td>
                    <td style="text-align: center;"><input type="checkbox" ' . $justifier . ' class="form-check-input" disabled /></td>
                    <td style="text-align: center;">'. date('d-m-Y', strtotime($datadaps->created_at)) . '</td>
                    <td align="left">'. ucfirst($datadaps->user_prenom) . '</td>
                  </tr>';
          }
      }
  
      // Retourner la vue avec la liste générée
      return view('document.dap.print_liste', compact('output','dateinfo'));
  }
  
  
  
  
  

}
