<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\Project;
use App\Models\Rallongebudget;
use App\Models\typeprojet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class RallongebudgetController extends Controller
{
    public function index()
    {
      $IDP = session()->get('id');
      $devise =session()->get('devise');
      $budget =session()->get('budget');
      $periode =session()->get('periode');
    
      $title = 'Budgetisation';
      $compte= Compte::where('projetid', $IDP)->where('compteid', '=', 0)->get();
      $typebudget= typeprojet::all();
      
     

      return view('rallonge.index',
        [
          'title' => $title,
          'compte' => $compte,
          'periode' => $periode,
          'typebudget' => $typebudget
        ]
      );
    }


    public function fetchAll()
    {
      $IDP = session()->get('id');
      $devise =session()->get('devise');
      $budget =session()->get('budget');
      $periode =session()->get('periode');

      $data = Compte::where('compteid', '=', 0)
      ->where('projetid', $IDP)
      ->get();

      $showData = Project::find($IDP);

      $sommerepartie= DB::table('rallongebudgets')
      ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
      ->Where('rallongebudgets.projetid', $IDP)
      ->SUM('budgetactuel');
   
  
      $user=  DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
       ->Where('users.id', $showData->lead)
      ->get();

      

       // TOTAL Budget 
      $somme_budget= DB::table('rallongebudgets')
                ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
                ->Where('rallongebudgets.projetid', $IDP)
                ->SUM('budgetactuel');
      // Fin Budget 

      // FEB DATA

          $datasommefeb = DB::table('elementfebs')
          ->orderby('id', 'DESC')
          ->Where('projetids', $IDP)
          ->SUM('montant');

        $pourcentagefeb = round(($datasommefeb * 100) / $budget,2);
        $sommefeb = number_format($datasommefeb, 0, ',', ' ');

        if($pourcentagefeb == 100){
          $messageFEB='<center><span class="badge rounded-pill bg-primary font-size-11">Terminer</span></center>';
        }else{
          $messageFEB='<center><span class="badge rounded-pill bg-success font-size-11">Encours</span></center>';
        }


        // condition proccess close
     

      $output = '';
      if ($data->count() > 0) {
        $nombre = 1;
        // initier element dump process //
        $pourcatagesum=0;

        $pglobale = round(($somme_budget*100)/$showData->budget,2);

        if($sommerepartie == $showData->budget){
          $message='<center><span class="badge rounded-pill bg-primary font-size-11">Terminer</span></center>';
        }else{
          $message='<center><span class="badge rounded-pill bg-success font-size-11">Encours</span></center>';
        }

        $poursommerepartie = round(($sommerepartie*100)/$showData->budget,2);
        if($poursommerepartie == 100){
          $messageR='<center><span class="badge rounded-pill bg-primary font-size-11">Terminer</span></center>';
        }else{
          $messageR='<center><span class="badge rounded-pill bg-success font-size-11">Encours</span></center>';
        }

        $output .='

        <table class="table table-bordered  table-sm fs--1 mb-0">
        <tr scope="col">
          <td scope="col" style="padding:5px"><b>Rubrique du projet</b></td>
          <td scope="col" style="padding:5px"><b>Pays / region</b></td>
          <td scope="col" style="padding:5px"><b>N<sup>o</sup> Projet</b></td>
          <td scope="col" style="padding:5px"><b><center>Budget</center></b></td>
          <td scope="col" style="padding:5px"><b><center>%</center></b></td>
          <td scope="col" style="padding:5px"><b><center>Statut</center></b></td>
        </tr>
        <tr>
          <td style="padding:5px; width:50%">'.$showData->title.'</td>
          <td style="padding:5px">'.$showData->region.' </td>
          <td style="padding:5px">'.$showData->numeroprojet.' </td>
          <td style="padding:5px" align="right">'.number_format($showData->budget ,0, ',', ' ').'    </td>
          <td><center>100%</center></td>
          <td> '.$message.'</td>
        </tr>

        <tr>
          <td colspan="3" >Montant total repartie </td>
          <td style="padding:5px" align="right">'.number_format($somme_budget,0, ',', ' ').'   </td>
          <td><center>'.$pglobale.' %</center></td>
        <td> '.$messageR.'</td>
        </tr>

        <tr>
        <td colspan="3" >Montant encours de consommation</td>
        <td style="padding:5px" align="right">'.$sommefeb.' </td>
        <td><center>'.$pourcentagefeb.' %</center></td>
        <td> '.$messageFEB.'</td>
      </tr>
      </table>
      <br>
        ';

        $output .= '
        <table id="dtHorizontalVerticalExample" class="table table-striped table-bordered table-sm " cellspacing="0"
        width="100%">
        <thead>
          <tr >
            <th ><b>#</b></th>
            <th  style="padding:5px"><b>Code</b></th>
            <th style="width:30%"><b>Descriptiom ligne budgétaire</b></th>
            <th ><center><b>Budget</b></center></th>
        ';

            for($i=1; $i<=$periode ; $i++){

              $output .='<th > <center><b>T'.$i.'</b></center></th>';
            }

         

            
         
        $output .='<th class="sort border-top ps-3"><center> <B>Dépense</B></center></th>
            <th  ><b>%</b> </th>
          </tr>
        </thead>
        <tbody>';

       
     
        foreach ($data as $datas) {
          // TOTAL BUDBET
          $somme_budget_ligne= DB::table('rallongebudgets')
          ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
          ->Where('rallongebudgets.projetid', $IDP)
          ->where('rallongebudgets.compteid', $datas->id)
          ->SUM('rallongebudgets.budgetactuel');


          if($somme_budget_ligne !=0){
         
          $output .= 
          '<tr style="background-color:#F5F5F5">
            <td><b>'.$nombre.'</b></td>
            <td><b>' . ucfirst($datas->numero) . '</b></td>
            <td><b>' . ucfirst($datas->libelle) . '</b></td>
            <td align="right"><b>'. number_format($somme_budget_ligne,0, ',', ' ').' </b></td>
            

            ';

            for($i=1; $i<=$periode ; $i++){
              $tglign= 'T'.$i;
              $somme_TMOntant= DB::table('elementfebs')
              ->Where('tperiode', $tglign)
              ->Where('projetids', $IDP)
              ->Where('grandligne', $datas->id)
              ->SUM('montant');

              $output .='<td align="right"><b>'. number_format($somme_TMOntant,0, ',', ' ').' </b></td>';
              
            }
            
            $total_TMOntant= DB::table('elementfebs')
             
              ->Where('projetids', $IDP)
              ->Where('grandligne', $datas->id)
              ->SUM('montant');
              if($somme_budget_ligne==0){
                $pourcentagelignetotal =0;
              }else{
                $pourcentagelignetotal=($total_TMOntant*100)/$somme_budget_ligne;
              }
                
         
           $output .='

           
           
            <td align="right"><b>'. number_format($total_TMOntant,0, ',', ' ').' </b></td>
            <td align="right">'.round($pourcentagelignetotal,2).'% </td>
          </tr>';
          // recuperation element de la ligne
          $sous_compte = DB::table('rallongebudgets')
          ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
          ->select('rallongebudgets.*', 'comptes.libelle','comptes.numero')
          ->Where('rallongebudgets.projetid', $IDP)
          ->where('rallongebudgets.compteid', $datas->id)
          ->get();

        if ($sous_compte->count() > 0) {
          $ndale = 1;
          foreach ($sous_compte as $sc) {
            
             $ids = Crypt::encrypt($sc->id); 
            $route = route('showligne', $ids);

            if($showData->autorisation==1){
                $showme='<center> 
                <a  href="'.$route.'" class="edit-link"  title="Revision budgétaire"><i class="fa fa-edit"></i> </a> 
              </center>';
            }else{
              $showme='';
            }

            if($sc->retruction==1){
              $difference="difference";
              $url= '<a href="'.$sc->urldoc.'" target="_blank" title="Aller voir les condictions"><i class="fas fa-external-link-alt text-success"></i></a>';

          }else{
            $difference='';
            $url="";
          }
            
            
           
            // <a href="#" id="' . $sc->id . '" class="text-success mx-1 ssavesc" data-bs-toggle="modal" data-bs-target="#addssousDealModal"><i class="fa fa-plus-circle"></i> </a>
            $output .= '

            
                  <tr class="'.$difference.'">
                    <td class="align-left" style="background-color:#F5F5F5">
                      '.$showme.'
                    </td>
                    <td>' . ucfirst($sc->numero) .'</td>
                    <td  style="width:400px"> ' . ucfirst($sc->libelle) .' '.$url.' </td>
                    <td align="right">' . number_format($sc->budgetactuel,0, ',', ' ').' </td>
                    ';

                      for($i=1; $i<=$periode ; $i++){

                        $RefT='T'.$i;

                        // MONTANT TOTAL PAR T
                        $TMOntant= DB::table('elementfebs')
                            ->Where('tperiode', $RefT)
                            ->Where('projetids', $IDP)
                            ->Where('grandligne', $sc->compteid)
                            ->Where('eligne', $sc->souscompte)
                            ->SUM('montant');

                        $output .='<td  align="right"> ' . number_format($TMOntant,0, ',', ' ').'  </td>
                        ';
                     
                      }

                      // MONTANT GLOBALE DES TS
                      $montantGlobaledepense= DB::table('elementfebs')
                      ->Where('projetids', $IDP)
                      ->Where('grandligne', $sc->compteid)
                      ->Where('eligne', $sc->souscompte)
                      ->SUM('montant');
                      // FIN

                      // POURCENTAGE PAR LIGNE 

                      $POURCENTAGEPARLIGNE = ($montantGlobaledepense*100)/$sc->budgetactuel;
                      
        $output .='
                  <td  align="right"> ' . number_format($montantGlobaledepense,0, ',', ' ').' </td>
                   <td align="right">'. round($POURCENTAGEPARLIGNE,2) .'%</td>
                  </tr>
            ';
            $ndale++;
          }
        }
        }
          $nombre++;
        
      }
          $output .=' 
          </tbody>
          </table>' ; 
        
        echo $output;
       
      }
    }
  
    // insert a new rallongement request
    public function store(Request $request)
    {


      try {
        $ID = session()->get('id');
        $compte =$request->compteid;
        $scompte =$request->scomptef;
        $check = Rallongebudget::where('compteid',$compte)
        ->where('souscompte', $scompte)
        ->where('projetid', $ID)
        ->first();
        
        if($check){
          return response()->json([
            'status' => 203,
          ]);
        }else{
  

      $IDP = session()->get('id');
      $budget =session()->get('budget');

        // TOTAL Budget 
        $somme_budget= DB::table('rallongebudgets')
        ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
        ->Where('rallongebudgets.projetid', $IDP)
        ->SUM('budgetactuel');


        if ($request->has('customSwitch1')) {
              $retruction = 1;
          } else {
            $retruction = 0;
          }
  
      // Vérification de l'existence et du remplissage de l'URL du document
      if ($request->filled('urldoc')) {
          $urldocValue = $request->input('urldoc');
         
      } else {
        $urldocValue="";
      }

        $globale = $request->budgetactuel+$somme_budget;

        // condition initier proccesse bugdetisation
        // retruction initial 1
        // retruction d'acception 2
        // retruction non valide 0

        if($budget >= $globale){
          $rallonge = new Rallongebudget;
          $rallonge->projetid = $request->projetid;
          $rallonge->compteid = $request->compteid;
          $rallonge->souscompte = $request->scomptef;
          $rallonge->budgetactuel = $request->budgetactuel; 
          $rallonge->retruction = $retruction; 
          $rallonge->urldoc = $urldocValue;
          $rallonge->typeprojet = $request->typeprojet; 
          $rallonge->userid = Auth()->user()->id;
          $rallonge->save();
    
          return response()->json([
            'status' => 200,
          ]);

        }else{
          return response()->json([
            'status' => 201,
          ]);
        }
      }

      } catch (Exception $e) {
        return response()->json([
          'status' => 202,
        ]);
      }

   
    }

    public function storesc(Rallongebudget $gl, Request $request)
    {
      $gl->projetid = $request->cid;
      $gl->compteid = $request->code;
      $gl->depensecumule = $request->libelle; 
      $gl->budgetactuel = $request->libelle; 
      $gl->userid = Auth()->user()->id;
      $gl->save();
      return response()->json([
        'status' => 200,
      ]);
    }


    public function updatlignebudget(Request $request)
    {
      $IDP = session()->get('id');
      $budget =session()->get('budget');

        // TOTAL Budget 
        $somme_budget= DB::table('rallongebudgets')
        ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
        ->Where('rallongebudgets.projetid', $IDP)
        ->SUM('budgetactuel');
        
        $globale = $somme_budget-$request->ancienmontantligne;

        $globale = $request->montantligne+$globale;

        if($budget >= $globale){
        $MisesA = Rallongebudget::find($request->id);
        $MisesA ->budgetactuel	= $request->montantligne;
        $MisesA ->update();
          
        if ($MisesA ) {

        $updateligne = Compte::find($request->souscompteid);
        $updateligne ->numero	= $request->code;
        $updateligne ->libelle	= $request->titreligne;
        $updateligne ->update();


          return redirect()->route('rallongebudget')->with('success', 'Très bien! le budgetaire  est bien modifier');
      } else {
          return back()->with('failed', 'Echec ! lle budgetaire  n\'est pas creer ');
      }
    }else{
      return back()->with('failed', 'Attention ! Vous ne devez pas depasser le montant du budget  global ');
    }
    }


   



     // SHOW ELEMENT
     public function show($key)
     {
      $key = Crypt::decrypt($key); 

       $dataJon =DB::table('rallongebudgets')
          ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
          ->select('rallongebudgets.*', 'comptes.libelle', 'comptes.numero')
          ->where('rallongebudgets.id', $key)
          ->get();

          return view('rallonge.viewligne',
          [
            'title' =>'Revision ligne budgetaire',
            'dataJon' => $dataJon
          ]
        );
         
      // return response()->json($datar);
     }
  
    // edit an service ajax request
    public function addsc(Request $request)
    {
      $id = $request->id;
      $fon = Rallongebudget::find($id);
      return response()->json($fon);
    }


  
    // update an service ajax request
    public function update(Request $request)
    {
      $emp = Rallongebudget::find($request->gc_id);
      $emp->gc_title = $request->gc_title;
      $emp->update();
      
      return response()->json([
        'status' => 200,
      ]);
    }


    public function findSousCompte(Request $request){
      try {
        $ID = session()->get('id');
        $data=Compte::where('compteid', $request->id)
        ->where('souscompteid', '=', 0)
        ->where('projetid', $ID)
        ->get();
     
        return response()->json($data);

     
      } catch (Exception $e) {
        return response()->json([
          'status' => 202,
        ]);
      }
       
	}

  public function condictionsearch(Request $request){
    try {
      $ID = session()->get('id');
      $comp= $request->id;
      $compp=explode("-", $comp);
     
      $grandcompte = $compp[0];
      $souscompte  = $compp[1];
      
      $data = DB::table('rallongebudgets')
      ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
      ->select('rallongebudgets.*', 'comptes.libelle','comptes.numero')
      ->Where('rallongebudgets.projetid', $ID)
      ->where('rallongebudgets.souscompte', $souscompte)
      ->get();
      
   
      $output = '';
      if ($data->count() > 0) 
      {
        foreach ($data as $key => $datas) 
        {
          if($datas->retruction==1){

            $output .= '
            <br>
           <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="mdi mdi-block-helper me-2"></i>
            Attention! Cette ligne est soumise aux conditions d\'utilisation , <a href="'.$datas->urldoc.'" target="_blank"><i class="fas fa-external-link-alt text-success"></i></a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>

          ';

          }else{
            $output .= '<i class="fa fa-info-circle" ></i>  Il n\'y a pas des condictions d\'utilisation';
          }

        } 
        echo $output;

      }
      else{
        echo ' <tr>
          <td colspan="3">
          <center>
            <h6 style="margin-top:1% ;color:#c0c0c0"> 
            <center><font size="50px"><i class="fa fa-info-circle"  ></i> </font><br><br>
           Ceci est vide  !</center> </h6>
          </center>
          </td>
          </tr>';
              
      }
   
    } catch (Exception $e) {
      return response()->json([
        'status' => 202,
      ]);
    }
     
}

  


  
    public function deleterb($id)
    {
        $rallonge = Rallongebudget::findOrFail($id);
        $rallonge->delete();
        return redirect()->route('rallongebudget')->with('success', 'Element supprimé avec succès.');
    }



}
