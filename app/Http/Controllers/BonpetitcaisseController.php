<?php

namespace App\Http\Controllers;

use App\Models\Beneficaire;
use App\Models\Bonpetitcaisse;
use App\Models\Elementboncaisse;
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
        // Vérifier si l'ID de la session n'est pas défini
        if (!$ID) {
            // Rediriger vers la route nommée 'dashboard'
            return redirect()->route('dashboard');
        }
        $compte =  DB::table('comptes')
            ->where('comptes.projetid', $ID)
            ->where('compteid', '=', 0)
            ->get();

        $beneficaire = Beneficaire::orderBy('libelle')->get();

        $personnel = DB::table('users')
            ->join('personnels', 'users.personnelid', '=', 'personnels.id')
            ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction', 'users.id as userid')
            ->orderBy('nom', 'ASC')
            ->get();

        return view(
            'document.bonpetitcaise.index',
            [
                'title' => $title,
                'compte' => $compte,
                'personnel' => $personnel,
                'beneficaire' => $beneficaire
            ]
        );
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
    
        try {
            $IDP = session()->get('id');
            $numerobpc = $request->numero;
    
            // Vérification de l'existence du numéro BPC
            $check = Bonpetitcaisse::where('numero', $request->numero)
                ->where('projetid', $IDP)
                ->first();
    
            if ($check) {
                return response()->json(['status' => 201]);
            }
    
            $interne = $request->interne;
    
            $bpc = new Bonpetitcaisse();
            $bpc->fill($request->all());
            $bpc->userid = Auth::id();

           if ($interne == 1) {
                $bpc->titre = $request->has('titre') ? $request->titre : null;
                $bpc->type_identite = $request->has('type_identite') ? $request->type_identite : null;
                $bpc->numero_piece = $request->has('numero_piece') ? $request->numero_piece : null;
                $bpc->adresse = $request->has('adresse') ? $request->adresse : null;
                $bpc->telephone_email = $request->has('telephone_email') ? $request->telephone_email : null;
            }

    
            $bpc->save();
    
            $IDBPC = $bpc->id;
    
            // Insertion des éléments de bon de caisse
            foreach ($request->numerodetail as $key => $items) {
                $elementbpc = new Elementboncaisse();
                $elementbpc->boncaisse_id = $IDBPC;
                $elementbpc->ligneid =  $request->referenceid[$key];
                $elementbpc->montant = $request->montant[$key];
                $elementbpc->save();
            }
    
            DB::commit();
    
            return response()->json(['status' => 200]);
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response()->json(['status' => 202, 'error' => $e->getMessage()]);
        }
    }
    

    public function list()
    {
        $bpc = Bonpetitcaisse::orderBy('numero', 'ASC')
        ->join('users', 'bonpetitcaisses.userid', '=', 'users.id')
        ->join('personnels', 'users.personnelid', '=', 'personnels.id')
        ->select('bonpetitcaisses.*', 'personnels.prenom as user_prenom')
        ->get();
        $output = '';
        if ($bpc->count() > 0) {
            $nombre = 1;
            foreach ($bpc as $rs) {
                $cryptedId = Crypt::encrypt($rs->id);

                $sommebpc = DB::table('elementboncaisses')
                ->where('boncaisse_id', $rs->id)
                ->sum('montant');

                $sommebpc = number_format($sommebpc, 0, ',', ' ');

                $output .= '<tr>
          <td>
          <center>
              <div class="btn-group me-2 mb-2 mb-sm-0">
                  <a  data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="mdi mdi-dots-vertical ms-2"></i> Options
                  </a>
                  <div class="dropdown-menu">
                      <a href="bonpetitcaisse/' . $cryptedId . '/view" class="dropdown-item mx-1" id="' . $rs->id . '">
                          <i class="fas fa-eye"></i> Voir 
                      </a>
                      <a href="bonpetitcaisse/' . $cryptedId . '/edit" class="dropdown-item mx-1" id="' . $rs->id . '" title="Modifier">
                          <i class="far fa-edit"></i> Modifier
                      </a>
                      <a href="bonpetitcaisse/' . $rs->id . '/generate-pdf-feb" class="dropdown-item mx-1">
                          <i class="fa fa-print"></i> Générer PDF
                      </a>
                     
                      <a class="dropdown-item text-danger mx-1 deleteIcon" id="' . $rs->id . '" href="#">
                          <i class="far fa-trash-alt"></i> Supprimer
                      </a>
                  </div>
              </div>
          </center>
      </td>
                <td align="center">' . ucfirst($rs->numero) . '</td>
                <td align="center">' . ucfirst($rs->motif) . '</td>
                <td>'.$sommebpc.'</td>
                <td align="center">' . ucfirst($rs->nom_prenom_sous_signe) . '</td>
                <td align="center">' . ucfirst($rs->date) . '</td>
                <td align="center">' . ucfirst($rs->user_prenom) . '</td>
                <td align="center">' . date('d-m-Y', strtotime($rs->created_at)) . '</td>
            
              </tr>';
                $nombre++;
            }

            echo $output;
        } else {
            echo ' <tr>
          <td colspan="8">
          <center>
            <h6 style="margin-top:1% ;color:#c0c0c0"> 
            <center><font size="50px"><i class="far fa-trash-alt"  ></i> </font><br><br>
           Ceci est vide  !</center> </h6>
          </center>
          </td>
          </tr>';
        }
    }

    public function  show($key)
    {

    }
}
