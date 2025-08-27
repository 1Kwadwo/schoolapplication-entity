<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::withCount('applications')->latest()->paginate(10);
        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:programs',
            'description' => 'nullable|string',
            'duration' => 'nullable|string|max:100',
            'tuition_fee' => 'nullable|numeric|min:0',
            'capacity' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        Program::create($request->all());

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program created successfully!');
    }

    public function show(Program $program)
    {
        $program->load(['applications.user']);
        return view('admin.programs.show', compact('program'));
    }

    public function edit(Program $program)
    {
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:programs,name,' . $program->id,
            'description' => 'nullable|string',
            'duration' => 'nullable|string|max:100',
            'tuition_fee' => 'nullable|numeric|min:0',
            'capacity' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $program->update($request->all());

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program updated successfully!');
    }

    public function destroy(Program $program)
    {
        // Check if program has applications
        if ($program->applications()->count() > 0) {
            return redirect()->route('admin.programs.index')
                ->with('error', 'Cannot delete program with existing applications. Please deactivate it instead.');
        }

        $program->delete();

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program deleted successfully!');
    }

    public function toggleStatus(Program $program)
    {
        $program->update(['is_active' => !$program->is_active]);

        $status = $program->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.programs.index')
            ->with('success', "Program {$status} successfully!");
    }
}
