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
      $compte = DB::table('comptes')
              ->Where('comptes.projetid', $ID)
              ->Where('compteid','=', 0)
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
      $ID = session()->get('id');
      $devise =session()->get('devise');
      $service = Compte::where('compteid', '=', 0)
        ->where('projetid', $ID)
        ->get();
      $output = '';
      if ($service->count() > 0) {
  
        $nombre = 1;
        foreach ($service as $rs) {
          $id = $rs->id;
          $output .= '<tr style="background-color:#F5F5F5">
                <td class="align-middle ps-3 name"><b>' . $nombre . '</td>
                <td><b>' . ucfirst($rs->numero) . '</b></td>
                <td colspan="5"><b>' . ucfirst($rs->libelle) . '</b></td>
              
              </tr>
              ';
  
          $sous_compte = Compte::where('compteid', $id)
            ->where('souscompteid', '=', 0)
            ->where('projetid', $ID)
            ->get();
          if ($sous_compte->count() > 0) {
            $ndale = 1;
            foreach ($sous_compte as $sc) {
              $ids = $sc->id;
  
              // <a href="#" id="' . $sc->id . '" class="text-success mx-1 ssavesc" data-bs-toggle="modal" data-bs-target="#addssousDealModal"><i class="fa fa-plus-circle"></i> </a>
              $output .= '
                    <tr>
                      <td class="align-left" style="background-color:#F5F5F5"></td>
                      <td style="width:15px">' . ucfirst($sc->numero) . '</td>
                      <td style="width:250px">' . ucfirst($sc->libelle) . '</td>
                      <td> ';

                      $act = DB::table('activities')
                            ->Where('projectid', $ID)
                            ->Where('compteidr', $ids)
                            ->orderby('id','DESC')
                            ->get();
                      $nombre = 1;
                      $output .= ' <table id="venteTable" class="table table-bordered table-striped mb-0 table-sm">';
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
                           $color=''; $class='success';
                          }
                          $output .= '
                          
                          <tr style="background-color:'.$color.'">
                            <td class="align-middle ps-3 name" >' . $nombre . '</td>
                            <td style="width:20px">
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
                            <td style="width:60%">  
                            ' . ucfirst($rs->titre). '
                            <span class="badge rounded-pill bg-'.$class.' font-size-11">' . ucfirst($rs->etat_activite). '</span>
                            <a href="#" id="' . $rs->id . '" class="text-success mx-1 observationshow" data-bs-toggle="modal" data-bs-target="#TableCommenteModale" title="Observation" ><i class="ri-wechat-line"></i> </a>
                            </td>
                         
                            <td align="right">' . number_format($rs->montantbudget,0, ',', ' ').' '. $devise.'</td>
                           
                           
                          </tr>';
                        $nombre++;

                        }
 
                        $output .= '</table> ';
                     
                  $output .= '</td>
                    </tr>
              ';
              $ndale++;
            }
  
  
            $sous_sous_compte = Compte::where('souscompteid', $ids)
              ->where('projetid', $ID)
              ->get();
            if ($sous_sous_compte->count() > 0) {
              $nd = 1;
              foreach ($sous_sous_compte as $ssc) {
                $output .= '
                  <tr>
                    <td class="align-middle ps-3 name">' . $nombre . '.' . $ndale . '.' . $nd . '</td>
                    <td>' . ucfirst($ssc->numero) . '</td>
                    <td>' . ucfirst($ssc->libelle) . '</td>
                    <td>
                     hello
                     
                       </td>
                  </tr>
            ';
                $nd++;
              }
            }
          }
  
  
  
  
  
          $nombre++;
        }
  
        echo $output;
      } else {
        echo ' <tr>
                  <td colspan="4">
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


  
      // insert a new ajax request
      public function store(Request $request )
      {

     

      $IDP = session()->get('id');
      $comp= $request->compteid;
      $compp=explode("-", $comp);
     
      $grandcompte = $compp[0];
      $souscompte  = $compp[1];
      

       
    $somme_budget_ligne= DB::table('rallongebudgets')
       ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
       ->Where('rallongebudgets.projetid', $IDP)
       ->Where('rallongebudgets.compteid', $grandcompte)
       ->Where('rallongebudgets.souscompte', $souscompte)
       ->SUM('rallongebudgets.budgetactuel');


       $somme_activite_ligne= DB::table('activities')
       ->Where('projectid', $IDP)
       ->Where('grandcompte', $grandcompte)
       ->Where('compteidr', $souscompte)
       ->SUM('montantbudget');

      

       $montant_somme = $request->montant + $somme_activite_ligne;

       if($somme_budget_ligne >= $montant_somme ){
          $activity = new Activity();
          
          $activity->projectid = $request->projetid;
          $activity->compteidr = $souscompte;
          $activity->grandcompte = $grandcompte;
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

       

      
      
        
      }


      // Update a new ajax request
      public function update(Request $request )
      {
        try {
              $act = Activity::find($request->aid);

              $comp= $request->ligneact;
              $compp=explode("-", $comp);
             
              $grandcompte = $compp[0];
              $souscompte  = $compp[1];
        

              $act->grandcompte = $grandcompte;
              $act->compteidr =$souscompte;
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
