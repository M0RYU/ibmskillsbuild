@extends('layouts.app')

@section('title', 'Alternatives for "' . $ranking->title . '"')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 mb-8 text-white">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div class="flex-1">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-list text-white text-lg"></i>
                </div>
                <div>
                    <span class="text-blue-100 text-sm font-medium">Ranking System</span>
                    <h1 class="text-2xl md:text-3xl font-bold">Alternatives List</h1>
                </div>
            </div>
            <p class="text-blue-100 text-lg">
                Alternatives for "{{ $ranking->title }}"
            </p>
            @if($ranking->description)
                <p class="text-blue-200 text-sm mt-2">{{ $ranking->description }}</p>
            @endif
        </div>
        
        <div>
            <a href="{{ route('rankings.alternatives.create', $ranking->id) }}" 
               class="inline-flex items-center px-6 py-3 bg-white hover:bg-gray-100 rounded-xl text-gray-700 font-semibold transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-plus-circle mr-2"></i>
                Add Another Alternative
            </a>
        </div>
    </div>
</div>

<!-- Alternatives Table -->
<div class="bg-white rounded-3xl shadow-xl overflow-hidden">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-list-ul text-white"></i>
            </div>
            <h2 class="text-xl font-bold text-white">Added Alternatives</h2>
        </div>
    </div>
    
    <div class="p-6">
        @if(count($alternatives) > 0)
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm mb-6">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">#</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Name</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Description</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Date Added</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($alternatives as $index => $alternative)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-800 rounded-full font-semibold text-sm">
                                    {{ $index + 1 }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    <span class="font-semibold text-gray-800">{{ $alternative->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-600">{{ $alternative->description }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2 text-gray-500 text-sm">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>{{ $alternative->created_at->format('M d, Y g:i A') }}</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Info Alert -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-blue-800 font-medium">You need at least 2 alternatives to calculate a ranking.</p>
                    </div>
                </div>
            </div>
            
            @if(count($alternatives) >= 2)
                <!-- Action Buttons - Multiple Alternatives -->
                <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('rankings.cancel-from-alternatives', $ranking->id) }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-red-100 hover:bg-red-200 rounded-xl text-red-700 font-semibold transition-all duration-300 transform hover:scale-105"
                       onclick="return confirm('Are you sure you want to cancel? All ranking data will be deleted.')">
                        <i class="fas fa-times-circle mr-3"></i>
                        Cancel Ranking
                    </a>
                    <a href="{{ route('rankings.alternatives.create', $ranking->id) }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 rounded-xl text-white font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <i class="fas fa-plus-circle mr-3"></i>
                        Add More Alternatives
                    </a>
                    <a href="{{ route('rankings.calculate', $ranking->id) }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 rounded-xl text-white font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <i class="fas fa-calculator mr-3"></i>
                        Calculate Ranking
                    </a>
                </div>
            @else
                <!-- Action Button - Need More Alternatives -->
                <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('rankings.cancel-from-alternatives', $ranking->id) }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-red-100 hover:bg-red-200 rounded-xl text-red-700 font-semibold transition-all duration-300 transform hover:scale-105"
                       onclick="return confirm('Are you sure you want to cancel? All ranking data will be deleted.')">
                        <i class="fas fa-times-circle mr-3"></i>
                        Cancel Ranking
                    </a>
                    <a href="{{ route('rankings.alternatives.create', $ranking->id) }}" 
                       class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 rounded-xl text-white font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <i class="fas fa-plus-circle mr-3"></i>
                        Add More Alternatives
                    </a>
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">No Alternatives Added</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    No alternatives have been added to this ranking yet. Get started by adding your first alternative.
                </p>
                
                <a href="{{ route('rankings.alternatives.create', $ranking->id) }}" 
                   class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 rounded-xl text-white font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <i class="fas fa-plus-circle mr-3"></i>
                    Add First Alternative
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
