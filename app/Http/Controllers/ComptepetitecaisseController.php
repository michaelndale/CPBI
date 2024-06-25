<?php

namespace App\Http\Controllers;

use App\Models\Comptepetitecaisse;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComptepetitecaisseController extends Controller
{
    public function index()
    {
        // Vérifie si l'ID de projet existe dans la session
        if (!session()->has('id')) {
            // Redirige vers le tableau de bord si l'ID de projet n'existe pas dans la session
            return redirect()->route('dashboard')->with('error', 'ID de projet non trouvé dans la session.');
        }
        $title = 'Compte ';
        $projet = Project::all();
        // Retourne la vue avec les données nécessaires
        return view('bonpetitecaisse.compte', [
            'title' => $title,
            'projet' => $projet
        ]);
    }

    public function fetchAll()
    {
        $ID = session()->get('id');
        $services = Comptepetitecaisse::where('projetid', $ID)
            ->join('users', 'comptepetitecaisses.userid', '=', 'users.id')
            ->join('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('comptepetitecaisses.*', 'personnels.prenom as personnel_prenom')
            ->get();


        $output = '';
        $nombre = 1;

        if ($services->count() > 0) {
            foreach ($services as $rs) {
                $output .= '<tr style="background-color:#F5F5F5">
               
                  <td> ' . ucfirst($rs->code) . '</td>
                  <td>' . ucfirst($rs->libelle) . '</td>
                  <td>' . ucfirst($rs->personnel_prenom) . '</td>
                  <td>' . date('d-m-Y', strtotime($rs->created_at)) . '</td>
                  <td align="center" style="width:13%">
                  <div class="btn-group me-2 mb-2 mb-sm-0">
                      <a  data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="mdi mdi-dots-vertical ms-2"></i>
                      </a>
                      <div class="dropdown-menu">
                        
                          <a class="dropdown-item  mx-1 edit" id="' . $rs->id . '"  data-bs-toggle="modal" data-bs-target="#modifierLigneModal" title="Modifier le compte"><i class="far fa-edit"></i> Modifier la ligne</a>
                          <a class="dropdown-item text-danger mx-1 deleteIcon"  id="' . $rs->id . '"  href="#" title="Supprimer le compte"><i class="far fa-trash-alt"></i> Supprimer la ligne</a>
                      </div>
                  </div>
                  </td>
              </tr>';



                $ndale = 1;

                $nombre++;
            }
        } else {
            $output .= '<tr>
              <td colspan="5">
                  <center>
                      <h6 style="margin-top:1%; color:#c0c0c0"> 
                          <center><font size="50px"><i class="far fa-trash-alt"></i></font><br><br>
                          Ceci est vide !
                      </center>
                  </h6>
              </center>
              </td>
          </tr>';
        }

        echo $output;
    }


    public function store(Request $request)
    {
        try {
            $ID = session()->get('id');
            $title = $request->libelle;
            $code = $request->code;
            $check = Comptepetitecaisse::where('libelle', $title)
                ->where('code', $code)
                ->where('projetid', $ID)
                ->first();
            if ($check) {
                return response()->json([
                    'status' => 201,
                ]);
            } else {
                $gc = new Comptepetitecaisse();

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

            $emp = Comptepetitecaisse::find($request->cidedit);
            if ($emp->userid == Auth::id()) {

                $emp->libelle = $request->clibelle;
                $emp->code = $request->ccode;
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
                // Supprimer le projet
                Comptepetitecaisse::destroy($id);
                DB::commit();
                return response()->json([
                    'status' => 200,
                ]);
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
