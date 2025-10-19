@extends('layouts.admin')

@section('title', 'Admin - Edit Criteria')

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
                    <h1 class="text-2xl md:text-3xl font-bold">Edit Criteria</h1>
                </div>
            </div>
            <p class="text-blue-100 text-lg">
                Update criteria settings for the MOORA decision support system
            </p>
        </div>
        
        <div>
            <a href="{{ route('admin.criterias.index') }}" 
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
            <h2 class="text-xl font-bold text-white">Criteria Details</h2>
        </div>
    </div>
    
    <div class="p-6">
        <form action="{{ route('admin.criterias.update', $criteria->id) }}" method="POST" id="criteriaForm">
            @csrf
            @method('PUT')
            
            <!-- Enhanced Form Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Criteria Name Field -->
                    <div class="group">
                        <label for="name" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                            Criteria Name 
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
                                   value="{{ old('name', $criteria->name) }}" 
                                   placeholder="Enter criteria name..."
                                   required>
                        </div>
                        @error('name')
                            <div class="flex items-center mt-2 text-red-600 text-sm">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Criteria Type Field -->
                    <div class="group">
                        <label for="type" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                            <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                            Criteria Type 
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-list-alt text-gray-400"></i>
                            </div>
                            <select class="w-full pl-12 pr-4 py-4 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-300 text-gray-700 bg-white appearance-none @error('type') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror" 
                                    id="type" 
                                    name="type" 
                                    required>
                                <option value="" class="text-gray-400">-- Select Type --</option>
                                <option value="benefit" {{ (old('type', $criteria->type) == 'benefit') ? 'selected' : '' }}>✓ Benefit (Higher is better)</option>
                                <option value="cost" {{ (old('type', $criteria->type) == 'cost') ? 'selected' : '' }}>✗ Cost (Lower is better)</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                        @error('type')
                            <div class="flex items-center mt-2 text-red-600 text-sm">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">                    <!-- Input Type Field -->
                    <div class="group">
                        <label for="input_type" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                            <div class="w-2 h-2 bg-orange-500 rounded-full mr-3"></div>
                            Input Type 
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-keyboard text-gray-400"></i>
                            </div>
                            <select class="w-full pl-12 pr-4 py-4 rounded-xl border-2 border-gray-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all duration-300 text-gray-700 bg-white appearance-none @error('input_type') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror" 
                                    id="input_type" 
                                    name="input_type" 
                                    required>
                                <option value="" class="text-gray-400">-- Select Input Type --</option>
                                <option value="number" {{ (old('input_type', $criteria->input_type) == 'number') ? 'selected' : '' }}>🔢 Number</option>
                                <option value="options" {{ (old('input_type', $criteria->input_type) == 'options') ? 'selected' : '' }}>📋 Options</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                        <div class="flex items-center mt-2 text-amber-600 text-sm">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Warning:</strong> Changing input type will remove all existing option values.
                        </div>
                        @error('input_type')
                            <div class="flex items-center mt-2 text-red-600 text-sm">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Status Field -->
                    <div class="group">
                        <label class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                            Status
                        </label>
                        <div class="bg-gray-50 border-2 border-gray-200 rounded-xl p-4">
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" 
                                       class="w-5 h-5 text-green-600 border-2 border-gray-300 rounded focus:ring-green-500 focus:ring-2 transition-all duration-300"
                                       id="is_active" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', $criteria->is_active) ? 'checked' : '' }}>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-toggle-on text-green-500"></i>
                                    <span class="text-gray-700 font-medium">Active (criteria will be available for ranking)</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Enhanced Options Container -->
            <div id="optionsContainer" class="mt-8 bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-100 rounded-2xl p-8 shadow-lg transform transition-all duration-500" style="{{ (old('input_type', $criteria->input_type) == 'options') ? '' : 'display: none;' }}">
                <div class="mb-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-list-check text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Criteria Options</h3>
                            <p class="text-gray-600 text-sm">Define the options for this criteria along with their values.</p>
                        </div>
                    </div>
                </div>
                
                <div id="options" class="space-y-6">
                    @if(old('options'))
                        @foreach(old('options') as $key => $option)
                            <div class="option-row bg-white p-6 rounded-2xl shadow-md border-2 border-gray-100 hover:border-blue-200 transition-all duration-300 transform hover:scale-[1.02]">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                                    <div class="md:col-span-5">
                                        <label class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                            Option Text 
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <i class="fas fa-text-width text-gray-400"></i>
                                            </div>
                                            <input type="text" 
                                                   class="w-full pl-12 pr-4 py-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300" 
                                                   name="options[{{ $key }}][text]" 
                                                   value="{{ $option['text'] ?? '' }}" 
                                                   placeholder="Enter option text..."
                                                   required>
                                        </div>
                                    </div>
                                    <div class="md:col-span-5">
                                        <label class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                            <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                            Option Value 
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <i class="fas fa-hashtag text-gray-400"></i>
                                            </div>
                                            <input type="number" 
                                                   step="any" 
                                                   class="w-full pl-12 pr-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300" 
                                                   name="options[{{ $key }}][value]" 
                                                   value="{{ $option['value'] ?? '' }}" 
                                                   placeholder="0"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="md:col-span-2">
                                        <button type="button" class="w-full px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 remove-option shadow-md">
                                            <i class="fas fa-trash mr-2"></i>Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @elseif($criteria->input_type == 'options')
                        @foreach($criteria->options as $key => $option)
                            <div class="option-row bg-white p-6 rounded-2xl shadow-md border-2 border-gray-100 hover:border-blue-200 transition-all duration-300 transform hover:scale-[1.02]">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                                    <div class="md:col-span-5">
                                        <label class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                            Option Text 
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <i class="fas fa-text-width text-gray-400"></i>
                                            </div>
                                            <input type="text" 
                                                   class="w-full pl-12 pr-4 py-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300" 
                                                   name="options[{{ $key }}][text]" 
                                                   value="{{ $option->option_text }}" 
                                                   placeholder="Enter option text..."
                                                   required>
                                        </div>
                                    </div>
                                    <div class="md:col-span-5">
                                        <label class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                            <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                            Option Value 
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <i class="fas fa-hashtag text-gray-400"></i>
                                            </div>
                                            <input type="number" 
                                                   step="any" 
                                                   class="w-full pl-12 pr-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300" 
                                                   name="options[{{ $key }}][value]" 
                                                   value="{{ $option->option_value }}" 
                                                   placeholder="0"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="md:col-span-2">
                                        <button type="button" class="w-full px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 remove-option shadow-md">
                                            <i class="fas fa-trash mr-2"></i>Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach                            

                    @else
                        <div class="option-row bg-white p-6 rounded-2xl shadow-md border-2 border-gray-100 hover:border-blue-200 transition-all duration-300 transform hover:scale-[1.02]">
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                                <div class="md:col-span-5">
                                    <label class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                        Option Text 
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-text-width text-gray-400"></i>
                                        </div>
                                        <input type="text" 
                                               class="w-full pl-12 pr-4 py-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300" 
                                               name="options[0][text]"
                                               placeholder="Enter option text...">
                                    </div>
                                </div>
                                <div class="md:col-span-5">
                                    <label class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                        <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                        Option Value 
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-hashtag text-gray-400"></i>
                                        </div>
                                        <input type="number" 
                                               step="any" 
                                               class="w-full pl-12 pr-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300" 
                                               name="options[0][value]"
                                               placeholder="0">
                                    </div>
                                </div>
                                <div class="md:col-span-2">
                                    <button type="button" class="w-full px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 remove-option shadow-md">
                                        <i class="fas fa-trash mr-2"></i>Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="mt-6 flex justify-center">
                    <button type="button" class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg" id="addOption">
                        <i class="fas fa-plus-circle mr-2"></i> Add New Option
                    </button>
                </div>
            </div>
            
            <!-- Enhanced Submit Button -->
            <div class="mt-12 flex justify-center">
                <div class="flex space-x-4">
                    <a href="{{ route('admin.criterias.index') }}" 
                       class="px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-md">
                        <i class="fas fa-times mr-2"></i> Cancel
                    </a>
                    <button type="submit" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-save mr-2"></i> Update Criteria
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputTypeSelect = document.getElementById('input_type');
        const optionsContainer = document.getElementById('optionsContainer');
        const addOptionBtn = document.getElementById('addOption');
        const optionsDiv = document.getElementById('options');
        
        // Function to toggle required attribute on option inputs
        function toggleOptionInputsRequired(required) {
            const optionInputs = optionsDiv.querySelectorAll('input');
            optionInputs.forEach(input => {
                if (required) {
                    input.setAttribute('required', 'required');
                } else {
                    input.removeAttribute('required');
                }
            });
        }
        
        // Show/hide options container based on input type
        inputTypeSelect.addEventListener('change', function() {
            if (this.value === 'options') {
                optionsContainer.style.display = 'block';
                
                // Ensure there's at least one option
                if (optionsDiv.children.length === 0) {
                    addOption();
                }
                
                // Enable required attribute for option inputs
                toggleOptionInputsRequired(true);
            } else {
                optionsContainer.style.display = 'none';
                
                // Disable required attribute for option inputs
                toggleOptionInputsRequired(false);
            }
        });
        
        // Initialize the required attributes based on the initial input type
        toggleOptionInputsRequired(inputTypeSelect.value === 'options');
        
        // Add new option
        addOptionBtn.addEventListener('click', addOption);
        
        // Remove option
        optionsDiv.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-option') || e.target.closest('.remove-option')) {
                const optionRow = e.target.closest('.option-row');
                
                // Only remove if there's more than one option
                if (optionsDiv.children.length > 1) {
                    optionRow.remove();
                } else {
                    alert('You need at least one option.');
                }
            }
        });
        
        function addOption() {
            const optionCount = optionsDiv.children.length;
            const newOption = document.createElement('div');
            newOption.className = 'option-row bg-white p-6 rounded-2xl shadow-md border-2 border-gray-100 hover:border-blue-200 transition-all duration-300 transform hover:scale-[1.02]';
            newOption.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                    <div class="md:col-span-5">
                        <label class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                            Option Text 
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-text-width text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   class="w-full pl-12 pr-4 py-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300" 
                                   name="options[${optionCount}][text]">
                        </div>
                    </div>
                    <div class="md:col-span-5">
                        <label class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                            Option Value 
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-hashtag text-gray-400"></i>
                            </div>
                            <input type="number" 
                                   step="any" 
                                   class="w-full pl-12 pr-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300" 
                                   name="options[${optionCount}][value]">
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <button type="button" class="w-full px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 remove-option shadow-md">
                            <i class="fas fa-trash mr-2"></i>Remove
                        </button>
                    </div>
                </div>
            `;
            
            optionsDiv.appendChild(newOption);
            
            // Apply required attribute based on current input type
            if (inputTypeSelect.value === 'options') {
                const inputs = newOption.querySelectorAll('input');
                inputs.forEach(input => {
                    input.setAttribute('required', 'required');
                });
            }
        }
        
        // Validate form before submission
        document.getElementById('criteriaForm').addEventListener('submit', function(e) {
            const inputType = inputTypeSelect.value;
            
            // Only validate options if the input type is 'options'
            if (inputType === 'options') {
                const optionRows = optionsDiv.querySelectorAll('.option-row');
                
                if (optionRows.length === 0) {
                    e.preventDefault();
                    alert('You need to add at least one option for an options-type criteria.');
                    return;
                }
                
                // Check if all option fields are filled
                let hasEmptyFields = false;
                optionRows.forEach(row => {
                    const inputs = row.querySelectorAll('input');
                    inputs.forEach(input => {
                        if (!input.value.trim()) {
                            hasEmptyFields = true;
                        }
                    });
                });
                
                if (hasEmptyFields) {
                    e.preventDefault();
                    alert('Please fill in all option fields.');
                }
            }
        });
    });
</script>
@endsection
