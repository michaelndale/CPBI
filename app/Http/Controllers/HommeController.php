<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
class HommeController extends Controller
{
    public function index ()
    {

     
        $title = 'Accueil';

        return view('welcome', 
        [
          'title' => $title,
      
         
        ]);
    }
}
