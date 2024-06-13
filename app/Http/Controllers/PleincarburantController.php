<?php

namespace App\Http\Controllers;

use App\Models\Carburant;
use App\Models\Fournisseur;
use App\Models\Pleincarburant;
use App\Models\Vehicule;
use Illuminate\Http\Request;

class PleincarburantController extends Controller
{
    public function index()
    {
        $title = 'Carburents';
        $carburent = Carburant::all();
        $vehicule = Vehicule::all();
        $fournisseur = Fournisseur::all();
        return view(
            'carburent.index',
            [
                'title'     => $title,
                'carburent' => $carburent,
                'vehicule'  => $vehicule,
                'fournisseur'=>$fournisseur
            ]
        );
    }
    public function allcarburents()
    {
        $carburent = Pleincarburant::orderBy('id', 'DESC')->get();
        $output = '';
        if ($carburent->count() > 0) {
            $nombre = 1;
            foreach ($carburent as $car) {
            $output .= '<tr>
              <td class="align-middle ps-3 name">' . $nombre . '</td>
              <td>' . ucfirst($car->referenceblaque) . '</td>
              <td>' . ucfirst($car->carburent) . '</td>
              <td>' . ucfirst($car->quantite) . '</td>
              <td>' . ucfirst($car->prixunite) . '</td>
              <td>' . ucfirst($car->fournisseurid) . '</td>
              <td>' . ucfirst($car->kilometragedebut) . '</td>
              <td>' . ucfirst($car->kilometragefin) . '</td>
              <td>' . ucfirst($car->note) . '</td>
            
              <td>' . date('d.m.Y', strtotime($car->created_at)) . '</td>
              <td>
                   <center>
                 <div class="btn-group me-2 mb-2 mb-sm-0">
                  <a  data-bs-toggle="dropdown" aria-expanded="false">
                       <i class="mdi mdi-dots-vertical ms-2"></i>
                  </a>
                  <div class="dropdown-menu">
                    
                      <a class="dropdown-item text-white mx-1 deleteEntretient"  id="' . $car->id . '"  href="#" style="background-color:red"><i class="far fa-trash-alt"></i> Supprimer</a>
                  </div>
               </div>
              
                </center>
              </td>
            </tr>';
                $nombre++;
            }

            echo $output;
        } else {
            echo '
        <tr>
        <td colspan="12">
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
