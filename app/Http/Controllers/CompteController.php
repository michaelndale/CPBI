<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use Illuminate\Http\Request;

class CompteController extends Controller
{
    public function index()
    {
      $title = 'Compte';
      $active = 'Compte & Ligne';
      $compte = Compte::where('compteid', '=', NULL)->get();
      //$compteligne = Gestionlign::all();
      return view(
        'compteligne.index',
        [
          'title' => $title,
          'active' => $active,
          'compte' => $compte,
        
        ]
      );
    }
  
    public function selectcompte()
    {
      $service = Compte::where('compteid', '=', NULL)->get();

      
      $output = '';
      if ($service->count() > 0) {

       $output .=' <select class="form-select" id="compteid" name="compteid">
       <option value="">Aucun</option>';
        foreach ($service as $rs) {
          
          $output .= '
         
          <option value="' .$rs->id. '" >' . ucfirst($rs->gc_libelle). '</option>
         
            ';
           
            }

           $output .=' </select>';

         
      
        echo $output;
      } else {
        echo '<h4 class="text-center text-secondery my-5" > Aucun enregistrement dans la base de données ! </h4>';
      }
    }

    public function sousselectcompte()
    {
      $service = Compte::where('compteid', '!=', 'NULL')->get();
      $output = '';
      if ($service->count() > 0) {

       $output .=' <select class="form-select" id="souscompteid" name="souscompteid">
       <option value="">Aucun</option>';
        foreach ($service as $rs) {
          
          $output .= '
         
          <option value="'.$rs->id.'" >' . ucfirst($rs->libelle). '</option>
         
            ';
           
            }

           $output .=' </select>';
      
        echo $output;
      } else {
        echo '<h3 class="text-center text-secondery my-5" > Aucun enregistrement dans la base de données ! </h3>';
      }
    }


    public function fetchAll()
    {
      $service = Compte::where('compteid', '=', NULL)->get();
      $output = '';
      if ($service->count() > 0) {
        $output .= '<table class="table table-striped table-sm fs--1 mb-0">
          <thead>
            <tr>
              <th>#</th>
              <th>Code</th>
              <th>Title</th>
              <th>ACTION</th>
            </tr>
          </thead>
          <tbody class="list">
           ';
        $nombre = 1;
        foreach ($service as $rs) {
          $id = $rs->id;
          $output .= '<tr >
              <td class="align-middle ps-3 name"><b>' . $nombre . '</td>
              <td><b>' . ucfirst($rs->numero). '</b></td>
              <td><b>' . ucfirst($rs->libelle). '</b></td>
              <td>
              <a href="#" id="' . $rs->id . '" class="text-success mx-1 savesc" data-bs-toggle="modal" data-bs-target="#addDealModalSousCompte" title="Ajouter sous compte"><i class="fa fa-plus-circle"></i></a>
                <a href="#" id="' . $rs->id . '" class="text-info mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editcompteModal" title="modifier le compte"><i class="bi-pencil-square h4"></i><i class="fa fa-edit"></i>  </a>
                <a href="#" id="' . $rs->id . '" class="text-danger mx-1 deleteIcon" title="Supprimer le compte"><i class="fa fa-trash"></i>  </a>
              </td>
            </tr>
            
            ';

          $sous_compte= Compte::where('compteid', $id)->where('souscompteid', '=', NULL)->get();
          if ($sous_compte->count() > 0) {
            $ndale = 1;
          foreach ($sous_compte as $sc) {
            $ids = $sc->id;
            $output .='
                  <tr>
                    <td class="align-middle ps-3 name">' .$nombre.'.'.$ndale . '</td>
                 
                    <td>' . ucfirst($sc->numero). '</td>
                    <td>' . ucfirst($sc->libelle). '</td>
                  
                    <td>
                        <a href="#" id="' . $sc->id . '" class="text-success mx-1 ssavesc" data-bs-toggle="modal" data-bs-target="#addssousDealModal"><i class="fa fa-plus-circle"></i> </a>
                        <a href="#" id="' . $sc->id . '" class="text-info mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editcompteModal"><i class="bi-pencil-square h4"></i><i class="fa fa-edit"></i>  </a>
                        <a href="#" id="' . $sc->id . '" class="text-danger mx-1 deleteIcon"><i class="fa fa-trash"></i>  </a>
                    </td>
                  </tr>
            ';
            $ndale ++;
          }

        
          $sous_sous_compte= Compte::where('souscompteid', $ids)->get();
        if ($sous_sous_compte->count() > 0) {
          $nd = 1;
        foreach ($sous_sous_compte as $ssc) {
          $output .='
                <tr>
                  <td class="align-middle ps-3 name">' .$nombre.'.'.$ndale.'.'.$nd. '</td>
               
                  <td>' . ucfirst($ssc->numero). '</td>
                  <td>' . ucfirst($ssc->libelle). '</td>
                
                  <td>
                      <a href="#" id="' . $ssc->id . '" class="text-success mx-1 ssavesc" data-bs-toggle="modal" data-bs-target="#addssousDealModal"><i class="fa fa-plus-circle"></i> </a>
                      <a href="#" id="' . $ssc->id . '" class="text-info mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editcompteModal"><i class="bi-pencil-square h4"></i><i class="fa fa-edit"></i>  </a>
                      <a href="#" id="' . $ssc->id . '" class="text-danger mx-1 deleteIcon"><i class="fa fa-trash"></i> </a>
                  </td>
                </tr>
          ';
          $nd ++;
        }
        
      }
          
        }


        
            
            
          $nombre++;
        }
        $output .= '</tbody></table>';
        echo $output;
      } else {
        echo '<h4 class="text-center text-secondery my-5" > Aucun enregistrement dans la base de données ! </h4>';
      }
    }
  
    // insert a new service ajax request
    public function store(Compte $gc, Request $request)
    {
      $gc->numero = $request->code;
      $gc->libelle = $request->libelle;
      $gc->userid = Auth()->user()->id;
      $gc->save();
      return response()->json([
        'status' => 200,
      ]);
    }

    public function storesc(Compte $gl, Request $request)
    {
      $gl->compteid = $request->cid;
      $gl->numero = $request->code;
      $gl->libelle = $request->libelle;
      $gl->userid = Auth()->user()->id;
      $gl->save();
      return response()->json([
        'status' => 200,
      ]);
    }

    public function storessc(Compte $gl, Request $request)
    {
      $gl->compteid = $request->scid;
      $gl->souscompteid = $request->sscid;
      $gl->numero = $request->code;
      $gl->libelle = $request->libelle;
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
       $fon = Compte::find($id);
       return response()->json($fon);
     }
  
    // edit an service ajax request
    public function addsc(Request $request)
    {
      $id = $request->id;
      $fon = Compte::find($id);
      return response()->json($fon);
    }


  
    // update an service ajax request
    public function update(Request $request)
    {
      $emp = Compte::find($request->gc_id);
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
      Compte::destroy($id);
    }
}
