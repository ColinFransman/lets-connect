<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workshop;

class BookingController extends Controller
{
    public function bookWorkshop(Request $request, Workshop $workshop)
    {
        // Check if there is capacity
        if ($workshop->capacity > 0) {
            // If booking is successful, decrease capacity by 1
            $workshop->capacity -= 1;
            $workshop->save(); // Save the updated capacity

            return response()->json(['status' => 'success', 'message' => 'Workshop booked successfully.']);
        }

        // If no capacity available
        return response()->json(['status' => 'error', 'message' => 'No available spots.'], 400);
    }
}

