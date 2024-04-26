<?php

namespace App\Http\Controllers;

use App\Models\Feuilletemps;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeuilletempsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    $title = 'Feuille de temps';
    $projets = Project::where('statut', 'Activé')->get();
    return view('feuilletemps.index', 
    [
        'title'  => $title,
        'projet' => $projets

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
