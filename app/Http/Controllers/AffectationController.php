<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Project;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AffectationController extends Controller
{
  // Affectation store
  public function storeAffectation(Request $request)
  {


    $projectId = $request->project_id;
    $members = $request->personnel;

    // Supprimer les affectations existantes pour ce projet
    Affectation::where('projectid', $projectId)->delete();

    // Parcourir les membres sélectionnés
    foreach ($members as $memberId) {
   

      // Vérifier si l'utilisateur est sélectionné
      if (in_array($memberId, $members)) {
        // Créer une nouvelle affectation
        Affectation::create([
          'projectid' => $projectId,
          'memberid' => $memberId
        ]);
      }
    }

    return redirect()->back()->with('success', 'Mise à jour réussi avec succès..');
  }

  public function index()
  {
    $title = 'Affectation project';
    $active = 'Project';
    $idp = session()->get('id');

    $member = DB::table('personnels')
      ->join('users', 'personnels.id', '=', 'users.personnelid')
      ->select('users.*', 'personnels.*', 'users.personnelid as personnelid')
      ->get();




    $existe = DB::table('affectations')
      ->join('users', 'affectations.memberid', '=', 'users.personnelid')
      ->select('affectations.*')
      ->where('affectations.projectid', $idp)
      ->get();

    return view(
      'affectation.affectation',
      [
        'title'  => $title,
        'active' => $active,
        'member' => $member,
        'existe' => $existe
      ]
    );
  }
}
