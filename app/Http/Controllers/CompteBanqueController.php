<?php

namespace App\Http\Controllers;

use App\Models\Banque;
use App\Models\Comptebanques;
use App\Models\Devise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompteBanqueController extends Controller
{

    public function index()
    {
        $comptes = DB::table('comptebanques')
                  ->join('banques', 'comptebanques.banque_id', 'banques.id')
                  ->select('comptebanques.*', 'banques.libelle as banque_name')
                  ->get();

        $title="Compte";
        $banques = Banque::all();
        $devises  = Devise::all();
        return view('Agrel.comptebanque.index', compact('comptes','banques','title','devises'));
    }


    public function store(Request $request)
    {
    
         $comptes = new  Comptebanques();

         $comptes->banque_id = $request->banque_id;
         $comptes->devise= $request->devise;
         $comptes->numero_compte = $request->numero_compte;
         
         $comptes->save();

        return redirect()->back()->with('success', 'Compte bancaire créé avec succès.');
    }

    public function show(Comptebanques $comptebanque)
    {
        return view('comptebanque.show', compact('comptebanque'));
    }

    public function edit(Comptebanques $comptebanque)
    {
        return view('comptebanque.edit', compact('comptebanque'));
    }

    public function update(Request $request, Comptebanques $comptebanque)
    {
        $validatedData = $request->validate([
            'banque_id' => 'required|exists:banques,id',
            'numero_compte' => 'required|unique:comptebanque,numero_compte,' . $comptebanque->id,
            'solde' => 'required|numeric',
        ]);

        $comptebanque->update($validatedData);

        return redirect()->route('comptebanque.index')->with('success', 'Compte bancaire mis à jour avec succès.');
    }

    public function destroy(Comptebanques $comptebanque)
    {
        $comptebanque->delete();

        return redirect()->route('comptebanque.index')->with('success', 'Compte bancaire supprimé avec succès.');
    }
}
