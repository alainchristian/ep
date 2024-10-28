<?php

namespace App\Http\Controllers;

use App\Models\EP;
use App\Models\Center;
use Illuminate\Http\Request;

class EPController extends Controller
{
    public function index()
    {
        $eps = EP::with('center')
            ->where('IsActive', 1)
            ->orderBy('EPName')
            ->paginate(10);

        return view('eps.index', compact('eps'));
    }

    public function create()
    {
        $centers = Center::where('IsActive', 1)
            ->orderBy('CenterName')
            ->get();

        return view('eps.create', compact('centers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'EPName' => 'required|string|max:50|unique:ep,EPName',
            'CenterID' => 'required|exists:center,CenterID'
        ]);

        EP::create($validated + ['IsActive' => true]);

        return redirect()->route('eps.index')
            ->with('success', 'EP Program created successfully.');
    }

    public function show(EP $ep)
    {
        $ep->load(['center', 'rotations.rotation']);
        return view('eps.show', compact('ep'));
    }

    public function edit(EP $ep)
    {
        $centers = Center::where('IsActive', 1)
            ->orderBy('CenterName')
            ->get();

        return view('eps.edit', compact('ep', 'centers'));
    }

    public function update(Request $request, EP $ep)
    {
        $validated = $request->validate([
            'EPName' => 'required|string|max:50|unique:ep,EPName,' . $ep->EPID . ',EPID',
            'CenterID' => 'required|exists:center,CenterID'
        ]);

        $ep->update($validated);

        return redirect()->route('eps.index')
            ->with('success', 'EP Program updated successfully.');
    }

    public function destroy(EP $ep)
    {
        $ep->update(['IsActive' => false]);
        return redirect()->route('eps.index')
            ->with('success', 'EP Program deactivated successfully.');
    }
}
