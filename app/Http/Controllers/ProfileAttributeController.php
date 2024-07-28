<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\ProfileAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class ProfileAttributeController extends BaseController
{
    // Tuorial su come creare il controller e i suoi metodi
    // https://dev.to/rizqyep/simple-crud-rest-api-with-lumen-mysql-eloquent-orm-dkf

    // List all profile attribute
    public function index()
    {
        $attribute = ProfileAttribute::all();

        // Return the list of profile attribute with a 200 status code
        return response()->json($attribute, 200);
    }

    // Create a new profile attribute
    public function create(Request $request, $profile_id = null)
    {
        if (!Profile::find($profile_id)) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        // Validation rules
        $rules = [
            'attribute' => 'required|string|max:255',
        ];

        // Create a validator instance and validate the request
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create and save the new profile attribute
        $attribute = new ProfileAttribute();
        $attribute->profile_id = $profile_id;
        $attribute->attribute = strip_tags($request->input('attribute'));
        $attribute->save();

        // Return the created profile attribute with a 201 status code
        return response()->json($attribute, 201);
    }

    // Show a specific profile attribute by ID
    public function show($id = null, $profile_id = null)
    {
        if (!Profile::find($profile_id)) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        if ($id) {

            // Find the profile attribute by ID
            $attribute = ProfileAttribute::find($id);

            // Check if the profile attribute exists
            if (!$attribute) {
                return response()->json(['error' => 'Profile Attribute not found'], 404);
            }

            // Return the found profile with a 200 status code
            return response()->json($attribute, 200);
        } else {

            // List all profile attribute
            $attribute = ProfileAttribute::all();

            // Return the list of profile attribute with a 200 status code
            return response()->json($attribute, 200);
        }
    }

    // Update an existing profile attribute
    public function update(Request $request, $id = null, $profile_id = null)
    {
        if (!Profile::find($profile_id)) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        // Find the profile by ID
        $attribute = ProfileAttribute::find($id);

        // Check if the profile exists
        if (!$attribute) {
            return response()->json(['error' => 'Profile Attribute not found'], 404);
        }

        // Validation rules
        $rules = [
            'attribute' => 'required|string|max:255',
        ];

        // Create a validator instance and validate the request
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update and save the profile attribute
        $attribute->profile_id = $profile_id;
        $attribute->attribute = strip_tags($request->input('attribute'));
        $attribute->save();

        // Return the updated profile attribute with a 200 status code
        return response()->json($attribute, 200);
    }

    // Delete a profile attribute by ID
    public function delete($id = null, $profile_id = null)
    {
        if (!Profile::find($profile_id)) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        // Find the profile attribute by ID
        $attribute = ProfileAttribute::find($id);

        // Check if the profile attribute exists
        if (!$attribute) {
            return response()->json(['error' => 'Profile Attribute not found'], 404);
        }

        // Soft delete the profile attribute
        $attribute->delete();

        // Return a success message with a 200 status code
        return response()->json(['success' => 'Profile Attribute deleted successfully'], 200);
    }
}
