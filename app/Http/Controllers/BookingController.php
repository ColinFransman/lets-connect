<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workshop;
use App\Models\WorkshopMoment;
use App\Models\Bookings;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function bookWorkshop(Request $request)
    {
        // Retrieve workshop names from the request (e.g., save1, save2, save3, etc.)
        $workshopNames = $request->only(['save1', 'save2', 'save3']);
        
        // Initialize an array to hold the workshop objects
        $workshops = [];
        // Loop through the workshop names to fetch workshop data
        foreach ($workshopNames as $workshopName) {
            // Fetch the workshop by name (assuming 'name' is the field storing the workshop name)
            $workshops[] = Workshop::where('name', $workshopName)->first();
        }

        $errormessage = "";

        // Loop through the workshops and check if there are available spots
        foreach ($workshops as $index => $workshop) {
            // Get the workshop moment based on the index (assuming moments are 1, 2, 3)
            $wm = WorkshopMoment::with(['workshop', 'bookings'])
                ->where('workshop_id', $workshop->id)
                ->where('moment_id', $index + 1)
                ->first();
            
            // Check if the workshop has available spots
            if ($wm->workshop->capacity < $wm->bookings->count()) {
                $errormessage .= "Workshop " . ($index + 1) . " was unavailable. ";
            }
        }

        // If there's an error message, return it
        if ($errormessage) {
            return response()->json([
                'status' => 'error',
                'message' => $errormessage
            ], 400);
        }

        // Proceed with booking if no error
        // Check if the user has any existing bookings
        if (Bookings::where('student_id', auth()->id())->count() < 1) {
            // Create new bookings for each workshop moment
            foreach ($workshops as $index => $workshop) {
                $wm = WorkshopMoment::where('workshop_id', $workshop->id)
                    ->where('moment_id', $index + 1)
                    ->first();
                
                Bookings::create([
                    'wm_id' => $wm->id,
                    'student_id' => auth()->id(),
                ]);
            }
        } else {
            // Update existing bookings for each workshop moment
            foreach ($workshops as $index => $workshop) {
                $wm = WorkshopMoment::where('workshop_id', $workshop->id)
                    ->where('moment_id', $index + 1)
                    ->first();
                
                DB::table('bookings')
                    ->where('student_id', auth()->id())
                    ->whereRaw("MOD(id, 3) = ?", [$index + 1])
                    ->update(['wm_id' => $wm->id]);
            }
        }

        return redirect('/send-mail');
    }
}
