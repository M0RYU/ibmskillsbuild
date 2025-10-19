@extends('layouts.admin')

@section('title', 'Admin - Edit Alternative')

@section('content')
<!-- Page Header with Gradient -->
<div class="gradient-bg rounded-3xl p-8 mb-8 text-white">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div class="flex-1">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-edit text-white text-lg"></i>
                </div>
                <div>
                    <span class="text-blue-100 text-sm font-medium">Admin Panel</span>
                    <h1 class="text-2xl md:text-3xl font-bold">Edit Alternative</h1>
                </div>
            </div>
            <p class="text-blue-100 text-lg">
                Update alternative details for the MOORA decision support system
            </p>
        </div>
        
        <div>
            <a href="{{ route('admin.alternatives.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-white hover:bg-gray-100 rounded-xl text-gray-700 font-semibold transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to List
            </a>
        </div>
    </div>
</div>

<!-- Edit Form -->
<div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8">
    <div class="gradient-bg p-6">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-list-check text-white"></i>
            </div>
            <h2 class="text-xl font-bold text-white">Alternative Details</h2>
        </div>
    </div>
    
    <div class="p-6">        <form action="{{ route('admin.alternatives.update', $alternative->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <!-- Basic Information Section -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-100 rounded-2xl p-8">
                <div class="mb-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-info-circle text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Basic Information</h3>
                            <p class="text-gray-600 text-sm">Update the basic details for this alternative</p>
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
                                   value="{{ old('name', $alternative->name) }}" 
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
                            <div class="absolute top-4 left-0 pl-4 flex items-start pointer-events-none">
                                <i class="fas fa-align-left text-gray-400"></i>
                            </div>
                            <textarea class="w-full pl-12 pr-4 py-4 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-300 text-gray-700 placeholder-gray-400 @error('description') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3"
                                      placeholder="Enter description (optional)">{{ old('description', $alternative->description) }}</textarea>
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
            <!-- Criteria Assessments Section -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-100 rounded-2xl p-8">
                <div class="mb-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-chart-bar text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Criteria Assessments</h3>
                            <p class="text-gray-600 text-sm">Update values for each evaluation criteria</p>
                        </div>
                    </div>
                </div>
                
                @if(count($criterias) > 0)
                    <div class="space-y-6">
                        @foreach($criterias as $criteria)
                            <div class="bg-white p-6 rounded-2xl shadow-md border-2 border-gray-100 hover:border-green-200 transition-all duration-300 transform hover:scale-[1.02]">
                                <div class="flex flex-wrap items-center justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-list-check text-white text-sm"></i>
                                        </div>
                                        <h4 class="text-lg font-semibold text-gray-800">{{ $criteria->name }}</h4>
                                    </div>
                                    <div class="flex space-x-2 mt-2 sm:mt-0">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $criteria->type === 'benefit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            <i class="fas fa-{{ $criteria->type === 'benefit' ? 'arrow-up' : 'arrow-down' }} mr-1"></i>
                                            {{ $criteria->type === 'benefit' ? 'Benefit' : 'Cost' }}
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-weight-hanging mr-1"></i>
                                            Weight: {{ $criteria->weight }}%
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="space-y-4">
                                    @if($criteria->input_type === 'number')
                                        <div class="group">
                                            <label for="criteria_{{ $criteria->id }}" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                                <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                                Value 
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                    <i class="fas fa-hashtag text-gray-400"></i>
                                                </div>
                                                <input type="number" 
                                                       step="any" 
                                                       class="w-full pl-12 pr-4 py-4 rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 text-gray-700 @error('criteria_'.$criteria->id) border-red-400 focus:border-red-500 focus:ring-red-100 @enderror" 
                                                       id="criteria_{{ $criteria->id }}" 
                                                       name="criteria_{{ $criteria->id }}" 
                                                       value="{{ old('criteria_'.$criteria->id, isset($assessments[$criteria->id]) ? $assessments[$criteria->id]->value : '') }}" 
                                                       placeholder="Enter numeric value..."
                                                       required>
                                            </div>
                                            @error('criteria_'.$criteria->id)
                                                <div class="flex items-center mt-2 text-red-600 text-sm">
                                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    @else
                                        <div class="group">
                                            <label for="criteria_{{ $criteria->id }}" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                                <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                                Select Option 
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                    <i class="fas fa-list text-gray-400"></i>
                                                </div>
                                                <select class="w-full pl-12 pr-4 py-4 rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 text-gray-700 bg-white appearance-none @error('criteria_'.$criteria->id) border-red-400 focus:border-red-500 focus:ring-red-100 @enderror" 
                                                        id="criteria_{{ $criteria->id }}" 
                                                        name="criteria_{{ $criteria->id }}" 
                                                        required>
                                                    <option value="" class="text-gray-400">-- Select Option --</option>
                                                    @foreach($criteria->options as $option)
                                                        <option value="{{ $option->id }}" 
                                                            {{ old('criteria_'.$criteria->id, 
                                                                isset($assessments[$criteria->id]) ? $assessments[$criteria->id]->criteria_option_id : ''
                                                            ) == $option->id ? 'selected' : '' }}>
                                                            {{ $option->option_text }} (Value: {{ $option->option_value }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                                </div>
                                            </div>
                                            @error('criteria_'.$criteria->id)
                                                <div class="flex items-center mt-2 text-red-600 text-sm">
                                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-yellow-800 font-medium">No criteria have been defined yet.</p>
                                <p class="text-yellow-700 text-sm mt-1">Please add criteria first before creating alternatives.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>            
            <!-- Submit Button -->
            <div class="flex justify-center">
                <div class="flex space-x-4">
                    <a href="{{ route('admin.alternatives.index') }}" 
                       class="px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-md">
                        <i class="fas fa-times mr-2"></i> Cancel
                    </a>
                    <button type="submit" 
                            class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg {{ count($criterias) == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ count($criterias) == 0 ? 'disabled' : '' }}>
                        <i class="fas fa-save mr-2"></i> Update Alternative
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
