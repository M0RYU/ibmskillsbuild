@extends('layouts.app')

@section('title', 'Create New Ranking - Select Criteria')

@section('content')
<!-- Page Header -->
<div class="gradient-bg rounded-3xl p-8 mb-8 text-white">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div class="flex-1">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-plus-circle text-white text-lg"></i>
                </div>
                <div>
                    <span class="text-blue-100 text-sm font-medium">Step 1 of 4</span>
                    <h1 class="text-2xl md:text-3xl font-bold">Create New Ranking</h1>
                </div>
            </div>
            <p class="text-blue-100 text-lg">
                Select criteria and assign weights for your MOORA decision analysis
            </p>
        </div>
        
        <div>
            <a href="{{ route('rankings.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-white hover:bg-gray-100 rounded-xl text-gray-700 font-semibold transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Rankings
            </a>
        </div>
    </div>
</div>

<!-- Progress Steps -->
<div class="mb-8">
    <div class="flex items-center justify-center">
        <div class="flex items-center space-x-4">
            <!-- Step 1 - Active -->
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-semibold">
                    1
                </div>
                <span class="ml-2 font-medium text-blue-600">Select Criteria</span>
            </div>
            
            <div class="w-8 h-1 bg-gray-200 rounded"></div>
            
            <!-- Step 2 -->
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-semibold">
                    2
                </div>
                <span class="ml-2 font-medium text-gray-400">Assign Weights</span>
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

