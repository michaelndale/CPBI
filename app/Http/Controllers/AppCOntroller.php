<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Contact;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppCOntroller extends Controller
{
    public function index ()
    {
      $title="Dashboard";
      $active = "Dashboard";
      $project = Project::all();
      $user = User::all();
      $activite= Activity::all();
      $encours = Project::where('statut',1)->Count();
      $dernier = Project::orderBy();
      
      return view('dashboard.dashboard', 
      [

        'title' =>$title,
        'active' => $active,
        'project' => $project,
        'user' => $user,
        'activite' => $activite,
        'encours' => $encours 

      ]);
    }

    public function logout()
    {
      Auth::logout();
      return redirect('login');
    }

}
