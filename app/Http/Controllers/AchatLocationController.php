<?php

namespace App\Http\Controllers;

use App\Models\Achat_location;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AchatLocationController extends Controller
{
    public function fetchachat()
    {
        $achat = Achat_location::orderBy('id', 'DESC')->get();
        $output = '';
        if ($achat->count() > 0) {

            $nombre = 1;
            foreach ($achat as $rs) {
                $output .= '<tr>
              <td class="align-middle ps-3 name">' . $nombre . '</td>
              <td>' . ucfirst($rs->location) . '</td>
              <td>' . date('d.m.Y', strtotime($rs->date)). '</td>
              <td>' . ucfirst($rs->kilometrage) . '</td>
              <td>' . ucfirst($rs->prixvente) . '</td>
              <td>' . ucfirst($rs->expiration) . '</td>
              <td>' . ucfirst($rs->vehicule) . '</td>
              <td>' . ucfirst($rs->fournisseur) . '</td>
              <td>' . ucfirst($rs->note) . '</td>
              <td>' . date('d.m.Y', strtotime($rs->created_at)) . '</td>
              <td>
              <center>
                 <div class="btn-group me-2 mb-2 mb-sm-0">
                  <a  data-bs-toggle="dropdown" aria-expanded="false">
                       <i class="mdi mdi-dots-vertical ms-2"></i>
                  </a>
                  <div class="dropdown-menu">
                     
                      <a class="dropdown-item text-white mx-1 deleteachat"  id="' . $rs->id . '"  href="#" style="background-color:red"><i class="far fa-trash-alt"></i> Supprimer</a>
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
        <td colspan="11">
        <center>
          <h6 style="margin-top:1% ;color:#c0c0c0"> 
          <center><font size="50px"><i class="fa fa-info-circle"  ></i> </font><br><br>
              Ceci est vide  !</center> </h6>
        </center>
        </td>
        </tr>';
        }
    }

    // insert a new Achat/Location request
    public function storeachat(Request $request)
    {
        try {

            $achat = new Achat_location();

            $achat->location = $request->choix;
            $achat->date = $request->date;
            $achat->kilometrage	 = $request->kilometrage;
            $achat->expiration = $request->expiration;
            $achat->prixvente = $request->prixvente;
            $achat->vehicule = $request->vehicule;
            $achat->fournisseur	 = $request->fournisseur;
            $achat->note = $request->note;
            $achat->userid = Auth::id();
            $achat->save();

            return response()->json([
                'status' => 200,
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => 202,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function deleteachat(Request $request)
    {
        try {
            $emp = Achat_location::find($request->id);
            if ($emp->userid == Auth::id()) {
                $id = $request->id;
                Achat_location::destroy($id);
                return response()->json([
                    'status' => 200,
                ]);
            } else {
                return response()->json([
                    'status' => 205,
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 202,
            ]);
        }
    }
}
