@extends('layouts.app')

@section('title', 'Ranking Details: ' . $ranking->title)

@section('content')
<!-- Page Header -->
<div class="gradient-bg rounded-3xl p-8 mb-8 text-white">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div class="flex-1">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-line text-white text-lg"></i>
                </div>
                <div>
                    <span class="text-blue-100 text-sm font-medium">Ranking Results</span>
                    <h1 class="text-2xl md:text-3xl font-bold">{{ $ranking->title }}</h1>
                </div>
            </div>
            
            @if($ranking->description)
                <p class="text-blue-100 text-lg mb-4">{{ $ranking->description }}</p>
            @endif
            
            <div class="flex flex-wrap items-center gap-6 text-sm text-blue-100">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-calendar"></i>
                    <span>Created: {{ $ranking->created_at->format('F d, Y g:i A') }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-user"></i>
                    <span>By: {{ $ranking->created_by ?? 'Guest' }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-list"></i>
                    <span>{{ $ranking->alternatives->count() }} alternatives</span>
                </div>
            </div>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('rankings.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-xl text-white font-semibold transition-all duration-300 glassmorphism">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Rankings
            </a>
            <a href="{{ route('rankings.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-white hover:bg-gray-100 rounded-xl text-gray-700 font-semibold transition-all duration-300">
                <i class="fas fa-plus-circle mr-2"></i>
                Create New Ranking
            </a>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-white rounded-3xl shadow-xl overflow-hidden">
    <!-- Header -->
    <div class="gradient-success p-6">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-trophy text-white"></i>
            </div>
            <h2 class="text-2xl font-bold text-white">MOORA Ranking Results</h2>
        </div>
    </div>
    
    <div class="p-8">
        @if($alternativeRankings->count() > 0)
            <!-- Info Banner -->
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 mb-8">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-info-circle text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-blue-900 mb-2">About MOORA Method</h3>
                        <p class="text-blue-700">The ranking is based on the MOORA (Multi-Objective Optimization on the basis of Ratio Analysis) method, which provides optimal decision-making results by considering multiple criteria simultaneously.</p>
                    </div>
                </div>
            </div>
            
            <!-- Results Cards -->
            <div class="space-y-4">
                @foreach($alternativeRankings as $index => $rankingData)
                    @php
                        $alternative = $ranking->alternatives->where('id', $rankingData['id'])->first();
                    @endphp
                    
                    @if($alternative)
                        <div class="group relative">
                            <div class="p-6 border border-gray-200 rounded-2xl transition-all duration-300 hover:shadow-lg hover:border-blue-300 {{ $index === 0 ? 'bg-gradient-to-r from-green-50 to-blue-50 border-green-300' : 'bg-white hover:bg-gray-50' }}">
                                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                                    <div class="flex items-start space-x-4">
                                        <!-- Rank Badge -->
                                        <div class="flex-shrink-0">
                                            @if($index === 0)
                                                <div class="w-16 h-16 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg">
                                                    <div class="text-center">
                                                        <i class="fas fa-crown text-white text-lg"></i>
                                                        <div class="text-white text-xs font-bold mt-1">#{{ $rankingData['rank'] }}</div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="w-16 h-16 bg-gradient-to-r from-gray-400 to-gray-500 rounded-2xl flex items-center justify-center">
                                                    <div class="text-center">
                                                        <i class="fas fa-medal text-white text-lg"></i>
                                                        <div class="text-white text-xs font-bold mt-1">#{{ $rankingData['rank'] }}</div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Alternative Info -->
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-xl font-bold text-gray-900 mb-2 {{ $index === 0 ? 'text-green-800' : '' }}">
                                                {{ $alternative->name }}
                                                @if($index === 0)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 ml-2">
                                                        <i class="fas fa-star mr-1"></i>Best Choice
                                                    </span>
                                                @endif
                                            </h3>
                                            @if($alternative->description)
                                                <p class="text-gray-600 mb-3">{{ $alternative->description }}</p>
                                            @endif
                                            
                                            <!-- Optimization Value -->
                                            <div class="flex items-center space-x-3">
                                                <span class="text-sm font-medium text-gray-500">Optimization Value:</span>
                                                <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-lg font-mono font-bold">
                                                    {{ number_format($rankingData['optimization_value'], 4) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                      <!-- Progress Bar for Optimization Value -->
                                    <div class="lg:w-48">
                                        @php
                                            $allValues = $alternativeRankings->pluck('optimization_value');
                                            $maxValue = $allValues->max();
                                            $minValue = $allValues->min();
                                            
                                            // Handle case where all values are negative or there's a mix of positive/negative
                                            if ($minValue < 0) {
                                                // Normalize values to be positive for display
                                                $normalizedValue = $rankingData['optimization_value'] - $minValue;
                                                $normalizedMax = $maxValue - $minValue;
                                                $percentage = $normalizedMax > 0 ? ($normalizedValue / $normalizedMax) * 100 : 0;
                                            } else {
                                                // Original logic for all positive values
                                                $percentage = $maxValue > 0 ? ($rankingData['optimization_value'] / $maxValue) * 100 : 0;
                                            }
                                            
                                            // Ensure percentage is between 0 and 100
                                            $percentage = max(0, min(100, $percentage));
                                        @endphp
                                        <div class="text-center mb-2">
                                            <span class="text-sm font-medium text-gray-600">Performance</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-3">
                                            <div class="h-3 rounded-full {{ $index === 0 ? 'bg-gradient-to-r from-green-400 to-green-600' : 'bg-gradient-to-r from-blue-400 to-blue-600' }}" 
                                                 style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <div class="text-center mt-1">
                                            <span class="text-xs text-gray-500">{{ number_format($percentage, 1) }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach            </div>
            
            <!-- Criteria Used Section -->
            <div class="mt-8 bg-gray-50 rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-cogs text-blue-500 mr-2"></i>
                    Criteria Used in This Ranking
                </h3>
                
                @if($ranking->rankingCriteria && $ranking->rankingCriteria->count() > 0)
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($ranking->rankingCriteria as $rankingCriterion)
                            <div class="bg-white rounded-xl p-4 border border-gray-200">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-semibold text-gray-900">{{ $rankingCriterion->criteria->name }}</h4>
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-lg text-sm font-bold">
                                        {{ $rankingCriterion->weight }}%
                                    </span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="badge bg-{{ $rankingCriterion->criteria->type === 'benefit' ? 'success' : 'danger' }} text-xs px-2 py-1 rounded">
                                        {{ $rankingCriterion->criteria->type === 'benefit' ? 'Benefit' : 'Cost' }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ $rankingCriterion->criteria->input_type === 'number' ? 'Numeric' : 'Selection' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                        <div class="flex items-center text-sm text-blue-700">
                            <i class="fas fa-info-circle mr-2"></i>
                            <span>Total Weight: {{ $ranking->rankingCriteria->sum('weight') }}% | 
                                  Criteria Count: {{ $ranking->rankingCriteria->count() }}</span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4 text-gray-500">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        No criteria information available for this ranking.
                    </div>
                @endif
            </div>
            
            <!-- Summary Section -->
            <div class="mt-12 bg-gradient-to-r from-gray-50 to-blue-50 rounded-3xl p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Ranking Summary</h3>
                
                <div class="grid lg:grid-cols-2 gap-8 items-center">
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">How to Interpret Results</h4>
                        <ul class="space-y-3 text-gray-700">
                            <li class="flex items-start space-x-3">
                                <i class="fas fa-check-circle text-green-500 mt-1"></i>
                                <span>Higher optimization values indicate better performance</span>
                            </li>
                            <li class="flex items-start space-x-3">
                                <i class="fas fa-chart-line text-blue-500 mt-1"></i>
                                <span>Rankings are calculated using mathematical analysis</span>
                            </li>
                            <li class="flex items-start space-x-3">
                                <i class="fas fa-balance-scale text-purple-500 mt-1"></i>
                                <span>Multiple criteria are weighted and considered</span>
                            </li>
                        </ul>
                    </div>
                    
                    @if($alternativeRankings->count() > 0)
                        @php
                            $topRanking = $alternativeRankings->first();
                            $topAlternative = $ranking->alternatives->where('id', $topRanking['id'])->first();
                        @endphp
                        
                        @if($topAlternative)
                            <div class="bg-white rounded-2xl p-6 shadow-lg">
                                <div class="text-center">
                                    <div class="w-16 h-16 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-trophy text-white text-2xl"></i>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900 mb-2">Recommended Choice</h4>
                                    <p class="text-2xl font-bold text-green-600 mb-2">{{ $topAlternative->name }}</p>
                                    <p class="text-gray-600 mb-4">Optimization Value: <span class="font-mono font-bold text-blue-600">{{ number_format($topRanking['optimization_value'], 4) }}</span></p>
                                    <div class="text-sm text-gray-500">
                                        This alternative scored highest according to the MOORA analysis
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-exclamation-triangle text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Ranking Data Available</h3>
                <p class="text-gray-600 mb-8">There are no alternatives or assessment data for this ranking yet.</p>
                <a href="{{ route('rankings.index') }}" 
                   class="inline-flex items-center px-6 py-3 gradient-bg text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Rankings
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
