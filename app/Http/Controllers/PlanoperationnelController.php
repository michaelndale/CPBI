<?php

namespace App\Http\Controllers;

use App\Models\Elementplanoperationnel;
use App\Models\Planoperationnel;
use App\Models\realisation;
use App\Models\Realisationplan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlanoperationnelController extends Controller
{

  public function index()
  {
    $title  = "Plan d'action ";

    return view(
      'planoperationnel.index',
      [
        'title' => $title,

      ]
    );
  }


  public function save(Request $request)
  {

    try {
      $IDP = session()->get('id');
      $plan = new Planoperationnel();
      $plan->categorie = $request->categorie;
      $plan->periode = $request->periode;
      $plan->projetid = $IDP;
      
      $plan->save();

      $IP = $plan->id;
      // insersion module elments de details
      foreach ($request->numero as $key => $items) {

        $elementplan = new Elementplanoperationnel();
        $elementplan->projetref          =  $IDP;
        $elementplan->plano              =  $IP;
        $elementplan->activite           =  $request->activite[$key];
        $elementplan->lieu               =  $request->lieu[$key];
        $elementplan->categoriebenpre    =  $request->categoriebenpre[$key];

        $elementplan->hommebenprev    =  $request->hommebenprev[$key];
        $elementplan->femmebenprev   =  $request->femmebenprev[$key];
        $elementplan->dateprev    =  $request->datefin[$key];

        $elementplan->nombrebenpre       =  $request->nombrebenpre[$key];
        $elementplan->nombreseancepre    =  $request->nombreseancepre[$key];

        $elementplan->save();
      }

      return response()->json([
        'status' => 200,

      ]);
    } catch (Exception $e) {
      return response()->json([
        'status' => 202,
      ]);
    }
  }


  public function saverealisation(Request $request)
  {

    try {

      $IDP = session()->get('id');

      $realisaction = new Realisationplan();

      $realisaction->planid = $request->planid;
      $realisaction->activiteid = $request->activiteid;
      $realisaction->nombrehomme = $request->nombrehomme;
      $realisaction->nombrefemme = $request->nombrefemme;
      $realisaction->nombreseance = $request->nombreseance;
      $realisaction->daterea = $request->dateday;
      $realisaction->projeid = $IDP;

      $realisaction->save();

      return response()->json([
        'status' => 200,

      ]);
    } catch (Exception $e) {
      return response()->json([
        'status' => 202,
      ]);
    }
  }


  public function fetchAll()
  {
    $ID = session()->get('id');
    $data = DB::table('planoperationnels')

      ->Where('projetid', $ID)
      ->get();

    $output = '
      <table class="table table-bordered  table-sm fs--1 mb-0">
      <tr>
        <th colspan="8"> <center>Prévision </center></th>
        <th colspan="3"><center>Réalisation</center></th>
      </tr>
      <tr style="background-color:#DCDCDC"> 
      <th style="width:50px">N<sup>o</sup></th>
      <th style="width:300px">Catégorie</th>
      <th style="width:300px">Activité</th>
      <th style="width:150px">Lieu</th>
      <th style="width:100px"align="left">Catégorie des bénéficiaires</th>
      <th style="width:50px" colspan="3" >Nombre  des bénéficiaires</th>
      <th style="width:150px">Nombre de séances</th>
      <th style="width:150px">Reste à la date du jour</th>
      <th style="width:50px" colspan="3">Nombre des bénéficiaires</th>
      <th style="width:150px">Nombre de séances</th>
      <th style="width:150px">Reste à la date du jour</th>
      <th style="width:50px" colspan="3" >Bénéficiaires</th>
    </tr>
        <th colspan="5" style="background-color:#DCDCDC" > </th>
        <th style="width:100px"align="left">Homme</th>
        <th style="width:100px"align="left">Femme</th>
        <th style="width:100px"align="left">Total</th>
      
        <th colspan="2" style="background-color:#DCDCDC"></th>
      
        <th style="width:100px"align="left">Homme</th>
        <th style="width:100px"align="left">Femme</th>
        <th style="width:100px"align="left">Total</th>
        <th colspan="2" style="background-color:#DCDCDC"></th>
        <th style="width:100px"align="left">Homme</th>
        <th style="width:100px"align="left">Femme</th>
        <th style="width:100px"align="left">Total</th>
        
      </tr>
    <tbody>';
    if ($data->count() > 0) {
      $nombre = 1;
      foreach ($data as $datas) {

        $showelement = DB::table('elementplanoperationnels')
          ->Where('plano', $datas->id)
          ->get();
        $count = $showelement->count() + 1;
        $output .= '
          <tr>
            <td rowspan="' . $count . '" >' . $nombre . '</td>
            <td rowspan="' . $count . '" >' . ucfirst($datas->categorie) . ' 
              
              <a href="javascript::(void)" class="editerPlan"  id="' . $datas->id . '"  data-bs-toggle="modal" data-bs-target="#modification"> Modifier prévision</a> <br>

              <a href="javascript::(void)" class="deletePlan"  id="' . $datas->id . '"> Supprimer le plan d\'action </a>
            </td>
          </tr>
          ';
        foreach ($showelement as $key => $showelements) {
          $output .= ' 
                        <tr>
                            <td>' . ucfirst($showelements->activite) . '
                            <a href="javascript::(void)" class="ajouterplan" id="' . $showelements->id . '"  data-bs-toggle="modal" data-bs-target="#ajouterrelisation"> Ajouter la réalisation</a><br>
                            </td>
                            <td>' . ucfirst($showelements->lieu) . '</td> 
                            <td>
                            ' . ucfirst($showelements->categoriebenpre) . '
                           
                            </td> 
                            <td>' .$showelements->hommebenprev. '</td> 
                            <td>' .$showelements->femmebenprev. '</td> 
                            <td>' . $showelements->hommebenprev+$showelements->femmebenprev . '</td>
                            <td>' . ucfirst($showelements->nombreseancepre) . '</td> 
                            <td>' . ucfirst($showelements->nombreseancepre) . '</td> 
                            
                            ';
                            

                            $realisation = DB::table('realisationplans')
                            ->Where('planid', $showelements->plano)
                            ->Where('activiteid', $showelements->id)
                            ->get();

                            foreach ($realisation as $key => $realisations) { 
                              $output .= '   
                              <td>' . $realisations->nombrehomme . '</td>
                              <td>' . $realisations->nombrefemme . '</td>
                              <td>' . $realisations->nombrehomme+$realisations->nombrefemme. '</td>
                               ';
                              
                            
                            }

                            
                            
                            if(isset($showelements->planid)){ $pland = $showelements->planid;}
                            else{ $pland = 0; }

                            if(isset($showelements->activiteid)){ $activ= $showelements->activiteid;}
                            else{ $activ = 0; }


                            $comparaisonbe =  DB::table('realisationplans')
                                            ->join('elementplanoperationnels','realisationplans.planid', '=','elementplanoperationnels.plano')
                                            ->select('realisationplans.*','elementplanoperationnels.*')
                                            ->Where('realisationplans.planid', $pland)
                                            ->Where('realisationplans.activiteid', $activ)
                                            ->get();

                                         

                                            foreach ($realisation as $key => $realisations) { 
                                              $output .= '  
                                              <td>' .$realisations->nombreseance. '</td>
                                              <td>' .$realisations->nombreseance . '</td> 
                                              <td>' .$showelements->hommebenprev-$realisations->nombrehomme . '</td>
                                              <td>' . $showelements->femmebenprev-$realisations->nombrefemme . '</td>
                                              <td>' . ($showelements->hommebenprev+$showelements->femmebenprev)-($realisations->nombrehomme+$realisations->nombrefemme) . '</td>
                                               ';
                            }
                            $output .= '   
                             
                        </tr>
                        ';
        }
        ' 
                   
               
              
                </tbody>
              
                </table>
            

        
        ';
        $nombre++;
      }
      echo $output;
    } else {
      echo
      '
        
        <center>
          <h6 style="margin-top:1% ;color:#c0c0c0"> 
          <center><font size="50px"><i class="fa fa-info-circle"  ></i> </font><br><br>
          Ceci est vice !</center> </h6>
        </center>
        
        
        ';
    }
  }

  // edit an employee ajax request
  public function showplanElement(Request $request)
  {
    $id = $request->id;
    $fon = Elementplanoperationnel::find($id);
  
    return response()->json($fon);
  }

  // supresseion
  public function deletePlan(Request $request)
  {
    $id = $request->id;
    $del=Planoperationnel::destroy($id);
    
    if($del){
      Elementplanoperationnel::where('plano', $id)->delete();
      Realisationplan::where('planid', $id)->delete();
    }
  }
}
