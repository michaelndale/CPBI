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
      $data = Notification::all();
      return view(
        'notification.index',
        [
          'title' => $title,
          'active' => $active,
          'data'  => $data
        ]
      );
    }
  
}
