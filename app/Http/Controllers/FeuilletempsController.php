<?php

namespace App\Http\Controllers;

use App\Models\elementsfeuilletemps;
use App\Models\Feuilletemps;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeuilletempsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    $title = 'Feuille de temps';
    $projets = Project::where('statut', 'Activé')->get();
    $elfs= elementsfeuilletemps::all()->first();
    return view('feuilletemps.index', 
    [
        'title'  => $title,
        'projet' => $projets,
        'elf'    => $elfs

    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $title = $request->ftitle;
            $check = Feuilletemps::where('datepresence', $title)->first();
            if ($check) {
              return response()->json([
                'status' => 201,
              ]);
            } else {

      
              $feuille = new Feuilletemps();
              $feuille->userid = Auth::id();
              $feuille->projetid= $request->projetid;
              $feuille->datepresence= $request->datejour;
              $feuille->nombre= $request->nombre;
              $feuille->tempsmax= $request->tampsmax;
              $feuille->tempsmin= $request->tampsmin;
              $feuille->description= $request->description;
              

              $feuille->save();

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

    public function monfeuille()
    {
  
      $data = DB::table('feuilletemps')
            ->Join('projects', 'feuilletemps.projetid' , 'projects.id')
            ->select('feuilletemps.*','feuilletemps.id', 'projects.title')
            ->orderby('id','DESC')
            ->where('feuilletemps.userid' , Auth::id())
            ->get();
  
      $output = '';
      if ($data->count() > 0) {
        $nombre = 1;
        foreach ($data as $datas) {
          $output .= '
          <tr>
            <td> '.$nombre.'  </td>
            <td> '.date("d-m-Y", strtotime($datas->datepresence)).'  </td>
            <td> '.$datas->title.'  </td>
            <td> '.$datas->tempsmax.' </td>
            <td> '.$datas->nombre.' </td>
            <td> '.$datas->description.' </td>
           
            <td> 
            <center>
            <div class="btn-group me-2 mb-2 mb-sm-0">
              <button class="btn btn-primary btn-sm dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="mdi mdi-dots-vertical ms-2"></i> Action
              </button>
              <div class="dropdown-menu">
                
                  <a href="#" class="dropdown-item text-primary mx-1 editIcon " title="Modifier"><i class="far fa-edit"></i> Modifier dja</a>
              
                  <a class="dropdown-item text-danger mx-1 deleteIcon"  id="' . $datas->id . '"  href="#"><i class="far fa-trash-alt"></i> Supprimer dja</a>
              </div>
            </div>
            </center>
            </td>
       
           
          </tr>
        '
            ;
          $nombre++;
        }
        echo $output;
      } else {
        echo '<tr>
          <td colspan="9">
          <center>
            <h6 style="margin-top:1% ;color:#c0c0c0"> 
            <center><font size="10px"><i class="fa fa-info-circle"  ></i> </font><br><br>
            Ceci est vide  !</center> </h6>
          </center>
          </td>
          </tr>
          ';
      }
    }

    /**
     * Display the specified resource.
     */
    public function show(Feuilletemps $feuilletemps)
    {
        $dateOnthisMOnth= date('d-m-Y');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feuilletemps $feuilletemps)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feuilletemps $feuilletemps)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feuilletemps $feuilletemps)
    {
        //
    }
}
