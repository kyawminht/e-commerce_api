<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class LocationController extends Controller
{
    public function index()
    {
        $locations=Location::paginate(10);
        if (!$locations){
            return response()->json([
                'message'=>"Locations not found"
            ],404);
        }

        return response()->json([
            'locations'=>$locations
        ],200);

    }

    public function store(Request $request)
    {
        if (Auth::check()) {
            $validator = Validator::make($request->all(), [
                'street' => 'required|string',
                'area' => 'required|string',
                'building' => 'required|string',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 422);
            }
    
            $userId = Auth::id();
    
            $location = Location::create([
                'street' => $request->street,
                'area' => $request->area,
                'building' => $request->building,
                'user_id' => $userId,
            ]);
    
            return response()->json([
                'message' => 'Location created successfully',
                'location' => $location,
            ], 201);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
    
    public function update(Request $request, Location $location)
{
    // Check if the user is authenticated
    if (Auth::check()) {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'street' => 'required|string',
            'area' => 'required|string',
            'building' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        // Get the authenticated user's ID
        $userId = Auth::id();

        // Check if the authenticated user is the owner of the location
        if ($location->user_id == $userId) {
            // Update the location
            $location->update([
                'street' => $request->street,
                'area' => $request->area,
                'building' => $request->building,
            ]);

            return response()->json([
                'message' => 'Location updated successfully',
                'location' => $location,
            ], 200);
        } else {
            // Return an unauthorized response if the user is not the owner of the location
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    } else {
        // Return an unauthorized response if the user is not authenticated
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
    public function destroy($location)
    {
        $location=Location::find($location);

        if (!$location){
            return response()->json([
                'message'=>'location not found',
            ],404);
        }

        return response()->json([
            'message'=>'location deleted successfully.',
        ]);


    }
}
