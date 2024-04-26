<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Contact;
use App\Models\Folder;
use App\Models\Project;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
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
      $encours = Project::where('statut','Activé')->Count();
      $folder = Folder::orderBy('title', 'ASC')->get();
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
      try {
        $data=DB::table('projects')
                ->select('annee')
                ->where('numerodossier',$request->id)
                ->distinct()
                ->get();
     
        return response()->json($data);

     
      } catch (Exception $e) {
        return response()->json([
          'status' => 202,
        ]);
      }
       
	}


	public function findAnnee(Request $request){
    try {
        $anne = $request->id;
        $docid = $request->docid;

        

        $p = DB::table('projects')
            ->select('numeroprojet', 'title', 'start_date', 'deadline', 'annee', 'id', 'statut')
            ->where('annee', $anne)
            ->where('numerodossier', $docid)
            ->orderBy('id', 'DESC')
            ->get();

        $output = '';
        if ($p->count() > 0) {
            $nombre = 1;
            foreach ($p as $rs) {
              $cryptedId = Crypt::encrypt($rs->id);
                $output .= '<tr class="hover-actions-trigger btn-reveal-trigger position-static">
                            <td class="closed-won border-end"><b><a href="project/'.$cryptedId.'/view"># '. ucfirst($rs->numeroprojet) .' </a></b></td>
                            <td class="closed-won border-end ">' . ucfirst($rs->title) . '</td>
                            <td class="closed-won border-end ">' . date('d-m-Y', strtotime($rs->start_date)) . '</td>
                            <td class="closed-won border-end ">' . date('d-m-Y', strtotime($rs->deadline))  . '</td>
                            <td class="closed-won border-end ">' . $rs->statut . '</td>
                            <td class="closed-won border-end ">' . $rs->annee  . '</td>
                </tr>';
                $nombre++;
            }
            return response()->json($output);
        } else {
            return response()->json([
                'message' => 'Ceci est vide !',
            ]);
        }
    } catch (Exception $e) {
      return response()->json([
        'status' => 202,
      ]);
    }
}




}
