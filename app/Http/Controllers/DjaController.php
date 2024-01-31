<?php

namespace App\Http\Controllers;

use App\Models\Beneficaire;
use App\Models\Compte;
use App\Models\Dja;
use App\Models\Folder;
use App\Models\Historique;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DjaController extends Controller
{

      // insert a new employee ajax request
      public function store(Request $request)
      {
        
        $djaData= new Dja();

        $djaData->numerodjas = $request->numerodja;
        $djaData->projetiddja = $request->projetid;
        $djaData->beneficiaire = $request->beneficiaire;
        $djaData->datefondrecu= $request->datefondrecu;
        $djaData->numerofeb= $request->reffeb;
        $djaData->numerodap= $request->dapnum;
        $djaData->numeroov= $request->ovch;
        $djaData->lignebdt= $request->ligneid;
        $djaData->montant_avance= $request->montant_avance;
        $djaData->devise= $request->devise;
        $djaData->duree_avence= $request->dure_avance;
        $djaData->description= $request->description;
        $djaData->fondapprouver= $request->fondapprouver;
        $djaData->sign_fond= $request->sign_fond;
        $djaData->date_fond= $request->date_fond;
        $djaData->avance_approuver = $request->avance_approuver;
        $djaData->sign_avance= $request->sign_avance;
        $djaData->chefcomptable= $request->chefcomptable;
        $djaData->date_chefcomptable= $request->date_chefcomptable;
        $djaData->avence_approuver_deuxieme= $request->avence_approuver_deuxieme;
        $djaData->signe_deuxieme= $request->signe_deuxieme;
        $djaData->raf= $request->raf;
        $djaData->date_raf= $request->date_raf;
        $djaData->avence_approuver_troisieme= $request->avence_approuver_troisieme;
        $djaData->sign_avence_apr_troisieme= $request->sign_avence_apr_troisieme;
        $djaData->sg= $request->sg;
        $djaData->datesg= $request->datesg;
        $djaData->fondboursser= $request->fondboursser;
        $djaData->sign_fonddeboursse= $request->sign_fonddeboursse;
        $djaData->date_fonddeboursse= $request->date_fonddeboursse;
        $djaData->fondresu= $request->fondresu;
        $djaData->signature_fondresu= $request->signature_fondresu;
        $djaData->date_fondrecu= $request->date_fondrecu;
        $djaData->userid = Auth()->user()->id;

        $djaData->save();

        return response()->json([
         'status' => 200,
         
        ]);
       
      }

    public function list()
    {
        $title="DJA";
        $data= Dja::all();
        $total = Dja::all()->count();
        $active = 'Project';
        $compte = Compte::where('compteid', '=', NULL)->get();
        $personnel = DB::table('users')
                  ->join('personnels', 'users.personnelid', '=', 'personnels.id')
                  ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
                  ->orWhere('fonction', '!=' ,'Chauffeur')
                  ->orderBy('nom', 'ASC')
                  ->get();


        return view('document.dja.list', 
        [
          'title' =>$title,
          'data' => $data,
          'total' => $total,
          'active' => $active,
          'personnel' => $personnel,
          'compte'    => $compte
        ]);
    }
}
