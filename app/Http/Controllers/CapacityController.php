<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkshopMoment;
use App\Models\Workshop;

// class WorkshopDashboardController extends Controller
// {
//     public function index() 
//     {
//         return view('dashboard.workshops')->with('workshopmoments', WorkshopMoment::with(['workshop'], ['bookings'])->get());
                                        
//         //return view('dashboard.bookings')->with ('bookings',  Bookings::with(['student', 'workshopMoment.workshop', 'workshopMoment.moment'])->get());
//     }
//     public function showbookings(WorkShopMoment $wsm)
//     {
        
//         $wsm->load('bookings');
//         return view('dashboard.showbookings',compact('wsm'));
//     }

    
// }

class CapacityController extends Controller
{
    public function MomentCapacity(Request $request)
    {

        $workshopNames = $request->only(['save1', 'save2', 'save3']);

         // Initialize an array to hold the workshop objects
         $workshops = [];
         // Loop through the workshop names to fetch workshop data
         foreach ($workshopNames as $workshopName) {
             // Fetch the workshop by name (assuming 'name' is the field storing the workshop name)
             $workshops[] = Workshop::where('name', $workshopName)->first();
         }
 
        dd($workshops);

        $wm1 = WorkshopMoment::with(['workshop', 'bookings'])->where('workshop_id' , $workshops[1]->id)->where("moment_id",1)->first();
        $wm2 = WorkshopMoment::with(['workshop', 'bookings'])->where('workshop_id' , $workshops[2]->id)->where("moment_id",2)->first();
        $wm3 = WorkshopMoment::with(['workshop', 'bookings'])->where('workshop_id' , $workshops[3]->id)->where("moment_id",3)->first();
 
        if( $wm1->workshop->capacity < $wm1->bookings->count()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No available spots for the workshop: ' . $wm1->name
            ], 400);
        }

        if( $wm2->workshop->capacity < $wm2->bookings->count()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No available spots for the workshop: ' . $wm2->name
            ], 400);
        }
        
        if( $wm3->workshop->capacity < $wm3->bookings->count()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No available spots for the workshop: ' . $wm3->name
            ], 400);
        }
    }       
}
