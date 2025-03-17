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

        // Initialize the error message
        $errormessage = "";

        // Loop through the workshops and check if there are available spots
        foreach ($workshops as $index => $workshop) {
            // Get the workshop moment for the current index
            $wm = $this->getWorkshopMoment($workshop->id, $index + 1);

            // Check if the workshop moment has available spots
            if (!$this->checkWorkshopMomentCapacity($wm)) {
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
                $wm = $this->getWorkshopMoment($workshop->id, $index + 1);
                
                Bookings::create([
                    'wm_id' => $wm->id,
                    'student_id' => auth()->id(),
                ]);
            }
        } else {
            // Update existing bookings for each workshop moment
            foreach ($workshops as $index => $workshop) {
                $wm = $this->getWorkshopMoment($workshop->id, $index + 1);
                
                DB::table('bookings')
                    ->where('student_id', auth()->id())
                    ->whereRaw("MOD(id, 3) = ?", [$index + 1])
                    ->update(['wm_id' => $wm->id]);
            }
        }

        return redirect('/send-mail');
    }

    private function getWorkshopMoment($workshopId, $momentId)
    {
        return WorkshopMoment::with(['workshop', 'bookings'])
            ->where('workshop_id', $workshopId)
            ->where('moment_id', $momentId)
            ->first();
    }
    private function checkWorkshopMomentCapacity($wm)
    {
        return $wm && $wm->workshop->capacity > $wm->bookings->count();
    }

    public function viewCapacity()
    {
        // Get all workshops along with their moments and bookings count
        $workshops = Workshop::with(['workshopMoments' => function ($query) {
            $query->withCount('bookings');  // Get the count of bookings for each moment
        }])->get();
    
        // Prepare the response data in a structured format
        $data = $workshops->map(function ($workshop) {
            return [
                'workshop_name' => $workshop->name, // Return the name of the workshop
                'moments' => $workshop->workshopMoments->map(function ($moment) use ($workshop) {
                    return [
                        'workshop_id' => $workshop->id, // Workshop ID
                        'capacity' => $moment->workshop->capacity, // Workshop capacity
                        'wm_id' => $moment->id, // Workshop moment ID (wm_id)
                        'bookings' => $moment->bookings_count,
                        'status' => $moment->bookings_count >= $moment->workshop->capacity
                            ? 'Fully booked' 
                            : 'Available spots', // Booking status
                    ];
                })
            ];
        });
    
        // Check if $data is not empty
        if ($data->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No data available',
            ], 404); // Return an error message if no data exists
        }
    
        // If data exists, return success with the data
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }    
}
