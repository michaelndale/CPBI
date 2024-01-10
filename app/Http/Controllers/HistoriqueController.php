<?php

namespace App\Http\Controllers;

use App\Models\Historique;
use Illuminate\Http\Request;

class HistoriqueController extends Controller
{
    public function index()
    {
      $title = 'History';
      $active = "Parameter";
      $data = Historique::all();
      return view(
        'history.index',
        [
          'title' => $title,
          'active' => $active,
          'data' => $data
        ]
      );
    }
  
}
