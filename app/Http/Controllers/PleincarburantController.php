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
                    <a href="#" id="' . $car->id . '" class="text-primary mx-1 editvehicule" data-bs-toggle="modal" data-bs-target="#edit_vehiculeModal" title="Modifier" ><i class="far fa-edit"></i> </a>
                    <a href="#" id="' . $car->id . '" class="text-danger mx-1 deleteIcon" title="Supprimer"><i class="far fa-trash-alt"></i></a>
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
