<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use App\Models\Comptepetitecaisse;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComptepetitecaisseController extends Controller
{
    public function index()
    {
        // Vérifie si l'ID de projet existe dans la session
        $projectId = session()->get('id');
        $exerciceId = session()->get('exercice_id');
        // Vérifie si l'ID de projet existe dans la session
        if (!$projectId && !$exerciceId) {
        // Gérer le cas où l'ID du projet et exercice est invalide
            return redirect()->back()->with('error', "La session du projet et de l'exercice est terminée. Vous allez être redirigé...");
        }

        $title = 'Compte ';
        
        $projet = Project::all();
        // Retourne la vue avec les données nécessaires
        return view('bonpetitecaisse.compte.compte', [
            'title' => $title,
            'projet' => $projet
        ]);
    }

    public function fetchAll()
    {
        $ID = session()->get('id');
        $exerciceId = session()->get('exercice_id');

        $services = Comptepetitecaisse::where('projetid', $ID)
            ->where('exercice_id', $exerciceId)
            ->join('users', 'comptepetitecaisses.userid', '=', 'users.id')
            ->join('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('comptepetitecaisses.*', 'personnels.prenom as personnel_prenom')
            ->get();

        $output = '';
        $nombre = 1;

        if ($services->count() > 0) {
            foreach ($services as $rs) {
                $output .= '<tr style="background-color:#F5F5F5">
                 <td align="center" style="width:13%">
                  <div class="btn-group me-2 mb-2 mb-sm-0">
                      <a  data-bs-toggle="dropdown" aria-expanded="false"> <i class="mdi mdi-dots-vertical ms-2"></i> Options</a>
                      <div class="dropdown-menu">
                         <a class="dropdown-item mx-1 voirHistorique" id="' . $rs->id . '" data-bs-toggle="modal" data-bs-target=".bs-historique-modal-xl" title="Voir Historique">
                            <i class="fa fa-list"></i> Mouvement encours
                        </a>
                        <a class="dropdown-item  mx-1 editCaisse" id="' . $rs->id . '"  data-bs-toggle="modal" data-bs-target="#modifierLigneModal" title="Modifier le compte"><i class="far fa-edit"></i> Modifier le compte</a>
                         <a class="dropdown-item text-danger mx-1 deleteIcon"  id="' . $rs->id . '"  href="#" title="Supprimer le compte"><i class="far fa-trash-alt"></i> Supprimer le compte</a>
                        </div>
                  </div>
                  </td>
               
                  <td> ' . ucfirst($rs->code) . '</td>
                  <td> ' . ucfirst($rs->libelle) . '</td>
                  <td align="right">  ' . number_format($rs->solde, 0, ',', ' ') . ' </td>
                  <td> ' . ucfirst($rs->personnel_prenom) . '</td>
                  <td> ' . date('d-m-Y, H:i', strtotime($rs->created_at)) . '</td>
                  <td> ' . date('d-m-Y, H:i ', strtotime($rs->updated_at)) . '</td>
                 
              </tr>';

                //    <a class="dropdown-item mx-1 PrintHistorique" data-id="'.$rs->id .'" title="Imprimer le rapport de caisse">
                //    <i class="fa fa-print"></i> Imprimer le rapport de caisse
                // </a>
                //<a class="dropdown-item text-danger mx-1 deleteIcon"  id="' . $rs->id . '"  href="#" title="Supprimer le compte"><i class="far fa-trash-alt"></i> Supprimer la ligne</a>
                $ndale = 1;
                $nombre++;
            }
        } else {
            $output .= '<tr>
              <td colspan="7">
                  <center>
                      <h6 style="margin-top:1%; color:#c0c0c0"> 
                          <center><font size="50px"><i class="fa fa-info-circle"></i></font><br><br>
                          Ceci est vide !
                      </center>
                  </h6>
              </center>
              </td>
          </tr>';
        }

        echo $output;
    }

    public function fetchHistoriqueCaisse(Request $request)
    {
        $projetID = session()->get('id');
        $id = $request->input('id');
        $dateDebut = $request->input('dateDebut');
        $dateFin = $request->input('dateFin');
        $exerciceId = session()->get('exercice_id');

        // Récupération de l'historique du compte de petite caisse
        $historique = Comptepetitecaisse::where('projetid', $projetID)
            ->where('comptepetitecaisses.id', $id)
            ->where('exercice_id', $exerciceId)
            ->join('users', 'comptepetitecaisses.userid', '=', 'users.id')
            ->join('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('comptepetitecaisses.*', 'comptepetitecaisses.id as compid' ,'personnels.prenom as personnel_prenom')
            ->first();

        // Initialisation de la requête pour les transactions de caisse
        $historiqueCompteQuery = Caisse::where('projetid', $projetID)
            ->where('caisses.compteid', $id)
            ->where('exercice_id', $exerciceId)
            ->where('caisses.statut', 0)
            ->join('users', 'caisses.userid', '=', 'users.id')
            ->join('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('caisses.*', 'caisses.id as idcc' ,'personnels.prenom as personnel_prenom')
            ->orderBy('caisses.id', 'ASC');

        // Filtrage par dates si les deux dates sont fournies
        if ($dateDebut && $dateFin) {
            $dateDebut = (new \DateTime($dateDebut))->format('Y-m-d 00:00:00');
            $dateFin = (new \DateTime($dateFin))->modify('+1 day')->format('Y-m-d 00:00:00');
            $historiqueCompteQuery->whereBetween('caisses.created_at', [$dateDebut, $dateFin]);
        }

        // Pagination des résultats, avec 25 résultats par page
        $historiqueCompte = $historiqueCompteQuery->paginate(1000);

        $personnel = DB::table('users')
        ->join('personnels', 'users.personnelid', '=', 'personnels.id')
        ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
        ->orderBy('nom', 'ASC')
        ->get();


        // Retourne la vue avec les données paginées
        return view('bonpetitecaisse.compte.historique', compact('historique', 'historiqueCompte','personnel'));
    }

    // ComptepetitecaisseController.php
    public function printHistoriqueCaisse($id)
    {
        $projetID = session()->get('id');
        $exerciceId = session()->get('exercice_id');

        // Vérifiez que les valeurs de $projetID et $id sont bien définies
        if (!$projetID || !$id) {
            return redirect()->back()->withErrors('Projet ou ID non défini.');
        }

        // Récupérer les informations du rapport de caisse
        $historique = Comptepetitecaisse::where('projetid', $projetID)
            ->where('comptepetitecaisses.id', $id)
            ->where('exercice_id', $exerciceId)
            ->join('users', 'comptepetitecaisses.userid', '=', 'users.id')
            ->join('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('comptepetitecaisses.*', 'personnels.prenom as personnel_prenom')
            ->first();

        if (!$historique) {
            return redirect()->back()->withErrors('Rapport non trouvé.');
        }

        // Récupérer les transactions liées au rapport de caisse
        $historiqueCompte = Caisse::where('projetid', $projetID)
             ->where('exercice_id', $exerciceId)
            ->where('caisses.compteid', $id)
            ->join('users', 'caisses.userid', '=', 'users.id')
            ->join('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('caisses.*', 'personnels.prenom as personnel_prenom')
            ->orderBy('caisses.id', 'ASC')
            ->get();

        // Retourne la vue formatée pour l'impression
        return view('bonpetitecaisse.compte.print', compact('historique', 'historiqueCompte'));
    }

    public function store(Request $request)
    {
        try {

            $ID = session()->get('id');
            $exerciceId = session()->get('exercice_id');

            $title = $request->libelle;
            $code = $request->code;
            $check = Comptepetitecaisse::where('libelle', $title)
                ->where('code', $code)
                ->where('projetid', $ID)
                ->where('exercice_id', $exerciceId)
                ->first();
                
            if ($check) {
                return response()->json([
                    'status' => 201,
                ]);
            } else {
                $gc = new Comptepetitecaisse();

                $gc->exercice_id = $exerciceId;
                $gc->projetid = $request->projetid;
                $gc->code = $request->code;
                $gc->libelle = $request->libelle;
                $gc->userid = Auth::id();
                $gc->save();

                return response()->json([
                    'status' => 200,
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 202,
            ]);
        }
    }
    // edit an service ajax request
    public function edit(Request $request)
    {
        $id = $request->id;
        $fon = Comptepetitecaisse::find($id);
        return response()->json($fon);
    }

    public function update(Request $request)
    {
        try {

            $emp = Comptepetitecaisse::find($request->c_id);
            if ($emp->userid == Auth::id()) {

                $emp->libelle = $request->c_description;
                $emp->code = $request->c_code;
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

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->id;
            $emp = Comptepetitecaisse::find($id);
            if ($emp && $emp->userid == Auth::id()) {
                $id = $request->id;
              
                if($emp->solde == 0){
                // Supprimer le projet
                Comptepetitecaisse::destroy($id);
                DB::commit();
                return response()->json([
                    'status' => 200,
                ]);

               }else{

                DB::rollBack();
                return response()->json([
                    'status' => 205,
                    'message' => 'Vous n\'avez pas l\'autorisation de supprimer le compte qui est encours d\'exécution.'
                ]);

                
               }
                

           
            } else {
                DB::rollBack();
                return response()->json([
                    'status' => 205,
                    'message' => 'Vous n\'avez pas l\'autorisation nécessaire pour supprimer cette compte petite caisse. Veuillez contacter le créateur  pour procéder à la suppression.'
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Erreur lors de la suppression du compte petite.',
                'error' => $e->getMessage(), // Message d'erreur de l'exception
                'exception' => (string) $e // Détails de l'exception convertis en chaîne
            ]);
        }
    }
    
}
