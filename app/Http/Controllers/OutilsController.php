<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OutilsController extends Controller
{
    public function index()
    {
        $title = 'Outils PA';
        return view(
            'outilspa.index',
            [
              'title' => $title,
            ]
          );
    }

    public function alltype(){

    }

    public function storetype(){
      
    }
}
