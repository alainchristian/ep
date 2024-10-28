<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    public function index()
    {
        $families = Family::where('IsActive', 1)
            ->withCount('students')
            ->orderBy('FamilyName')
            ->paginate(10);

        return view('families.index', compact('families'));
    }

    public function create()
    {
        return view('families.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'FamilyName' => 'required|string|max:100|unique:family,FamilyName',
            'FamilyMana' => 'required|string|max:100'
        ]);

        Family::create($validated + ['IsActive' => true]);

        return redirect()->route('families.index')
            ->with('success', 'Family created successfully.');
    }

    public function show(Family $family)
    {
        $family->load(['students' => function($query) {
            $query->where('IsActive', 1);
        }]);

        return view('families.show', compact('family'));
    }

    public function edit(Family $family)
    {
        return view('families.edit', compact('family'));
    }

    public function update(Request $request, Family $family)
    {
        $validated = $request->validate([
            'FamilyName' => 'required|string|max:100|unique:family,FamilyName,' . $family->FamilyID . ',FamilyID',
            'FamilyMana' => 'required|string|max:100'
        ]);

        $family->update($validated);

        return redirect()->route('families.index')
            ->with('success', 'Family updated successfully.');
    }

    public function destroy(Family $family)
    {
        $family->update(['IsActive' => false]);
        return redirect()->route('families.index')
            ->with('success', 'Family deactivated successfully.');
    }
}
