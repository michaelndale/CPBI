<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\UseRequest;
use App\Http\Requests\UserpassupRequest;
use App\Http\Requests\UserupRequest;
use App\Models\Departement;
use App\Models\Profile;
use App\Models\Status;
use App\Models\User;
use App\Notifications\SendUserRegistrationNotification;
use Exception;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
  public function index()
  {
    $title = 'Users';
    $active = 'Users';
    $profile= profile::all();
    $department= Departement::all();
    $statut= Status::all();
    return view(
      'user.index',
      [
        'title' => $title,
        'active' => $active,
        'profile' => $profile,
        'department'=> $department,
        'statut'=> $statut
      ]
    );
  }

  public function fetchAll()
  {
    $User = User::all();
    $output = '';
    if ($User->count() > 0) {
     
      foreach ($User as $rs) {
  $output .='<tr class="hover-actions-trigger btn-reveal-trigger position-static">
  <td class="customer align-middle white-space-nowrap">
      <a class="d-flex align-items-center text-900 text-hover-1000" href="">
          <div class="avatar avatar-m">
              <div class="avatar-name rounded-circle"><span> '.ucfirst(substr($rs->lastname,0,1)).' </span></div>
          </div>
         <h6 class="mb-0 ms-3 fw-semi-bold">'. ucfirst($rs->name).' '. ucfirst($rs->lastname).'</h6>
      </a>
  </td>
  <td class="city align-middle white-space-nowrap text-900"> '.$rs->email.'   </td>
  <td class="city align-middle white-space-nowrap text-900">'. $rs->phone. '  </td>
  <td class="city align-middle white-space-nowrap text-900">'. $rs->role. '  </td>
  
  <td class="city align-middle white-space-nowrap text-900">'. $rs->departement. '  </td>
  <td class="city align-middle white-space-nowrap text-900">'. $rs->fonction. '  </td>
  <td class="city align-middle white-space-nowrap text-900">'. $rs->statut. '  </td>
  <td class="customer align-middle white-space-nowrap">'.  date('d.m.Y', strtotime($rs->created_at)) .' </td>
  <td >
      <a href="#" id="' . $rs->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#edit_profileModal"><i class="bi-pencil-square h4"></i> Edit</a>
      <a href="#" id="' . $rs->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i> Delete </a>
  </td>
</tr>';
      
      }
      echo $output;
    } else {
      echo '
      <tr class="hover-actions-trigger btn-reveal-trigger position-static">
        <td  rowspan="5" class="customer align-middle white-space-nowrap" align="center">
          <h4 class="text-center text-secondery my-3" >No record in the database ! </h4>
        </td>
      </tr>';
    }
  }

  // insert a new employee ajax request
  public function store(User $User, Request $request)
  {
    $username= $request->identifiant;

    $user_id= $request->memberid;

    $chek = User::where('member_id', $user_id)->first();

    if($chek){
      return response()->json([
        'status' => 202,
      ]);

    }else
    {

        $check = User::where('identifiant', $username)->first();

        if($check)
        {
          return response()->json([
            'status' => 201,
          ]);

        }else
        {
          $User->profil_id= $request->profileid;
          $User->departments= $request->department;
          $User->member_id = $request->memberid;
          $User->identifiant = $request->identifiant;
          $User->statut= $request->statut;
          $User->password= Hash::make($request->password,['rounds' =>12]);
          $User->save();
    
          return response()->json([
            'status' => 200,
          ]);
        }
     }
   
  }

    public function login()
    {
        return view('auth.login');
    }
    public function handlelogin(AuthRequest $request)
    {
      try{

        $username = $request->email;
        $password = $request->password;
        if (Auth::attempt(['identifiant'=> $username,'password'=> $password])) {

              $user = Auth::User();
             // session()->put('statut', $user->statut);
             
            if($user->statut=='Activé'){
              return response()->json([ [1] ]);
             
            }
            else if($user->statut=='Bloqué'){
              return response()->json([ [2] ]);
             
            }
            else if($user->statut=='Desactivé'){
              return response()->json([ [3] ]);
             }
             
          }
          else
          {
            return response()->json([ [4] ]);
          }
      
        } catch (Exception $e) {
          return response()->json([ [5] ]);
        }
       
    }

    public function create()
    {
        $title="New users";
        $data = Profile::orderBy('id', 'DESC')->get();
        return view('user.create' , [
            'title' => $title,
            'profile' => $data 
          ]);
    }

    public function postuser(User $user, UseRequest $request)
    {
      try {
        $user->name = $request->firstname;
        $user->lastname = $request->lastname;
        $user->role= $request->role;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->remember_token = $request->password;
        $user->save();

        if($user)
        {
            $user->notify(new SendEmailVerificationNotification());
        }
        else
        {

        }
    
        return redirect('users/listeuser')->with('success', 'New user is successfully created');
      } catch (Exception $e) {
        ///return redirect()->back()->with('success', 'Error Update save ');
        dd($e);
      }
     
    // envoyer un mail a l'utilisateur 
    
  }


    public function liste()
    {
        $title="List user";
        $liste= User::orderBy('id', 'DESC')->get();
        return view('user.liste', 
        [
          'title' =>$title,
          'liste' => $liste
        ]);
    }

    public function edit(User $user)
    {
        $title="Edit user";
        $profile = Profile::orderBy('id', 'DESC')->get();
        return view('user.edit', 
        [
          'title' =>$title,
          'data' => $user,
          'profile'=> $profile
        ]);
    }

    public function  changepass(User $user)
    {
        $title="Edit user";
        return view('user.changepassword', 
        [
          'title' =>$title,
          'data' => $user
        
        ]);
    }



    public function changepasse(user $user, UserpassupRequest $request)
    {
    
      try
      {
          $user->password = $request->password;
       
          $user->update();
          return redirect()->back()->with('success', 'Update blog is successfully .');
         
      } catch (Exception $e) {
        return redirect()->back()->with('danger', 'Errot Update blog ');
      }

    }
   

    public function update(user $user,  UserupRequest $request)
    {
      try {

        if(!empty($request->image)):
          $imageName=time().'.'.$request->image->extension();
           $request->image->move(public_path('avatar/'),$imageName);
           $imageurl = ('avatar/').$imageName;
           
        else:
          $imageurl = $request->ancienimage;
        endif;
      
          $user->name = $request->firstname;
          $user->lastname = $request->lastname;
          $user->role= $request->role;
          $user->email = $request->email;
          $user->avatar = $imageurl ;
          $user->update();
          return redirect()->back()->with('success', 'Update blog is successfully .');
      } catch (Exception $e) {
        return redirect()->back()->with('danger', 'Errot Update user ');
      }

    }


    public function delete(User $user)
    {
      try 
      { 
        $user->delete();
        return redirect()->back()->with('success', 'The item is successfully deleted.');
      } 
        catch (Exception $e) {
        throw new Exception('An error occurred during overpressure ');
      }
    }

}