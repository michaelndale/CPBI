<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\UseRequest;
use App\Http\Requests\UserpassupRequest;
use App\Http\Requests\UserupRequest;
use App\Models\Departement;
use App\Models\Fonction;
use App\Models\Personnel;
use App\Models\Profile;
use App\Models\Status;
use App\Models\User;
use App\Notifications\SendUserRegistrationNotification;
use Exception;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
  public function index()
  {
    $title = 'Utilisateur';
    $active = 'Parameter';
    $personnel = Personnel::all();
    $profile = Fonction::all();
    $department = Departement::all();
    $statut = Status::all();
    return view(
      'user.index',
      [
        'title'      => $title,
        'active'     => $active,
        'profile'    => $profile,
        'department' => $department,
        'statut'     => $statut,
        'personnel'  => $personnel
      ]
    );
  }

  public function conducteur()
  {
    $title = 'Conducteur';
    $active = 'Parc';
    $profile = profile::all();
    $statut = Status::all();
    return view(
      'conducteur.index',
      [
        'title' => $title,
        'active' => $active,
        'profile' => $profile,
        'statut' => $statut
      ]
    );
  }

  public function fetchAll()
  {
    $User = DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->orderBy('nom', 'ASC')
      ->get();

    $output = '';
    if ($User->count() > 0) {

      foreach ($User as $rs) {
        $output .= '<tr >
              <td>
                  <a  href="">
                      
                    <h6 class="mb-0 ms-3 fw-semi-bold">' . ucfirst($rs->nom) . ' ' . ucfirst($rs->prenom) . '</h6>
                  </a>
              </td>
              <td> ' . $rs->identifiant . '   </td>
         
              <td>' . $rs->role . '  </td>
      
              <td>' . $rs->statut . '  </td>
              <td>' .  date('d.m.Y', strtotime($rs->created_at)) . ' </td>
              <td>
             
                <a href="#" id="' . $rs->id . '" class="text-primary mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#edit_functionModal" title="Modifier" ><i class="far fa-edit"></i> </a>
                <a href="#" id="' . $rs->id . '" class="text-danger mx-1 deleteIcon" title="Supprimer"><i class="far fa-trash-alt"></i></a>
             
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


  public function fetchAllcond()
  {
    $User =    DB::table('users')
      ->join('personnels', 'users.personnelid', '=', 'personnels.id')
      ->select('users.*', 'personnels.nom', 'personnels.prenom', 'personnels.fonction')
      ->orWhere('fonction', 'Chauffeur')
      ->orderBy('nom', 'ASC')
      ->get();
    $output = '';
    if ($User->count() > 0) {

      foreach ($User as $rs) {
        $output .= '<tr>
  <td>' . ucfirst($rs->name) . ' ' . ucfirst($rs->prenom) . '</h6></td>
  <td> ' . $rs->email . '   </td>
  <td>' . $rs->phone . '  </td>
  <td>' . $rs->role . '  </td>
  <td>' . $rs->fonction . '  </td>
  <td>' . $rs->statut . '  </td>
  <td>' .  date('d.m.Y', strtotime($rs->created_at)) . ' </td>
  <td >
      <a href="#" id="' . $rs->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#edit_profileModal"><i class="bi-pencil-square h4"></i> Edit</a>
      <a href="#" id="' . $rs->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i> Delete </a>
  </td>
</tr>';
      }
      echo $output;
    } else {
      echo '
      <tr>
        <td  rowspan="5">
          <h4 class="text-center text-secondery my-3" >No record in the database ! </h4>
        </td>
      </tr>';
    }
  }

  // insert a new ajax request
  public function store(Request $request)
  {

    $username = $request->identifiant;
    $userid =   $request->personnelid;


    $chek = User::where('personnelid', $userid)->first();
    if ($chek) {
      return response()->json([
        'status' => 202,
      ]);
    } else {

      $checkidentifiant = User::where('identifiant', $username)->first();

      if ($checkidentifiant) {
        return response()->json([
          'status' => 201,
        ]);
      } else {

        $User =             new User;
        $User->personnelid = $request->personnelid;
        $User->identifiant = $request->identifiant;
        $User->role =        $request->profileid;
        $User->password =    Hash::make($request->password);
        $User->userid =     Auth()->user()->id;
        $User->save();

        return response()->json([
          'status' => 200,
        ]);
      }
    }
  }













  public function login()
  {
    if (Auth::id()) {
      return redirect()->route('dashboard');
    } else {
      return view('auth.login');
    }
  }



  public function handlelogin(AuthRequest $request)
  {
    try {

      $username = $request->email;
      $password = $request->password;
      if (Auth::attempt(['identifiant' => $username, 'password' => $password])) {

        $user = Auth::User();


        if ($user->statut == 'Activé') {


          $datauser = Personnel::find($user->personnelid);
          session()->put('nomauth', $datauser->nom);
          session()->put('prenomauth', $datauser->prenom);
          session()->put('fonction', $datauser->fonction);
          session()->put('avatar', $datauser->avatar);
          session()->put('signature', $datauser->signature);
         

          return response()->json([[1]]);
        } else if ($user->statut == 'Bloqué') {
          return response()->json([[2]]);
        } else if ($user->statut == 'Desactivé') {
          return response()->json([[3]]);
        }
      } else {
        return response()->json([[4]]);
      }
    } catch (Exception $e) {
      return response()->json([[5]]);
    }
  }

  public function create()
  {
    $title = "New users";
    $data = Profile::orderBy('id', 'DESC')->get();
    return view('user.create', [
      'title' => $title,
      'profile' => $data
    ]);
  }

  public function postuser(User $user, UseRequest $request)
  {
    try {
      $user->name = $request->firstname;
      $user->lastname = $request->lastname;
      $user->role = $request->role;
      $user->email = $request->email;
      $user->password = $request->password;
      $user->remember_token = $request->password;
      $user->save();

      if ($user) {
        $user->notify(new SendEmailVerificationNotification());
      } else {
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
    $title = "List user";
    $liste = User::orderBy('id', 'DESC')->get();
    return view(
      'user.liste',
      [
        'title' => $title,
        'liste' => $liste
      ]
    );
  }

  public function edit(User $user)
  {
    $title = "Edit user";
    $profile = Profile::orderBy('id', 'DESC')->get();
    return view(
      'user.edit',
      [
        'title' => $title,
        'data' => $user,
        'profile' => $profile
      ]
    );
  }

  public function  changepass(User $user)
  {
    $title = "Edit user";
    return view(
      'user.changepassword',
      [
        'title' => $title,
        'data' => $user

      ]
    );
  }



  public function changepasse(user $user, UserpassupRequest $request)
  {

    try {
      $user->password = $request->npwd;

      $user->update();
      return redirect()->back()->with('success', 'Update blog is successfully .');
    } catch (Exception $e) {
      return redirect()->back()->with('danger', 'Errot Update blog ');
    }
  }


  public function update(user $user,  UserupRequest $request)
  {
    try {

      if (!empty($request->image)) :
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('avatar/'), $imageName);
        $imageurl = ('avatar/') . $imageName;

      else :
        $imageurl = $request->ancienimage;
      endif;

      $user->name = $request->firstname;
      $user->lastname = $request->lastname;
      $user->role = $request->role;
      $user->email = $request->email;
      $user->avatar = $imageurl;
      $user->update();
      return redirect()->back()->with('success', 'Update blog is successfully .');
    } catch (Exception $e) {
      return redirect()->back()->with('danger', 'Errot Update user ');
    }
  }


  public function delete(User $user)
  {
    try {
      $user->delete();
      return redirect()->back()->with('success', 'The item is successfully deleted.');
    } catch (Exception $e) {
      throw new Exception('An error occurred during overpressure ');
    }
  }


  public function logout()
  {
    session()->forget('id');
    Auth::logout();
    return redirect('/');
  }
}
