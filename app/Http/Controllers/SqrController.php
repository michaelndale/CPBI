<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SqrController extends Controller
{
    public function list()
    {
        $title="SQR";
        $active = 'Project';
        $personnel =  DB::table('users')->Where('fonction', '!=','Chauffeur')->get();
        //$data= Dja::all();
       
        return view('document.sqr.list', 
        [
          'title' =>$title,
          'active' => $active,
          'personnel' => $personnel
        ]);
    }
}
