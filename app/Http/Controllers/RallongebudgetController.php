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
    
      $title = 'Budgetisation';
      $compte= Compte::all();
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


      return view('rallonge.index',
        [
          'title' => $title,
          'compte' => $compte,
          'showData' => $showData,
          'userData' => $user,
          'sommerapartie' =>  $sommerepartie
        ]
      );
    }


    public function fetchAll()
    {
      $IDP = session()->get('id');
      $devise =session()->get('devise');
      $budget =session()->get('budget');

      $data = DB::table('rallongebudgets')
                ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
                ->select('rallongebudgets.*', 'comptes.libelle', 'comptes.numero')
                ->Where('rallongebudgets.projetid', $IDP)
                ->orderBy('rallongebudgets.id', 'ASC')
                ->get();
      

       // TOTAL Budget 
      $somme_budget= DB::table('rallongebudgets')
                ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
                ->Where('rallongebudgets.projetid', $IDP)
                ->SUM('budgetactuel');
      // Fin Budget 


      // depense total t1 
      $depenseT1= DB::table('elementfebs')
      ->Where('tperiode', 'T1')
      ->Where('projetids', $IDP)
      ->SUM('montant');

      //fin


      // depense total t2
      $depenseT2= DB::table('elementfebs')
      ->Where('tperiode', 'T2')
      ->Where('projetids', $IDP)
      ->SUM('montant');
      //fin

      // depense total t3
      $depenseT3= DB::table('elementfebs')
      ->Where('tperiode', 'T3')
      ->Where('projetids', $IDP)
      ->SUM('montant');
      //fin

      // depense total 4

      $depenseT4= DB::table('elementfebs')
      ->Where('tperiode', 'T4')
      ->Where('projetids', $IDP)
      ->SUM('montant');

      //fin
      // total all
      $alldepense = $depenseT1+$depenseT2+$depenseT3+$depenseT4;

      // poucentage all

      $alldepense_pourcentage = round(($alldepense*100)/$budget);



      $output = '';
      if ($data->count() > 0) {
        $nombre = 1;
       
        foreach ($data as $datas) {
          $id = $datas->id;
          $ligne = $datas->compteid;


          // T1 SOMME

          $T1= DB::table('elementfebs')
          ->Where('tperiode', 'T1')
          ->Where('projetids', $IDP)
          ->Where('eligne', $ligne)
          ->SUM('montant');


          // FIN 


           // T2 SOMME

           $T2= DB::table('elementfebs')
           ->Where('tperiode', 'T2')
           ->Where('projetids', $IDP)
           ->Where('eligne', $ligne)
           ->SUM('montant');
 
 
           // FIN 


            // T1 SOMME

          $T3= DB::table('elementfebs')
          ->Where('tperiode', 'T3')
          ->Where('projetids', $IDP)
          ->Where('eligne', $ligne)
          ->SUM('montant');


          // FIN 



           // T4 SOMME

           $T4= DB::table('elementfebs')
           ->Where('tperiode', 'T4')
           ->Where('projetids', $IDP)
           ->Where('eligne', $ligne)
           ->SUM('montant');
 
 
           // FIN 

           //total depense

           $total_T = $T1+$T2+$T3+$T4;

           // fin


           // poucentage depense

           $pourcentage_depense =round(($total_T*100)/$budget);



         
          $montant_budget = number_format($datas->budgetactuel,0, ',', ' ');
       
          $output .= 
          '<tr>
              <td>  ' .$datas->numero.'&nbsp;&nbsp;&nbsp; '.ucfirst($datas->libelle). '   </td>
              <td align="right"> ' . $montant_budget.' '.$devise.'</td>
              <td align="right"> ' . $T1 .' '.$devise.'</td>
              <td align="right"> ' . $T2 .' '.$devise.' </td>
              <td align="right"> ' . $T3 .' '.$devise.' </td>
              <td align="right"> ' . $T4 .' '.$devise.'</td>
              <td align="right"> ' . $total_T  .' '.$devise.'</td>
              <td align="right"> ' . $pourcentage_depense  .'% </td>
            </tr>
          ';
          $nombre++;
         
        }
        
        $output .= '<tr>
        <td><b>Total</b></td>
        <td align="right">'.$somme_budget.' '.$devise.'</td>
        <td align="right">'.$depenseT1.' '.$devise.'</td>
        <td align="right">'.$depenseT2.' '.$devise.' </td>
        <td align="right">'.$depenseT3.' '.$devise.'</td>
        <td align="right">'.$depenseT4.' '.$devise.'</td>
        <td align="right">'.$alldepense.' '.$devise.'</td>
        <td align="right">'.$alldepense_pourcentage.'%</td>
        </tr>';
       
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
        </tr>
     ';
      }
    }
  
    // insert a new rallongement request
    public function store(Request $request)
    {


      try {
        $compte =$request->compteid;
        $check = Rallongebudget::where('compteid',$compte)->first();
        
        if($check){
          return response()->json([
            'status' => 203,
          ]);
        }else{
  

      $IDP = session()->get('id');
      $budget =session()->get('budget');

        // TOTAL Budget 
        $somme_budget= DB::table('rallongebudgets')
        ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
        ->Where('rallongebudgets.projetid', $IDP)
        ->SUM('budgetactuel');

        $globale = $request->budgetactuel+$somme_budget;

        if($budget >= $globale){
          $rallonge = new Rallongebudget;
          $rallonge->projetid = $request->projetid;
          $rallonge->compteid = $request->compteid;
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


   

   
  
    // supresseion
    public function deleteall(Request $request)
    {
      $id = $request->id;
      Rallongebudget::destroy($id);
    }



}
