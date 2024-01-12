<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Contact;
use App\Models\Folder;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppCOntroller extends Controller
{
    public function index ()
    {
      $title="Dashboard";
      $active = "Dashboard";
      $project = Project::all();
      $user = User::all();
      $activite= Activity::all();
      $encours = Project::where('statut',1)->Count();
      $folder = Folder::all();
    //  $dernier = Project::orderBy('id', 'DESC')->limit(1)->get();
      
      return view('dashboard.dashboard', 
      [

        'title' =>$title,
        'active' => $active,
        'project' => $project,
        'user' => $user,
        'activite' => $activite,
        'encours' => $encours,
        'folder' => $folder

      ]);
    }


    public function findClaseur(Request $request){
        $data=DB::table('projects')
                ->select('annee')
                ->where('numerodossier',$request->id)
                ->distinct()
                ->get();
        return response()->json($data);
	}


	public function findAnnee(Request $request){
		$p=DB::table('projects')
          ->select('title')
          ->where('annee',$request->id)
          ->get();
          
    $output = '';
    if ($p->count() > 0) {
      foreach ($p as $rs) {
    $output .='<tr class="hover-actions-trigger btn-reveal-trigger position-static">
                <td class="city align-middle white-space-nowrap text-900">'. $rs->title. '  </td>
              </tr>';
      
      }
      echo $output;
    } else {
      echo '
      <tr class="hover-actions-trigger btn-reveal-trigger position-static">
        <td  rowspan="5" class="customer align-middle white-space-nowrap" align="center">
          <h4 class="text-center text-secondery my-3" >No record in the database ! </h4>
        </td>
      </tr>';
    }
	}




    public function logout()
    {
      Auth::logout();
      return redirect('login');
    }

}
