<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-slate-200">
                <div class="p-8 text-slate-900">
                    <div class="flex items-center mb-8">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl flex items-center justify-center mr-6 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-slate-900">Welcome, {{ Auth::user()->name }}! 👋</h3>
                    </div>
                    
                    @if($application)
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-8 mb-8 shadow-lg">
                            <h4 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Your Application Status
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-md">
                                    <h5 class="font-bold text-slate-900 mb-4 flex items-center text-lg">
                                        <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Application Details
                                    </h5>
                                    <div class="space-y-3 text-sm">
                                        <div class="flex justify-between"><span class="font-semibold text-slate-600">Full Name:</span> <span class="text-slate-900 font-medium">{{ $application->full_name }}</span></div>
                                        <div class="flex justify-between"><span class="font-semibold text-slate-600">Email:</span> <span class="text-slate-900 font-medium">{{ $application->email }}</span></div>
                                        <div class="flex justify-between"><span class="font-semibold text-slate-600">Phone:</span> <span class="text-slate-900 font-medium">{{ $application->phone_number }}</span></div>
                                        <div class="flex justify-between"><span class="font-semibold text-slate-600">Program:</span> <span class="text-slate-900 font-medium">{{ $application->program_of_choice }}</span></div>
                                        <div class="flex justify-between"><span class="font-semibold text-slate-600">Submitted:</span> <span class="text-slate-900 font-medium">{{ $application->created_at->format('M d, Y') }}</span></div>
                                    </div>
                                </div>
                                
                                <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-md">
                                    <h5 class="font-bold text-slate-900 mb-4 flex items-center text-lg">
                                        <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Status
                                    </h5>
                                    <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $application->getStatusBadgeClass() }} mb-4">
                                        {{ $application->getStatusDisplayName() }}
                                    </div>
                                    
                                    @if($application->status === 'pending')
                                        <p class="text-sm text-amber-700 font-medium">⏳ Your application is being reviewed. We'll notify you once a decision has been made.</p>
                                    @elseif($application->status === 'under_review')
                                        <p class="text-sm text-blue-700 font-medium">🔍 Your application is currently under review by our admissions team.</p>
                                    @elseif($application->status === 'accepted')
                                        <p class="text-sm text-green-700 font-bold">🎉 Congratulations! Your application has been accepted. You will receive further instructions via email.</p>
                                    @elseif($application->status === 'rejected')
                                        <p class="text-sm text-red-700 font-medium">😔 We regret to inform you that your application has not been accepted at this time.</p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mt-8">
                                <a href="{{ route('student.application.show', $application) }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-widest hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-lg">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View Full Application
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-2xl p-8 mb-8 shadow-lg">
                            <h4 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                No Application Submitted
                            </h4>
                            <p class="text-slate-700 text-lg font-medium mb-6">You haven't submitted an application yet. Click the button below to start your application process.</p>
                            
                            <a href="{{ route('student.application.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-widest hover:from-amber-600 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-all duration-200 shadow-lg">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Apply Now
                            </a>
                        </div>
                    @endif
                    
                    <div class="bg-gradient-to-r from-slate-50 to-blue-50 border border-slate-200 rounded-2xl p-8">
                        <h4 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Application Process
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-lg font-bold shadow-lg">1</div>
                                <p class="text-sm font-semibold text-slate-900">Submit Application</p>
                            </div>
                            <div class="text-center">
                                <div class="w-16 h-16 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-lg font-bold shadow-lg">2</div>
                                <p class="text-sm font-semibold text-slate-900">Under Review</p>
                            </div>
                            <div class="text-center">
                                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-lg font-bold shadow-lg">3</div>
                                <p class="text-sm font-semibold text-slate-900">Decision Made</p>
                            </div>
                            <div class="text-center">
                                <div class="w-16 h-16 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-lg font-bold shadow-lg">4</div>
                                <p class="text-sm font-semibold text-slate-900">Notification</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
