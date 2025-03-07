<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workshop;
use App\Models\WorkshopMoment;
use App\Models\Bookings;

class BookingController extends Controller
{
    public function bookWorkshop(Request $request)
    {
        // Retrieve workshop names from the request (e.g., save1, save2, save3, etc.)
        $workshopNames = $request->only(['save1', 'save2', 'save3']);
      //  dd($workshopNames);
        
        // Initialize an array to hold the workshop objects
        $workshops = [];
        // Loop through the workshop names to fetch workshop data
        foreach ($workshopNames as $workshopName) {
            // Fetch the workshop by name (assuming 'name' is the field storing the workshop name)
            $workshops[] = Workshop::where('name', $workshopName)->first();
        }

        $wm1 = WorkshopMoment::where('workshop_id' , $workshops[0])->where("moment_id",1);
        $wm2 = WorkshopMoment::where('workshop_id' , $workshops[1])->where("moment_id",2);
        $wm3 = WorkshopMoment::where('workshop_id' , $workshops[2])->where("moment_id",3);

        if( $wm1->workshop->capacity > $wm1->bookings->count() &&
             $wm2->workshop->capacity > $wm2->bookings->count() &&
             $wm3->workshop->capacity > $wm3->bookings->count())
        {
            Booking::create([
            'wm_id' => $wm1->id,
            'user_id' => auth()->id(),
            ]);
    
            Booking::create([
                'wm_id' => $wm2->id,
                'user_id' => auth()->id(),
            ]);   
            Booking::create([
                'wm_id' => $wm3->id,
                'user_id' => auth()->id(),
            ]);
        }else {
            // If no spots are available, return an error for the specific workshop
            return response()->json([
                'status' => 'error',
                'message' => 'No available spots for the workshop: ' . $workshop->name
            ], 400);
        };
/*

        // Loop through the workshops to check availability and book
        foreach ($workshops as $workshop) {
            // Ensure the workshop exists

            if ($workshop) {
                // Fetch the number of bookings for this workshop
                $currentBookingsCount = Bookings::where('wm_id', $workshop->id)->count();
                
                // Calculate the current available capacity without modifying the workshop's capacity field
                $currentCapacity = $workshop->capacity - $currentBookingsCount;
                
                if ($currentCapacity > 0) {
                    // Proceed with the booking
                    Booking::create([
                        'wm_id' => $workshop->id,
                        'user_id' => auth()->id(),
                    ]);
                } else {
                    // If no spots are available, throw an exception
                    throw new \Exception("No available spots for the workshop: " . $workshop->name);
                }
                dd($currentBookingsCount);

                // Check if there is available capacity
                if ($currentCapacity > 0) {
                    // The workshop has available spots, so proceed with the booking
                    // You can add a new booking for the user here
                    // Booking::create(['workshop_id' => $workshop->id, 'user_id' => auth()->id()]);

                    // Optionally, if you want to store the booking, you could save it like this:
                    // $booking = new Booking();
                    // $booking->workshop_id = $workshop->id;
                    // $booking->user_id = auth()->id();
                    // $booking->save();
                } 
        }
*/
        return response()->json(['status' => 'success', 'message' => 'All workshops booked successfully.']);
    }
}
