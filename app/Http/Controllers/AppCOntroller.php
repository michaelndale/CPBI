<?php

namespace App\Http\Controllers;


use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppCOntroller extends Controller
{
    public function index ()
    {
      $title="Dashboard";
      $active = "Dashboard";
      return view('dashboard.dashboard', 
      [
        'title' =>$title,
        'active' => $active
      ]);
    }

    public function logout()
    {
      Auth::logout();
      return redirect('login');
    }

}
