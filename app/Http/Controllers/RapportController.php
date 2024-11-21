<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use App\Models\Comptepetitecaisse;
use App\Models\Identification;
use App\Models\rappotage;
use App\Models\Rappotagecaisse;
use App\Models\Rapprochement;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class RapportController extends Controller
{
    public function caisse()
    {
        $title = 'Rapport de caisse';
        $ID = session()->get('id');
        // Vérifier si l'ID de la session n'est pas défini
        if (!$ID) {
            // Rediriger vers la route nommée 'dashboard'
            return redirect()->route('dashboard');
        }

        $personnel = DB::table('users')
            ->join('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
            ->orderBy('nom', 'ASC')
            ->get();

        $compte_bpc =  Comptepetitecaisse::where('projetid', $ID)
            ->join('users', 'comptepetitecaisses.userid', '=', 'users.id')
            ->join('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('comptepetitecaisses.*', 'personnels.prenom as personnel_prenom')
            ->get();

        return view(
            'bonpetitecaisse.rapport.index',
            [
                'title'     => $title,
                'personnel' => $personnel,
                'compte_bpc' => $compte_bpc

            ]
        );
    }
    
    public function cloturecaisse()
    {
        $title = 'Rapport de caisse';
        $ID = session()->get('id');
        // Vérifier si l'ID de la session n'est pas défini
        if (!$ID) {
            // Rediriger vers la route nommée 'dashboard'
            return redirect()->route('dashboard');
        }


        $historiqueCompte = Rappotagecaisse::orderBy('caisse_id', 'ASC')
            ->where('rappotages.cloture', 0)
            ->join('caisses', 'rappotagecaisses.caisse_id', 'caisses.id')
            ->join('rappotages', 'rappotagecaisses.rapportage_id', 'rappotages.id')
            ->select(
                'caisses.description as descriptions',
                'caisses.input as inputs',
                'caisses.debit as debits',
                'caisses.credit as credits',
                'caisses.solde as soldes',
                'rappotages.id as ids',
                'rappotages.*',
                'caisses.date as dates',
                'caisses.numerobon as numerobons'
            )
            ->get();

        $classement = Rappotage::where('cloture', 0)
            ->where('projetid', $ID)
            ->first();

        $verifie_par = DB::table('users')
            ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
            ->where('users.id', $classement->verifier_par)
            ->first();

        $approuver_par = DB::table('users')
            ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
            ->where('users.id',  $classement->approver_par)
            ->first();

        return view(
            'bonpetitecaisse.rapport.cloture',
            [
                'title'     => $title,
                'historiqueCompte' => $historiqueCompte,
                'classement' =>  $classement,
                'verifie_par' => $verifie_par,
                'approuver_par' => $approuver_par
            ]
        );
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $IDP = session()->get('id');

            $numero = rappotage::where('projetid',  $IDP)->count();
            $numero = $numero + 1;

            $cloture = new rappotage();
            $cloture->dernier_solde = $request->soldeCaisse;
            $cloture->verifier_par = $request->verifie_par;
            $cloture->approver_par = $request->approuver_par;
            $cloture->numero_groupe = $numero . '/' . date('Y');
           
            $cloture->userid = Auth::id();
            $cloture->projetid = $IDP;
            $cloture->compteid = $request->compteId;
            $cloture->moianne = $request->moiAnne;
            $cloture->save();
            $idRapportage = $cloture->id;

            // Insertion des éléments de bon de caisse
            foreach ($request->caisseId as $key => $items) {
                $exec = new Rappotagecaisse();
                $exec->rapportage_id    =   $idRapportage;
                $exec->caisse_id = $request->caisseId[$key];
                $exec->save();

                $caisseUpdate = Caisse::find($request->caisseId[$key]);
                $caisseUpdate->statut = 1;
                $caisseUpdate->update();
            }

            DB::commit();

            return response()->json(['status' => 200]);
        } catch (\Exception $e) {
            DB::rollBack();

            // Retourner une réponse avec l'erreur
            return response()->json(['status' => 202, 'error' => $e->getMessage()]);
        }
    }

    public function updateSignatureCloture(Request $request)
    {
        try {
            if (!empty($request->verifier) ||  !empty($request->approver)) {

                $verifierPar = !empty($request->verifier) ? 1 : $request->clone_verifier;
                $approver = !empty($request->approver) ? 1 : $request->clone_approver;

                $emp = rappotage::find($request->rapportid);

                $emp->verifier_signature  = $verifierPar;
                $emp->approver_signature = $approver;
               
                if($verifierPar==1){
                    $emp->le_etablie = $request->le_etablie;
                }

                if($approver==1){
                    $emp->le_verifier = $request->le_verifier;
                }

                if($verifierPar==1 && $approver==1){
                    $emp->cloture = 1;
                 }
              
                $do = $emp->update();

                if ($do) {

                    if ($emp->verifier_signature == 1 && $emp->approver_signature     == 1) {

                        $caisse              = new Caisse();
                        $caisse->date        = date('j-m-Y');
                        $caisse->compteid    = $request->compteId;
                        $caisse->projetid    = $request->ProjetId;
                        $caisse->numerobon   = "";
                        $caisse->description = "Approvisionnement caisse";
                        $caisse->input       = "";
                        $caisse->debit       = $request->soldeCaisse;
                        $caisse->credit      = "0";
                        $caisse->solde       = $request->soldeCaisse;;
                        $caisse->dapid       = "0";
                        $caisse->userid      = Auth::id();
                        $caisse->bonid       = 0;
                        $caisse->save();

                        $CompteUpdate = Comptepetitecaisse::find($request->compteId);
                        $CompteUpdate->cloture = 1;
                        $CompteUpdate->update();
                    }
                    if($verifierPar==1 && $approver==1){
                    return redirect()->route('Rapport.caisse')->with('success', 'Très bien! La signature a bien été enregistrée avec une clotube de la caisse');
                    }else{
                        return redirect()->back()->with('success', 'Très bien! La signature a bien été enregistrée avec une clotube de la caisse'); 
                    }
                } else {
                }
            } else {
                return back()->with('failed', 'Vous devez cocher au moins une case pour enregistrer la signature.');
            }
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            return back()->with('failed', 'Échec ! La signature n\'a pas été créée' . $errorMessage);
        }
    }

    public function getNumeros($compteId)
    {
        try {
            // Récupérer les données correspondant au compte sélectionné
            $numeros = rappotage::where('compteid', $compteId)->pluck('numero_groupe', 'id');

            // Vérifier si des données existent
            if ($numeros->isEmpty()) {
                return response()->json(['message' => 'Aucun numéro trouvé pour ce compte.'], 404);
            }

            // Retourner les données sous forme JSON
            return response()->json($numeros);
        } catch (\Exception $e) {
            // Enregistrer l'erreur dans les logs et retourner une réponse d'erreur
            Log::error('Erreur dans getNumeros : ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la récupération des numéros.'], 500);
        }
    }

    public function filterData(Request $request)
    {
        $compteId = $request->input('compte_bpc');
        $numeroId = $request->input('numeroCompte');

        // Vérifiez que les deux sélections sont présentes
        if (!$compteId || !$numeroId) {
            return response('<p>Les deux sélections sont obligatoires.</p>', 400);
        }

        try {
            // Requête avec jointures pour filtrer les données
            $data = Rappotage::select('rappotages.*', 'caisses.*')
                ->join('rappotagecaisses', 'rappotages.id', '=', 'rappotagecaisses.rapportage_id')
                ->join('caisses', 'rappotagecaisses.caisse_id', '=', 'caisses.id')
                ->where('rappotages.compteid', $compteId)
                ->where('rappotages.numero_groupe', $numeroId)
                ->get();

            $classement = Rappotage::select('rappotages.*', 'comptepetitecaisses.libelle as libelles', 'comptepetitecaisses.code as codes')
                ->join('comptepetitecaisses', 'rappotages.compteid', 'comptepetitecaisses.id')
                ->where('compteid', $compteId)
                ->where('numero_groupe', $numeroId)
                ->first();

            if (!$classement) {
                return response('<p>Aucun classement trouvé pour les critères spécifiés.</p>', 404);
            }

            $verifie_par = DB::table('users')
                ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
                ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
                ->where('users.id', $classement->verifier_par)
                ->first();

            $approuver_par = DB::table('users')
                ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
                ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
                ->where('users.id', $classement->approver_par)
                ->first();

            // Vérifiez si des données ont été trouvées
            if ($data->isEmpty()) {
                return response('<p>Aucune donnée trouvée pour les critères spécifiés.</p>', 404);
            }

            // Retourner une vue partielle avec les résultats filtrés
            return view('bonpetitecaisse.rapport.rapport', [
                'data' => $data,
                'classement' => $classement,
                'verifie_par' => $verifie_par,
                'approuver_par' => $approuver_par
            ]);
        } catch (\Exception $e) {
            // Capture des exceptions et retour d'un message d'erreur
            return response('<p>Une erreur est survenue : ' . $e->getMessage() . '</p>', 500);
        }
    }


   /* public function generatePrintableFile(Request $request)
    {
        $compteId = $request->compte_bpc;
        $numeroId = $request->numeroCompte;

        // Vérifiez que les deux sélections sont présentes
        if (!$compteId || !$numeroId) {
            return response('<p>Les deux sélections sont obligatoires.</p>', 400);
        }

        try {
            // Requête avec jointures pour filtrer les données
            $data = Rappotage::select('rappotages.*', 'caisses.*')
                ->join('rappotagecaisses', 'rappotages.id', '=', 'rappotagecaisses.rapportage_id')
                ->join('caisses', 'rappotagecaisses.caisse_id', '=', 'caisses.id')
                ->where('rappotages.compteid', $compteId)
                ->where('rappotages.numero_groupe', $numeroId)
                ->get();

            $classement = Rappotage::select('rappotages.*', 'comptepetitecaisses.libelle as libelles', 'comptepetitecaisses.code as codes')
                ->join('comptepetitecaisses', 'rappotages.compteid', '=', 'comptepetitecaisses.id')
                ->where('rappotages.compteid', $compteId)
                ->where('rappotages.numero_groupe', $numeroId)
                ->first();

            if (!$classement) {
                return response('<p>Aucun classement trouvé pour les critères spécifiés.</p>', 404);
            }

            $verifie_par = DB::table('users')
                ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
                ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
                ->where('users.id', $classement->verifie_par)
                ->first();

            $approuver_par = DB::table('users')
                ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
                ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
                ->where('users.id', $classement->approver_par)
                ->first();

            // Vérifiez si des données ont été trouvées
            if ($data->isEmpty()) {
                return response('<p>Aucune donnée trouvée pour les critères spécifiés.</p>', 404);
            }

            // Récupération des informations globales
            $infoglo = DB::table('identifications')->first();

            // Génération du PDF
            $pdf = PDF::loadView('bonpetitecaisse.rapport.print', compact('data', 'classement', 'verifie_par', 'approuver_par', 'infoglo'));

            $pdf->setPaper('A4', 'portrait'); // Format A4 en mode portrait

            // Nom du fichier PDF téléchargé avec numéro FEB et date actuelle
            $fileName = 'RAPPORT_CAISSE.pdf';

            // Télécharge le PDF
            return $pdf->download($fileName);
        } catch (\Exception $e) {
            // Capture des exceptions et retour d'un message d'erreur
            return response('<p>Une erreur est survenue : ' . $e->getMessage() . '</p>', 500);
        }
    }
  */

    public function generatePrintableFile(Request $request) {


        $compteId = $request->input('compte_bpc');
        $numeroId = $request->input('numeroCompte');

        // Vérifiez que les deux sélections sont présentes
        if (!$compteId || !$numeroId) {
            return response('<p>Les deux sélections sont obligatoires.</p>', 400);
        }

        try {
            // Requête avec jointures pour filtrer les données
            $data = Rappotage::select('rappotages.*', 'caisses.*')
                ->join('rappotagecaisses', 'rappotages.id', '=', 'rappotagecaisses.rapportage_id')
                ->join('caisses', 'rappotagecaisses.caisse_id', '=', 'caisses.id')
                ->where('rappotages.compteid', $compteId)
                ->where('rappotages.numero_groupe', $numeroId)
                ->get();

            $classement = Rappotage::select('rappotages.*', 'comptepetitecaisses.libelle as libelles', 'comptepetitecaisses.code as codes')
                ->join('comptepetitecaisses', 'rappotages.compteid', 'comptepetitecaisses.id')
                ->where('compteid', $compteId)
                ->where('numero_groupe', $numeroId)
                ->first();

            if (!$classement) {
                return response('<p>Aucun classement trouvé pour les critères spécifiés.</p>', 404);
            }

            $verifie_par = DB::table('users')
                ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
                ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
                ->where('users.id', $classement->verifier_par)
                ->first();

            $approuver_par = DB::table('users')
                ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
                ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
                ->where('users.id', $classement->approver_par)
                ->first();

            // Vérifiez si des données ont été trouvées
            if ($data->isEmpty()) {
                return response('<p>Aucune donnée trouvée pour les critères spécifiés.</p>', 404);
            }

            $infoglo = DB::table('identifications')->first();

            // Retourner une vue partielle avec les résultats filtrés
            return view('bonpetitecaisse.rapport.print', [
                'data' => $data,
                'classement' => $classement,
                'verifie_par' => $verifie_par,
                'approuver_par' => $approuver_par,
                'infoglo'  =>  $infoglo,
            ])->render();
        } catch (\Exception $e) {
            // Capture des exceptions et retour d'un message d'erreur
            return response('<p>Une erreur est survenue : ' . $e->getMessage() . '</p>', 500);
        }
       


    
    }

    public function rapprochement()
    {
        $title = 'Rapport de caisse';
        $ID = session()->get('id');
        // Vérifier si l'ID de la session n'est pas défini
        if (!$ID) {
            // Rediriger vers la route nommée 'dashboard'
            return redirect()->route('dashboard');
        }
        $data =  DB::table('djas')
                ->leftJoin('elementdjas', 'djas.id','elementdjas.iddjas')
                ->join('users', 'djas.userid', '=', 'users.id')
                ->join('personnels', 'users.personnelid', '=', 'personnels.id')
                ->select('djas.*', 'personnels.prenom as user_prenom','elementdjas.montant_avance as montantAvance','elementdjas.montant_utiliser as montantJustifie','elementdjas.montant_retourne as montantRetourne')
                ->where('djas.projetiddja', $ID)
                ->get();


        $service = Service::all();

        $personnel = DB::table('users')
        ->join('personnels', 'users.personnelid', '=', 'personnels.id')
        ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
        ->orderBy('nom', 'ASC')
        ->get();

        return view(
            'rapport.rapprochement.index',
            [
                'title'     => $title,
                'dataDjas'  => $data,
                'service'   => $service,
                'personnel' => $personnel
            ]
        );
    }

    public function rapartitiooncouts()
    {
        $title = 'Rapport de caisse';
        $ID = session()->get('id');
        // Vérifier si l'ID de la session n'est pas défini
        if (!$ID) {
            // Rediriger vers la route nommée 'dashboard'
            return redirect()->route('dashboard');
        }
        $dataDjas =  DB::table('djas')
        ->orderBy('daps.numerodp', 'asc')
        ->join('users', 'djas.userid', '=', 'users.id')
        ->join('personnels', 'users.personnelid', '=', 'personnels.id')
        ->join('daps','djas.numerodap' ,'daps.id')
        ->select('djas.*', 'personnels.prenom as user_prenom', 'daps.numerodp as nume_dap')
        ->where('djas.projetiddja', $ID)
        ->get();


        return view(
            'rapport.rapartitiooncouts.index',
            [
                'title'     => $title,
                'dataDjas'  => $dataDjas

            ]
        );
    }

    public function rapporRapprochement($id)
    {
        $title = 'Rapport de caisse';
        $IDp = session()->get('id');
        // Vérifier si l'ID de la session n'est pas défini
        if (!$IDp) {
            // Rediriger vers la route nommée 'dashboard'
            return redirect()->route('dashboard');
        }
        $rapport = Rapprochement::join('users as user_creator', 'rapprochements.userid', '=', 'user_creator.id')
            ->join('personnels as creator_personnel', 'user_creator.personnelid', '=', 'creator_personnel.id')
            ->join('users as user_established', 'rapprochements.etabliepar', '=', 'user_established.id')
            ->join('personnels as estab_personnel', 'user_established.personnelid', '=', 'estab_personnel.id')

            ->join('users as user_verifier', 'rapprochements.verifier', '=', 'user_verifier.id')
            ->join('personnels as verif_personnel', 'user_verifier.personnelid', '=', 'verif_personnel.id')
            
            ->join('services', 'rapprochements.serviceid','services.id')
            ->select(
                'rapprochements.*',
                'creator_personnel.prenom as creator_prenom', 
                'creator_personnel.nom as creator_nom', // Prénom et nom de l'utilisateur qui a créé
                'estab_personnel.prenom as estab_prenom', 
                'estab_personnel.nom as estab_nom',   // Prénom et nom de l'utilisateur qui a établi
                'verif_personnel.prenom as verifier_prenom',
                'verif_personnel.nom as verifier_nom',   // Prénom et nom de l'utilisateur qui a vérifié
                'services.title as title_service'
            )
            ->where('rapprochements.id', '=', $id)
            ->where('rapprochements.projetid', '=', $IDp)
            ->first();

            //dd($rapport);


            $datede = $rapport->datede; // Date de début (datetime)
            $dateau = $rapport->dateau; // Date de fin (datetime)

            
            
            $dataDjas = DB::table('djas')
            
            ->orderBy('djas.numerodjas', 'asc')
            ->leftjoin('daps', 'djas.dapid', '=', 'daps.id')
            ->join('users', 'djas.userid', '=', 'users.id')
            ->join('personnels', 'users.personnelid', '=', 'personnels.id')
            ->leftjoin('users as user_beneficier', 'daps.beneficiaire', '=', 'user_beneficier.id')
            ->leftJoin('personnels as benef_personnel', 'user_beneficier.personnelid', '=', 'benef_personnel.id')
            ->leftJoin('elementdjas', 'djas.id', '=', 'elementdjas.iddjas')
            ->select(
                'djas.*', 
                'personnels.prenom as user_prenom', 
                'elementdjas.montant_avance as montantAvance',
                'elementdjas.montant_utiliser as montantJustifie',
                'elementdjas.montant_retourne as montantRetourne', 
                'daps.comptabiliteb',
                'daps.id as refdapid',
                'daps.cho as cheque',
                'daps.justifier as dapjustifier',
                'daps.created_at as datecreation',
                'daps.dateautorisation as dateautorisations',
                'benef_personnel.id as idb',
                'benef_personnel.prenom as benef_prenom',
                'benef_personnel.nom as benef_nom'
            )
            ->where('djas.projetiddja', $IDp)
            ->where(function ($query) use ($datede, $dateau) {  
                $query->whereBetween('djas.created_at', [$datede, $dateau])
                    ->orWhere('djas.created_at', '=', $datede)
                    ->orWhere('djas.created_at', '=', $dateau);
            })
            ->get();

            $dateinfo = Identification::all()->first();

        return view(
            'rapport.rapprochement.rapport',
            [
                'title'         => $title,
                'rapport'       => $rapport,
                'datailrapport' =>$dataDjas,
                'dateinfo'      =>   $dateinfo 
               

            ]
        );
    }


    public function storeRecherche(Request $request)
    {
        $IDp = session()->get('id'); 
        $nombreEnregistrements = Rapprochement::where('projetid', $IDp)->count(); 
        $num = $nombreEnregistrements + 1;
        $rapprochement = new Rapprochement();

        $rapprochement->projetid = $request->projetid;
        $rapprochement->serviceid = $request->serviceid;
        $rapprochement->numero = $num;
        $rapprochement->datede = $request->datede;
        $rapprochement->dateau = $request->dateau;
        $rapprochement->etabliepar = $request->etabliepar;
        $rapprochement->verifier = $request->verifier;
        $rapprochement->userid = Auth::id();
        $rapprochement->save();

        return response()->json([
          'status' => 200,
        ]);


      
    }


    public function getRapprochement()
{
    $IDp = session()->get('id');
    // Vérifier si l'ID de la session n'est pas défini
    if (!$IDp) {
        // Rediriger vers la route nommée 'dashboard'
        return redirect()->route('dashboard');
    }

    $rapports = Rapprochement::join('users as user_creator', 'rapprochements.userid', '=', 'user_creator.id')
    ->join('personnels as creator_personnel', 'user_creator.personnelid', '=', 'creator_personnel.id')
    ->join('users as user_established', 'rapprochements.etabliepar', '=', 'user_established.id')
    ->join('personnels as estab_personnel', 'user_established.personnelid', '=', 'estab_personnel.id')
    ->join('users as user_verifier', 'rapprochements.verifier', '=', 'user_verifier.id')
    ->join('personnels as verif_personnel', 'user_verifier.personnelid', '=', 'verif_personnel.id')
    ->select(
        'rapprochements.*',
        'creator_personnel.prenom as creator_prenom', 'creator_personnel.nom as creator_nom', // Prénom de l'utilisateur qui a créé
        'estab_personnel.prenom as estab_prenom', 'estab_personnel.nom as estab_nom',   // Prénom de l'utilisateur qui a établi
        'verif_personnel.prenom as verifier_prenom','verif_personnel.nom as verifier_nom'   // Prénom de l'utilisateur qui a vérifié
    )
    ->where('rapprochements.projetid', $IDp)
    ->get();


    return view('rapport.rapprochement.liste', compact('rapports')); // Renvoyer la vue avec les rapports
}



  // supresseion
  public function destroy(Request $request)
  {
    try {

      $emp = Rapprochement::find($request->id);
      if ($emp->userid == Auth::id()) {
       
        $id = $request->id;
        Rapprochement::destroy($id);
        
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


    

    
}
