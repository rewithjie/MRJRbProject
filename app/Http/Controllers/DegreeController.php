<?php

namespace App\Http\Controllers;

use App\Models\Degree;
use Illuminate\Http\Request;

class DegreeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $degrees = Degree::paginate(10);
        return view('degrees.index', ['degrees' => $degrees]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('degrees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:degrees,title',
        ]);

        Degree::create([
            'title' => $request->title,
        ]);

        return redirect()->route('degrees.index')
                        ->with('success', 'Degree created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $degree = Degree::find($id);
        
        if (!$degree) {
            return redirect()->route('degrees.index')
                           ->with('error', 'Degree not found!');
        }
        
        return view('degrees.show', ['degree' => $degree]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $degree = Degree::find($id);
        
        if (!$degree) {
            return redirect()->route('degrees.index')
                           ->with('error', 'Degree not found!');
        }
        
        return view('degrees.edit', ['degree' => $degree]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $degree = Degree::find($id);
        
        if (!$degree) {
            return redirect()->route('degrees.index')
                           ->with('error', 'Degree not found!');
        }

        $request->validate([
            'title' => 'required|string|max:255|unique:degrees,title,' . $id,
        ]);

        $degree->update([
            'title' => $request->title,
        ]);

        return redirect()->route('degrees.show', $degree->id)
                        ->with('success', 'Degree updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $degree = Degree::find($id);
        
        if (!$degree) {
            return redirect()->route('degrees.index')
                           ->with('error', 'Degree not found!');
        }

        $degree->delete();

        return redirect()->route('degrees.index')
                        ->with('success', 'Degree deleted successfully!');
    }
}
