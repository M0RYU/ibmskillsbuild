@extends('layouts.admin')

@section('title', 'Admin - Criteria Management')

@section('content')
<!-- Page Header with Gradient -->
<div class="gradient-bg rounded-3xl p-8 mb-8 text-white">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div class="flex-1">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-list-check text-white text-lg"></i>
                </div>
                <div>
                    <span class="text-blue-100 text-sm font-medium">Admin Panel</span>
                    <h1 class="text-2xl md:text-3xl font-bold">Criteria Management</h1>
                </div>
            </div>
            <p class="text-blue-100 text-lg">
                Manage and configure evaluation criteria for the MOORA decision support system
            </p>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('admin.criterias.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-white hover:bg-gray-100 rounded-xl text-gray-700 font-semibold transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-plus-circle mr-2"></i>
                Add New Criteria
            </a>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-list text-white"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900">{{ count($criterias) }}</h3>
                <p class="text-gray-600">Total Criteria</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-white"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $criterias->where('is_active', true)->count() }}</h3>
                <p class="text-gray-600">Active Criteria</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-cogs text-white"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $criterias->where('input_type', 'options')->count() }}</h3>
                <p class="text-gray-600">Criteria with Options</p>
            </div>
        </div>
    </div>
</div>

<!-- Criteria List -->
<div class="bg-white rounded-3xl shadow-xl overflow-hidden">
    <div class="gradient-success p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-database text-white"></i>
                </div>
                <h2 class="text-2xl font-bold text-white">All Criteria</h2>
            </div>
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 bg-white bg-opacity-20 rounded-lg text-white text-sm font-medium">
                    Total: {{ count($criterias) }} criteria
                </span>
            </div>
        </div>
    </div>
    
    <!-- Search Box -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
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
            <div class="flex items-center space-x-3">
                <select id="statusFilter" class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                    <option value="all">All Status</option>
                    <option value="active">Active Only</option>
                    <option value="inactive">Inactive Only</option>
                </select>
            </div>
        </div>
    </div>
    
    <div class="p-6">        @if(count($criterias) > 0)
            <div class="space-y-4" id="criteriaList">
                @foreach($criterias as $criteria)
                <div class="criteria-item p-6 bg-gray-50 hover:bg-gray-100 rounded-2xl transition-all duration-300 card-hover" 
                     data-name="{{ strtolower($criteria->name) }}" 
                     data-status="{{ $criteria->is_active ? 'active' : 'inactive' }}">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center">
                                    <i class="fas fa-{{ $criteria->input_type === 'number' ? 'hashtag' : 'list' }} text-white text-xl"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <h3 class="text-xl font-bold text-gray-900">{{ $criteria->name }}</h3>
                                        <!-- Status Badge -->
                                        @if($criteria->is_active)
                                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-lg text-sm font-medium">
                                                <i class="fas fa-check-circle mr-1"></i>Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 rounded-lg text-sm font-medium">
                                                <i class="fas fa-times-circle mr-1"></i>Inactive
                                            </span>
                                        @endif
                                    </div>
                                      <div class="flex flex-wrap items-center gap-3 mb-4">
                                        <!-- Type Badge -->
                                        @if($criteria->type === 'benefit')
                                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-lg text-sm font-medium">
                                                <i class="fas fa-arrow-up mr-1"></i>Benefit
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 rounded-lg text-sm font-medium">
                                                <i class="fas fa-arrow-down mr-1"></i>Cost
                                            </span>
                                        @endif
                                        
                                        <!-- Input Type Badge -->
                                        @if($criteria->input_type === 'number')
                                            <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-800 rounded-lg text-sm font-medium">
                                                <i class="fas fa-hashtag mr-1"></i>Number Input
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 bg-orange-100 text-orange-800 rounded-lg text-sm font-medium">
                                                <i class="fas fa-list mr-1"></i>Options ({{ count($criteria->options) }})
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Options Preview -->
                                    @if($criteria->input_type === 'options' && count($criteria->options) > 0)
                                        <div class="bg-white rounded-xl p-4 border border-gray-200">
                                            <h4 class="text-sm font-semibold text-gray-700 mb-3">Available Options:</h4>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                                @foreach($criteria->options->take(4) as $option)
                                                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                                                        <span class="text-sm text-gray-700">{{ $option->option_text }}</span>
                                                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $option->option_value }}</span>
                                                    </div>
                                                @endforeach
                                                @if(count($criteria->options) > 4)
                                                    <div class="p-2 text-center text-sm text-gray-500">
                                                        +{{ count($criteria->options) - 4 }} more options
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                          <!-- Action Buttons -->
                        <div class="flex items-center space-x-3">
                            <!-- Toggle Active Button -->
                            <form action="{{ route('admin.criterias.toggle-active', $criteria->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 {{ $criteria->is_active ? 'bg-red-100 hover:bg-red-200 text-red-700' : 'bg-green-100 hover:bg-green-200 text-green-700' }} rounded-lg font-medium transition-all duration-300">
                                    <i class="fas fa-{{ $criteria->is_active ? 'times' : 'check' }} mr-2"></i>
                                    {{ $criteria->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            
                            @if($criteria->input_type === 'options' && count($criteria->options) > 0)
                                <button type="button" 
                                        class="inline-flex items-center px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg font-medium transition-all duration-300"
                                        onclick="toggleOptions('options-{{ $criteria->id }}')">
                                    <i class="fas fa-eye mr-2"></i>View All Options
                                </button>
                            @endif
                            
                            <a href="{{ route('admin.criterias.edit', $criteria->id) }}" 
                               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </a>
                            
                            <form action="{{ route('admin.criterias.destroy', $criteria->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this criteria? This will also delete all related assessments.')"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-trash-alt mr-2"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Expandable Options Detail -->
                    @if($criteria->input_type === 'options' && count($criteria->options) > 0)
                        <div id="options-{{ $criteria->id }}" class="hidden mt-6 pt-6 border-t border-gray-200">
                            <h4 class="font-semibold text-gray-900 mb-4">All Options for "{{ $criteria->name }}"</h4>
                            <div class="bg-white rounded-xl overflow-hidden shadow-sm">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-1">
                                    @foreach($criteria->options as $option)
                                        <div class="flex items-center justify-between p-4 border-b border-gray-100 last:border-b-0">
                                            <span class="font-medium text-gray-900">{{ $option->option_text }}</span>
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-sm font-mono">{{ $option->option_value }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-list-check text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Criteria Defined</h3>
                <p class="text-gray-600 mb-8">Get started by creating your first evaluation criteria for the MOORA decision system.</p>
                <a href="{{ route('admin.criterias.create') }}" 
                   class="inline-flex items-center px-6 py-3 gradient-bg text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-plus-circle mr-2"></i>Add First Criteria
                </a>
            </div>
        @endif
    </div>
</div>

<script>
function toggleOptions(elementId) {
    const element = document.getElementById(elementId);
    element.classList.toggle('hidden');
}

// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('criteriaSearch');
    const statusFilter = document.getElementById('statusFilter');
    const criteriaList = document.getElementById('criteriaList');
    const criteriaItems = criteriaList.querySelectorAll('.criteria-item');

    function filterCriteria() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;

        criteriaItems.forEach(item => {
            const name = item.getAttribute('data-name');
            const status = item.getAttribute('data-status');
            
            const matchesSearch = name.includes(searchTerm);
            const matchesStatus = statusValue === 'all' || status === statusValue;
            
            if (matchesSearch && matchesStatus) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterCriteria);
    statusFilter.addEventListener('change', filterCriteria);
});
</script>
@endsection
