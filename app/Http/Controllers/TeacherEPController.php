<?php

namespace App\Http\Controllers;

use App\Models\EPRotation;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TeacherEPController extends Controller
{
    public function index()
    {
        $eps = EPRotation::with(['ep', 'rotation', 'students'])
            ->when(Auth::user()->role === 'Teacher', function($query) {
                return $query->where('UserID', Auth::id());
            })
            ->whereHas('rotation', function($query) {
                $query->where('StartDate', '<=', now())
                    ->where('EndDate', '>=', now())
                    ->where('IsActive', 1);
            })
            ->get();

        return view('teacher.eps.index', compact('eps'));
    }

    public function assignStudents(Request $request, EPRotation $epRotation)
    {
        $validated = $request->validate([
            'students' => 'required|array',
            'students.*' => 'exists:student,StudentID'
        ]);

        $epRotation->students()->sync($validated['students']);

        return redirect()->route('my-eps.index')
            ->with('success', 'Students assigned successfully.');
    }
}
