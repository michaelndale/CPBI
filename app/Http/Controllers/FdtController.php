<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FdtController extends Controller
{
    public function list()
    {
        $title="FTD";
        $active = 'Project';
        $personnel =  DB::table('users')->Where('fonction', '!=','Chauffeur')->get();
        //$data= Dja::all();
       
        return view('document.fdt.list', 
        [
          'title' =>$title,
          'active' => $active,
          'personnel' => $personnel
        ]);
    }
}
