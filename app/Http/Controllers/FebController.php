<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Compte;
use App\Models\Elementfeb;
use App\Models\Feb;
use App\Models\Historique;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class FebController extends Controller
{
  public function fetchAll()
  {
    $devise =session()->get('devise');
    $budget =session()->get('budget');

    $ID = session()->get('id');
    $data = DB::table('febs')
          ->orderby('id','DESC')
          ->Where('projetid', $ID)
          ->get();

    $output = '';
    if ($data->count() > 0) {
      $nombre = 1;
      foreach ($data as $datas) {

        $sommefeb= DB::table('elementfebs')
        ->Where('febid', $datas->id)
        ->SUM('montant');

        $pourcentage = round(($sommefeb*100)/$budget);

        $sommefeb = number_format($sommefeb,0, ',', ' ');

        $output .= '
        <tr>
        <td class="align-middle">

          <center>
               
          <div class="btn-group me-2 mb-2 mb-sm-0">
            <a  data-bs-toggle="dropdown" aria-expanded="false">
                 <i class="mdi mdi-dots-vertical ms-2"></i>
            </a>
            <div class="dropdown-menu">
                <a href="feb/'.$datas->id.'/view" class="dropdown-item text-success mx-1 voirIcon" id="' . $datas->id . '"  ><i class="far fa-edit"></i> Voir feb</a>
                <a class="dropdown-item text-primary mx-1 editIcon " id="' . $datas->id . '"  data-bs-toggle="modal" data-bs-target="#editFolderModal" title="Modifier"><i class="far fa-edit"></i> Modifier</a>
                <a class="dropdown-item text-danger mx-1 deleteIcon"  id="' . $datas->id . '"  href="#"><i class="far fa-trash-alt"></i> Supprimer</a>
            </div>
         </div>
        
        
          </center>

          </td>
         <td>'.$nombre.'</td>
          <td class="align-middle"> <b>'.$datas->numerofeb.' </b>  </td>
          <td class="align-middle"> '.$datas->facture.'  </td>
          <td class="align-middle"> '.$datas->datefeb.' </td>
          <td class="align-middle"> '.$datas->bc.' </td>
          <td class="align-middle"> '.$datas->periode.' </td>
          <td class="align-middle"> '.$datas->om.' </td>
          <td class="align-right"> <b> '.$sommefeb.' '.$devise.'</b>  </td>
          <td class="align-middle"> '.$pourcentage .'%</td>
          
        </tr>
      '
          ;
        $nombre++;
      }
      echo $output;
    } else {
      echo
      '
      <tr>
      <td colspan="10">
      <center>
        <h6 style="margin-top:1% ;color:#c0c0c0"> 
        <center><font size="50px"><i class="far fa-trash-alt"  ></i> </font><br><br>
        Ceci est vice !</center> </h6>
      </center>
      </td>
      </tr>
      
      ';
    }
  }


   public function Sommefeb()
  {
    $devise =session()->get('devise');
    $budget =session()->get('budget');
    $ID = session()->get('id');

      $data = DB::table('elementfebs')
            ->orderby('id','DESC')
            ->Where('projetids', $ID)
            ->SUM('montant');

    $output = '';
    
        $pourcentage = round(($data*100)/$budget);
        $sommefeb = number_format($data,0, ',', ' ');

        $output .= '
          <td style="padding-left:10px"> Montant globale d\'expression des besoins</td>
          <td class="align-right" padding-left:5px> <b> '.$sommefeb.' '.$devise.'</b>  </td>
          <td > '.$pourcentage .'%</td> 
          <td> &nbsp;</td>
      ';
       
      
      echo $output;
  }


  
      // insert a new employee ajax request
      public function store(Request $request)
      {
        
        /*$operation ="New activite: ".$request->title;
        $link ='listactivity';
        $notis->operation = $operation;
        $his->userid  = Auth()->user()->id;
        $notis->link = $link;
        $notis->save();
        */

     
          $numerofeb = $request->numerofeb;
          $check = Feb::where('numerofeb',$numerofeb)->first();
          if($check){
            return response()->json([
              'status' => 201,
            ]);
          }else{

        $activity = new Feb();
        $activity->numerofeb = $request->numerofeb;
        $activity->projetid = $request->projetid;
        $activity->activiteid = $request->activityid;
        $activity->periode= $request->periode;
        $activity->datefeb = $request->datefeb;
        $activity->ligne_bugdetaire = $request->ligneid;
        $activity->bc= $request->bc;
        $activity->facture= $request->facture;
        $activity->om= $request->om;
        $activity->acce= $request->acce;
        $activity->comptable= $request->comptable;
        $activity->chefcomposante= $request->chefcomposante;
        $activity->userid = Auth::id();
        $activity->save();

        
        $IDf= $activity->id;
            // insersion module elments de details
            foreach ($request->numerodetail as $key => $items)
            {

              $elementfeb = new Elementfeb();
              $elementfeb->febid  =  $IDf;
              $elementfeb->libellee= $request->description[$key];
              $elementfeb->montant=  $request->unit_cost[$key];
              $elementfeb->projetids=  $request->projetid;
              $elementfeb->tperiode=  $request->periode;
              $elementfeb->eligne=  $request->ligneid;
              $elementfeb->save();

            }
        
        return response()->json([
         'status' => 200,
         
        ]);
      }
     

       
  }

  public function findligne(Request $request){
    try {
      $ID = session()->get('id');
      $data=DB::table('elementfebs')
            ->join('febs', 'elementfebs.febid', '=', 'febs.id')
            ->select('elementfebs.*', 'febs.projetid', 'febs.ligne_bugdetaire')
            ->orWhere('febs.ligne_bugdetaire', $request->id)
         //   ->orWhere('febs.projetid', $ID)
            ->get();
   
      return response()->json($data);

   
    } catch (Exception $e) {
      return response()->json([
        'status' => 202,
      ]);
    }
     
}

    public function list()
    {
        $title="FEB";
        $compte = Compte::where('compteid', '=', NULL)->get();
        $personnel = DB::table('users')
                    ->join('personnels', 'users.personnelid', '=', 'personnels.id')
                    ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
                    ->orWhere('fonction', '!=' ,'Chauffeur')
                    ->orderBy('nom', 'ASC')
                    ->get();
        $active = 'Project';
        $ID = session()->get('id');
        $activite = DB::table('activities')
              ->orderby('id','DESC')
              ->Where('projectid', $ID)
              ->get();
        return view('document.feb.list', 
        [
          'title' =>$title,
          'active' => $active,
          'activite' => $activite,
          'personnel' => $personnel,
          'compte' => $compte
        ]);
    }

    public function show(Feb $key)
    {
      $budget =session()->get('budget');

      $title = 'Feb';
      $ida = $key->activiteid;
      $idl = $key->ligne_bugdetaire;
      $idfeb =  $key->id;

      $dataActivite = Activity::where('id',$ida)->first();

      $dataLigne = Compte::where('id',$idl)->first();

      // Debut % ligfne
      $sommelign= DB::table('elementfebs')
      ->Where('eligne', $idl)
      ->SUM('montant');
      $sommelignpourcentage = round(($sommelign*100)/$budget);
      // fin

      // sommes element

      $sommefeb= DB::table('elementfebs')
      ->Where('febid', $idfeb)
      ->SUM('montant');

      //

      //etablie par 
      $etablienom=  DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction')
       ->Where('users.id', $key->acce)
      ->first();

      //comptable
      $comptable_nom=  DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction')
       ->Where('users.id', $key->comptable)
      ->first();


      //chef composant
      $checcomposant_nom=  DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('personnels.nom', 'personnels.prenom', 'personnels.fonction')
       ->Where('users.id', $key->chefcomposante)
      ->first();



      $datElement = Elementfeb::where('febid',$idfeb)->get();

      return view('document.feb.voir', 
        [
          'title' =>$title,
          'dataFeb' => $key,
          'dataActivite' => $dataActivite,
          'dataLigne' => $dataLigne,
          'sommelignpourcentage' => $sommelignpourcentage,
          'datElement' => $datElement,
          'sommefeb' => $sommefeb,
          'etablienom' => $etablienom,
          'comptable_nom' => $comptable_nom,
          'checcomposant_nom' => $checcomposant_nom

        ]);
    }


    public function update(Request $request)
    {
      try {
          $emp = Feb::find($request->febid);

          if(!empty($request->accesignature)){ $accesignature=1; }else{ $accesignature=0; }
          if(!empty($request->comptablesignature)){ $comptablesignature=1; }else{ $comptablesignature=0; }
          if(!empty($request->chefsignature)){ $chefsignature=1; }else{ $chefsignature=0; }

          $emp->acce_signe = $accesignature;
          $emp->comptable_signe = $comptablesignature;
          $emp->chef_signe = $chefsignature;
          
          $emp->update();
          
          return back()->with('success', 'Très bien! le signature  est bien enregistrer');
        
      } catch (Exception $e) {
        return back()->with('failed', 'Echec ! le signature  n\'est pas creer ');
      }

      



      
    }
  


    public function delete(Request $request)
    {
      $his = new Historique;
      $function ="Suppression";
      $operation ="Suppression FEB";
      $link ='feb';
      $his->fonction = $function;
      $his->operation = $operation;
      $his->userid = Auth()->user()->id;
      $his->link = $link;
      $his->save();

      $id = $request->id;
      Feb::destroy($id);
    }
}
