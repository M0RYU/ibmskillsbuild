@extends('layouts.app')

@section('title', 'Create New Ranking - Assign Weights')

@section('content')
<!-- Page Header -->
<div class="gradient-bg rounded-3xl p-8 mb-8 text-white">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div class="flex-1">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-weight-hanging text-white text-lg"></i>
                </div>
                <div>
                    <span class="text-blue-100 text-sm font-medium">Step 2 of 4</span>
                    <h1 class="text-2xl md:text-3xl font-bold">Assign Criteria Weights</h1>
                </div>
            </div>
            <p class="text-blue-100 text-lg">
                Assign importance weights to your selected criteria (total ≤ 100%)
            </p>
        </div>
        
        <div>
            <a href="{{ route('rankings.select-criteria') }}" 
               class="inline-flex items-center px-6 py-3 bg-white hover:bg-gray-100 rounded-xl text-gray-700 font-semibold transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Criteria Selection
            </a>
        </div>
    </div>
</div>

<!-- Progress Steps -->
<div class="mb-8">
    <div class="flex items-center justify-center">
        <div class="flex items-center space-x-4">
            <!-- Step 1 - Completed -->
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-semibold">
                    <i class="fas fa-check"></i>
                </div>
                <span class="ml-2 font-medium text-green-600">Select Criteria</span>
            </div>
            
            <div class="w-8 h-1 bg-green-600 rounded"></div>
            
            <!-- Step 2 - Active -->
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-semibold">
                    2
                </div>
                <span class="ml-2 font-medium text-blue-600">Assign Weights</span>
            </div>
            
            <div class="w-8 h-1 bg-gray-200 rounded"></div>
            
            <!-- Step 3 -->
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-semibold">
                    3
                </div>
                <span class="ml-2 font-medium text-gray-400">Add Alternatives</span>
            </div>
            
            <div class="w-8 h-1 bg-gray-200 rounded"></div>
            
            <!-- Step 4 -->
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-semibold">
                    4
                </div>
                <span class="ml-2 font-medium text-gray-400">Calculate Results</span>
            </div>
        </div>
    </div>
</div>

