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

    
}
