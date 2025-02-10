<?php

namespace App\Http\Controllers;


use App\Models\Bonpetitcaisse;
use App\Models\Caisse;
use App\Models\Compte;
use App\Models\Comptepetitecaisse;
use App\Models\Elementboncaisse;
use App\Models\Identification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class BonpetitcaisseController extends Controller
{
    public function index()
    {
        $title = 'Bon de petite caisse';
        $ID = session()->get('id');
        $exerciceId = session()->get('exercice_id');
        // Vérifier si l'ID de la session n'est pas défini
        if (!$ID) {
            // Rediriger vers la route nommée 'dashboard'
            return redirect()->route('dashboard');
        }
      
        $compte_bpc =  Comptepetitecaisse::where('projetid', $ID)
             ->where('exercice_id', $exerciceId)
            ->join('users', 'comptepetitecaisses.userid', '=', 'users.id')
            ->join('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('comptepetitecaisses.*', 'personnels.prenom as personnel_prenom')
            ->get();

        $comptes = Compte::where('projetid', $ID)
            ->where('compteid', 0)
            ->distinct()
            ->get();

       
        $personnel = DB::table('users')
            ->join('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
            ->orderBy('nom', 'ASC')
            ->get();

        return view(
            'bonpetitecaisse.bonpc.index',
            [
                'title'     => $title,
                'compte_bpc'    => $compte_bpc,
                'compte'    => $comptes,
                'personnel' => $personnel,
               
            ]
        );
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
    
        try {
            $IDP = session()->get('id');
            $exerciceId = session()->get('exercice_id');
            $numerobpc = $request->numero;
            $IdCompte  = $request->compteid;
            $montant   = $request->total_global;

           /* $checkSoldeCompte = Comptepetitecaisse::where('id', $IdCompte)
                                ->where('solde', '>=', $montant)
                                ->first();
            if ($checkSoldeCompte) {    */    

                  // Vérification de l'existence du numéro BPC
            $check = Bonpetitcaisse::where('numero', $numerobpc)
            ->where('projetid', $IDP)
            ->first();

                if ($check) {
                    return response()->json(['status' => 201]);
                } else {

                    $acce = empty($request->acce) ? 0 : $request->acce;

                    $bpc = new Bonpetitcaisse();

                    $bpc->projetid = $IDP;
                    $bpc->numero = $request->numero;
                    $bpc->compteid = $request->compteid;
                    $bpc->total_montant = $request->total_global;
                    $bpc->date = $request->date;

                    $bpc->etabli_par = $acce;
                    $bpc->verifie_par = $request->comptable;
                    $bpc->approuve_par = $request->chefcomposante;

                    $bpc->nom_sousigne = $request->nom_sousigne;
                    $bpc->titre = $request->titre;
                    $bpc->type_identite = $request->type_identite;
                    $bpc->numero_piece = $request->numero_piece;
                    $bpc->adresse = $request->adresse;
                    $bpc->telephone_email = $request->telephone_email;
                    $bpc->exercice_id = $exerciceId;

                    if($acce==0){
                        $bpc->beneficiaire = $request->beneficiaire;

                    }

                    $bpc->userid = Auth::id();
                    // Sauvegarde du bon de caisse
                    $bpc->save();

                    $IDBPC = $bpc->id;

                    // Insertion des éléments de bon de caisse
                    foreach ($request->numerodetail as $key => $items) {

                       

                        $comp = $request->referenceid[$key];
                        $compp = explode("-", $comp);

                      
                            $grandcompte = $compp[0];
                            $souscompte = $compp[1];
                            $input = $compp[2];
                        
                      
                        $elementbpc = new Elementboncaisse();

                        $elementbpc->boncaisse_id = $IDBPC;
                        $elementbpc->ligneid = $souscompte;
                        $elementbpc->ligne_principale = $grandcompte;
                        $elementbpc->montant = $request->montant_details[$key];
                        $elementbpc->motifs = $request->motif[$key];
                        $elementbpc->input= $input;
                        $elementbpc->projetid = $IDP;

                        // Sauvegarde de l'élément de bon de caisse
                        $elementbpc->save();
                    }

                    DB::commit();

                    return response()->json(['status' => 200]);
                }
          /*  } else {
                return response()->json(['status' => 205]);
            }  */
    
          
        } catch (\Exception $e) {
            DB::rollBack();
    
            // Retourner une réponse avec l'erreur
            return response()->json(['status' => 202, 'error' => $e->getMessage()]);
        }
    }
    
    public function list()
    {
        $ID = session()->get('id');
        $exerciceId = session()->get('exercice_id');
        $bpc = Bonpetitcaisse::orderBy('numero', 'ASC')
        ->join('users', 'bonpetitcaisses.userid', '=', 'users.id')
        ->join('personnels', 'users.personnelid', '=', 'personnels.id')
        ->join('elementboncaisses', 'bonpetitcaisses.id', 'elementboncaisses.boncaisse_id')
        ->select('bonpetitcaisses.*', 'bonpetitcaisses.id as idb', 'elementboncaisses.*', 'personnels.prenom as user_prenom')
        ->where('bonpetitcaisses.projetid', $ID)
        ->where('bonpetitcaisses.exercice_id', $exerciceId)
        ->get();
        $output = '';
        if ($bpc->count() > 0) {
            $nombre = 1;
            foreach ($bpc as $rs) {
                $cryptedId = Crypt::encrypt($rs->idb);

               
                $output .= '<tr>
          <td>
       
              <div class="btn-group me-2 mb-2 mb-sm-0">
                  <a  data-bs-toggle="dropdown" ariba-expanded="false">
                      <i class="mdi mdi-dots-vertical ms-2"></i> Options
                  </a>
                  <div class="dropdown-menu">
                      <a href="bonpetitcaisse/' . $cryptedId . '/viewbpc" class="dropdown-item mx-1" id="' . $rs->idb . '">
                          <i class="fas fa-eye"></i> Voir 
                      </a>
                       <a href="bonpetitcaisse/' . $cryptedId . '/voir" class="dropdown-item mx-1" id="' . $rs->idb . '">
                          <i class="fas fa-edit"></i> Modifier
                      </a>
                    
                  </div>
              </div>
         
      </td>
                <td>' . ucfirst($rs->numero) . '</td>
                <td>' . ucfirst($rs->motifs) . '</td>
                <td align="right">'.number_format($rs->montant, 0, ',', ' ').'</td>
                 <td align="center">'.$rs->input.'</td>
                <td >' . ucfirst($rs->nom_sousigne) . '</td>
               
                <td >' . ucfirst($rs->user_prenom) . '</td>
                 <td align="center">' . ucfirst($rs->date) . '</td>
                <td align="center">' . date('d-m-Y', strtotime($rs->created_at)) . '</td>
            
              </tr>';
                $nombre++;
            }

            echo $output;
        } else {
            echo ' <tr>
          <td colspan="9">
          <center>
            <h6 style="margin-top:1% ;color:#c0c0c0"> 
            <center><font size="50px"><i class="fa fa-info-circle"  ></i> </font><br>
           Ceci est vide  !</center> </h6>
          </center>
          </td>
          </tr>';
        }
    }

    public function  show($key)
    {

        $title = 'Bon petite caisse';
        
      
        $exerciceId = session()->get('exercice_id');

        $keys= Crypt::decrypt($key);

        $dateinfo = Identification::all()->first();
      
        $dataPetiteCaisse = Bonpetitcaisse::orderBy('numero', 'ASC') // Trie les résultats par numéro en ordre croissant
        ->join('comptepetitecaisses', 'bonpetitcaisses.compteid', '=', 'comptepetitecaisses.id')
        ->join('users', 'bonpetitcaisses.userid', '=', 'users.id') // Joint la table 'users' en utilisant 'userid' de 'bonpetitcaisses'
        ->join('personnels', 'users.personnelid', '=', 'personnels.id') // Joint la table 'personnels' en utilisant 'personnelid' de 'users'
        ->select('bonpetitcaisses.*', 'comptepetitecaisses.code as code','personnels.prenom as user_prenom') // Sélectionne toutes les colonnes de 'bonpetitcaisses' et le prénom de 'personnels'
        ->where('bonpetitcaisses.id', $keys) // Filtre les résultats pour obtenir l'enregistrement correspondant à l'ID donné
        ->where('bonpetitcaisses.exercice_id', $exerciceId)
        ->first(); // Récupère le premier (et seul) enregistrement correspondant

        $etablienom = DB::table('users')
            ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as userid')
            ->where('users.id', $dataPetiteCaisse->etabli_par)
            ->first();
            
            $verifie_par = DB::table('users')
            ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
            ->where('users.id', $dataPetiteCaisse->verifie_par)
            ->first();

        $approuver_par = DB::table('users')
            ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
            ->where('users.id',  $dataPetiteCaisse->approuve_par)
            ->first();
        
            $element_petite_caisse = Elementboncaisse::where('boncaisse_id',$dataPetiteCaisse->id)->get();

          

        return view(
            'bonpetitecaisse.bonpc.voir',
            [
                'title'            => $title,
                'dataPetiteCaisse' => $dataPetiteCaisse,
                'dateinfo'         => $dateinfo ,
                'etablienom'       => $etablienom,
                'verifie_par'      => $verifie_par,
                'approuver_par'    => $approuver_par,
                'element_petite_caisse' => $element_petite_caisse
            ]
        );

    }

    public function  voir($key)
    {

        $title = 'Bon petite caisse';
        
        $ID = session()->get('id');
        // Vérifier si l'ID de la session n'est pas défini
        if (!$ID) {
            // Rediriger vers la route nommée 'dashboard'
            return redirect()->route('dashboard');
        }

        $keys= Crypt::decrypt($key);

        $dateinfo = Identification::all()->first();
      
        $dataPetiteCaisse = Bonpetitcaisse::orderBy('numero', 'ASC') // Trie les résultats par numéro en ordre croissant
        ->join('comptepetitecaisses', 'bonpetitcaisses.compteid', '=', 'comptepetitecaisses.id')
        ->join('users', 'bonpetitcaisses.userid', '=', 'users.id') // Joint la table 'users' en utilisant 'userid' de 'bonpetitcaisses'
        ->join('personnels', 'users.personnelid', '=', 'personnels.id') // Joint la table 'personnels' en utilisant 'personnelid' de 'users'
        ->select('bonpetitcaisses.*', 'comptepetitecaisses.code as code','personnels.prenom as user_prenom') // Sélectionne toutes les colonnes de 'bonpetitcaisses' et le prénom de 'personnels'
        ->where('bonpetitcaisses.id', $keys) // Filtre les résultats pour obtenir l'enregistrement correspondant à l'ID donné
        ->first(); // Récupère le premier (et seul) enregistrement correspondant

        $etablienom = DB::table('users')
            ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.signature', 'users.id as userid')
            ->where('users.id', $dataPetiteCaisse->etabli_par)
            ->first();
            
            $verifie_par = DB::table('users')
            ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
            ->where('users.id', $dataPetiteCaisse->verifie_par)
            ->first();

        $approuver_par = DB::table('users')
            ->leftJoin('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid', 'users.signature')
            ->where('users.id',  $dataPetiteCaisse->approuve_par)
            ->first();
        
            $element_petite_caisse = Elementboncaisse::where('boncaisse_id',$dataPetiteCaisse->id)->get();

            $compte_bpc =  Comptepetitecaisse::where('projetid', $ID)
                ->join('users', 'comptepetitecaisses.userid', '=', 'users.id')
                ->join('personnels', 'users.personnelid', '=', 'personnels.id')
                ->select('comptepetitecaisses.*', 'personnels.prenom as personnel_prenom')
                ->get();
    
            $comptes = Compte::where('projetid', $ID)
                ->where('compteid', 0)
                ->distinct()
                ->get();
    
           
            $personnel = DB::table('users')
                ->join('personnels', 'users.personnelid', '=', 'personnels.id')
                ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
                ->orderBy('nom', 'ASC')
                ->get();

          

        return view(
            'bonpetitecaisse.bonpc.edit',
            [
                'title'            => $title,
                'dataPetiteCaisse' => $dataPetiteCaisse,
                'dateinfo'         => $dateinfo ,
                'etablienom'       => $etablienom,
                'verifie_par'      => $verifie_par,
                'approuver_par'    => $approuver_par,
                'element_petite_caisse' => $element_petite_caisse,
                'compte_bpc' => $compte_bpc,
                'compte'  => $comptes,
                'personnel' => $personnel
            ]
        );

    }

    public function updateSignature(Request $request)
    {
      try {
        if (!empty($request->verifier) ||  !empty($request->approver)) {
          $emp = Bonpetitcaisse::find($request->febid);
  
          
          $accesignature = !empty($request->accesignature) ? 1 : $request->clone_accesignature;
          $verifierPar = !empty($request->verifier) ? 1 : $request->clone_verifier;
          $approver = !empty($request->approver) ? 1 : $request->clone_approver;
        
          $emp->etabli_par_signature   = $accesignature;
          $emp->verifie_par_signature  = $verifierPar;
          $emp->approuve_par_signature = $approver;
          $emp->faita = $request->lieu;
          $emp->date = $request->date;

          if($request->beneficiaire){
            $emp->beneficiaire= $request->beneficiaire;
          }
        

          $do = $emp->update();

          if($do){

            

            if (!Caisse::where('bonid', $request->bonid)->exists()) {

                if ($emp->verifie_par_signature == 1 && $emp->approuve_par_signature	 == 1) {
                 

                    $element_petite_caisse = Elementboncaisse::where('boncaisse_id',$request->febid)->get();

                    foreach ($element_petite_caisse as $key => $element_petite_caisses) { 
                        $input= $element_petite_caisses->input;
                        $cout= $element_petite_caisses->montant;
                        $motifs= $element_petite_caisses->motifs;
                      

                        $petiteCaisse = Comptepetitecaisse::find($request->compteid);
    
                        if ($petiteCaisse) {


                        $idProjet = $emp->projetid;
                        $solde = $petiteCaisse->solde - $cout;
                        $petiteCaisse->solde = $solde;
                        $petiteCaisse->save();
                        // compte pour attribue le numero
                        $numero = Caisse::where('projetid', $idProjet)->count();
                        // compte where projet
                        // Utilisation de save() au lieu de update() pour plus de simplicité
                        // nouveau entrer dans la caisse.
                        $caisse              = new Caisse();
        
                        $caisse->date        = date('j-m-Y');
                        $caisse->compteid    = $request->compteid;
                        $caisse->projetid    = $idProjet;
                        $caisse->numerobon     = $request->numBon;
                        $caisse->description = $motifs;
                        $caisse->input       = $input;
                        $caisse->debit       = "0";
                        $caisse->credit      = $cout;
                        $caisse->solde       = $solde;
                        $caisse->dapid       = "0";
                        $caisse->userid      = Auth::id();
                        $caisse->bonid       = $request->bonid;
        
                        $caisse->save();
                        }

                    }

    
                  
                
                }
              }

              return back()->with('success', 'Très bien! La signature a bien été enregistrée');

          }else{

          }
  
         
        } else {
          return back()->with('failed', 'Vous devez cocher au moins une case pour enregistrer la signature.');
        }
      } catch (Exception $e) {
        $errorMessage = $e->getMessage();
        return back()->with('failed', 'Échec ! La signature n\'a pas été créée' . $errorMessage);
      }
    }
  
}
