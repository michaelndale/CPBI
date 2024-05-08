<?php

namespace App\Http\Controllers;

use App\Models\Optiondescription;
use Illuminate\Http\Request;

class OptiondescriptionController extends Controller
{
    

    public function storeOPtion(Request $request)
    {
        $request->validate([
            'value' => 'required|unique:options,value',
        ]);

        $option = new Optiondescription();
        $option->titre = $request->titre;
        $option->save();

        return response()->json($option);
    }
}
