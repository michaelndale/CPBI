<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\Project;
use App\Models\Rallongebudget;
use Exception;
use Illuminate\Http\Request;
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
      
     

      return view('rallonge.index',
        [
          'title' => $title,
          'compte' => $compte,
          'periode' => $periode
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


     

      $output = '';
      if ($data->count() > 0) {
        $nombre = 1;
        $pourcatagesum=0;

        $pglobale = round(($somme_budget*100)/$showData->budget);

        if($sommerepartie == $showData->budget){
          $message='<center><span class="badge rounded-pill bg-primary font-size-11">Terminer</span></center>';
        }else{
          $message='<center><span class="badge rounded-pill bg-success font-size-11">Encours</span></center>';
        }

        $output .='

        <table class="table table-bordered  table-sm fs--1 mb-0">
        <tr scope="col" >
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
          <td style="padding:5px" align="right">'.number_format($showData->budget ,0, ',', ' ').' '.$showData->devise.'   </td>
          <td><center>'.$pglobale.' %</center></td>
          <td> '.$message.'</td>
        </tr>

        <tr>
          <td colspan="3" >Montant total repartie </td>
          <td style="padding:5px" align="right">'.number_format($somme_budget,0, ',', ' ').' '.$showData->devise.'  </td>
         
          <td colspan="2" style="background-color:#c0c0c0"></td>
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
            <th ><b>Code</b></th>
            <th ><b>Ligne budgétaire</b></th>
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
            <td align="right"><b>'. number_format($somme_budget_ligne,0, ',', ' ').' '.$devise.'</b></td>
            

            ';

            for($i=1; $i<=$periode ; $i++){
              $tglign= 'T'.$i;
              $somme_TMOntant= DB::table('elementfebs')
              ->Where('tperiode', $tglign)
              ->Where('projetids', $IDP)
              ->Where('grandligne', $datas->id)
              ->SUM('montant');

              $output .='<td align="right"><b>'. number_format($somme_TMOntant,0, ',', ' ').' '.$devise.'</b></td>';
              
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

           
           
            <td align="right"><b>'. number_format($total_TMOntant,0, ',', ' ').' '.$devise.'</b></td>
            <td align="right">'.round($pourcentagelignetotal).'% </td>
          </tr>';
          // recuperation element de la ligne
          $sous_compte = DB::table('rallongebudgets')
          ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
          ->Where('rallongebudgets.projetid', $IDP)
          ->where('rallongebudgets.compteid', $datas->id)
          ->get();

        if ($sous_compte->count() > 0) {
          $ndale = 1;
          foreach ($sous_compte as $sc) {
            $ids = $sc->id;

             
           
            
           
            // <a href="#" id="' . $sc->id . '" class="text-success mx-1 ssavesc" data-bs-toggle="modal" data-bs-target="#addssousDealModal"><i class="fa fa-plus-circle"></i> </a>
            $output .= '
                  <tr>
                    <td class="align-left" style="background-color:#F5F5F5"></td>
                    <td>' . ucfirst($sc->numero) . '</td>
                    <td>' . ucfirst($sc->libelle) . '</td>
                    <td align="right">' . number_format($sc->budgetactuel,0, ',', ' ').' '.$devise.'</td>
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

                        $output .='<td  align="right"> ' . number_format($TMOntant,0, ',', ' ').' '.$devise.' </td>
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
                  <td  align="right"> ' . number_format($montantGlobaledepense,0, ',', ' ').' '.$devise.'</td>
                   <td align="right">'. round($POURCENTAGEPARLIGNE) .'%</td>
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

        $globale = $request->budgetactuel+$somme_budget;

        if($budget >= $globale){
          $rallonge = new Rallongebudget;
          $rallonge->projetid = $request->projetid;
          $rallonge->compteid = $request->compteid;
          $rallonge->souscompte = $request->scomptef;
          $rallonge->budgetactuel = $request->budgetactuel; 
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

   

     // edit an service ajax request
     public function edit(Request $request)
     {
       $id = $request->id;
       $fon = Rallongebudget::find($id);
       return response()->json($fon);
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


   

   
  
    // supresseion
    public function deleteall(Request $request)
    {
      $id = $request->id;
      Rallongebudget::destroy($id);
    }



}
