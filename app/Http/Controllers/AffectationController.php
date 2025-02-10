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
    $title = 'Affectation';

    $idp = session()->get('id');
    $exerciceId = session()->get('exercice_id');

    if (!$idp && !$exerciceId) {
      // Gérer le cas où l'ID du projet et exercice est invalide
      return redirect()->back()->with('error', "La session du projet et de l'exercice est terminée. Vous allez être redirigé...");
    }

    $member = DB::table('personnels')
      ->join('users', 'personnels.id', '=', 'users.personnelid')
      ->select('personnels.nom', 'personnels.prenom','users.id as userid')
      ->get();

    $existe = DB::table('affectations')
      ->join('users', 'affectations.memberid', '=', 'users.id')
      ->select('affectations.*')
      ->where('affectations.projectid', $idp)
      ->get();

    return view(
      'affectation.affectation',
      [
        'title'  => $title,
        'member' => $member,
        'existe' => $existe
      ]
    );
  }
}
