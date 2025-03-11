<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkshopMoment;
use App\Models\Workshop;

class WorkshopDashboardController extends Controller
{
    public function index() 
    {
        return view('dashboard.workshops')->with('workshopmoments', WorkshopMoment::with(['workshop'], ['bookings'])->get());
                                        
        //return view('dashboard.bookings')->with ('bookings',  Bookings::with(['student', 'workshopMoment.workshop', 'workshopMoment.moment'])->get());
    }
    public function showbookings(WorkShopMoment $wsm)
    {
        
        //$wsm->load('bookings');

        return view('dashboard.showbookings')->with('wsm', $wsm);
        

    }

    public function viewCapacity (Request $request)
     {
         // Dummy data to be returned
         $dummyData = [
             'status' => 'success',
             'data' => [
                [
                    'id' => 1, //booking id
                    'moment_id' => 1, //workshop_moment moment_id
                    'workshop_id' => 1, //workshop_moment workshop_id
                    'student_id' => 1, //booking student_id
                    'capacity' => 30, //workshop capacity
                ],
                [
                    'id' => 1, //booking id
                    'moment_id' => 2, //workshop_moment moment_id
                    'workshop_id' => 1, //workshop_moment workshop_id
                    'student_id' => 1, //booking student_id
                    'capacity' => 25, //workshop capacity
                ],
                [
                    'id' => 2, //booking id
                    'moment_id' => 2, //workshop_moment moment_id
                    'workshop_id' => 5, //workshop_moment workshop_id
                    'student_id' => 1, //booking student_id
                    'capacity' => 30, //workshop capacity
                   
                ],
                [
                    'id' => 2, //booking id
                    'moment_id' => 3, //workshop_moment moment_id
                    'workshop_id' => 9, //workshop_moment workshop_id
                    'student_id' => 1, //booking student_id
                    'capacity' => 30, //workshop capacity
                ]
            ]
         ];
 
         // Return the dummy data as a JSON response
         return response()->json($dummyData);
     }
}
