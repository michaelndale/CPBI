<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use App\Models\Comptepetitecaisse;
use App\Models\rappotage;
use App\Models\Rappotagecaisse;
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
            $cloture->numero_groupe = $numero . '/' . date('d-m-Y');
            $cloture->le = date('Y-m-d');
            $cloture->userid = Auth::id();
            $cloture->projetid = $IDP;
            $cloture->compteid = $request->compteId;
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
                $emp->fait_a = $request->lieu;
                $emp->le = $request->le;
                $emp->cloture = 1;
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
                    return redirect()->route('Rapport.caisse')->with('success', 'Très bien! La signature a bien été enregistrée avec une clotube de la caisse');
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
    
}
