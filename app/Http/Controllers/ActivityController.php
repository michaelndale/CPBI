<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Catactivity;
use App\Models\Compte;
use App\Models\Folder;
use App\Models\Historique;
use App\Models\Notification;
use App\Models\Project;
use App\Models\Rallongebudget;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function index ()
    {
      $title='Activite';
     
      $dataProjet = Project::all();
   

      $ID = session()->get('id');
      $compte = DB::table('rallongebudgets')
              ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
              ->Where('rallongebudgets.projetid', $ID)
              ->get();

           
       

      return view('activite.index', 
        [
          'title' =>$title,
          'dataProject' => $dataProjet,
         
         
          'compte' => $compte,
      ]);
    }

    public function fetchAll()
    {
      $devise =session()->get('devise');
      $ID = session()->get('id');
      $act = DB::table('activities')
            ->orderby('id','DESC')
            ->Where('projectid', $ID)
            ->get();

            $somme_activite= DB::table('activities')
            ->Where('projectid', $ID)
            ->SUM('montantbudget');

           
               
      $output = '';
      if ($act->count() > 0) {
       
        $nombre = 1;
        foreach ($act as $rs) {
          if($rs->etat_activite=="Annuler"){ $color ='#F08080'; $class='danger' ;}
      

         elseif($rs->etat_activite=="Terminée"){
          $color=''; $class='primary';
         }

         elseif($rs->etat_activite=="Contrainte"){
          $color=''; $class='warning';
         }

         elseif($rs->etat_activite=="Encours"){
          $color=''; $class='info';
         }

         else{

         }
          
          $output .= '
            <tr style="background-color:'.$color.'">
              <td class="align-middle ps-3 name">' . $nombre . '</td>
              <td>
              <center>
               
                <div class="btn-group me-2 mb-2 mb-sm-0">
                  <a  data-bs-toggle="dropdown" aria-expanded="false">
                       <i class="mdi mdi-dots-vertical ms-2"></i>
                  </a>
                  <div class="dropdown-menu">
                  <a class="dropdown-item text-success mx-1 editIcon " id="' . $rs->id . '"  data-bs-toggle="modal" data-bs-target="#AddCommenteModale" title="Modifier"><i class="ri-wechat-line"></i> Ajouter un onbservation</a>
                      <a class="dropdown-item text-primary mx-1 editIcon " id="' . $rs->id . '"  data-bs-toggle="modal" data-bs-target="#EditModale" title="Modifier"><i class="far fa-edit"></i> Modifier</a>
                      <a class="dropdown-item text-danger mx-1 deleteIcon"  id="' . $rs->id . '"  href="#"><i class="far fa-trash-alt"></i> Supprimer</a>
                  </div>
               </div>
              

              </td>
              <td>' . ucfirst($rs->titre). '
              <a href="#" id="' . $rs->id . '" class="text-success mx-1 observationshow" data-bs-toggle="modal" data-bs-target="#TableCommenteModale" title="Observation" ><i class="ri-wechat-line"></i> </a>
              </td>
           
              <td align="right">' . number_format($rs->montantbudget,0, ',', ' ').' '. $devise.'</td>
              <td><center><span class="badge rounded-pill bg-'.$class.' font-size-11">' . ucfirst($rs->etat_activite). '</span></center></td>
              <td>' . date('d-m-Y', strtotime($rs->created_at)) . '</td>
              
            </tr>';
          $nombre++;
        }
        $output.='
        <tr>
          <td colspan="3">
            Total
          </td>
            <td align="right"> 
            
              <b> '.number_format($somme_activite,0, ',', ' ').' BIF</b>
            
            </td>
           
        </tr>';
        echo $output;
      } else {
        echo
            '
            <tr>
            <td colspan="6">
            <center>
              <h6 style="margin-top:1% ;color:#c0c0c0"> 
              <center><font size="10px"><i class="far fa-trash-alt"  ></i> </font><br><br>
              Ceci est vide  !</center> </h6>
            </center>
            </td>
            </tr>
            
            ';
      }
    }


  
      // insert a new ajax request
      public function store(Request $request )
      {

        try {

        $IDP = session()->get('id');
        $IDL = $request->compteid;
      
       $somme_budget_ligne= DB::table('rallongebudgets')
       ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
       ->Where('rallongebudgets.projetid', $IDP)
       ->Where('rallongebudgets.compteid', $IDL)
       ->SUM('rallongebudgets.budgetactuel');


       $somme_activite_ligne= DB::table('activities')
       ->Where('projectid', $IDP)
       ->Where('compteidr', $IDL)
       ->SUM('montantbudget');

      

       $montant_somme = $request->montant + $somme_activite_ligne;

       if($somme_budget_ligne >= $montant_somme ){
          $activity = new Activity();
          
          $activity->projectid = $request->projetid;
          $activity->compteidr = $request->compteid;
          $activity->titre = $request->titre;
          $activity->montantbudget= $request->montant;
          $activity->etat_activite= $request->etat;
          $activity->userid= Auth::id();

          $activity->save();

          return response()->json([
          'status' => 200,
          
          ]);
       }else{
        return response()->json([
          'status' => 201,
        ]);
        
       }

      } catch (Exception $e) {
        return response()->json([
          'status' => 202,
         // dd($e)
        ]);
      }
      
        
      }


      // Update a new ajax request
      public function update(Request $request )
      {
        try {
              $act = Activity::find($request->aid);

              $act->compteidr = $request->ligneact;
              $act->titre = $request->titreact;
              $act->montantbudget = $request->montantact;
              $act->etat_activite = $request->etatact;
              $act->userid =  Auth::id();

              $act->update();
              
              return response()->json([
                'status' => 200,
              ]);
          
        } catch (Exception $e) {
          return response()->json([
            'status' => 202,
          ]);
        
      
      }
        
       // $operation ="Nouveau activite: ".$request->title;
       // $link ='listactivity';
        //$notis->operation = $operation;
        ////$his->userid  = Auth()->user()->id;
       // $notis->link = $link;
       // $notis->save();


        $activity = new Activity();
        
        $activity->projectid = $request->projetid;
        $activity->compteidr = $request->compteid;
        $activity->titre = $request->titre;
        $activity->montantbudget= $request->montant;
        $activity->etat_activite= $request->etat;
        $activity->userid= Auth::id();

        $activity->save();

        return response()->json([
         'status' => 200,
         
        ]);
        
        
      }


   

    // edit an folder ajax request
  public function show(Request $request)
  {
    $id = $request->id;
    $fon =Activity::find($id);
  
    return response()->json($fon);
  }

    public function deleteall(Request $request,)
    {
      $his = new Historique;
      $function ="Supprimer";
      $operation ="Supprimer Activite ";
      $link ='history';
      $his->fonction = $function;
      $his->operation = $operation;
      $his->userid = Auth::id();
      $his->link = $link;
      $his->save();

      $id = $request->id;
      Activity::destroy($id);
    }
    
}
