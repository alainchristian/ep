<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Family;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('family')
            ->where('IsActive', 1)
            ->orderBy('FirstName')
            ->paginate(10);

        return view('students.index', compact('students'));
    }

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin,Teacher');
    }

    public function create()
    {
        $families = Family::where('IsActive', 1)
            ->orderBy('FamilyName')
            ->get();

        return view('students.create', compact('families'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'UniqueID' => 'required|unique:student,UniqueID',
            'FirstName' => 'required|string|max:50',
            'LastName' => 'required|string|max:50',
            'FamilyID' => 'required|exists:family,FamilyID',
            'Gender' => 'required|in:Male,Female'
        ]);

        $student = Student::create($validated + ['IsActive' => true]);

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        $student->load(['family', 'epRotations.ep', 'attendances']);
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $families = Family::where('IsActive', 1)
            ->orderBy('FamilyName')
            ->get();

        return view('students.edit', compact('student', 'families'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'UniqueID' => 'required|unique:student,UniqueID,' . $student->StudentID . ',StudentID',
            'FirstName' => 'required|string|max:50',
            'LastName' => 'required|string|max:50',
            'FamilyID' => 'required|exists:family,FamilyID',
            'Gender' => 'required|in:Male,Female'
        ]);

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->update(['IsActive' => false]);
        return redirect()->route('students.index')
            ->with('success', 'Student deactivated successfully.');
    }
}
