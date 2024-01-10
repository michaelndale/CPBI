<?php

namespace App\Http\Controllers;

use App\Models\Identification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\New_;

class IdentificationController extends Controller
{
    public function index()
    {
      $active = 'Parameter';
      $title = 'New Indetification';
      $info = identification::all();
    

      if($info->count() <= 0){
      
        return view(
            'info.index',
            [
              'title' => $title,
              'active' => $active

            ]
          );

      }else{
       
        return view(
            'info.edit',
            [
              'title' => $title,
              'active' => $active,
              'info' => $info,
              
            ]
          );
      }

     
    }

     // insert a new employee ajax request
     public function store(identification $info, Request $request)
     {

      try {
        if ($request->hasFile('file')) {
          $file = $request->file('file');
          $fileName = time() . '.' . $file->getClientOriginalExtension();
          $file->storeAs('public/info', $fileName); //php artisan storage:link
        } else {
            $fileName =  '';
        }
  
         $info = new identification;

         $info->nominstitution= $request->name;
         $info->nif = $request->nif;
         $info->adresse= $request->adresse;
         $info->email= $request->email;
         $info->phone= $request->phone;
         $info->bp=$request->bp;
         $info->fax=$request->fax;
         $info->description= $request->description;
         $info->urlogo= $fileName;
         $info->userid = Auth()->user()->id;

         $info->save();

         return response()->json([
           'status' => 200,
         ]);

    } catch (Exception $e) {
      return response()->json([
        'status' => 201,
      ]);
    }
      
    
     
     }

       // insert a new employee ajax request
       public function edit(Request $request)
       {
        $fileName = '';
        $emp = identification::find($request->info_id);
      
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/info', $fileName); //php artisan storage:link
            if ($emp->urllogo) {
                Storage::delete('public/info/'.$emp->urllogo);
            }
        } else {
            $fileName = $request->emp_avatar;
        }
                
        $emp->nominstitution= $request->name;
        $emp->nif = $request->nif;
        $emp->adresse= $request->adresse;
        $emp->email= $request->email;
        $emp->phone= $request->phone;
        $emp->bp=$request->bp;
        $emp->fax=$request->fax;
        $emp->description= $request->description;
        $emp->urlogo= $fileName;
        $emp->userid = Auth()->user()->id;
        $emp->Update();
         
         return response()->json([
           'status' => 200,
         ]);

       }

}
