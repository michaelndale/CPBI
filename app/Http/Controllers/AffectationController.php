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

        $request->validate([
            'project_id' =>'required',
            'personnel' =>'required'
        ]);

        $prid =$request->project_id;
        $dele=  Affectation::where('projectid',$prid)->delete();
        if($dele){
            for($i=0; $i < count ($request->personnel); $i++)
            {
                $module_affectation = [
                    'projectid' => $request->project_id,
                    'userid' => Auth::id(),
                    'role' => $request->role[$i],
                    'memberid' => $request->personnel[$i],
                ];
                DB::table('affectations')->insert($module_affectation);
            }

            return redirect()->back()->with('success', 'Mise à jour réussi avec succès..');

        }else{
            for($i=0; $i < count ($request->personnel); $i++)
            {
                $module_affectation = [
                    'projectid' => $request->project_id,
                    'memberid' => $request->personnel[$i],
                    'role' => $request->role[$i],
                    'userid' => Auth::id(),
                    
                ];
                DB::table('affectations')->insert($module_affectation);
            }

            return redirect()->back()->with('success', 'Mise à jour réussi avec succès..');
        }

        
     }



    public function index ()
    {
      $title='Affectation project';
      $member = DB::table('personnels')->orWhere('fonction', '!=','Chauffeur')->get();
      $active = 'Project';

      $idp = session()->get('id');

      $existe = DB::table('affectations')
      ->join('users', 'affectations.memberid', '=', 'users.id')
      ->select('affectations.*' )
      ->where('affectations.projectid',$idp)
      ->get();

      return view('affectation.affectation', 
        [
          'title'  => $title,
          'active' => $active,
          'member' => $member,
          'existe' => $existe
      ]);
    }
 
}
