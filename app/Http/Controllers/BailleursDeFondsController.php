<?php

namespace App\Http\Controllers;

use App\Models\BailleursDeFonds;
use App\Models\BailleursDeFondsController as ModelsBailleursDeFondsController;
use App\Models\PaysModel;
use App\Models\ProjetAccesBailleur;
use BaconQrCode\Encoder\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BailleursDeFondsController extends Controller
{
    public function index()
  {
    $title = 'Bailleurs de Fonds';
    $active = 'Project';

    

    $idp = session()->get('id');
    $member = DB::table('personnels')
      ->join('users', 'personnels.id', '=', 'users.personnelid')
      ->select('personnels.nom', 'personnels.prenom','users.id as user_id')
      ->get();

    $pays = PaysModel::all();
    return view(
      'Bailleurs.index',
      [
        'title'  => $title,
        'active' => $active,
        'member' => $member,
        'pays'   => $pays
      ]
    );
  }

  public function liste()
  {
      // Récupérer l'ID du projet en cours depuis la session
      $idp = session()->get('id');
  
      // Récupérer les bailleurs avec les informations de projets et de comptes d'accès
      $bailleurs = BailleursDeFonds::select(
          'bailleurs_de_fonds.id',
          'bailleurs_de_fonds.nom',
          'bailleurs_de_fonds.pays_origine',
          'bailleurs_de_fonds.contact_nom',
          'bailleurs_de_fonds.contact_email',
          'bailleurs_de_fonds.contact_telephone',
          'bailleurs_de_fonds.site_web',
          'bailleurs_de_fonds.created_at',
          'projet_acces_bailleurs.verification_code',
          'projet_acces_bailleurs.is_verified',
          'projet_acces_bailleurs.projet_id'
      )
      ->leftJoin('projet_acces_bailleurs', function ($join) use ($idp) {
          $join->on('bailleurs_de_fonds.id', '=', 'projet_acces_bailleurs.bailleurs_id')
               ->where('projet_acces_bailleurs.projet_id', $idp);
      })
      ->get();
  
      // Retourner la réponse JSON
      return response()->json(['bailleurs' => $bailleurs]);
  }
  

  public function store(Request $request)
  {
      try {

          $bailleur = BailleursDeFonds::where('nom', $request->nom)->first();
          if ($bailleur) {
              return response()->json(['status' => 201, 'message' => 'Le Bailleur existe déjà!']);
          }
  
          // Création du bailleur
          $bailleur = new BailleursDeFonds();

          $bailleur->nom =          $request->nom;
          $bailleur->pays_origine =  $request->pays_origine;
          $bailleur->contact_nom =   $request->contact_nom;
          $bailleur->contact_email = $request->contact_email;
          $bailleur->contact_telephone = $request->contact_telephone;
          $bailleur->site_web =          $request->site_web;
          $bailleur->user_id =          Auth::id();

          $bailleur->save();
  
          // Retourner une réponse JSON
          return response()->json([
            'message' => 'Bailleur ajouté avec succès',
            'status' => 200,
            ]);
      } catch (\Exception $e) {
          // En cas d'erreur, retourner un message d'erreur
          return response()->json(['message' => 'Une erreur est survenue. Veuillez réessayer.'], 500);
      }
  }

  public function storeAcces(Request $request)
{
    try {
      

        // Vérifier si un compte vérifié existe déjà pour ce bailleur
        $existingAccount = ProjetAccesBailleur::where('bailleurs_id', $request->bailleur_id)
            ->where('is_verified', 1)
            ->first();

        if ($existingAccount) {
            // Compte déjà vérifié trouvé (200 : OK)
            return response()->json([
                'status' => 201,
                'message' => 'Ce bailleur possède déjà un compte vérifié.',
                'data' => $existingAccount
            ], 200);
        }

        // Création du compte d'accès
        $compteAcces = new ProjetAccesBailleur();
        $compteAcces->verification_code = $request->verification_code;
        $compteAcces->is_verified = 1; // Marquez comme vérifié
        $compteAcces->bailleurs_id = $request->bailleur_id;
        $compteAcces->projet_id = $request->projet_id;

        // Génération du QR code (commenté pour usage futur)
        // $qrCode = QrCode::size(250)->generate($request->verification_code);
        // $compteAcces->qr_code = $qrCode; // Sauvegarde le QR code généré

        if ($compteAcces->save()) {
            // Enregistrement réussi (201 : Ressource créée)
            return response()->json([
                'status' => 200,
                'message' => 'Compte d\'accès créé avec succès!',
                'data' => $compteAcces
            ], 200);
        } else {
            // Problème lors de l'enregistrement (202 : Accepté mais incomplet)
            return response()->json([
                'status' => 202,
                'message' => 'Le compte d\'accès n\'a pas pu être sauvegardé. Veuillez réessayer.'
            ], 202);
        }
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Erreurs de validation (400 : Mauvaise requête)
        return response()->json([
            'status' => 400,
            'message' => 'Validation échouée.',
            'errors' => $e->errors()
        ], 400);
    } catch (\Exception $e) {
        // Autres erreurs (500 : Erreur interne du serveur)
        return response()->json([
            'status' => 500,
            'message' => 'Une erreur est survenue lors de la création du compte d\'accès.',
            'error' => $e->getMessage()
        ], 500);
    }
}

  
  
}
