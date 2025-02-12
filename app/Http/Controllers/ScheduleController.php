<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    function save(Request $request, Schedule $schedule) {
        // dd($request);
        if (
            DB::table('schedules')->upsert(
                ['userId' => auth()->user()->id, 'round1' => $request->input('save1'), 'round2' => $request->input('save2'), 'round3' => $request->input('save3')],
                ['userId'],
                ['round1', 'round2', 'round3']
            )
        ) {
            return back()->with(['status' => 'success', 'message' => 'Je planning is opgeslagen']);
        } else {
            return back()->with(['status' => 'failed', 'message' => 'Er ging iets mis tijdens het opslaan ):']);
        }
    }
}
