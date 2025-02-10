<?php

namespace App\Http\Controllers;

use App\Models\casutilisation;
use App\Models\casutilisation_details;
use App\Models\Dja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CasutilisationController extends Controller
{
  public function store(Request $request)
  {
      $IDP = session()->get('id');
      $exerciceId = session()->get('exercice_id');

      DB::beginTransaction();
      try {
          $febid = $request->febid;
          $djaid = $request->djaid;
          $totalMontant = $request->GrandTotal;

          // Vérifier si un enregistrement existe déjà
          $check = casutilisation::where('febid', $febid)
              ->where('projetid', $IDP)
              ->where('exerciceid', $exerciceId)
              ->first();

          if ($check) {
              // Si l'enregistrement existe déjà, on met à jour
              $cas = $check;

              // Nettoyer les données avant mise à jour
              $beneficiaire = $request->beneficiaire;
              if ($beneficiaire === 'Sélectionner un bénéficiaire' || empty($beneficiaire)) {
                  $beneficiaire = null; // Assigner NULL si la valeur est invalide
              }

              $autreBeneficiaire = $request->autrebenefiaire;
              if ($autreBeneficiaire === 'Sélectionner un bénéficiaire' || empty($autreBeneficiaire)) {
                  $autreBeneficiaire = null; // Assigner NULL si la valeur est invalide
              }

              // Mettre à jour les champs de l'enregistrement existant
              $cas->ligne_bugdet = $request->ligne_budgetaire;
              $cas->sous_ligne_bugdet = $request->sous_ligne_budgetaire;
              $cas->periode = $request->periode;
              $cas->description = $request->description;
              $cas->datefeb = $request->datefeb;
              $cas->beneficiaire = $beneficiaire; // Utiliser la valeur nettoyée
              $cas->autrebeneficiare = $autreBeneficiaire; // Utiliser la valeur nettoyée
              $cas->userid = Auth::id();

              $cas->save();

              // Récupérer l'ID de l'enregistrement existant
              $IDf = $cas->id;

              // Supprimer les détails existants pour les remplacer par les nouveaux
              casutilisation_details::where('casid', $IDf)->delete();

              // Enregistrer ou mettre à jour les nouveaux détails
              foreach ($request->numerodetail as $key => $items) {
                  $elementCas = new casutilisation_details();
                  $elementCas->casid = $IDf;
                  $elementCas->projetid = $IDP;
                  $elementCas->exerciceid = $exerciceId;
                  $elementCas->febid = $request->febid;
                  $elementCas->activiteid = $request->activiteid[$key];
                  $elementCas->libelle = $request->libelle[$key];
                  $elementCas->unite = $request->unite[$key];
                  $elementCas->quantity = $request->quantity[$key];
                  $elementCas->frequency = $request->frequency[$key];
                  $elementCas->unitprice = $request->unitprice[$key];
                  $elementCas->userid = Auth::id();

                  $elementCas->save();
              }

               // Mettre à jour le montant utilisé dans la table djas
            if ($djaid && is_numeric($totalMontant)) {
              $dja = Dja::find($djaid);

              if ($dja) {
                  $currentUtilise = $dja->montant_utiliser ?? 0;
                  $dja->montant_utiliser = $currentUtilise + $totalMontant;
                  $dja->save();
              } 
          }

              DB::commit();
              return response()->json([
                  'status' => 200,
                  'message' => 'Enregistrement mis à jour avec succès.'
              ]);
          } else {
              // Si l'enregistrement n'existe pas, on crée un nouvel enregistrement
              $cas = new casutilisation();

              // Nettoyer les données avant insertion
              $beneficiaire = $request->beneficiaire;
              if ($beneficiaire === 'Sélectionner un bénéficiaire' || empty($beneficiaire)) {
                  $beneficiaire = null; // Assigner NULL si la valeur est invalide
              }

              $autreBeneficiaire = $request->autrebenefiaire;
              if ($autreBeneficiaire === 'Sélectionner un bénéficiaire' || empty($autreBeneficiaire)) {
                  $autreBeneficiaire = null; // Assigner NULL si la valeur est invalide
              }

              $cas->djaid = $djaid;
              $cas->febid = $request->febid;
              $cas->projetid = $IDP;
              $cas->exerciceid = $exerciceId;
              $cas->ligne_bugdet = $request->ligne_budgetaire;
              $cas->sous_ligne_bugdet = $request->sous_ligne_budgetaire;
              $cas->periode = $request->periode;
              $cas->description = $request->description;
              $cas->datefeb = $request->datefeb;
              $cas->beneficiaire = $beneficiaire; // Utiliser la valeur nettoyée
              $cas->autrebeneficiare = $autreBeneficiaire; // Utiliser la valeur nettoyée
              $cas->userid = Auth::id();

              $cas->save();

              // Récupérer l'ID du nouvel enregistrement
              $IDf = $cas->id;

              // Enregistrer les détails associés
              foreach ($request->numerodetail as $key => $items) {
                  $elementCas = new casutilisation_details();
                  $elementCas->casid = $IDf;
                  $elementCas->projetid = $IDP;
                  $elementCas->exerciceid = $exerciceId;
                
                  $elementCas->febid = $request->febid;
                  $elementCas->activiteid = $request->activiteid[$key];
                  $elementCas->libelle = $request->libelle[$key];
                  $elementCas->unite = $request->unite[$key];
                  $elementCas->quantity = $request->quantity[$key];
                  $elementCas->frequency = $request->frequency[$key];
                  $elementCas->unitprice = $request->unitprice[$key];
                  $elementCas->userid = Auth::id();

                  $elementCas->save();
              }

              // Mettre à jour les colonnes montant_avance_un et montant_avance dans la table djas
              if ($djaid && is_numeric($totalMontant)) {
                $dja = Dja::find($djaid);
  
                if ($dja) {
                    $currentUtilise = $dja->montant_utiliser ?? 0;
                    $dja->montant_utiliser = $currentUtilise + $totalMontant;
                    $dja->save();
                } 
            }
  

              DB::commit();
              return response()->json([
                  'status' => 200,
                  'message' => 'Nouvel enregistrement créé avec succès.'
              ]);
          }
      } catch (\Exception $e) {
          DB::rollBack();
          return response()->json([
              'status' => 202,
              'error' => $e->getMessage()
          ]);
      }
  }
}
