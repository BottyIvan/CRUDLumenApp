<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\ProfileAttribute;
use FastRoute\RouteParser\Std;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;
use stdClass;

class ProfileController extends BaseController
{
    // Tuorial su come creare il controller e i suoi metodi
    // https://dev.to/rizqyep/simple-crud-rest-api-with-lumen-mysql-eloquent-orm-dkf

    // List all profiles
    public function index()
    {
        $profilesList = [];

        foreach (Profile::all() as $profile) {
            $profileAttribute = new stdClass();

            $profileAttribute->id = $profile->id;
            $profileAttribute->nome = $profile->nome;
            $profileAttribute->cognome = $profile->cognome;
            $profileAttribute->telefono = $profile->telefono;
            $profileAttribute->attribute = ProfileAttribute::where('profile_id', $profile->id)->get();
            $profileAttribute->created_at = $profile->created_at;
            $profileAttribute->updated_at = $profile->updated_at;
            $profileAttribute->deleted_at = $profile->deleted_at;

            $profilesList[] = $profileAttribute;
        }

        // Return the list of profiles with attributes with a 200 status code
        return response()->json($profilesList, 200);
    }

    // Create a new profile
    public function create(Request $request)
    {
        // Validation rules
        $rules = [
            'nome' => 'required|string|max:255',
            'cognome' => 'required|string|max:255',
            // Espressione regolare per verificare i numeri di telefono
            // https://stackoverflow.com/questions/16699007/regular-expression-to-match-standard-10-digit-phone-number
            'telefono' => 'required|regex:/^(\+\d{1,2}\s?)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/|max:20',
        ];

        // Create a validator instance and validate the request
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create and save the new profile
        $profile = new Profile();
        $profile->nome = strip_tags($request->input('nome'));
        $profile->cognome = strip_tags($request->input('cognome'));
        $profile->telefono = preg_replace('/^\+\d{1,2}\s?/', '', strip_tags($request->input('telefono')));
        $profile->save();

        // Return the created profile with a 201 status code
        return response()->json($profile, 201);
    }

    // Show a specific profile by ID or list all profiles if no ID is provided
    public function show($id = null)
    {
        if ($id) {

            // Find the profile by ID
            $profile = Profile::find($id);

            // Check if the profile exists
            if (!$profile) {
                return response()->json(['error' => 'Profile not found'], 404);
            }

            // Return the found profile with a 200 status code
            return response()->json($profile, 200);
        } else {

            // List all profiles
            $profiles = Profile::all();

            // Return the list of profiles with a 200 status code
            return response()->json($profiles, 200);
        }
    }

    // Update an existing profile
    public function update(Request $request, $id)
    {
        // Find the profile by ID
        $profile = Profile::find($id);

        // Check if the profile exists
        if (!$profile) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        // Validation rules
        $rules = [
            'nome' => 'required|string|max:255',
            'cognome' => 'required|string|max:255',
            // Espressione regolare per verificare i numeri di telefono
            // https://stackoverflow.com/questions/16699007/regular-expression-to-match-standard-10-digit-phone-number
            'telefono' => 'required|regex:/^(\+\d{1,2}\s?)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/|max:20',
        ];

        // Create a validator instance and validate the request
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update and save the profile
        $profile->nome = strip_tags($request->input('nome'));
        $profile->cognome = strip_tags($request->input('cognome'));
        $profile->telefono = preg_replace('/^\+\d{1,2}\s?/', '', strip_tags($request->input('telefono')));
        $profile->save();

        // Return the updated profile with a 200 status code
        return response()->json($profile, 200);
    }

    // Delete a profile by ID
    public function delete($id)
    {
        // Find the profile by ID
        $profile = Profile::find($id);

        // Check if the profile exists
        if (!$profile) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        // Delete the profile
        $profile->delete();

        // Return a success message with a 200 status code
        return response()->json(['success' => 'Profile deleted successfully'], 200);
    }
}
