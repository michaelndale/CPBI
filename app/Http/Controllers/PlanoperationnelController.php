<?php

namespace App\Http\Controllers;

use App\Models\Elementplanoperationnel;
use App\Models\Planoperationnel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlanoperationnelController extends Controller
{

    public function index()
    {
      $title  = 'Plan operationnelle';
     
      return view(
        'planoperationnel.index',
        [
          'title' => $title,
          
        ]
      );
    }
  

    public function save(Request $request){ 

    try {
           $IDP = session()->get('id');
            $plan= new Planoperationnel();
            $plan->categorie = $request->categorie;
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

    public function fetchAll()
    {
      $ID = session()->get('id');
      $data = DB::table('planoperationnels')
       
        ->Where('projetid', $ID)
        ->get();
  
      $output = '
      <table class="table table-bordered  table-sm fs--1 mb-0">
      <table class="table table-bordered  table-sm fs--1 mb-0">
      <tr>
        <th colspan="5"></th>
        <th colspan="3"> <center>Prévision </center></th>
        <th colspan="3"><center>Réalisation</center></th>
      </tr>

      <tr style="background-color:#DCDCDC"> 
        <th style="width:50px">N<sup>o</sup></th>
        <th style="width:300px">Catégorie</th>
        <th style="width:300px">Activité</th>
        <th style="width:150px">Lieu</th>
        <th style="width:100px"align="left">Catégorie des bénéficiaires</th>
        <th style="width:50px">Nombre des bénéficiaires</th>
        <th style="width:150px">Nombre de séances</th>
        <th style="width:150px">Reste à la date du jour</th>
        <th style="width:50px">Nombre des bénéficiaires</th>
        <th style="width:150px">Nombre de séances</th>
        <th style="width:150px">Reste à la date du jour</th>
      </tr>
<tbody>';
      if ($data->count() > 0) {
        $nombre = 1;
        foreach ($data as $datas) {
  
          $showelement= DB::table('elementplanoperationnels')
            ->Where('plano', $datas->id)
            ->get();
        $count =$showelement->count()+1;
          $output.= '
        
         
          <tr>
            <td rowspan="'.$count.'" >'.$nombre.'</td>
            <td rowspan="'.$count.'" >'. ucfirst($datas->categorie).' 
            <a href="" class="AjouterPlan" id="'.$datas->id.'"  data-bs-toggle="modal" data-bs-target="#Ajouterrelisation" > Ajouter la Realisation</a><br>
            <a href="" class="editerPlan" id="'.$datas->id.'" data-bs-toggle="modal" data-bs-target="#modification" > Modifier</a> <br>
            <a href="" class="deletePlan" id="'.$datas->id.'" > Supprimer</a>
            
            </td>
          </tr>

          
                    ';
                    foreach ($showelement as $key => $showelements) 
                    {
                        $output.=' 
                        <tr>
                            <td>'.ucfirst($showelements->activite).'</td>
                            <td>'.ucfirst($showelements->lieu).'</td> 
                            <td>'.ucfirst($showelements->categoriebenpre).'</td> 
                            <td>'.ucfirst($showelements->nombrebenpre).'</td> 
                            <td>'.ucfirst($showelements->nombreseancepre).'</td> 
                            <td>'.ucfirst($showelements->restejourpre).'</td> 
                            <td>'.ucfirst($showelements->nombrebenrev).'</td> 
                            <td>'.ucfirst($showelements->nombreseanrev).'</td> 
                            <td>'.ucfirst($showelements->restejourrev).'</td> 
                        </tr>
                        ';
                    }' 
                   
               
              
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
          <center><font size="50px"><i class="far fa-trash-alt"  ></i> </font><br><br>
          Ceci est vice !</center> </h6>
        </center>
        
        
        ';
      }
    }

     // edit an employee ajax request
     public function showplan(Request $request)
     {
       $id = $request->id;
       $fon = Planoperationnel::find($id);
       return response()->json($fon);
     }
}
