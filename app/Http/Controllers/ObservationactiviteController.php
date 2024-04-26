<?php

namespace App\Http\Controllers;

use App\Models\Observationactivite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObservationactiviteController extends Controller
{
    public function fetchAllcommente(Request $request )
    {
      $id = $request->id;
      $observe =DB::table('observationactivites')
                ->join('users','observationactivites.userid', 'users.id')
                ->select('observationactivites.*','users.avatar','users.identifiant')
                ->where('activiteid',$id)->get();
      $output = '';
      
    
      if ($observe->count() > 0) {
        
        $nombre = 1;
        foreach ($observe as $rs) {
          $output .= '
          <li class="active">
          <a href="#" class="mt-0">
              <div class="d-flex">
                  
                  <div class="user-img online align-self-center me-3">
                      <img src="../../element/profile/default.png" class="rounded-circle avatar-xs" alt="avatar-2">
                      <span class="user-status"></span>
                  </div>
                  
                  <div class="flex-1 overflow-hidden">
                      <h5 class="text-truncate font-size-14 mb-1">@'. $rs->identifiant .'</h5>
                      <p class="text-truncate mb-0">' . $rs->message . '</p>
                  </div>
                  <div class="font-size-11">' .date('d-m-Y', strtotime($rs->created_at)). '</div>
              </div>
          </a>
      </li>
        ';
          $nombre++;
        }
    
        echo $output;
      } else {
        echo '<h3 class="text-center text-secondery my-5" > Ceci est vide ! </h3>';
      }
    
}
}
