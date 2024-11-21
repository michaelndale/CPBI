<?php

namespace App\Http\Controllers;

use App\Models\PaysModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaysController extends Controller
{
   
    /**
     * Display a listing of the countries.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title="Pays";
        return view('pays.index', compact('title'));
    }

    public function liste()
    {
        try {
            $pays = PaysModel::all(); // Retrieve all countries

            if ($pays->isEmpty()) {
                return response()->json([
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'No countries found.'
                ], 404);
            }

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Countries retrieved successfully.',
                'data' => $pays
            ], 200);

        } catch (\Exception $e) {
        
            // Return a JSON response with an error message and 500 status code
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'An error occurred while retrieving countries.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created country in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Validate the form data
            $validatedData = $request->validate([
              
                'name' => 'required|string|max:225|unique:pays_models',
                'currenty_code' => 'required|string',
                'phone_code' => 'required|string|max:5',
        
            ]);
    
            // Create a new instance of the PaysModel and set the attributes
            $pays = new PaysModel();

            $pays->user_id = Auth::id();
            $pays->name = $validatedData['name'];
            $pays->currenty_code = $validatedData['currenty_code'];
            $pays->phone_code = $validatedData['phone_code'];
       
    
            // Save the new country to the database
            $pays->save();
    
            // Return a success response with the newly created country data
            return response()->json([
                'code' => 201,
                'status' => 'success',
                'message' => 'Country created successfully',
                'new' => $pays
            ], 201);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation exceptions
            return response()->json([
                'code' => 422,
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
    
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Failed to create country',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Display the specified country.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pays = PaysModel::find($id);

        if (!$pays) {
            return response()->json(['error' => 'Country not found'], 404);
        }

        return response()->json($pays);
    }

    /**
     * Update the specified country in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pays = PaysModel::find($id);

        if (!$pays) {
            return response()->json(['error' => 'Country not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'string|max:225',
            'currenty_code' => 'string|size:3',
            'phone_code' => 'string|max:5',
        
        ]);

        $pays->update($validatedData);

        return response()->json([
            'message' => 'Country updated successfully',
            'data' => $pays
        ]);
    }

    /**
     * Remove the specified country from the database (soft delete).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // Find the country by ID, or return a 404 if not found
            $pays = PaysModel::findOrFail($id);
    
            // Delete the country
            $pays->delete();
    
            // Return success response
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Country deleted successfully'
            ], 200);
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle the case where the country is not found
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'Country not found'
            ], 404);
    
        } catch (\Exception $e) {
            // Handle any other errors
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'An error occurred while deleting the country.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    
    


}
