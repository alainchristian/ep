<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Center;
use App\Models\EP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function attendance(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonth());
        $endDate = $request->input('end_date', now());

        // Attendance by EP
        $epAttendance = DB::table('attendance');
    }
}