<!-- Weight Assignment Form -->
<form action="{{ route('rankings.store-weights') }}" method="POST" id="weightAssignmentForm">
    @csrf
    
    <!-- Hidden fields for title and description -->
    <input type="hidden" name="title" value="{{ $title }}">
    <input type="hidden" name="description" value="{{ $description }}">
    
    <!-- Ranking Summary -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8">
        <div class="gradient-bg p-6">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-info-circle text-white"></i>
                </div>
                <h2 class="text-xl font-bold text-white">Ranking Summary</h2>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">Title</h3>
                    <p class="text-gray-900">{{ $title }}</p>
                </div>
                @if($description)
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Description</h3>
                        <p class="text-gray-900">{{ $description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Weight Assignment -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8">
        <div class="gradient-success p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-weight-hanging text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Assign Weights</h2>
                        <p class="text-green-100">Total weight: <span id="total-weight" class="font-bold">0</span>%</p>
                    </div>
                </div>
                
                <div class="bg-white bg-opacity-20 rounded-lg px-4 py-2">
                    <span class="text-white font-medium">Remaining: <span id="remaining-weight" class="font-bold">100</span>%</span>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <!-- Weight Status -->
            <div id="weight-status" class="mb-6 p-4 rounded-xl hidden">
                <div class="flex items-center space-x-2">
                    <i id="status-icon" class="fas fa-info-circle"></i>
                    <span id="status-message"></span>
                </div>
            </div>
            
            <div class="space-y-6">
                @foreach($selectedCriterias as $criteria)
                    <div class="criteria-weight-item p-6 bg-gray-50 rounded-2xl border-2 border-gray-200 transition-all duration-300">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $criteria->name }}</h3>
                                    
                                    <!-- Type Badge -->
                                    @if($criteria->type === 'benefit')
                                        <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 rounded-lg text-xs font-medium">
                                            <i class="fas fa-arrow-up mr-1"></i>Benefit
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 bg-red-100 text-red-800 rounded-lg text-xs font-medium">
                                            <i class="fas fa-arrow-down mr-1"></i>Cost
                                        </span>
                                    @endif
                                    
                                    <!-- Input Type Badge -->
                                    @if($criteria->input_type === 'number')
                                        <span class="inline-flex items-center px-2 py-1 bg-purple-100 text-purple-800 rounded-lg text-xs font-medium">
                                            <i class="fas fa-hashtag mr-1"></i>Number
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 bg-orange-100 text-orange-800 rounded-lg text-xs font-medium">
                                            <i class="fas fa-list mr-1"></i>Options
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Options Preview -->
                                @if($criteria->input_type === 'options' && $criteria->options->count() > 0)
                                    <div class="mt-2">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($criteria->options->take(3) as $option)
                                                <span class="inline-flex items-center px-2 py-1 bg-white text-gray-600 rounded text-xs border">
                                                    {{ $option->option_text }} ({{ $option->option_value }})
                                                </span>
                                            @endforeach
                                            @if($criteria->options->count() > 3)
                                                <span class="text-xs text-gray-500 px-2 py-1">+{{ $criteria->options->count() - 3 }} more</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex items-center space-x-4">
                                <!-- Weight Input -->
                                <div class="flex items-center space-x-2">
                                    <label for="weight_{{ $criteria->id }}" class="text-sm font-medium text-gray-700 whitespace-nowrap">
                                        Weight:
                                    </label>
                                    <div class="relative">
                                        <input type="number" 
                                               id="weight_{{ $criteria->id }}"
                                               name="criteria_weights[{{ $criteria->id }}]"
                                               value="{{ old('criteria_weights.' . $criteria->id, $oldWeights[$criteria->id] ?? '') }}"
                                               min="0" 
                                               max="100" 
                                               step="0.1"
                                               class="w-20 px-3 py-2 text-center rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all duration-300 weight-input"
                                               placeholder="0">
                                        <span class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm">%</span>
                                    </div>
                                </div>
                                
                                <!-- Quick Weight Buttons -->
                                <div class="flex space-x-1">
                                    <button type="button" 
                                            class="quick-weight-btn px-2 py-1 text-xs bg-blue-100 hover:bg-blue-200 text-blue-700 rounded transition-all duration-200"
                                            data-criteria="{{ $criteria->id }}" 
                                            data-weight="10">
                                        10%
                                    </button>
                                    <button type="button" 
                                            class="quick-weight-btn px-2 py-1 text-xs bg-blue-100 hover:bg-blue-200 text-blue-700 rounded transition-all duration-200"
                                            data-criteria="{{ $criteria->id }}" 
                                            data-weight="25">
                                        25%
                                    </button>
                                    <button type="button" 
                                            class="quick-weight-btn px-2 py-1 text-xs bg-blue-100 hover:bg-blue-200 text-blue-700 rounded transition-all duration-200"
                                            data-criteria="{{ $criteria->id }}" 
                                            data-weight="50">
                                        50%
                                    </button>
                                </div>
                            </div>
                        </div>
                        @error('criteria_weights.' . $criteria->id)
                            <div class="flex items-center mt-2 text-red-600 text-sm">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                @endforeach
            </div>
            
            @error('total_weight')
                <div class="flex items-center mt-4 text-red-600 text-sm">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ $message }}
                </div>
            @enderror
            
            <!-- Equal Distribution Button -->
            <div class="mt-6 text-center">
                <button type="button" 
                        id="equal-distribution-btn"
                        class="px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-xl font-medium transition-all duration-300 transform hover:scale-105 shadow-md">
                    <i class="fas fa-balance-scale mr-2"></i>
                    Distribute Equally
                </button>
            </div>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
        <a href="{{ route('rankings.cancel') }}" 
           class="inline-flex items-center justify-center px-8 py-4 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105"
           onclick="return confirm('Are you sure you want to cancel? All data will be lost.')">
            <i class="fas fa-times-circle mr-2"></i>
            Cancel Ranking
        </a>
        <a href="{{ route('rankings.back-to-criteria') }}" 
           class="inline-flex items-center justify-center px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Criteria Selection
        </a>
        <button type="submit" 
                id="create-ranking-btn"
                class="px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
            <i class="fas fa-plus-circle mr-2"></i>
            Create Ranking & Continue
        </button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const weightInputs = document.querySelectorAll('.weight-input');
    const totalWeightSpan = document.getElementById('total-weight');
    const remainingWeightSpan = document.getElementById('remaining-weight');
    const weightStatus = document.getElementById('weight-status');
    const statusIcon = document.getElementById('status-icon');
    const statusMessage = document.getElementById('status-message');
    const createBtn = document.getElementById('create-ranking-btn');
    const equalDistBtn = document.getElementById('equal-distribution-btn');
    const quickWeightBtns = document.querySelectorAll('.quick-weight-btn');
    
    function updateWeightSummary() {
        let total = 0;
        weightInputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            total += value;
        });
        
        const remaining = 100 - total;
        
        totalWeightSpan.textContent = total.toFixed(1);
        remainingWeightSpan.textContent = remaining.toFixed(1);
        
        // Update status
        weightStatus.classList.remove('hidden');
        
        if (total === 0) {
            weightStatus.className = 'mb-6 p-4 rounded-xl bg-gray-50 border border-gray-200 text-gray-600';
            statusIcon.className = 'fas fa-info-circle';
            statusMessage.textContent = 'Assign weights to criteria to get started';
            createBtn.disabled = true;
        } else if (total > 100) {
            weightStatus.className = 'mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700';
            statusIcon.className = 'fas fa-exclamation-triangle';
            statusMessage.textContent = `Total weight exceeds 100% by ${(total - 100).toFixed(1)}%`;
            createBtn.disabled = true;
        } else if (total < 50) {
            weightStatus.className = 'mb-6 p-4 rounded-xl bg-yellow-50 border border-yellow-200 text-yellow-700';
            statusIcon.className = 'fas fa-exclamation-triangle';
            statusMessage.textContent = 'Consider using more weight for better analysis';
            createBtn.disabled = false;
        } else {
            weightStatus.className = 'mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700';
            statusIcon.className = 'fas fa-check-circle';
            statusMessage.textContent = 'Weight distribution looks good!';
            createBtn.disabled = false;
        }
        
        // Update button text
        if (createBtn.disabled) {
            createBtn.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i>Fix weights to continue';
        } else {
            createBtn.innerHTML = '<i class="fas fa-plus-circle mr-2"></i>Create Ranking & Continue';
        }
    }
    
    // Add event listeners to weight inputs
    weightInputs.forEach(input => {
        input.addEventListener('input', updateWeightSummary);
        input.addEventListener('blur', function() {
            // Ensure value is within bounds
            let value = parseFloat(this.value) || 0;
            if (value < 0) value = 0;
            if (value > 100) value = 100;
            this.value = value === 0 ? '' : value;
            updateWeightSummary();
        });
    });
    
    // Quick weight buttons
    quickWeightBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const criteriaId = this.dataset.criteria;
            const weight = this.dataset.weight;
            const input = document.getElementById(`weight_${criteriaId}`);
            input.value = weight;
            updateWeightSummary();
        });
    });
    
    // Equal distribution button
    equalDistBtn.addEventListener('click', function() {
        const equalWeight = (100 / weightInputs.length).toFixed(1);
        weightInputs.forEach(input => {
            input.value = equalWeight;
        });
        updateWeightSummary();
    });
    
    // Initial update
    updateWeightSummary();
});
</script>
@endsection
