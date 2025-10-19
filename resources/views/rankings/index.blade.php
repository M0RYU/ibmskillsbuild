@extends('layouts.app')

@section('title', 'Rankings History')

@section('content')
<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
    <div>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Rankings History</h1>
        <p class="text-lg text-gray-600">Manage and view all your decision rankings</p>
    </div>
    <div class="mt-4 md:mt-0">
        <a href="{{ route('rankings.create.new') }}" 
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
            <i class="fas fa-plus-circle mr-3"></i>Create New Ranking
        </a>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="bg-white rounded-3xl shadow-lg p-6 mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-900">Search & Filter Rankings</h2>
        <i class="fas fa-search text-gray-400 text-xl"></i>
    </div>
    
    <form action="{{ route('rankings.index') }}" method="GET" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Search Input -->
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Search Rankings</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" 
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" 
                           placeholder="Search by title, description, or creator" 
                           name="search" 
                           value="{{ request('search') }}">
                </div>
            </div>
            
            <!-- Date From -->
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar text-gray-400"></i>
                    </div>
                    <input type="date" 
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" 
                           name="date_from" 
                           value="{{ request('date_from') }}">
                </div>
            </div>
            
            <!-- Date To -->
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar text-gray-400"></i>
                    </div>
                    <input type="date" 
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" 
                           name="date_to" 
                           value="{{ request('date_to') }}">
                </div>
            </div>
        </div>
        
        <!-- Sort Options -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                <select name="sort_by" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Date Created</option>
                    <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Title</option>
                    <option value="created_by" {{ request('sort_by') == 'created_by' ? 'selected' : '' }}>Creator</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort Direction</label>
                <select name="sort_direction" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                    <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                    <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                </select>
            </div>
            
            <div class="flex items-end space-x-3">
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
                
                @if(request('search') || request('date_from') || request('date_to') || request('sort_by') || request('sort_direction'))
                    <a href="{{ route('rankings.index') }}" 
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-xl transition-all duration-300">
                        <i class="fas fa-times mr-2"></i>Clear
                    </a>
                @endif
            </div>
        </div>
    </form>
</div>

<!-- Rankings List -->
<div class="bg-white rounded-3xl shadow-lg overflow-hidden">
    <div class="gradient-bg p-6">
        <h2 class="text-xl font-semibold text-white">All Rankings</h2>
    </div>
    
    <div class="p-6">
        @if(count($rankings) > 0)
            <div class="space-y-4">
                @foreach($rankings as $ranking)
                <div class="bg-gray-50 hover:bg-gray-100 rounded-2xl p-6 transition-all duration-300 card-hover">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex-1">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-chart-line text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $ranking->title }}</h3>
                                    @if($ranking->description)
                                        <p class="text-gray-600 mb-3">{{ Str::limit($ranking->description, 80) }}</p>
                                    @endif
                                    
                                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                        <span class="flex items-center">
                                            <i class="fas fa-user mr-2"></i>{{ $ranking->created_by ?? 'Guest' }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-calendar mr-2"></i>{{ $ranking->created_at->format('M d, Y') }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-list mr-2"></i>{{ $ranking->alternatives->count() }} alternatives
                                        </span>
                                        <div class="flex items-center">
                                            @if($ranking->result_data)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i>Complete
                                                </span>
                                            @elseif($ranking->alternatives->count() >= 2)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-clock mr-1"></i>Ready to Calculate
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    <i class="fas fa-plus mr-1"></i>Need More Alternatives
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 lg:mt-0 lg:ml-6 flex items-center space-x-3">
                            @if($ranking->result_data)
                                <a href="{{ route('rankings.show', $ranking->id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-eye mr-2"></i>View Results
                                </a>
                            @elseif($ranking->alternatives->count() >= 2)
                                <a href="{{ route('rankings.calculate', $ranking->id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-calculator mr-2"></i>Calculate
                                </a>
                            @else
                                <a href="{{ route('rankings.alternatives.create', $ranking->id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-plus mr-2"></i>Add Alternatives
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($rankings->hasPages())
                <div class="mt-8 flex justify-center">
                    <div class="bg-white rounded-2xl p-4 shadow-md">
                        {{ $rankings->links() }}
                    </div>
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gradient-to-r from-blue-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-chart-line text-3xl text-gray-400"></i>
                </div>
                
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Rankings Found</h3>
                
                @if(request('search') || request('date_from') || request('date_to'))
                    <p class="text-gray-600 mb-6">
                        No rankings found matching your search criteria.
                        @if(request('search'))
                            <br><span class="text-sm">Search term: "<strong>{{ request('search') }}</strong>"</span>
                        @endif
                        @if(request('date_from') || request('date_to'))
                            <br><span class="text-sm">Date range: 
                                {{ request('date_from') ? request('date_from') : 'Any' }} 
                                to 
                                {{ request('date_to') ? request('date_to') : 'Any' }}
                            </span>
                        @endif
                    </p>
                    
                    <div class="space-x-4">
                        <a href="{{ route('rankings.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all duration-300">
                            <i class="fas fa-times mr-2"></i>Clear Filters
                        </a>
                        <a href="{{ route('rankings.create.new') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-plus-circle mr-2"></i>Create First Ranking
                        </a>
                    </div>
                @else
                    <p class="text-gray-600 mb-6">No rankings have been created yet. Start by creating your first ranking to begin making data-driven decisions.</p>
                    
                    <a href="{{ route('rankings.create.new') }}" 
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-plus-circle mr-3 text-xl"></i>Create Your First Ranking
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
