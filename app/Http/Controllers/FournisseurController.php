<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function fetchfournisseur()
    {
      $folder = Fournisseur::orderBy('nom', 'ASC')->get();
      $output = '';
      if ($folder->count() > 0) {
        $nombre = 1;
        foreach ($folder as $rs) {
          $output .= '<tr>
                <td class="align-middle ps-3 name">' . $nombre . '</td>
                <td>' . ucfirst($rs->nom) . '</td>
                <td>' . ucfirst($rs->adresse) . '</td>
                <td>' . ucfirst($rs->phone) . '</td>
                <td>' . ucfirst($rs->email) . '</td>
                <td>' . ucfirst($rs->email) . '</td>
                <td>
                <center>
                  <div class="btn-group me-2 mb-2 mb-sm-0">
                    <a  data-bs-toggle="dropdown" aria-expanded="false">
                         <i class="mdi mdi-dots-vertical ms-2"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item text-primary mx-1 editStatut" id="' . $rs->id . '"  data-bs-toggle="modal" data-bs-target="#editStatutModal" title="Modifier"><i class="far fa-edit"></i> Modifier</a>
                        <a class="dropdown-item text-danger mx-1 deleteStatut"  id="' . $rs->id . '"  title="Supprimer"><i class="far fa-trash-alt"></i> Supprimer</a>
                    </div>
                 </div>
                  </center>
                </td>
              </tr>';
          $nombre++;
        }
  
        echo $output;
      } else {
        echo ' <tr>
          <td colspan="8">
          <center>
            <h6 style="margin-top:1% ;color:#c0c0c0"> 
            <center><font size="50px"><i class="fa fa-info-circle"  ></i> </font><br><br>
           Ceci est vide  !</center> </h6>
          </center>
          </td>
          </tr>';
      }
    }
}
