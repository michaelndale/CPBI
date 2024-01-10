<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Exception;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
      $title = 'Service';
      $active = 'Parameter';
      return view(
        'service.index',
        [
          'title' => $title,
          'active' => $active
        ]
      );
    }
  
    public function fetchAll()
    {
      $service = Service::all();
      $output = '';
      if ($service->count() > 0) {
        $output .= '
          <table class="table table-striped table-sm fs--1 mb-0">
          <thead style="background-color:#D5F5E3;">
            <tr>
              <th class="align-middle ps-3 name">#</th>
              <th class="sort border-top ps-3" data-sort="name">Libellé</th>
              <th><center>ACTION</center></th>
            </tr>
          </thead>
          <tbody class="list">
           ';
            $nombre = 1;
            foreach ($service as $rs) {
              $output .= '
              <tr>
                  <td class="align-middle ps-3 name">' . $nombre . '</td>
                  <td>' . ucfirst($rs->title). '</td>
                  <td>
                    <center>
                      <a href="#" id="' . $rs->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#edit_ServiceModal" title="Modifier" ><i class="far fa-edit"></i> </a>
                      <a href="#" id="' . $rs->id . '" class="text-danger mx-1 deleteIcon" title="Supprimer"><i class="far fa-trash-alt"></i></a>
                    </center>
                  </td>
              </tr>';
              $nombre++;
        }
        $output .= '</tbody></table>';
        echo $output;
      } else {
        echo '<h3 class="text-center text-secondery my-5" > Aucun enregistrement dans la base de données ! </h3>';
      }
    }
  
    // insert a new service ajax request
    public function store(Service $service, Request $request)
    {
      try {
      
      $title = $request->title;
      $check = Service::where('title',$title)->first();

      if($check){
        return response()->json([
          'status' => 201,
        ]);
      }else{

        $service->title = $request->title;
        $service->userid = Auth()->user()->id;
        $service->save();
        return response()->json([
          'status' => 200,
        ]);
      }
    } catch (Exception $e) {
      return response()->json([
        'status' => 202,
      ]);
    }
     
    }
  
    // Get service  request
    public function edit(Request $request)
    {
      $id = $request->id;
      $fon = Service::find($id);
      return response()->json($fon);

    }
  
    // update an service ajax request
    public function update(Request $request)
    {

      try {
        $title = $request->ser_title;
        $check = Service::where('title',$title)->first();
        
        if($check){
          return response()->json([
            'status' => 201,
          ]);
        }else{
  
          $emp = Service::find($request->ser_id);
          $emp->title = $request->ser_title;
          $emp->userid = Auth()->user()->id;
          $emp->update();
          
          return response()->json([
            'status' => 200,
          ]);
        }
      } catch (Exception $e) {
        return response()->json([
          'status' => 202,
        ]);
      }

     
    }
  
    // supresseion
    public function deleteall(Request $request)
    {
      $id = $request->id;
      Service::destroy($id);
    }

}
