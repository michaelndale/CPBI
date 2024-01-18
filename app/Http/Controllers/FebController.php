<?php

namespace App\Http\Controllers;

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
    $ID = session()->get('id');
    $data = DB::table('febs')
          ->orderby('id','DESC')
          ->Where('projetid', $ID)
          ->get();

    $output = '';
    if ($data->count() > 0) {
      $nombre = 1;
      foreach ($data as $datas) {
        $output .= '
        <tr>
          <td class="align-middle">  '.$nombre.' </td>
          <td class="align-middle"> #  '.$datas->numerofeb.'  </td>
          <td class="align-middle"> '.$datas->facture.'  </td>
          <td class="align-middle"> '.$datas->datefeb.' </td>
          <td class="align-middle"> '.$datas->bc.' </td>
          <td class="align-middle"> '.$datas->periode.' </td>
          <td class="align-middle"> '.$datas->om.' </td>
          <td class="align-middle">
          <a href="#" id="' . $datas->id . '" class="text-info mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editcompteModal" title="modifier le compte"><i class="fas fa-window-restore"></i>  </a>
            <a href="#" id="' . $datas->id . '" class="text-info mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editcompteModal" title="modifier le compte"><i class="bi-pencil-square h4"></i><i class="fa fa-edit"></i>  </a>
            <a href="#" id="' . $datas->id . '" class="text-danger mx-1 deleteIcon" title="Supprimer le compte"><i class="fa fa-trash"></i>  </a>
          </td>
        </tr>
      '
          ;
        $nombre++;
      }
      echo $output;
    } else {
      echo '
      <tr>
        <td colspan="8">
         <h5 class="text-center text-secondery my-5" > Aucun enregistrement dans la base de données ! </h5>
        </td>
      </tr>';
    }
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

        $feb=DB::table('febs')->select('id')->first();
        $IDf= $feb->id;
            // insersion module elments de details
            foreach ($request->numerodetail as $key => $items)
            {

              $elementfeb = new Elementfeb();
              $elementfeb->febid  =  $IDf;
              $elementfeb->libellee= $request->description[$key];
              $elementfeb->montant=  $request->montant[$key];
              $elementfeb->save();

            }
        
        return response()->json([
         'status' => 200,
         
        ]);
      }
     

       
  }

    public function list()
    {
        $title="FEB";
        $personnel = DB::table('users')->Where('fonction', '!=','Chauffeur')->get();
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
          'personnel' => $personnel
        ]);
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
