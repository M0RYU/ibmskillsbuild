@extends('layouts.app')

@section('title', 'Add Alternative to "' . $ranking->title . '"')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 mb-8 text-white">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div class="flex-1">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-plus-circle text-white text-lg"></i>
                </div>
                <div>
                    <span class="text-blue-100 text-sm font-medium">Ranking System</span>
                    <h1 class="text-2xl md:text-3xl font-bold">Add Alternative</h1>
                </div>
            </div>
            <p class="text-blue-100 text-lg">
                Add alternative to "{{ $ranking->title }}"
            </p>
            @if($ranking->description)
                <p class="text-blue-200 text-sm mt-2">{{ $ranking->description }}</p>
            @endif
        </div>
        
        <div>
            <a href="{{ route('rankings.alternatives.list', $ranking->id) }}" 
               class="inline-flex items-center px-6 py-3 bg-white hover:bg-gray-100 rounded-xl text-gray-700 font-semibold transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-list mr-2"></i>
                View Added Alternatives
            </a>
        </div>
    </div>
</div>

<!-- Add Alternative Form -->
<div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-clipboard-list text-white"></i>
            </div>
            <h2 class="text-xl font-bold text-white">Alternative Details</h2>
        </div>
    </div>
    
    <div class="p-6">        <!-- Info Alert -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-blue-800 font-medium">Add an alternative with values for each criteria.</p>
                </div>
            </div>
        </div>
        
        <form action="{{ route('rankings.alternatives.store', $ranking->id) }}" method="POST" class="space-y-8">
            @csrf
            
            <!-- Basic Information Section -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-100 rounded-2xl p-8">
                <div class="mb-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-info-circle text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Basic Information</h3>
                            <p class="text-gray-600 text-sm">Enter the basic details for this alternative</p>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Alternative Name -->
                    <div class="group">
                        <label for="name" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                            Alternative Name 
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-tag text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   class="w-full pl-12 pr-4 py-4 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 text-gray-700 placeholder-gray-400 @error('name') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Enter alternative name..."
                                   required>
                        </div>
                        @error('name')
                            <div class="flex items-center mt-2 text-red-600 text-sm">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Description -->
                    <div class="group">
                        <label for="description" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                            <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                            Description
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-align-left text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   class="w-full pl-12 pr-4 py-4 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-300 text-gray-700 placeholder-gray-400 @error('description') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror" 
                                   id="description" 
                                   name="description" 
                                   value="{{ old('description') }}"
                                   placeholder="Enter description (optional)">
                        </div>
                        @error('description')
                            <div class="flex items-center mt-2 text-red-600 text-sm">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>            
            <!-- Criteria Values Section -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-100 rounded-2xl p-8">
                <div class="mb-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-clipboard-list text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Criteria Values</h3>
                            <p class="text-gray-600 text-sm">Enter values for each criteria below</p>
                        </div>
                    </div>
                </div>
                
                <!-- Warning Alert -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-yellow-800 font-medium">All criteria must have values.</p>
                        </div>
                    </div>
                </div>
                
                @if(count($rankingCriteria) > 0)
                    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Criteria</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Type</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Weight</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Value</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($rankingCriteria as $rankingCriterion)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                            <span class="font-semibold text-gray-800">{{ $rankingCriterion->criteria->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-2">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                                {{ $rankingCriterion->criteria->type === 'benefit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                <i class="fas fa-{{ $rankingCriterion->criteria->type === 'benefit' ? 'arrow-up' : 'arrow-down' }} mr-2"></i>
                                                {{ $rankingCriterion->criteria->type === 'benefit' ? 'Benefit' : 'Cost' }}
                                            </span>
                                            <div class="text-xs text-gray-500">
                                                {{ $rankingCriterion->criteria->type === 'benefit' ? 'Higher is better' : 'Lower is better' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-percentage mr-2"></i>
                                            {{ $rankingCriterion->weight }}%
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($rankingCriterion->criteria->input_type === 'number')
                                            <div class="space-y-2">
                                                <input type="number" 
                                                       step="any" 
                                                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 text-gray-700 @error('criteria_' . $rankingCriterion->criteria->id) border-red-400 focus:border-red-500 focus:ring-red-100 @enderror" 
                                                       name="criteria_{{ $rankingCriterion->criteria->id }}" 
                                                       value="{{ old('criteria_' . $rankingCriterion->criteria->id) }}" 
                                                       placeholder="Enter value..."
                                                       required>
                                                @error('criteria_' . $rankingCriterion->criteria->id)
                                                    <div class="flex items-center text-red-600 text-sm">
                                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        @else
                                            <div class="space-y-2">
                                                <select class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 text-gray-700 @error('criteria_' . $rankingCriterion->criteria->id) border-red-400 focus:border-red-500 focus:ring-red-100 @enderror" 
                                                        name="criteria_{{ $rankingCriterion->criteria->id }}" 
                                                        required>
                                                    <option value="">-- Select Option --</option>
                                                    @foreach($rankingCriterion->criteria->options as $option)
                                                        <option value="{{ $option->id }}" {{ old('criteria_' . $rankingCriterion->criteria->id) == $option->id ? 'selected' : '' }}>
                                                            {{ $option->option_text }} (Value: {{ $option->option_value }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('criteria_' . $rankingCriterion->criteria->id)
                                                    <div class="flex items-center text-red-600 text-sm">
                                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="bg-red-50 border border-red-200 rounded-xl p-6 text-center">
                        <div class="flex items-center justify-center space-x-3 mb-4">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-times-circle text-red-500 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-red-800">No Criteria Available</h4>
                                <p class="text-red-600">No criteria have been selected for this ranking yet. Please select criteria first.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4 pt-8">
                <a href="{{ route('rankings.cancel-from-alternatives', $ranking->id) }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-red-100 hover:bg-red-200 rounded-xl text-red-700 font-semibold transition-all duration-300 transform hover:scale-105"
                   onclick="return confirm('Are you sure you want to cancel? All ranking data will be deleted.')">
                    <i class="fas fa-times-circle mr-3"></i>
                    Cancel Ranking
                </a>
                
                <a href="{{ route('rankings.back-to-weights', $ranking->id) }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-gray-100 hover:bg-gray-200 rounded-xl text-gray-700 font-semibold transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-arrow-left mr-3"></i>
                    Back to Weights
                </a>
                
                <button type="submit" 
                        name="add_another" 
                        value="1" 
                        class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 rounded-xl text-white font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <i class="fas fa-plus-circle mr-3"></i>
                    Save & Add Another
                </button>
                
                <button type="submit" 
                        class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 rounded-xl text-white font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <i class="fas fa-save mr-3"></i>
                    Save & View Alternatives
                </button>
            </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
