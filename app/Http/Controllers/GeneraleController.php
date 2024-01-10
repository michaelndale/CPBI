<?php

namespace App\Http\Controllers;

use App\Http\Requests\GeneralRequest;
use App\Models\general;
use Exception;
use Illuminate\Http\Request;

class GeneraleController extends Controller
{


    public function edit(general $general)
    {
        $title="General";
        return view('general.edit', 
        [
          'title' =>$title,
          'data' => $general
        ]);
    }

    public function update(general $general, GeneralRequest $request)
    {
      try {

        if(!empty($request->urllogo)):
          $imageName=time().'.'.$request->urllogo->extension();
           $request->urllogo->move(public_path('images/logo/'),$imageName);
           $ancien_logo = ('images/logo/').$imageName;
        else:
          $ancien_logo = $request->ancien_logo;
        endif;

        if(!empty($request->urlfavicon)):
          $imageName=time().'.'.$request->urlfavicon->extension();
           $request->urlfavicon->move(public_path('images/logo/'),$imageName);
           $ancien_favicon = ('images/logo/').$imageName;
        else:
          $ancien_favicon = $request->ancien_favicon;
        endif;
      
        $general->namesite = $request->namesite;
        $general->adresse = $request->adress;
        $general->email = $request->email;
        $general->other_email = $request->other_email;
        $general->phone = $request->phone;
        $general->other_phone = $request->other_phone;
        $general->description = $request->description;
        $general->map_adresse = $request->map_adresse;
        $general->url_facebook = $request->url_facebook;
        $general->url_twitter = $request->url_twitter;
        $general->url_youtube = $request->url_youtube;
        $general->url_instagramm= $request->url_instagramm;
        $general->url_paypal = $request->url_paypal;
        $general->urllogo = $ancien_logo;
        $general->urlfavicon =$ancien_favicon ;

        $general->update();

        return redirect()->back()->with('success', 'Update information is successfully .');
         
      } catch (Exception $e) {
        return redirect()->back()->with('success', 'Errot Update information ');
      }


          
        
  }
   
}
