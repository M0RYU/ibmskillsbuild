@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Page Header with Gradient -->
<div class="gradient-bg rounded-3xl p-8 mb-8 text-white">
    <div class="text-center">
        <div class="w-20 h-20 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-tachometer-alt text-3xl text-white"></i>
        </div>
        <h1 class="text-3xl md:text-4xl font-bold mb-4">Admin Dashboard</h1>
        <p class="text-xl text-blue-100 max-w-2xl mx-auto">
            Manage the Decision Support System settings, criteria, and monitor system performance
        </p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Criteria Card -->
    <div class="group relative">
        <div class="gradient-success rounded-3xl p-6 text-white card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-blue-100 text-sm font-medium mb-2">Total Criteria</div>
                    <div class="text-3xl font-bold mb-1">{{ count($criterias) }}</div>
                    <div class="text-blue-100 text-sm">Active criteria</div>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-list-check text-2xl text-white"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white border-opacity-20">
                <a href="{{ route('admin.criterias.index') }}" 
                   class="inline-flex items-center text-white hover:text-blue-100 transition-colors duration-300">
                    <span class="mr-2">Manage Criteria</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- System Status Card -->
    <div class="group relative">
        <div class="gradient-purple rounded-3xl p-6 text-white card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-purple-100 text-sm font-medium mb-2">System Status</div>
                    <div class="text-3xl font-bold mb-1">Active</div>
                    <div class="text-purple-100 text-sm">All systems operational</div>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-server text-2xl text-white"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white border-opacity-20">
                <div class="flex items-center text-white">
                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                    <span class="text-sm">All services running</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions Card -->
    <div class="group relative">
        <div class="gradient-orange rounded-3xl p-6 text-white card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-orange-100 text-sm font-medium mb-2">Quick Actions</div>
                    <div class="text-lg font-bold mb-1">Management</div>
                    <div class="text-orange-100 text-sm">System tools</div>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-tools text-2xl text-white"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white border-opacity-20">
                <a href="{{ route('admin.criterias.create') }}" 
                   class="inline-flex items-center text-white hover:text-orange-100 transition-colors duration-300">
                    <span class="mr-2">Add Criteria</span>
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Overview -->
<div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8">
    <div class="gradient-bg p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-white"></i>
                </div>
                <h2 class="text-2xl font-bold text-white">System Overview</h2>
            </div>
            <a href="{{ route('admin.criterias.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg text-white font-medium transition-all duration-300 glassmorphism">
                <i class="fas fa-cog mr-2"></i>Manage System
            </a>
        </div>
    </div>
    
    <div class="p-6">
        @if(count($criterias) > 0)
            <div class="text-center py-8">
                <div class="w-20 h-20 gradient-success rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-check-circle text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">System Ready</h3>
                <p class="text-gray-600 mb-6 max-w-md mx-auto">
                    Your MOORA decision support system is configured with {{ count($criterias) }} criteria 
                    @if($totalWeight == 100)
                        and perfectly balanced weights.
                    @elseif($totalWeight < 100)
                        with {{ 100 - $totalWeight }}% weight capacity remaining.
                    @else
                        but needs weight adjustment ({{ $totalWeight - 100 }}% over limit).
                    @endif
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('admin.criterias.index') }}" 
                       class="inline-flex items-center px-6 py-3 gradient-bg text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-list-check mr-2"></i>View All Criteria
                    </a>
                    <a href="{{ route('client.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-rocket mr-2"></i>Start Ranking
                    </a>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-list-check text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">System Setup Required</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">Get started by creating your first evaluation criteria for the MOORA decision system.</p>
                <a href="{{ route('admin.criterias.create') }}" 
                   class="inline-flex items-center px-6 py-3 gradient-bg text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-plus-circle mr-2"></i>Add First Criteria
                </a>
            </div>
        @endif
    </div>
</div>

<!-- System Information Section -->
<div class="grid lg:grid-cols-2 gap-8">
    <!-- System Info Card -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
        <div class="gradient-success p-6">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-info-circle text-white"></i>
                </div>
                <h2 class="text-xl font-bold text-white">System Information</h2>
            </div>
        </div>
        
        <div class="p-6 space-y-6">
            <div class="flex items-center justify-between p-4 bg-blue-50 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-brain text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Analysis Method</h3>
                        <p class="text-gray-600 text-sm">Multi-Objective Optimization</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-lg text-sm font-medium">MOORA</span>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-green-50 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shield-alt text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Active Criteria</h3>
                        <p class="text-gray-600 text-sm">{{ count($criterias) }} evaluation criteria configured</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-lg text-sm font-medium">
                    Active
                </span>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions Card -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
        <div class="gradient-purple p-6">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-bolt text-white"></i>
                </div>
                <h2 class="text-xl font-bold text-white">Quick Actions</h2>
            </div>
        </div>
        
        <div class="p-6 space-y-4">
            <a href="{{ route('admin.criterias.create') }}" 
               class="block p-4 bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-xl transition-all duration-300 transform hover:scale-105">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plus text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Add New Criteria</h3>
                        <p class="text-gray-600 text-sm">Create evaluation criteria for decision making</p>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('admin.criterias.index') }}" 
               class="block p-4 bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 rounded-xl transition-all duration-300 transform hover:scale-105">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-cog text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Manage All Criteria</h3>
                        <p class="text-gray-600 text-sm">View and edit existing criteria settings</p>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('client.index') }}" 
               class="block p-4 bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 rounded-xl transition-all duration-300 transform hover:scale-105">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-home text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Back to Client Area</h3>
                        <p class="text-gray-600 text-sm">Return to the main application interface</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
