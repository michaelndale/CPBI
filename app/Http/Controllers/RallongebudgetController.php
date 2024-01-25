<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\Rallongebudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RallongebudgetController extends Controller
{
    public function index()
    {
    
      $active= 'Project';
      $title = 'Rallongebudget budgetaire';
      $compte= Compte::all();

      return view(
        'rallonge.index',
        [
          'title' => $title,
          'active' => $active,
          'compte' => $compte
        
        ]
      );
    }


    public function fetchAll()
    {
      $ID = session()->get('id');
      $data = DB::table('rallongebudgets')
                ->join('comptes', 'rallongebudgets.projetid', '=', 'comptes.id')
                ->select('rallongebudgets.*', 'comptes.libelle', 'comptes.numero')
                ->Where('projetid', $ID)
                ->orderBy('rallongebudgetsid', 'DESC')
                ->get();


      $output = '';
      if ($data->count() > 0) {
        $nombre = 1;
        foreach ($data as $datas) {
          $id = $datas->id;
          $output .= '<tr >
              <td><b>' . ucfirst($datas->numero). '</b></td>
              <td><b>' . ucfirst($datas->libelle). '</b></td>
              <td><b>' . ucfirst($datas->libelle). '</b></td>
              <td>
              <a href="#" id="' . $id . '" class="text-success mx-1 savesc" data-bs-toggle="modal" data-bs-target="#addDealModalSousRallongebudget" title="Ajouter sous compte"><i class="fa fa-plus-circle"></i></a>
                <a href="#" id="' . $id . '" class="text-info mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editcompteModal" title="modifier le compte"><i class="bi-pencil-square h4"></i><i class="fa fa-edit"></i>  </a>
                <a href="#" id="' . $id . '" class="text-danger mx-1 deleteIcon" title="Supprimer le compte"><i class="fa fa-trash"></i>  </a>
              </td>
            </tr>
            
            ';
          $nombre++;
        }
        echo $output;
      } else {
        echo '<h4 class="text-center text-secondery my-5" > Aucun enregistrement dans la base de données ! </h4>';
      }
    }
  
    // insert a new rallongement request
    public function store(Request $request)
    {
      $rallonge = new Rallongebudget;

      $rallonge->projetid = $request->projetid;
      $rallonge->compteid = $request->compteid;
      $rallonge->depensecumule = $request->coutestime; 
      $rallonge->budgetactuel = $request->budgetactuel; 
      $rallonge->userid = Auth()->user()->id;

      $rallonge->save();

      return response()->json([
        'status' => 200,
      ]);
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