<!-- Selection Form -->                <form action="{{ route('rankings.store-criteria-selection') }}" method="POST" id="criteriaSelectionForm">
    @csrf
    
    <!-- Basic Information -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8">
        <div class="gradient-bg p-6">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-info-circle text-white"></i>
                </div>
                <h2 class="text-xl font-bold text-white">Basic Information</h2>
            </div>
        </div>
          <div class="p-6">
            <div class="grid grid-cols-1 gap-6">
                <!-- Display Ranking Info -->
                <div class="bg-gray-50 rounded-xl p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $rankingData['title'] }}</h3>
                    @if(!empty($rankingData['description']))
                        <p class="text-gray-600 text-sm">{{ $rankingData['description'] }}</p>
                    @endif
                </div>
            </div>        </div>
    </div>
    
    <!-- Criteria Selection -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8">
        <div class="gradient-success p-6">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-list-check text-white"></i>
                </div>
                <h2 class="text-xl font-bold text-white">Select Criteria</h2>
            </div>
            <p class="text-green-100 mt-2">Choose at least 2 criteria for your ranking analysis</p>
        </div>
          <div class="p-6">
            @if($criterias->count() > 0)
                <!-- Search Box -->
                <div class="mb-6">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" 
                               id="criteriaSearch" 
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" 
                               placeholder="Search criteria by name...">
                    </div>
                </div>
                
                <div class="space-y-4" id="criteriaList">                    @foreach($criterias as $criteria)
                        @php
                            $selectedCriteria = $rankingData['selected_criteria'] ?? [];
                            $isChecked = in_array($criteria->id, $selectedCriteria);
                        @endphp
                        <div class="criteria-item p-6 bg-gray-50 hover:bg-blue-50 rounded-2xl transition-all duration-300 cursor-pointer border-2 border-transparent hover:border-blue-200"
                             data-name="{{ strtolower($criteria->name) }}">
                            <label class="flex items-start space-x-4 cursor-pointer">
                                <div class="flex-shrink-0 mt-1">
                                    <input type="checkbox" 
                                           name="selected_criteria[]" 
                                           value="{{ $criteria->id }}"
                                           class="w-5 h-5 text-blue-600 border-2 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 transition-all duration-300"
                                           {{ $isChecked ? 'checked' : '' }}>
                                </div>
                                
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
                                        <div class="mt-3 p-3 bg-white rounded-lg border border-gray-200">
                                            <h4 class="text-sm font-medium text-gray-700 mb-2">Available Options:</h4>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($criteria->options->take(3) as $option)
                                                    <span class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs">
                                                        {{ $option->option_text }} ({{ $option->option_value }})
                                                    </span>
                                                @endforeach
                                                @if($criteria->options->count() > 3)
                                                    <span class="text-xs text-gray-500">+{{ $criteria->options->count() - 3 }} more</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
                
                @error('selected_criteria')
                    <div class="flex items-center mt-4 text-red-600 text-sm">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ $message }}
                    </div>
                @enderror
                
                <div id="selection-feedback" class="mt-4 text-sm text-gray-600 hidden">
                    <span id="selected-count">0</span> criteria selected
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-exclamation-triangle text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Criteria Available</h3>
                    <p class="text-gray-600 mb-6">There are no criteria defined yet. Please contact an administrator to set up criteria first.</p>
                    <a href="{{ route('rankings.index') }}" 
                       class="inline-flex items-center px-6 py-3 gradient-bg text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Rankings
                    </a>
                </div>
            @endif
        </div>
    </div>
    
    @if($criterias->count() > 0)
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
            <a href="{{ route('rankings.cancel') }}" 
               class="inline-flex items-center justify-center px-8 py-4 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105"
               onclick="return confirm('Are you sure you want to cancel? All data will be lost.')">
                <i class="fas fa-times-circle mr-2"></i>
                Cancel Ranking
            </a>
            <a href="{{ route('rankings.create') }}" 
               class="inline-flex items-center justify-center px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-arrow-left mr-2"></i>
                Back
            </a>
            <button type="submit" 
                    id="continue-btn"
                    class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled>
                <i class="fas fa-arrow-right mr-2"></i>
                Continue to Weight Assignment
            </button>
        </div>
    @endif
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('input[name="selected_criteria[]"]');
    const continueBtn = document.getElementById('continue-btn');
    const feedback = document.getElementById('selection-feedback');
    const selectedCount = document.getElementById('selected-count');
    
    function updateSelection() {
        const checked = document.querySelectorAll('input[name="selected_criteria[]"]:checked');
        const count = checked.length;
        
        if (selectedCount) {
            selectedCount.textContent = count;
            feedback.classList.remove('hidden');
        }
        
        // Enable continue button if at least 2 criteria are selected
        if (continueBtn) {
            continueBtn.disabled = count < 2;
            
            if (count < 2) {
                continueBtn.innerHTML = '<i class="fas fa-info-circle mr-2"></i>Select at least 2 criteria';
            } else {
                continueBtn.innerHTML = '<i class="fas fa-arrow-right mr-2"></i>Continue to Weight Assignment';
            }
        }
        
        // Update visual styling for selected items
        checkboxes.forEach(checkbox => {
            const item = checkbox.closest('.criteria-item');
            if (checkbox.checked) {
                item.classList.add('border-blue-500', 'bg-blue-50');
                item.classList.remove('border-transparent');
            } else {
                item.classList.remove('border-blue-500', 'bg-blue-50');
                item.classList.add('border-transparent');
            }
        });
    }
      // Add event listeners to all checkboxes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelection);
    });
    
    // Add click event to criteria items
    document.querySelectorAll('.criteria-item').forEach(item => {
        item.addEventListener('click', function(e) {
            if (e.target.type !== 'checkbox') {
                const checkbox = item.querySelector('input[type="checkbox"]');
                checkbox.checked = !checkbox.checked;
                updateSelection();
            }
        });
    });
    
    // Initial update
    updateSelection();
    
    // Search functionality
    const searchInput = document.getElementById('criteriaSearch');
    const criteriaList = document.getElementById('criteriaList');
    const criteriaItems = criteriaList.querySelectorAll('.criteria-item');

    function filterCriteria() {
        const searchTerm = searchInput.value.toLowerCase();

        criteriaItems.forEach(item => {
            const name = item.getAttribute('data-name');
            
            if (name.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterCriteria);
});
</script>
@endsection
