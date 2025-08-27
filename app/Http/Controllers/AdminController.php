<?php

namespace App\Http\Controllers;

// Force fresh deployment - cache busting

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    /**
     * Display admin dashboard.
     */
    public function dashboard()
    {
        $totalApplications = Application::count();
        $pendingApplications = Application::where('status', 'pending')->count();
        $underReviewApplications = Application::where('status', 'under_review')->count();
        $acceptedApplications = Application::where('status', 'accepted')->count();
        $rejectedApplications = Application::where('status', 'rejected')->count();
        
        $recentApplications = Application::with('user')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalApplications',
            'pendingApplications',
            'underReviewApplications',
            'acceptedApplications',
            'rejectedApplications',
            'recentApplications'
        ));
    }

    /**
     * Display all applications with search and filter.
     */
    public function applications(Request $request)
    {
        $query = Application::with('user');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('program_of_choice', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        $applications = $query->latest()->paginate(15);
        
        return view('admin.applications.index', compact('applications'));
    }

    /**
     * Show application details.
     */
    public function showApplication($id)
    {
        $application = Application::with('user')->findOrFail($id);
        return view('admin.applications.show', compact('application'));
    }

    /**
     * Update application status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,under_review,accepted,rejected',
        ]);
        
        $application = Application::findOrFail($id);
        $application->update(['status' => $request->status]);
        
        return redirect()->back()->with('success', 'Application status updated successfully!');
    }

    /**
     * Export applications as CSV.
     */
    public function exportCsv()
    {
        $applications = Application::with('user')->get();
        
        $filename = 'applications_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($applications) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, [
                'ID',
                'Student Name',
                'Email',
                'Phone',
                'Date of Birth',
                'Gender',
                'Address',
                'Program',
                'Previous Education',
                'Status',
                'Submitted Date'
            ]);
            
            // Add data
            foreach ($applications as $application) {
                fputcsv($file, [
                    $application->id,
                    $application->full_name,
                    $application->email,
                    $application->phone_number,
                    $application->date_of_birth->format('Y-m-d'),
                    $application->gender,
                    $application->address,
                    $application->program_of_choice,
                    $application->previous_education,
                    $application->getStatusDisplayName(),
                    $application->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
}
