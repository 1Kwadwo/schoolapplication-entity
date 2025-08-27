<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            $applications = Application::with('user')->latest()->paginate(10);
            return view('admin.applications.index', compact('applications'));
        }
        
        $application = $user->applications()->latest()->first();
        return view('student.dashboard', compact('application'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        
        if (!$user->isStudent()) {
            return redirect()->route('dashboard')->with('error', 'Access denied.');
        }
        
        $existingApplication = $user->applications()->latest()->first();
        
        if ($existingApplication) {
            return redirect()->route('student.dashboard')->with('info', 'You have already submitted an application.');
        }
        
        $programs = \App\Models\Program::where('is_active', true)->get();
        
        return view('student.application.create', compact('programs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isStudent()) {
            return redirect()->route('dashboard')->with('error', 'Access denied.');
        }
        
        $existingApplication = $user->applications()->latest()->first();
        
        if ($existingApplication) {
            return redirect()->route('student.dashboard')->with('error', 'You have already submitted an application.');
        }
        
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string|max:500',
            'program_id' => 'required|exists:programs,id',
            'previous_education' => 'required|string|max:1000',
            'grade_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
        
        $data = $request->all();
        $data['user_id'] = $user->id;
        
        // Get the program name for the program_of_choice field
        $program = \App\Models\Program::find($request->program_id);
        $data['program_of_choice'] = $program->name;
        
        if ($request->hasFile('grade_file')) {
            $file = $request->file('grade_file');
            $fileName = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('grade_files', $fileName, 'public');
            $data['grade_file'] = $filePath;
        }
        
        Application::create($data);
        
        return redirect()->route('student.dashboard')->with('success', 'Application submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $application = Application::with('user')->findOrFail($id);
        
        if (!$user->isAdmin() && $application->user_id !== $user->id) {
            return redirect()->route('dashboard')->with('error', 'Access denied.');
        }
        
        return view('applications.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $application = Application::findOrFail($id);
        
        if (!$user->isAdmin() && $application->user_id !== $user->id) {
            return redirect()->route('dashboard')->with('error', 'Access denied.');
        }
        
        return view('applications.edit', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        $application = Application::findOrFail($id);
        
        if (!$user->isAdmin() && $application->user_id !== $user->id) {
            return redirect()->route('dashboard')->with('error', 'Access denied.');
        }
        
        if ($user->isAdmin()) {
            $request->validate([
                'status' => 'required|in:pending,under_review,accepted,rejected',
            ]);
            
            $application->update(['status' => $request->status]);
            
            return redirect()->route('admin.applications.index')->with('success', 'Application status updated successfully!');
        }
        
        return redirect()->route('dashboard')->with('error', 'Access denied.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        $application = Application::findOrFail($id);
        
        if (!$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Access denied.');
        }
        
        if ($application->grade_file) {
            Storage::disk('public')->delete($application->grade_file);
        }
        
        $application->delete();
        
        return redirect()->route('admin.applications.index')->with('success', 'Application deleted successfully!');
    }
}
