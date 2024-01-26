<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\Project;
use App\Models\Rallongebudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RallongebudgetController extends Controller
{
    public function index()
    {
      $ID = session()->get('id');
      $active= 'Budgetisation';
      $title = 'Budgetisation';
      $compte= Compte::all();
      $showData = DB::table('projects')
                ->join('users', 'projects.userid', '=', 'users.id')
                ->select('projects.*', 'users.name', 'users.lastname')
                ->Where('projects.id', $ID)
                ->get();

      return view('rallonge.index',
        [
          'title' => $title,
          'active' => $active,
          'compte' => $compte,
          'showData' => $showData
        ]
      );
    }


    public function fetchAll()
    {
      $ID = session()->get('id');
      

      $data = DB::table('rallongebudgets')
                ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
                ->select('rallongebudgets.*', 'comptes.libelle', 'comptes.numero')
                ->Where('projetid', $ID)
                ->orderBy('rallongebudgets.id', 'ASC')
                ->get();


      $output = '';
      if ($data->count() > 0) {
        $nombre = 1;
        foreach ($data as $datas) {
          $id = $datas->id;
          $ab = 
          $output .= 
          '<tr>
              <td>  ' .$datas->numero.'&nbsp;&nbsp;&nbsp; '.ucfirst($datas->libelle). '   </td>
              <td align="right">  ' . ucfirst($datas->depensecumule).'  </td>
              <td align="right">  '. 0 .'  </td>
              <td align="right"> ' . ucfirst($datas->depensecumule).' </td>
              <td align="right"> ' . ucfirst($datas->budgetactuel).' </td>
              <td align="right"> ' . ucfirst($datas->depensecumule).' </td>
              <td> ' . 2 .'% </td>
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
