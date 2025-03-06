<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workshop;

class BookingController extends Controller
{
    public function bookWorkshop(Request $request)
    {
        // Retrieve workshop names from the request (e.g., save1, save2, save3, etc.)
        $workshopNames = $request->only(['save1', 'save2', 'save3']);
        
        // Initialize an array to hold the workshop objects
        $workshops = [];

        // Loop through the workshop names
        foreach ($workshopNames as $workshopName) {
            // Fetch the workshop by name (assuming 'name' is the field storing the workshop name)
            $workshops[] = Workshop::where('name', $workshopName)->first();
        }

        // Loop through the workshops to check capacity and book
        foreach ($workshops as $workshop) {
            // Ensure the workshop exists and has available capacity
            if ($workshop && $workshop->capacity > 0) {
                // Decrease capacity for this workshop by 1
                $workshop->capacity -= 1;
                $workshop->save(); // Save the updated capacity
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No available spots for some of the workshops.'
                ], 400);
            }
        }

        return response()->json(['status' => 'success', 'message' => 'All workshops booked successfully.']);
    }
}
