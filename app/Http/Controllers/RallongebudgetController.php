<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\Coutbudget;
use App\Models\Project;
use App\Models\Rallongebudget;
use App\Models\typeprojet;
use Illuminate\Support\Str;
use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class RallongebudgetController extends Controller
{
  public function index()
  {

    if (!session()->has('id')) {
      return redirect()->route('dashboard');
    }
    // Récupération des valeurs de la session
    $IDP = session()->get('id');
    $devise = session()->get('devise');
    $budget = session()->get('budget');
    $periode = session()->get('periode');

    // Définition du titre de la page
    $title = 'Budgétisation';

    // Récupération des comptes associés au projet en cours
    $compte = Compte::where('projetid', $IDP)
      ->where('compteid', 0)
      ->get();

    // Récupération de tous les types de budget
    $typebudget = TypeProjet::all();

    // Récupération des données du projet
    $projetdatat = Project::find($IDP);

    // Vérification que les données du projet ont été récupérées
    if (!$projetdatat) {
      // Gestion du cas où le projet n'existe pas
      return redirect()->route('error.page')->with('error', 'Projet non trouvé.');
    }

    // Retourne la vue avec les données nécessaires
    return view('rallonge.index', [
      'title' => $title,
      'compte' => $compte,
      'periode' => $periode,
      'typebudget' => $typebudget,
      'projetdatat' => $projetdatat,
     
    ]);
  }

  public function fetchAll($isForPrinting = false)
{
    // Récupération des valeurs de la session
    $IDP = session()->get('id');
    $devise = session()->get('devise');
    $budget = session()->get('budget');
    $periode = session()->get('periode');

    // Récupération des données de base
    $data = Compte::where('compteid', 0)
        ->where('projetid', $IDP)
        ->get();

    // Récupération des informations du projet
    $showData = Project::find($IDP);

    // Calcul du budget total réparti
    $sommerepartie = DB::table('rallongebudgets')
        ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
        ->where('rallongebudgets.projetid', $IDP)
        ->sum('budgetactuel');

    // Récupération des informations sur l'utilisateur responsable du projet
    $user = DB::table('users')
        ->join('personnels', 'users.personnelid', '=', 'personnels.id')
        ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
        ->where('users.id', $showData->lead)
        ->get();

    // Calcul du budget total et du pourcentage FEB
    $datasommefeb = DB::table('elementfebs')
        ->where('projetids', $IDP)
        ->sum('montant');

    $pourcentagefeb = $budget ? round(($datasommefeb * 100) / $budget, 2) : 0;
    $sommefeb = number_format($datasommefeb, 0, ',', ' ');

    $messageFEB = $pourcentagefeb == 100
        ? '<center><span class="badge rounded-pill bg-primary font-size-11">Terminé</span></center>'
        : '<center><span class="badge rounded-pill bg-success font-size-11">En cours</span></center>';

    // Initialisation du message pour le budget global
    $pglobale = $showData->budget ? round(($sommerepartie * 100) / $showData->budget, 2) : 0;
    $message = $sommerepartie == $showData->budget
        ? '<center><span class="badge rounded-pill bg-primary font-size-11">Terminé</span></center>'
        : '<center><span class="badge rounded-pill bg-success font-size-11">En cours</span></center>';

    $poursommerepartie = $showData->budget ? round(($sommerepartie * 100) / $showData->budget, 2) : 0;
    $messageR = $poursommerepartie == 100
        ? '<center><span class="badge rounded-pill bg-primary font-size-11">Terminé</span></center>'
        : '<center><span class="badge rounded-pill bg-success font-size-11">En cours</span></center>';

    // Construction du tableau de résumé du projet
    $output = '';
    if ($data->count() > 0) {
        $nombre = 1;

        $output .= '
            <table class="table table-bordered table-sm fs--1 mb-0">
                <tr style="background-color:#82E0AA">
                    <td style="padding:5px"><b>Rubrique du projet</b></td>
                    <td style="padding:5px"><b>Pays / région</b></td>
                    <td style="padding:5px"><b>N<sup>o</sup> Projet</b></td>
                    <td style="padding:5px"><b><center>Budget</center></b></td>
                    <td style="padding:5px"><b><center>%</center></b></td>
                    <td style="padding:5px"><b><center>Statut</center></b></td>
                </tr>
                <tr>
                    <td style="padding:5px; width:50%">' . htmlspecialchars($showData->title) . '</td>
                    <td style="padding:5px">' . htmlspecialchars($showData->region) . '</td>
                    <td style="padding:5px">' . htmlspecialchars($showData->numeroprojet) . '</td>
                    <td style="padding:5px" align="right">' . number_format($showData->budget, 0, ',', ' ') . '</td>
                    <td align="right">100%</td>
                    <td>' . $message . '</td>
                </tr>
                <tr>
                    <td colspan="3">Total Budget Réparti</td>
                    <td style="padding:5px" align="right">' . number_format($sommerepartie, 0, ',', ' ') . '</td>
                    <td align="right">' . $pglobale . '%</td>
                    <td>' . $messageR . '</td>
                </tr>
                <tr>
                    <td colspan="3">Montant en cours de consommation</td>
                    <td style="padding:5px" align="right">' . $sommefeb . '</td>
                    <td align="right">' . $pourcentagefeb . '%</td>
                    <td>' . $messageFEB . '</td>
                </tr>
            </table>';

        // Type de budget
        $typeBudget = typeprojet::all();

        foreach ($typeBudget as $typeBudgets) {
            $cle_id_type_projet = $typeBudgets->id;

            // Vérifier si le type de budget contient des éléments
            $containsElements = false;
            foreach ($data as $datas) {
                $somme_budget_ligne = DB::table('rallongebudgets')
                    ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
                    ->where('rallongebudgets.projetid', $IDP)
                    ->where('rallongebudgets.compteid', $datas->id)
                    ->where('comptes.cle_type_projet', $cle_id_type_projet)
                    ->sum('rallongebudgets.budgetactuel');

                if ($somme_budget_ligne !== null) {
                    $containsElements = true;
                    break;
                }
            }

            // Afficher le titre du type de budget seulement s'il contient des éléments
            if ($containsElements) {
                $output .= '<br><h5>&nbsp; &nbsp;&nbsp;<u>'.$cle_id_type_projet.'. ' . $typeBudgets->titre . '</u></h5>';

                $output .= '
                    <table class="table table-bordered table-sm fs--1 mb-0">
                        <thead>
                            <tr style="background-color:#82E0AA;">
                                <th style="width:2%"><b>#</b></th>
                                <th style="width:4%"><b>Compte</b></th>
                                <th style="width:25%"><b>Postes Budgétaire</b></th>
                                <th><center><b>Prévisions</b></center></th>';

                for ($i = 1; $i <= $periode; $i++) {
                    $output .= '<th><center><b>T' . $i . '</b></center></th>';
                }

                $output .= '<th><center><b>Dépenses</b></center></th>
                                <th><b><center>Relicat</center></b></th>
                                <th><b><center>T.E</center></b></th>
                            </tr>
                        </thead>
                        <tbody>';

                // Initialisation des totaux
                $totalBudget = 0;
                $totalDepense = 0;
                $totalT = array_fill(1, $periode, 0);

                foreach ($data as $datas) {
                    $somme_budget_ligne = DB::table('rallongebudgets')
                        ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
                        ->where('rallongebudgets.projetid', $IDP)
                        ->where('rallongebudgets.compteid', $datas->id)
                        ->where('comptes.cle_type_projet', $cle_id_type_projet)
                        ->sum('rallongebudgets.budgetactuel');

                    if ($somme_budget_ligne > 0) {
                        $output .= '
                            <tr style="background-color:#F5F5F5">
                                <td> </td>
                                <td><b>' . ucfirst($datas->numero) . '</b></td>
                                <td><b>' . ucfirst($datas->libelle) . '</b></td>
                                <td align="right"><b>' . number_format($somme_budget_ligne, 0, ',', ' ') . '</b></td>';

                        $totalBudget += $somme_budget_ligne;

                        for ($i = 1; $i <= $periode; $i++) {
                            $tglign = 'T' . $i;
                            $somme_TMOntant = DB::table('elementfebs')
                                ->where('tperiode', $tglign)
                                ->where('projetids', $IDP)
                                ->where('grandligne', $datas->id)
                                ->sum('montant');

                            $output .= '<td align="right"><b>' . number_format($somme_TMOntant, 0, ',', ' ') . '</b></td>';
                            $totalT[$i] += $somme_TMOntant;
                        }

                        $somme_montantligne = DB::table('elementfebs')
                            ->where('projetids', $IDP)
                            ->where('grandligne', $datas->id)
                            ->sum('montant');

                        $totalDepense += $somme_montantligne;

                        $reliquat = $somme_budget_ligne - $somme_montantligne;
                        $pourcentageparligne = $somme_budget_ligne
                            ? round(($somme_montantligne * 100) / $somme_budget_ligne, 2)
                            : 0;

                        $output .= '
                            <td align="right"><b>' . number_format($somme_montantligne, 0, ',', ' ') . '</b></td>
                            <td align="right"><b>' . number_format($reliquat, 0, ',', ' ') . '</b></td>
                            <td align="right"><b>' . $pourcentageparligne . '%</b></td>
                        </tr>';

                        // Récupération des sous-comptes
                        $sous_compte = DB::table('rallongebudgets')
                            ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
                            ->select('rallongebudgets.*', 'comptes.libelle', 'comptes.cle_type_projet', 'comptes.numero', 'rallongebudgets.id as idr')
                            ->where('rallongebudgets.projetid', $IDP)
                            ->where('rallongebudgets.compteid', $datas->id)
                            ->where('comptes.cle_type_projet', $cle_id_type_projet)
                            ->get();

                        foreach ($sous_compte as $sc) {
                            $ids = Crypt::encrypt($sc->id);
                            $showme = '';
                            if (!$isForPrinting) {
                                $showme = $showData->autorisation == 1
                                    ? '<div class="btn-group me-2 mb-2 mb-sm-0">
                                        <a data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical ms-2"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item mx-1 showrevision" id="' . $sc->idr . '" data-bs-toggle="modal" data-bs-target="#revisionModal" title="Revision budgétaire"><i class="far fa-edit"></i> Execute la revision budgétaire </a>
                                        </div>
                                    </div>'
                                    : '';
                            }

                            $difference = $sc->retruction == 1 ? "difference" : '';
                            $url = $sc->retruction == 1 ? '<a href="' . $sc->urldoc . '" target="_blank" title="Voir les conditions"><i class="fas fa-external-link-alt text-success"></i></a>' : '';

                            $output .= '
                                <tr class="' . $difference . '">
                                    <td style="background-color:#F5F5F5">' . $showme . '</td>
                                    <td>' . ucfirst($sc->numero) . '</td>
                                    <td>' . ucfirst($sc->libelle) . ' ' . $url . '</td>
                                    <td align="right">' . number_format($sc->budgetactuel, 0, ',', ' ') . '</td>';

                            for ($i = 1; $i <= $periode; $i++) {
                                $RefT = 'T' . $i;
                                $TMOntant = DB::table('elementfebs')
                                    ->where('tperiode', $RefT)
                                    ->where('projetids', $IDP)
                                    ->where('grandligne', $sc->compteid)
                                    ->where('eligne', $sc->souscompte)
                                    ->sum('montant');

                                $output .= '<td align="right">' . number_format($TMOntant, 0, ',', ' ') . '</td>';
                            }

                            $montantGlobaledepense = DB::table('elementfebs')
                                ->where('projetids', $IDP)
                                ->where('grandligne', $sc->compteid)
                                ->where('eligne', $sc->souscompte)
                                ->sum('montant');
                            $POURCENTAGEPARLIGNE = $sc->budgetactuel ? round(($montantGlobaledepense * 100) / $sc->budgetactuel, 2) : 0;

                            $output .= '
                                <td align="right">' . number_format($montantGlobaledepense, 0, ',', ' ') . '</td>
                                <td align="right">' . number_format($sc->budgetactuel - $montantGlobaledepense, 0, ',', ' ') . '</td>
                                <td align="right">' . $POURCENTAGEPARLIGNE . '%</td>
                            </tr>';
                        }
                        $nombre++;
                    }
                }

                // Ajout des totaux pour chaque type de budget
                $output .= '
                    <tr style="background-color:#82E0AA;">
                        <td colspan="3"><b>Total ' . htmlspecialchars($typeBudgets->titre) . '</b></td>
                        <td align="right"><b>' . number_format($totalBudget, 0, ',', ' ') . '</b></td>';

                for ($i = 1; $i <= $periode; $i++) {
                    $output .= '<td align="right"><b>' . number_format($totalT[$i], 0, ',', ' ') . '</b></td>';
                }

                $output .= '<td align="right"><b>' . number_format($totalDepense, 0, ',', ' ') . '</b></td>
                            
                              <td align="right">'. number_format($totalBudget-$totalDepense, 0, ',', ' ') . ' </td>
                            <td align="right">' . ($totalDepense > 0 ? round(($totalDepense * 100) / $sommerepartie, 2) : 0) . '%</td>
                        </tr>';

                $output .= '</tbody></table>';
            }
        }
    }

    return $output;
}

  

  // insert a new rallongement request
  public function store(Request $request)
  {
    try {
      // Récupération des valeurs de la session
      $IDP = session()->get('id');
      $budget = session()->get('budget');

      // Récupération des données de la requête
      $compte = $request->input('compteid');
      $scompte = $request->input('scomptef');

      // Vérification de l'existence d'un budget pour le même projet, compte et sous-compte
      $check = Rallongebudget::where('compteid', $compte)
        ->where('souscompte', $scompte)
        ->where('projetid', $IDP)
        ->first();

      if ($check) {
        return response()->json(['status' => 203]);
      }

      // Calcul du budget total actuel
      $somme_budget = DB::table('rallongebudgets')
        ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
        ->where('rallongebudgets.projetid', $IDP)
        ->sum('budgetactuel');

      // Détermination du statut de rétruction
      $retruction = $request->has('customSwitch1') ? 1 : 0;

      // Récupération de l'URL du document si elle est fournie
      $urldocValue = $request->filled('urldoc') ? $request->input('urldoc') : "";

      // Calcul du budget global après ajout du nouveau budget
      $globale = $request->input('budgetactuel') + $somme_budget;

      // Vérification si le budget global reste dans les limites du budget projet
      if ($budget >= $globale) {
        // Création et sauvegarde de la nouvelle rallonge budgétaire
        $rallonge = new Rallongebudget();
        $rallonge->projetid = $IDP;
        $rallonge->compteid = $compte;
        $rallonge->souscompte = $scompte;
        $rallonge->budgetactuel = $request->input('budgetactuel');
        $rallonge->retruction = $retruction;
        $rallonge->urldoc = $urldocValue;
        $rallonge->userid = auth()->user()->id;
        $rallonge->save();

        return response()->json(['status' => 200]);
      } else {
        return response()->json(['status' => 201]);
      }
    } catch (Exception $e) {
      // Log the exception for debugging purposes

      return response()->json(['status' => 202], ['error' => $e->getMessage()]);
    }
  }

  public function storesc(Rallongebudget $gl, Request $request)
  {
    $gl->projetid = $request->cid;
    $gl->compteid = $request->code;
    $gl->depensecumule = $request->libelle;
    $gl->budgetactuel = $request->libelle;
    $gl->userid = Auth()->user()->id;
    $gl->save();
    return response()->json([
      'status' => 200,
    ]);
  }


  public function updatlignebudget(Request $request)
  {

    $IDP = session()->get('id');
    $budget = session()->get('budget');

    // Calcul du budget total
    $somme_budget = DB::table('rallongebudgets')
      ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
      ->where('rallongebudgets.projetid', $IDP)
      ->sum('budgetactuel');

    $globale = $somme_budget - $request->ancienmontantligne;
    $globale += $request->r_budgetactuel;

    if ($budget >= $globale) {
      $MisesA =  Rallongebudget::find($request->r_idr);
      $MisesA->budgetactuel = $request->r_budgetactuel;
      $MisesA->update();

      if ($MisesA) {
        $updateligne = Compte::find($request->r_souscompte);
        $updateligne->numero = $request->r_code;
        $updateligne->libelle = $request->r_libelle;
        $updateligne->update();

        return response()->json(['status' => 200, 'message' => 'Très bien! Le budget a été bien modifié.']);
      } else {
        return response()->json(['status' => 202, 'message' => 'Échec ! Le budget n\'a pas été modifié.']);
      }
    } else {
      return response()->json(['status' => 205, 'message' => 'Attention ! Vous ne devez pas dépasser le montant du budget global.']);
    }
  }


  // SHOW ELEMENT
  public function showrallonge(Request $request)
  {
    // Valider la requête pour s'assurer que 'id' est présent
    $validated = $request->validate([
      'id' => 'required|integer' // Supposons que l'ID est un entier
    ]);

    try {
      $key = $validated['id'];

      // Récupérer les données
      $dataJon = DB::table('rallongebudgets')
        ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
        ->select('rallongebudgets.*', 'comptes.libelle', 'comptes.numero', 'rallongebudgets.id as idr')
        ->where('rallongebudgets.id', $key)
        ->get();

      // Vérifier si des données ont été trouvées
      if ($dataJon->isEmpty()) {
        return response()->json([
          'status' => 404,
          'message' => 'Aucune rallonge budgétaire trouvée pour cet ID.'
        ], 404);
      }

      // Retourner les données en format JSON
      return response()->json($dataJon, 200);
    } catch (Exception $e) {
      // Gérer les exceptions
      return response()->json([
        'status' => 500,
        'message' => 'Erreur lors de la récupération des données : ' . $e->getMessage()
      ], 500);
    }
  }

  // edit an service ajax request
  public function addsc(Request $request)
  {
    $id = $request->id;
    $fon = Rallongebudget::find($id);
    return response()->json($fon);
  }

  // update an service ajax request
  public function update(Request $request)
  {
    $emp = Rallongebudget::find($request->gc_id);
    $emp->gc_title = $request->gc_title;
    $emp->update();

    return response()->json([
      'status' => 200,
    ]);
  }

  public function findSousCompte(Request $request)
  {
    try {
      $ID = session()->get('id');
      $data = Compte::where('compteid', $request->id)
        ->where('souscompteid', '=', 0)
        ->where('projetid', $ID)
        ->get();

      return response()->json($data);
    } catch (Exception $e) {
      return response()->json([
        'status' => 202,
      ]);
    }
  }

  public function condictionsearch(Request $request)
  {
    try {
      $ID = session()->get('id');
      $comp = $request->id;
      $compp = explode("-", $comp);

      $grandcompte = $compp[0];
      $souscompte  = $compp[1];

      $data = DB::table('rallongebudgets')
        ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
        ->select('rallongebudgets.*', 'comptes.libelle', 'comptes.numero')
        ->Where('rallongebudgets.projetid', $ID)
        ->where('rallongebudgets.souscompte', $souscompte)
        ->get();


      $output = '';
      if ($data->count() > 0) {
        foreach ($data as $key => $datas) {
          if ($datas->retruction == 1) {

            $output .= '
            <br>
           <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="mdi mdi-block-helper me-2"></i>
            Attention! Cette ligne est soumise aux conditions d\'utilisation , <a href="' . $datas->urldoc . '" target="_blank"><i class="fas fa-external-link-alt text-success"></i></a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>

          ';
          } else {
            $output .= '<i class="fa fa-info-circle" ></i>  Il n\'y a pas des condictions d\'utilisation';
          }
        }
        echo $output;
      } else {
        echo ' <tr>
          <td colspan="3">
          <center>
            <h6 style="margin-top:1% ;color:#c0c0c0"> 
            <center><font size="50px"><i class="fa fa-info-circle"  ></i> </font><br><br>
           Ceci est vide  !</center> </h6>
          </center>
          </td>
          </tr>';
      }
    } catch (Exception $e) {
      return response()->json([
        'status' => 202,
      ]);
    }
  }

  public function deleteall(Request $request)
  {
    try {

      $emp = Rallongebudget::find($request->id);

      if ($emp->userid == Auth::id()) {

        $id = $request->id;
        Rallongebudget::where('id', $id)->delete();
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



  public function personnaliserContenuHtml($html)
    {
        // Ajouter l'en-tête au début du HTML généré
        $enteteHtml = '<h2><center>COMMUNAUTE DES EGLISES DE PENTECOTE AU BURUNDI "CEPBU"</center></h2>';
        
        $pied = "<p><center><small>Adresse: Boulevard de l'UPRONA No 38 ; BP. 2915 Bujumbura-Burundi ; Tél. (+257) 22 223466 ; (+257) 22 214889 ; Email : info@cepbu.bi</small></center></p>";
        
        // Insérer l'en-tête et la devise au début du HTML
        $html = $enteteHtml . $html;
        
        // Insérer le pied de page à la fin du HTML
        $html .= $pied;
        
        // Réduire la taille du texte dans le tableau et enlever le gras
        $html = preg_replace('/<table/', '<table style="width: 100%; font-size: 12px; margin: 0; padding: 0;"', $html); // Taille de police réduite à 12px et marges/paddings à 0
        
        $html = preg_replace('/<tr/', '<tr style="margin: 0; padding: 0;"', $html); // Marges/paddings des lignes à 0
        $html = preg_replace('/<td/', '<td style="margin: 0; padding: 0;"', $html); // Marges/paddings des cellules à 0
        
        $html = preg_replace('/<b>/', '', $html); // Suppression de toutes les balises <b>
        $html = preg_replace('/<\/b>/', '', $html); // Suppression de toutes les balises </b>
        
        return $html;
    }
    
    public function telecharger_rapport_budget()
    {
        // Génération du contenu HTML à convertir en PDF
        $html = $this->fetchAll(true); // true indique que c'est pour l'impression
        
        // Extraire le titre du projet à partir du contenu HTML
        preg_match('/<td style="padding:5px; width:50%">(.*?)<\/td>/', $html, $matches);
        $titre_projet = isset($matches[1]) ? $matches[1] : 'Projet'; // Utilisation du titre par défaut 'Projet' si non trouvé
        
        // Personnaliser le contenu HTML
        $html = $this->personnaliserContenuHtml($html);
        
        // Configuration de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('defaultFont', 'Arial');
        
        // Initialisation de Dompdf avec les options
        $dompdf = new Dompdf($options);
        
        // Chargement du HTML dans Dompdf
        $dompdf->loadHtml($html);
        
        // Définition du format du papier et de l'orientation (A4 paysage)
        $dompdf->setPaper('A4', 'landscape');
        
        // Rendu du PDF
        $dompdf->render();
        
        // Nom du fichier PDF à télécharger avec le titre du projet
        $fileName = 'rapport_' . Str::slug($titre_projet) . '.pdf'; // Utilisation de Str::slug pour formater le titre
        
        // Téléchargement du PDF
        return $dompdf->stream($fileName);
    }
  

  
}
