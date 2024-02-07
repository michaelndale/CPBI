<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Exception;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    
  public function index()
  {
    $title = 'Profile';
    $active = 'Parameter';
    return view(
      'profile.index',
      [
        'title' => $title,
        'active' => $active
      ]
    );
  }

  public function fetchAll()
  {
    $profile = profile::all();
    $output = '';
    if ($profile->count() > 0) {
      
      $nombre = 1;
      foreach ($profile as $rs) {
        $output .= '<tr>
            <td class="align-middle ps-3 name">' . $nombre . '</td>
            <td>' . ucfirst($rs->title). '</td>
            <td>
            <center>
            <a href="#" id="' . $rs->id . '" class="text-primary mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#edit_profileModal" title="Modifier" ><i class="far fa-edit"></i> </a>
            <a href="#" id="' . $rs->id . '" class="text-danger mx-1 deleteIcon" title="Supprimer"><i class="far fa-trash-alt"></i></a>
          </center>
            
             
            </td>
          </tr>';
        $nombre++;
      }
  
      echo $output;
    } else {
      echo '<h3 class="text-center text-secondery my-5" > Aucun enregistrement dans la base de données ! </h3>';
    }
  }

  // insert a new employee ajax request
  public function store(profile $profile, Request $request)
  {
    try {
      $title = $request->title;
      $check = Profile::where('title',$title)->first();

      if($check){
        return response()->json([
          'status' => 201,
        ]);
      }else{
        $profile->title= $request->title;
        $profile->userid = Auth()->user()->id;
        $profile->save();
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

  // edit an employee ajax request
  public function edit(Request $request)
  {
    $id = $request->id;
    $fon = profile::find($id);
    return response()->json($fon);
  }

  // update an function ajax request
  public function update(Request $request)
  {

    try {
      $title = $request->pro_title;
      $check = Profile::where('title',$title)->first();
      
      if($check){
        return response()->json([
          'status' => 201,
        ]);
      }else{

          $emp = Profile::find($request->pro_id);
          $emp->title = $request->pro_title;
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
    profile::destroy($id);
  }
}
