<?php

namespace App\Http\Controllers;

use App\Models\Comptepetitecaisse;
use App\Models\Dapbpc;
use App\Models\Feb;
use App\Models\Febpetitcaisse;
use App\Models\Project;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class FebpetitcaisseController extends Controller
{
  public function index()
  {
    // Récupérer l'ID de la session
    $ID = session()->get('id');

    // Vérifier si l'ID de la session n'est pas défini
    if (!$ID) {
      // Rediriger vers la route nommée 'dashboard'
      return redirect()->route('dashboard');
    }

    $title = 'FEB Petit Caisse';
    $compte   =Comptepetitecaisse::where('projetid', $ID)->get();


    $personnel = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
      ->orderBy('nom', 'ASC')
      ->get();

    return view(
      'bonpetitecaisse.feb.index',
      [
        'title' => $title,
        'compte' => $compte,
        'personnel' => $personnel
      ]
    );
  }

  public function fetchAll()
  {
    $ID = session()->get('id');

    $data = DB::table('febpetitcaisses')
      ->orderBy('numero', 'asc')
      ->join('users', 'febpetitcaisses.user_id', '=', 'users.id')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->join('comptepetitecaisses', 'febpetitcaisses.compte_id', 'comptepetitecaisses.id')
      ->select('febpetitcaisses.*', 'personnels.prenom as user_prenom', 'comptepetitecaisses.code as code')
      ->where('febpetitcaisses.projet_id', $ID)
      ->get();

    $output = '';

    if ($data->isNotEmpty()) {
      foreach ($data as $datas) {
        $cryptedId = Crypt::encrypt($datas->id);
        $output .= '
            <tr>
                <td>
                    <center>
                        <div class="btn-group me-2 mb-2 mb-sm-0">
                            <a data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical ms-2"></i> Options
                            </a>
                            <div class="dropdown-menu">
                                <a href="'. route('viewfebpc', ['id' => $cryptedId]) .'" class="dropdown-item mx-1" title="Title">
                                    <i class="fas fa-eye"></i> Voir 
                                </a>

                                 <a href="'. route('editfebpc', ['id' => $cryptedId]) .'" class="dropdown-item mx-1" title="Modifier">
                                    <i class="far fa-edit"></i> Modifier
                                </a>
                               
                               
                            </div>
                        </div>
                    </center>
                </td>
                <td align="center"> ' . $datas->numero . '</td>
                <td>' . $datas->description . '</td>
                <td align="right">' . number_format($datas->montant, 0, ',', ' ') . '</td>
                <td align="center">' . $datas->code . '</td>
                <td align="center">' . date('d-m-Y', strtotime($datas->date_dossier)) . '</td>
                <td align="center">' . date('d-m-Y', strtotime($datas->date_limite)) . '</td>
                <td align="center">' . date('d-m-Y, H:i', strtotime($datas->created_at)) . '</td>
                <td align="center">' . date('d-m-Y, H:i', strtotime($datas->updated_at)) . '</td>
                <td align="left">' . ucfirst($datas->user_prenom) . '</td>
            </tr>';

            // <a href="'. route('generate-pdf', ['id' => $cryptedId]) .'" class="dropdown-item mx-1">
           // <i class="fa fa-print"></i> Générer PDF
           // </a>
           // <a class="dropdown-item text-white mx-1 deleteIcon" id="' . $datas->id . '" data-numero="' . $datas->numero . '" href="#" style="background-color:red">
           //     <i class="far fa-trash-alt"></i> Supprimer
           // </a>
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

  public function show($id)
  {
    $title = 'FEB Petit Caisse';
    // Récupérer l'ID de la session
   
    // Décrypter l'ID
    $ids = Crypt::decrypt($id);

    // Récupérer les données correspondantes
    $febData = DB::table('febpetitcaisses')
      ->leftJoin('comptepetitecaisses', 'febpetitcaisses.compte_id', 'comptepetitecaisses.id')
      ->leftJoin('projects', 'febpetitcaisses.projet_id', '=', 'projects.id')
      ->leftJoin('users', 'febpetitcaisses.user_id', '=', 'users.id')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('febpetitcaisses.*', 'comptepetitecaisses.code as codes', 'comptepetitecaisses.libelle as libelle_compte',  'projects.id as IDP','projects.title as titles_projet', 'personnels.prenom', 'personnels.nom')
      ->where('febpetitcaisses.id', $ids)
      ->first();

    $etablie_par = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as userid')
      ->where('users.id', $febData->etabli_par)
      ->first();

    $verifie_par = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
      ->where('users.id', $febData->verifie_par)
      ->first();

    $approuver_par = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
      ->where('users.id', $febData->approuve_par)
      ->first();

    $dateinfo = DB::table('identifications')->first();

    // RECUPERATION BU DUBGET DU PROJET
    $IDB = $febData->IDP;
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


    
    return view('bonpetitecaisse.feb.show', [
      'title'          => $title,
      'febData'        => $febData,
      'dateinfo'       => $dateinfo,
      'etablie_par'    => $etablie_par,
      'verifie_par'     => $verifie_par,
      'approuver_par'  => $approuver_par,
      'POURCENTAGE_GLOGALE' => $POURCENTAGE_GLOGALE
    ]);
  }

  public function updatesignaturefebpetit(Request $request)
  {
    try {
      if (!empty($request->etabli_par) || !empty($request->verifie_par) || !empty($request->approuve_par)) {
        $emp = Febpetitcaisse::find($request->febid);

        $etabli_par = !empty($request->etabli_par) ? 1 : $request->clone_etabli_par;
        $verifie_par = !empty($request->verifie_par) ? 1 : $request->clone_verifie_par;
        $approuve_par = !empty($request->approuve_par) ? 1 : $request->clone_approuve_par;

        $emp->etabli_par_signature   = $etabli_par;
        $emp->verifie_par_signature  = $verifie_par;
        $emp->approuve_par_signature = $approuve_par;

        $emp->update();

        return back()->with('success', 'Très bien! La signature a bien été enregistrée');
      } else {
        return back()->with('failed', 'Vous devez cocher au moins une case pour enregistrer la signature.');
      }
    } catch (Exception $e) {
      return back()->with('failed', 'Échec ! La signature n\'a pas été créée');
    }
  }

  public function edit($id)
  {
    $title = 'FEB Petit Caisse';
    // Récupérer l'ID de la session
    $IDP = session()->get('id');

    if (!$IDP) {
      return redirect()->route('dashboard');
    }

    // Décrypter l'ID
    $ids = Crypt::decrypt($id);

    // Récupérer les données correspondantes
    $febData = DB::table('febpetitcaisses')
      ->leftJoin('comptepetitecaisses', 'febpetitcaisses.compte_id', 'comptepetitecaisses.id')
      ->leftJoin('projects', 'febpetitcaisses.projet_id', '=', 'projects.id')
      ->leftJoin('users', 'febpetitcaisses.user_id', '=', 'users.id')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('febpetitcaisses.*', 'comptepetitecaisses.code as codes', 'comptepetitecaisses.libelle as libelle_compte', 'projects.id as IDP', 'projects.title as titles_projet', 'personnels.prenom', 'personnels.nom')
      ->where('febpetitcaisses.id', $ids)
      ->first();

    $etablie_par = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as userid')
      ->where('users.id', $febData->etabli_par)
      ->first();

    $verifie_par = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
      ->where('users.id', $febData->verifie_par)
      ->first();

    $approuver_par = DB::table('users')
      ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
      ->where('users.id', $febData->approuve_par)
      ->first();

    $personnel = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
      ->where('fonction', '!=', 'Chauffeur')
      ->orderBy('nom', 'ASC')
      ->get();

      $compte   =Comptepetitecaisse::where('projetid', $febData->IDP)->get();


    return view('bonpetitecaisse.feb.edit', [
      'title'          => $title,
      'febData'        => $febData,
      'etablie_par'    => $etablie_par,
      'verifie_par'     => $verifie_par,
      'approuver_par'  => $approuver_par,
      'personnel'    => $personnel,
      'compte'       => $compte
    ]);
  }

  public function Updatestore(Request $request)
  {
    DB::beginTransaction();
    try {
      $IDP = session()->get('id');
     
      $activity = Febpetitcaisse::find($request->febid);
      
      $get_lead =  DB::table('febpetitcaisses')
      ->join('projects', 'febpetitcaisses.projet_id', '=', 'projects.id')
      ->select( 'projects.lead as lead')
      ->where('febpetitcaisses.id', $request->febid)
      ->first();

      $lead = session()->get('lead');
      $projet_lead= $get_lead ->lead;

      if ($activity && $activity->userid == Auth::id() || $projet_lead  == $lead  ) {

      if ($request->acce == $request->ancien_acce) {
        $acce_signe = $request->acce_signe;
      } else {
        $acce_signe = 0;
      }


      if ($request->comptable == $request->ancien_comptable) {
        $comptable_signe = $request->comptable_signe;
      } else {
        $comptable_signe = 0;
      }


      if ($request->chefcomposante == $request->ancien_chefcomposante) {
        $chef_signe = $request->chef_signe;
      } else {
        $chef_signe = 0;
      }

      if($request->montant != $request->ancien_montant) {
        $acce_signe = 0;
        $comptable_signe = 0;
        $chef_signe = 0;
      } 

      $activity->compte_id = $request->compteid;
      $activity->description = $request->description;
      $activity->numero = $request->numerofeb;
      $activity->montant = $request->montant;
      $activity->date_dossier = $request->datefeb;
      $activity->date_limite = $request->datelimite;
      $activity->etabli_par = $request->acce;
      $activity->verifie_par = $request->comptable;
      $activity->approuve_par = $request->chefcomposante;
      $activity->etabli_par_signature  =  $acce_signe;
      $activity->verifie_par_signature  =  $comptable_signe;
      $activity->approuve_par_signature	   =  $chef_signe;

      $activity->update();

      DB::commit();

      return redirect()->back()->with('success', 'FEB mises à jour avec succès');
   } else {
      DB::rollBack();
      return redirect()->back()->with('failed', 'Vous n\'avez pas l\'autorisation nécessaire pour Modifier le FEB. Veuillez contacter le créateur  pour procéder à la suppression.');
    } 
      
    } catch (\Exception $e) {
      DB::rollBack();

      return redirect()->back()->with('failed', 'FEB erreur des mises à jour: ' . $e->getMessage());
    }
  }

  public function checkfeb(Request $request)
  {
    $ID = session()->get('id');
    $numero = $request->numerofeb;

      $feb = Febpetitcaisse::where('numero', $numero)
              ->where('projet_id', $ID)
              ->exists();

    return response()->json(['exists' => $feb]);
  }

  public function store(Request $request)
  {
    DB::beginTransaction();

    try {

      $IDP = session()->get('id');

      $numerofeb = $request->numerofeb;
      $check = Febpetitcaisse::where('numero', $numerofeb)
        ->where('projet_id', $IDP)
        ->first();

      if ($check) {
        return response()->json([
          'status' => 201
        ]);
      } else {

        $feb = new Febpetitcaisse();

        $feb->projet_id = $request->projetid;
        $feb->compte_id = $request->compteid;
        $feb->description = $request->description;
        $feb->numero = $request->numerofeb;
        $feb->montant = $request->montantfeb;

        $feb->date_dossier = $request->datefeb;
        $feb->date_limite = $request->datelimite;
        $feb->etabli_par = $request->acce;
        $feb->verifie_par = $request->comptable;
        $feb->approuve_par = $request->chefcomposante;
        $feb->user_id = Auth::id();

        $feb->save();

        DB::commit();

        return response()->json([
          'status' => 200,
        ]);
      }
    } catch (Exception $e) {
      DB::rollBack();

      return response()->json([
        'status' => 202,
        'error' => $e->getMessage()
      ]);
    }
  }

  public function delete(Request $request)
  {
    DB::beginTransaction();

    try {

      $id = $request->id;
      $emp = Febpetitcaisse::find($request->id);

      if ($emp && $emp->user_id == Auth::id()) {
        $id = $request->id;

        Febpetitcaisse::destroy($id);
        Dapbpc::where('referencefeb', $id)->delete();

        DB::commit();

        return response()->json([
          'status' => 200,
        ]);
      } else {
        DB::rollBack();
        return response()->json([
          'status' => 205,
          'message' => 'Vous n\'avez pas l\'autorisation nécessaire pour supprimer le FEB Petite Caisse. Veuillez contacter le créateur  pour procéder à la suppression.'
        ]);
      }
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'status' => 500,
        'message' => 'Erreur lors de la suppression du FEB Petite Caisse.',
        'error' => $e->getMessage(), // Message d'erreur de l'exception
        'exception' => (string) $e // Détails de l'exception convertis en chaîne
      ]);
    }
  }

  public function generatePDFfebpc($id)
  {
    // Vérifie si la variable de session 'id' existe
    $title = 'FEB';
    $check = Febpetitcaisse::findOrFail($id);

    $idfeb = $check->id;
    $numero_classe_feb =  $check->numero;

    $IDB = $check->projetid;
    $chec = Project::findOrFail($IDB);
    $budget = $chec->budget;

    // $POURCENTAGE_GLOGALE = $budget ? round(($sommeallfeb * 100) / $budget, 2) : 0;
    // $sommelignpourcentage = $somme_ligne_principale ? round(($sommelign * 100) / $somme_ligne_principale, 2) : 0;
    // Instancie Dompdf

    $dompdf = new Dompdf();
    $infoglo = DB::table('identifications')->first();

    $datafeb = DB::table('febpetitcaisses')
      ->join('projects', 'febpetitcaisses.projetid', '=', 'projects.id')
      ->select('febpetitcaisses.*', 'projects.title as titre_p')
      ->where('febpetitcaisses.id', $id)
      ->first();


    // Etablie par
    $etablienom = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as userid')
      ->where('users.id', $datafeb->etabli_par)
      ->first();

    // Comptable
    $verifie_par = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as userid')
      ->where('users.id', $datafeb->verifie_par)
      ->first();

    // Chef composant
    $approuve_par = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
      ->where('users.id', $datafeb->approuve_par)
      ->first();

    // Génère le fichier PDF
    $pdf = FacadePdf::loadView('bonpetitecaisse.feb.doc', compact(
      'infoglo',
      'datafeb',
      'etablienom',
      'comptable_nom',
      'checcomposant_nom',
      'personnel'
    ));

    $pdf->setPaper('A4', 'landscape'); // Format A4 en mode paysage

    // Nom du fichier PDF téléchargé avec numéro FEB et date actuelle
    $fileName = 'FEB_NUMERO_' . $datafeb->numero . '.pdf';

    // Télécharge le PDF

    return $pdf->download($fileName);
  }


}
