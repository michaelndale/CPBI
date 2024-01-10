<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
      $title = 'Notifications';
      $active = "Parameter";
      return view(
        'notification.index',
        [
          'title' => $title,
          'active' => $active
        ]
      );
    }
  
    public function fetchAll()
    {
      $notis= Notification::all();
      $output = '';
      if ($notis->count() > 0) {
        $output .= '  <table class="table table-sm fs--1 mb-0">
          <thead>
            <tr>
            <th class="sort border-top ps-1" data-sort="name">Date</th>
              <th class="sort border-top ps-1" data-sort="name">Operation</th>
              <th class="sort border-top ps-1" data-sort="name">User</th>
              <th class="sort border-top ps-1" data-sort="name">Link</th>
             
            </tr>
          </thead>
          <tbody class="list">
           ';
        $nombre = 1;
        foreach ($notis as $rs) {
          $output .= '<tr>
              <td>' . ucfirst($rs->updated_at). '</td>
              <td>' . ucfirst($rs->operation). '</td>
              <td>' . ucfirst($rs->user). '</td>
              <td><a href="'.$rs->link.'"> Show</a></td>
             
             
            </tr>';
          $nombre++;
        }
        $output .= '</tbody></table>';
        echo $output;
      } else {
        echo '<h3 class="text-center text-secondery my-5" >  No record in the database ! </h3>';
      }
    }
}
