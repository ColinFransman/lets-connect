<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkshopMoment;
use App\Models\Workshop;
use Spatie\LaravelPdf\Facades\Pdf;


class WorkshopDashboardController extends Controller
{
    public function index(Request $request) 
    {
        $workshopmoments = WorkshopMoment::with(['workshop', 'bookings'])->get();

        if ($request->query('pdf')) {
            $pdf = Pdf::view('dashboard', compact('workshopmoments')); 
            return $pdf->download('dashboard.pdf');
        }

        return view('dashboard', compact('workshopmoments'));
    }


    public function showbookings(WorkShopMoment $wsm)
    {
        //$wsm->load('bookings');

        return view('dashboard.showbookings')->with('wsm', $wsm);
    }

    // public function viewCapacity (Request $request)
    // {
    //     // Dummy data to be returned
    //     $dummyData = [
    //         'status' => 'success',
    //         'data' => [
    //             [
    //                 'workshop_id' => 1,
    //                 'capacity' => 30,
    //                 'wm_id' => 1,
    //             ],
    //             [
    //                 'id' => 2, 
    //                 'name' => 'Workshop 2',
    //                 'capacity' => 50,
    //                 'wm_id' => 2,
    //                 'student_id' => 3,
                   
    //             ],
    //             [
    //                 'id' => 3,
    //                 'name' => 'Workshop 3',
    //                 'capacity' => 20,
    //                 'wm_id' => 1,
    //                 'student_id' => 4,
    //             ]
    //         ]
    //     ];

    //     // Return the dummy data as a JSON response
    //     return response()->json($dummyData);
    // }
}