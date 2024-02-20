<?php

namespace App\Http\Controllers;

use App\Models\Observationactivite;
use Illuminate\Http\Request;

class ObservationactiviteController extends Controller
{
    public function fetchAllcommente(Request $request )
    {
      $id = $request->id;
      $observe = Observationactivite::where('activiteid',$id)->first();
      $output = '';
      
      if($observe==null){
        echo '<h3 class="text-center text-secondery my-5" > Ceci est vide ! </h3>';
      }else{
      if ($observe->count() > 0) {
        
        $nombre = 1;
        foreach ($observe as $rs) {
          $output .= '
          <li class="active">
          <a href="#" class="mt-0">
              <div class="d-flex">
                  
                  <div class="user-img online align-self-center me-3">
                      <img src="assets/images/users/avatar-4.jpg" class="rounded-circle avatar-xs" alt="avatar-2">
                      <span class="user-status"></span>
                  </div>
                  
                  <div class="flex-1 overflow-hidden">
                      <h5 class="text-truncate font-size-14 mb-1">Frank Vickery</h5>
                      <p class="text-truncate mb-0">' . $rs->message . '</p>
                  </div>
                  <div class="font-size-11">04 min</div>
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
}
