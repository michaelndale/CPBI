<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonnelRequest;
use App\Models\Fonction;
use App\Models\Personnel;
use App\Models\Status;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PersonnelController extends Controller
{
    public function index()
    {
      $title = 'Personnel';
      $active = 'RH';
      $fonction= Fonction::all();
      $statut= Status::all();
      return view(
        'personnel.index',
        [
          'title' => $title,
          'active' => $active,
          'fonction' => $fonction,
          'statut'=> $statut
        ]
      );
    }

    public function fetchAll()
    {
      $personnel =Personnel::orderBy('nom', 'ASC')->get();
      $output = '';
      if ($personnel->count() > 0) {
       
        foreach ($personnel as $rs) {
    $output .='<tr class="hover-actions-trigger btn-reveal-trigger position-static">
    <td class="customer align-middle white-space-nowrap">
      <h6 >'. ucfirst($rs->nom).' '. ucfirst($rs->prenom).'</h6>
    </td>
    <td class="city align-middle white-space-nowrap text-900"> '.$rs->email.'   </td>
    <td class="city align-middle white-space-nowrap text-900">'. $rs->phone. '  </td>
    <td class="city align-middle white-space-nowrap text-900">'. $rs->fonction. '  </td>
    <td class="city align-middle white-space-nowrap text-900">'. $rs->statut. '  </td>
    <td class="customer align-middle white-space-nowrap">'.  date('d.m.Y', strtotime($rs->created_at)) .' </td>
    <td>
    <center>
      <a href="#" id="' . $rs->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#edit_functionModal" title="Modifier" ><i class="far fa-edit"></i> </a>
      <a href="#" id="' . $rs->id . '" class="text-danger mx-1 deleteIcon" title="Supprimer"><i class="far fa-trash-alt"></i></a>
    </center>
  </td>
  </tr>';
        
        }
        echo $output;
      } else {
        echo '
        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
          <td  colspan="7" class="customer align-middle white-space-nowrap" align="center">
            <h5 class="text-center text-secondery my-3" >  Aucun enregistrement dans la base de données  ! </h5>
          </td>
        </tr>';
      }
    }



    // insert a new employee ajax request
  public function store(PersonnelRequest $request)
  {
    $email= $request->email;
    $chek = personnel::where('email', $email)->first();
    if($chek){
      return response()->json([
        'status' => 202,
      ]);

    }else
    {
          $personnel = new Personnel();
          $personnel->nom= $request->nom;
          $personnel->prenom= $request->prenom;
          $personnel->sexe= $request->sexe;
          $personnel->email= $request->email;
          $personnel->phone= $request->phone;
          $personnel->fonction= $request->fonction;
        
          $personnel->userid = Auth()->user()->id;
          $personnel->save();
    
          return response()->json([
            'status' => 200,
          ]);
        
     }
   
  }

  public function edit(Request $request)
  {
    $id = $request->id;
    $fon = Personnel::find($id);
    return response()->json($fon);
  }

  public function update(Request $request)
  {
    try {
          $per = Personnel::find($request->per_id);
          $per->nom = $request->per_nom;
          $per->prenom = $request->per_prenom;
          $per->sexe = $request->per_sexe;
          $per->email = $request->per_email;
          $per->phone = $request->per_phone;
          $per->userid = Auth()->user()->id;
          $per->update();
          return response()->json([
            'status' => 200,
          ]);
      
    } 
    catch (Exception $e) {
      return response()->json([
        'status' => 202,
      ]);
    
  
  }

}

public function updatprofile(Request $request)
{
    try {
       
          if ($request->hasFile('file')) {
            

            $imageName=time().'.'.$request->file->extension();
            $request->file->move(public_path('element/profile/'),$imageName);
            $url = ('element/profile/').$imageName;

            
          } else {
            return response()->json([
              'status' => 206,
              'message' => 'Aucune image sélectionnée.',
          ]);
          }

        

        $per = User::find($request->profileuserid);
        
        $per->avatar = $url;
        $per->userid = Auth()->user()->id;

        $per->update();

        return response()->json([
            'status' => 200,
            'message' => 'Profil mis à jour avec succès.',
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 202,
            'message' => 'Erreur lors de la mise à jour du profil.',
        ]);
    }
}


public function updatsignature(Request $request)
{
  try {

        if(!empty($request->signature)):
          $imageName=time().'.'.$request->signature->extension();
          $request->signature->move(public_path('element/signature/'),$imageName);
          $imageurl = ('element/signature/').$imageName;
        else:
          return response()->json([
            'status' => 206,
          ]);
        endif;


        $per = User::find($request->personneidp);
  
        $per->signature = $imageurl;
        $per->userid = Auth()->user()->id;

        $per->update();
        return response()->json([
          'status' => 200,
        ]);
    
  } 
  catch (Exception $e) {
    return response()->json([
      'status' => 202,
    ]);
  

}

}


public function updatpassword(Request $request)
{
  try {
        $user = User::find($request->userid);

        $user->password =$request->npwd;
        
        $user->update();

        return response()->json([
          'status' => 200,
        ]);
    
  } 
  catch (Exception $e) {
    return response()->json([
      'status' => 202,
    ]);
  

}

}



}
