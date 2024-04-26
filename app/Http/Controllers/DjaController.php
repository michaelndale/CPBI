<?php

namespace App\Http\Controllers;

use App\Models\Beneficaire;
use App\Models\Compte;
use App\Models\Dja;
use App\Models\Folder;
use App\Models\Historique;
use App\Models\Identification;
use App\Models\Notification;
use App\Models\User;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Crypt;

class DjaController extends Controller
{

  public function fetchAll()
  {
    $ID = session()->get('id');

    $data = DB::table('djas')
          ->orderby('id','DESC')
          ->Where('projetiddja', $ID)
          ->get();

    $output = '';
    if ($data->count() > 0) {
      $nombre = 1;
      foreach ($data as $datas) {
        $cryptedId = Crypt::encrypt($datas->id);
        $output .= '
        <tr>
          <td> 
          <center>
          <div class="btn-group me-2 mb-2 mb-sm-0">
            <button class="btn btn-primary btn-sm dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-dots-vertical ms-2"></i> Action
            </button>
            <div class="dropdown-menu">
                <a href="dja/'.$cryptedId.'/view" class="dropdown-item text-success mx-1 voirIcon"  ><i class="far fa-edit"></i> Voir dja</a>
                <a href="dja/'.$cryptedId.'/edit" class="dropdown-item text-primary mx-1 editIcon " title="Modifier"><i class="far fa-edit"></i> Modifier dja</a>
                <a href="dja/'.$cryptedId. '/generate-pdf-dja" class="dropdown-item  mx-1"><i class="fa fa-print"> </i> Générer document PDF</a>
                <a class="dropdown-item text-danger mx-1 deleteIcon"  id="' . $datas->id . '"  href="#"><i class="far fa-trash-alt"></i> Supprimer dja</a>
            </div>
          </div>
          </center>
          </td>
          <td> '.$datas->numerodjas.'  </td>
          <td> '.$datas->numerofeb.'  </td>
          <td> '.$datas->numerodap.' </td>
          <td> '.$datas->numeroov.' </td>
          <td> '.$datas->beneficiaire.' </td>
          <td> '.$datas->montant_avance.' </td>
     
         
        </tr>
      '
          ;
        $nombre++;
      }
      echo $output;
    } else {
      echo '<tr>
        <td colspan="9">
        <center>
          <h6 style="margin-top:1% ;color:#c0c0c0"> 
          <center><font size="10px"><i class="fa fa-info-circle"  ></i> </font><br><br>
          Ceci est vide  !</center> </h6>
        </center>
        </td>
        </tr>
        ';
    }
  }

      // insert a new employee ajax request
      public function store(Request $request)
      {
        
        $djaData= new Dja();

        $djaData->numerodjas = $request->numerodja;
        $djaData->projetiddja = $request->projetid;
        $djaData->beneficiaire = $request->benef;
        $djaData->adresse = $request->adresse;
        $djaData->tel = $request->tel;
        $djaData->teld = $request->tel2;
        $djaData->datefondrecu= $request->daterecufond;
        $djaData->numerofeb= $request->numfeb;
        $djaData->numerodap= $request->dapnumero;
        $djaData->numeroov= $request->ov;
        $djaData->lignebdt= $request->lignebudget;
        $djaData->montant_avance= $request->montantavence;
        $djaData->devise= $request->devise;
        $djaData->duree_avence= $request->dureavence;
        $djaData->description= $request->description;
        $djaData->fonddemandepar= $request->fonddemandepar;
        $djaData->chefcomptable= $request->chefcomptable;
        $djaData->raf= $request->raf;
        $djaData->sg= $request->sga;
        $djaData->fondboursser= $request->fonddebourser;
        $djaData->fondresu= $request->fondresu;
        $djaData->fondpaye= $request->fondpaye;
        $djaData->utiadresse= $request->utiadresse;
        $djaData->utitelephone= $request->utitelephone;
        $djaData->utitelephoned= $request->utitelephone2;
        $djaData->userid = Auth::id();

        $djaData->save();

      
        if($djaData){
          return response()->json([
            'status' => 200,
            
           ]);
        }else{
          return response()->json([
            'status' => 202,
            
           ]);
        }
       
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

    public function show($idd){

      $title="Voir DJA";
      $ID = session()->get('id');
      $dateinfo = Identification::all()->first();

      $idd = Crypt::decrypt($idd); // bd

      $Jsondja = DB::table('djas')
                ->orderby('id','DESC')
                ->Where('projetiddja', $ID)
                ->Where('djas.id', $idd)
                ->first();
      
      return view('document.dja.voir', 
        [
          'title'     => $title,
          'dateinfo'  => $dateinfo,
          'Jsondja'   => $Jsondja
        ]);

    }


    public function edit($id){

      $title="Modification DJA";
      $ID = session()->get('id');

      $Jsondja = DB::table('djas')
      ->orderby('id','DESC')
      ->Where('projetiddja', $ID)
      ->Where('djas.id', $id)
      ->first();

      $total = Dja::all()->count();
      $active = 'Project';
      $compte = Compte::where('compteid', '=', NULL)->get();
      $personnel = DB::table('users')
                ->join('personnels', 'users.personnelid', '=', 'personnels.id')
                ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
                ->orWhere('fonction', '!=' ,'Chauffeur')
                ->orderBy('nom', 'ASC')
                ->get();

      return view('document.dja.edit', 
        [
          'title'     => $title,
          'Jsondja' => $Jsondja,
          'total' => $total,
          'active' => $active,
          'personnel' => $personnel,
          'compte'    => $compte
        ]);

    }

    public function generatePDFdja($id)
    {
      $IDB = session()->get('id');
      $budget = session()->get('budget');
      $devise = session()->get('devise');
      $dompdf = new Dompdf();

      $id = Crypt::decrypt($id); // bd
      
      $Jsondja = DB::table('djas')
      ->orderby('id','DESC')
      ->Where('projetiddja', $IDB)
      ->Where('djas.id', $id)
      ->first();

      $infoglo = DB::table('identifications')->first();
  
      $pdf = FacadePdf::loadView('document.dja.doc', compact('infoglo','Jsondja' ));
  
      $pdf->setPaper('A4', 'landscape'); // Définit le format A4 en mode paysage

      $lien_download= 'dja'.$id.'.pdf';
  
      return $pdf->download($lien_download);
    }

    public function delete(Request $request)
    {
      $his = new Historique;
      $function = "Suppression";
      $operation = "Suppression DJA";
      $link = 'dja';
      $his->fonction = $function;
      $his->operation = $operation;
      $his->userid = Auth()->user()->id;
      $his->link = $link;
      $his->save();
  
      $id = $request->id;
      Dja::destroy($id);
    }
}
