<?php

namespace App\Http\Controllers;

use App\Models\Banque;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BanqueController extends Controller
{
    public function index()
    {
        $title = 'Banque';
        return view('banque.index', ['title' => $title]);
    }

    public function fetchAll()
    {
        $banque = Banque::orderBy('libelle', 'ASC')
        ->join('users', 'banques.userid', '=', 'users.id')
        ->join('personnels', 'users.personnelid', '=', 'personnels.id')
        ->select('banques.*', 'personnels.prenom as user_prenom')
        ->get();
    

        $output = '';
        if ($banque->count() > 0) {

            $nombre = 1;
            foreach ($banque as $rs) {
                $output .= '<tr>
              <td class="align-middle ps-3 name">' . $nombre . '</td>
              <td>' . ucfirst($rs->libelle) . '</td>
              <td>' . ucfirst($rs->user_prenom) . '</td>
              <td>' . date('d-m-Y', strtotime($rs->created_at)) . '</td>
              <td>
        
                <div class="btn-group me-2 mb-2 mb-sm-0">
                  <a  data-bs-toggle="dropdown" aria-expanded="false">
                       <i class="mdi mdi-dots-vertical ms-2"></i>
                  </a>
                  <div class="dropdown-menu">
                      <a class="dropdown-item text-primary mx-1 editIcon " id="'. $rs->id.'"  data-bs-toggle="modal" data-bs-target="#editModal" title="Modifier"><i class="far fa-edit"></i> Modifier</a>
                      <a class="dropdown-item text-danger mx-1 deleteIcon"  id="'. $rs->id .'"  href="#"><i class="far fa-trash-alt"></i> Supprimer</a>
                  </div>
               </div>
              
              
               
              </td>
            </tr>';
                $nombre++;
            }

            echo $output;
        } else {
            echo ' <tr>
        <td colspan="5">
        <center>
          <h6 style="margin-top:1% ;color:#c0c0c0"> 
          <center><font size="50px"><i class="far fa-trash-alt"  ></i> </font><br><br>
         Ceci est vide  !</center> </h6>
        </center>
        </td>
        </tr>';
        }
    }

    // insert a new folder ajax request
    public function store(Request $request)
    {
        try {
            $title = $request->libelle;
            $check = Banque::where('libelle', $title)->first();
            if ($check) {
                return response()->json([
                    'status' => 201,
                ]);
            } else {

                $banque = new Banque();
                $banque->libelle = $request->libelle;
                $banque->userid = Auth()->user()->id;
                $banque->save();
                return response()->json([
                    'status' => 200,
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 202,
            ]);
        }
    }

    // edit an folder ajax request
    public function edit(Request $request)
    {
        $id = $request->id;
        $fon = Banque::find($id);
        return response()->json($fon);
    }

    // update an folder ajax request
    public function update(Request $request)
    {
        try {


            $title = $request->blibelle;
            $check = Banque::where('libelle', $title)->first();
            if ($check) {
                return response()->json([
                    'status' => 201,
                ]);
            } else {

                $emp = Banque::find($request->bid);

                if ($emp->userid == Auth::id()) {

                    $emp->libelle = $request->blibelle;
                    $emp->update();
                    return response()->json([
                        'status' => 200,
                    ]);
                } else {
                    return response()->json([
                        'status' => 205,
                    ]);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 202,
            ]);
        }
    }

    // supresseion
    public function delete(Request $request)
    {
        try {

            $emp = Banque::find($request->id);
            if ($emp->userid == Auth::id()) {
                $id = $request->id;
                Banque::destroy($id);
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
