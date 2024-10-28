<?php

namespace App\Http\Controllers;

use App\Models\EPRotation;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function create()
    {
        $eps = EPRotation::with(['ep', 'students'])
            ->when(Auth::user()->role === 'Teacher', function($query) {
                return $query->where('UserID', Auth::id());
            })
            ->whereHas('rotation', function($query) {
                $query->where('StartDate', '<=', now())
                    ->where('EndDate', '>=', now())
                    ->where('IsActive', 1);
            })
            ->get();

        return view('attendance.create', compact('eps'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ep_rotation_id' => 'required|exists:ep_rotation,EP_RotationID',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:Present,Absent'
        ]);

        foreach ($validated['attendance'] as $studentEPRotationId => $status) {
            Attendance::updateOrCreate(
                [
                    'Student_EP_RotationID' => $studentEPRotationId,
                    'AttendanceDate' => $validated['date']
                ],
                ['Status' => $status]
            );
        }

        return redirect()->route('attendance.create')
            ->with('success', 'Attendance recorded successfully.');
    }
}
