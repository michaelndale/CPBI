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
    $users = Personnel::orderBy('nom', 'ASC')->get();
    $personnel = DB::table('users')
      ->join('personnels', 'personnels.id', 'users.personnelid')
      ->select('users.*', 'personnels.nom', 'personnels.id', 'personnels.email', 'personnels.sexe', 'personnels.phone', 'personnels.fonction', 'personnels.prenom')
      ->get();

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
        'personnel'  => $personnel,
        'users'      => $users
      ]
    );
  }

  public function conducteur()
  {
    $title = 'Conducteur';
    $active = 'Parc';
    $profile = Fonction::all();
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
              <td> ' . $rs->identifiant . '</td>
         
              <td>' . $rs->role . '  </td>
              <td>' . $rs->statut . '  </td>
              <td>' .  date('d.m.Y', strtotime($rs->created_at)) . ' </td>
              <td>
                <a href="#" id="' . $rs->id . '" class="text-primary mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#edit_functionModal" title="Modifier" ><i class="far fa-edit"></i> </a>
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

</tr>';
      }
      echo $output;
    } else {
      echo '
      <tr>
        <td  colspan="7">
        <center>
        <h6 style="margin-top:1% ;color:#c0c0c0"> 
        <center><font size="50px"><i class="fa fa-info-circle"  ></i> </font><br><br>
            Ceci est vide  !</center> </h6>
      </center>
        </td>
      </tr>';
    }
  }

  // insert a new ajax request
  public function store(Request $request)
  {
      DB::beginTransaction(); // Démarre la transaction
  
      try {
          $username = $request->identifiant;
          $userid = $request->personnelid;
  
          $chek = User::where('personnelid', $userid)->first();
          if ($chek) {
              return response()->json([
                  'status' => 202,
              ]);
          }
  
          $checkidentifiant = User::where('identifiant', $username)->first();
          if ($checkidentifiant) {
              return response()->json([
                  'status' => 201,
              ]);
          }
  
          $user = new User;
          $user->personnelid = $request->personnelid;
          $user->identifiant = $request->identifiant;
          $user->role = $request->profileid;
          $user->password = Hash::make($request->password);
          $user->userid = Auth::id();
          $user->save();
  
          DB::commit(); // Valide la transaction
  
          return response()->json([
              'status' => 200,
          ]);
      } catch (Exception $e) {
          DB::rollBack(); // Annule la transaction en cas d'erreur
  
          return response()->json([
              'status' => 500
          ]);
      }
  }

  public function verifierIdentifiant(Request $request)
{
    $identifiant = $request->identifiant;

    // Vérifier si l'identifiant existe déjà dans la base de données
    $user = User::where('identifiant', $identifiant)->exists();

    return response()->json(['exists' => $user]);
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
  
          if (Auth::attempt(['identifiant' => $username, 'password' => $password], $request->filled('remember'))) {
              $user = Auth::user();
  
              switch ($user->statut) {
                  case 'Activé':
                      $datauser = Personnel::find($user->personnelid);
                      session()->put('nomauth', $datauser->nom);
                      session()->put('prenomauth', $datauser->prenom);
                      session()->put('fonction', $datauser->fonction);
                      session()->put('avatar', $datauser->avatar);
                      session()->put('signature', $datauser->signature);
  
                      return response()->json([1]);
                  case 'Bloqué':
                      return response()->json([2]);
                  case 'Desactivé':
                      return response()->json([3]);
                  default:
                      return response()->json([4]); // In case the statut is something unexpected
              }
          } else {
              return response()->json([4]);
          }
      } catch (Exception $e) {
          return response()->json([5]);
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
      if (!empty($request->image)) {
        $originalName = $request->image->getClientOriginalName();
        $timestamp = time();
        $extension = $request->image->extension();

        $imageName = $originalName . '_goproject_' . $timestamp . '.' . $extension;
        $request->image->move(public_path('avatar/'), $imageName);
        $imageurl = 'avatar/' . $imageName;
      } else {
        return response()->json([
          'status' => 206,
        ]);
      }

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

  public function restauration($id)
  {
    $title = 'Restauration';

    $user = DB::table('users')
      ->join('personnels', 'personnels.id', 'users.personnelid')
      ->select('users.*', 'personnels.nom', 'personnels.id', 'personnels.email', 'personnels.sexe', 'personnels.phone', 'personnels.fonction', 'personnels.prenom')
      ->where('users.id', $id)
      ->first();

    return view(
      'user.changepassword',
      [
        'title' => $title,
        'user'  => $user

      ]
    );
  }


  public function shomesignature($id)
  {
    $title = 'Changement de signature';

    $user = DB::table('users')
      ->join('personnels', 'personnels.id', 'users.personnelid')
      ->select('users.*', 'personnels.nom', 'users.id as idu', 'personnels.email', 'personnels.sexe', 'personnels.phone', 'personnels.fonction', 'personnels.prenom')
      ->where('personnels.id', $id)
      ->first();

    return view(
      'user.shomesignature',
      [
        'title' => $title,
        'user'  => $user
      ]
    );
  }


  public function updatePasswordone($id, Request $request)
  {

    $user = User::where('id', $request->idmdp)->first();

    $user->password = Hash::make($request->password);
    $user->update();

    return redirect()->route('user')->with('success', 'Password has been updated successfully.');
  }

  public function updatsignatureuser(Request $request)
  {
    DB::beginTransaction(); // Démarre la transaction

    try {
      if (!empty($request->signatur)) {
        $originalName = $request->signatur->getClientOriginalName();
        $timestamp = time();
        $extension = $request->signatur->extension();

        $imageName = $originalName . '_goproject_' . $timestamp . '.' . $extension;
        $request->signatur->move(public_path('element/signature/'), $imageName);
        $imageurl = 'element/signature/' . $imageName;
      } else {
        return response()->json([
          'status' => 206,
        ]);
      }

      $per = User::find($request->pid);
      $per->signature = $imageurl;
      $per->userid = Auth::id();
      $per->save(); // Utilisation de save() au lieu de update()

      DB::commit(); // Valide la transaction
      return response()->json([
        'status' => 200,
      ]);
    } catch (Exception $e) {
      DB::rollBack(); // Annule la transaction en cas d'erreur
      return response()->json([
        'status' => 202,
      ]);
    }
  }





  public function logout()
  {
    session()->forget('id');
    Auth::logout();
    return redirect('/out');
  }
}
