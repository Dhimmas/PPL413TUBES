<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 mt-8">
        <!-- Profile Header -->
        <div class="bg-gradient-to-br from-purple-600/20 via-blue-600/20 to-indigo-600/20 backdrop-blur-md rounded-2xl p-8 shadow-xl border border-white/20 text-white mb-8">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="relative">
                    @if($user->profile && $user->profile->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile->profile_picture) }}" 
                             alt="Profile Picture" 
                             class="w-32 h-32 rounded-full object-cover shadow-lg border-4 border-white/30" />
                    @else
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center shadow-lg border-4 border-white/30">
                            <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="absolute -bottom-2 -right-2 bg-green-500 rounded-full p-2 shadow-lg">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="text-center md:text-left flex-1">
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">{{ $user->name }}</h1>
                    <p class="text-white/70 text-lg mt-2">{{ $user->email }}</p>
                    @if($user->profile && $user->profile->bio)
                        <p class="text-white/80 mt-3 text-base italic">"{{ $user->profile->bio }}"</p>
                    @endif
                    <div class="flex flex-wrap gap-2 mt-4 justify-center md:justify-start">
                        @if($user->profile && $user->profile->gender)
                            <span class="px-3 py-1 bg-blue-500/30 rounded-full text-sm text-blue-200">{{ $user->profile->gender }}</span>
                        @endif
                        @if($user->profile && $user->profile->tanggal_lahir)
                            <span class="px-3 py-1 bg-purple-500/30 rounded-full text-sm text-purple-200">{{ $user->profile->tanggal_lahir->age }} years old</span>
                        @endif
                    </div>
                </div>
                
                <a href="{{ route('profile.edit') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Profile
                </a>
            </div>
        </div>

        <!-- Profile Information Cards -->
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Personal Information -->
            <div class="bg-white/10 backdrop-blur-md rounded-xl p-6 shadow-lg border border-white/20 text-white">
                <h3 class="text-xl font-semibold mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Personal Information
                </h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-white/10">
                        <span class="text-white/70">Full Name</span>
                        <span class="font-medium">{{ $user->name }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-white/10">
                        <span class="text-white/70">Email</span>
                        <span class="font-medium">{{ $user->email }}</span>
                    </div>
                    @if($user->profile && $user->profile->tanggal_lahir)
                        <div class="flex justify-between items-center py-3 border-b border-white/10">
                            <span class="text-white/70">Date of Birth</span>
                            <span class="font-medium">{{ $user->profile->tanggal_lahir->format('F d, Y') }}</span>
                        </div>
                    @endif
                    @if($user->profile && $user->profile->phone)
                        <div class="flex justify-between items-center py-3 border-b border-white/10">
                            <span class="text-white/70">Phone</span>
                            <span class="font-medium">{{ $user->profile->phone }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Activity Stats -->
            <div class="bg-white/10 backdrop-blur-md rounded-xl p-6 shadow-lg border border-white/20 text-white">
                <h3 class="text-xl font-semibold mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Activity Overview
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-3 border-b border-white/10">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-500/30 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <span class="text-white/70">Quizzes Completed</span>
                        </div>
                        <span class="font-semibold text-blue-400">{{ $quizStats['completed_quizzes'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b border-white/10">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-500/30 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <span class="text-white/70">Average Quiz Score</span>
                        </div>
                        <span class="font-semibold text-green-400">{{ $quizStats['average_score'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b border-white/10">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-500/30 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span class="text-white/70">Goals Achieved</span>
                        </div>
                        <span class="font-semibold text-green-400">0</span>
                    </div>
                    <div class="flex items-center justify-between py-3">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-purple-500/30 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <span class="text-white/70">Forum Posts</span>
                        </div>
                        <span class="font-semibold text-purple-400">{{ $forumPostsCount ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 bg-white/10 backdrop-blur-md rounded-xl p-6 shadow-lg border border-white/20 text-white">
            <h3 class="text-xl font-semibold mb-6 flex items-center">
                <svg class="w-5 h-5 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Quick Actions
            </h3>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('profile.edit') }}" class="flex flex-col items-center p-4 bg-blue-500/20 hover:bg-blue-500/30 rounded-lg transition-colors">
                    <svg class="w-8 h-8 text-blue-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span class="text-sm font-medium">Edit Profile</span>
                </a>
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center p-4 bg-green-500/20 hover:bg-green-500/30 rounded-lg transition-colors">
                    <svg class="w-8 h-8 text-green-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
                <a href="{{ route('quiz.index') }}" class="flex flex-col items-center p-4 bg-purple-500/20 hover:bg-purple-500/30 rounded-lg transition-colors">
                    <svg class="w-8 h-8 text-purple-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span class="text-sm font-medium">Take Quiz</span>
                </a>
                <a href="{{ route('study-goals.index') }}" class="flex flex-col items-center p-4 bg-yellow-500/20 hover:bg-yellow-500/30 rounded-lg transition-colors">
                    <svg class="w-8 h-8 text-yellow-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm font-medium">Study Goals</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
