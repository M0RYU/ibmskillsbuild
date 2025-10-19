@extends('layouts.app')

@section('title', 'Create New Ranking')

@section('content')
<!-- Page Header with Gradient -->
<div class="gradient-bg rounded-3xl p-8 mb-8 text-white">
    <div class="text-center">
        <div class="w-20 h-20 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-plus-circle text-3xl text-white"></i>
        </div>
        <h1 class="text-3xl md:text-4xl font-bold mb-4">Create New Ranking</h1>
        <p class="text-xl text-blue-100 max-w-2xl mx-auto">
            Start your decision-making process by creating a comprehensive ranking system using the MOORA method
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
        <!-- Info Banner -->
        <div class="bg-blue-50 p-6 border-b border-blue-100">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0 w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-info-circle text-white"></i>
                </div>                <div>
                    <h3 class="font-semibold text-blue-900 mb-1">Getting Started</h3>
                    <p class="text-blue-700">Create a new ranking by providing a title and description. You'll then select criteria, assign weights, and add alternatives to compare.</p>
                </div>
            </div>
        </div>
        
        <!-- Form Section -->
        <div class="p-8">
            <form action="{{ route('rankings.store-basic') }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- Title Field -->
                <div class="space-y-2">
                    <label for="title" class="block text-lg font-semibold text-gray-900">
                        Ranking Title 
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           class="w-full px-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('title') border-red-300 bg-red-50 @enderror" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $rankingData['title'] ?? '') }}" 
                           placeholder="e.g., Best Laptop for Programming"
                           required>
                    <p class="text-gray-600 text-sm">Give your ranking a clear, descriptive title that explains what you're comparing.</p>
                    @error('title')
                        <p class="text-red-600 text-sm flex items-center space-x-2">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>
                
                <!-- Description Field -->
                <div class="space-y-2">
                    <label for="description" class="block text-lg font-semibold text-gray-900">
                        Description
                    </label>
                    <textarea 
                        class="w-full px-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('description') border-red-300 bg-red-50 @enderror" 
                        id="description" 
                        name="description" 
                        rows="4"
                        placeholder="Provide additional details about this ranking (optional)">{{ old('description', $rankingData['description'] ?? '') }}</textarea>
                    <p class="text-gray-600 text-sm">Optional: Add context or specific requirements for your decision-making process.</p>
                    @error('description')
                        <p class="text-red-600 text-sm flex items-center space-x-2">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <a href="{{ route('rankings.index') }}" 
                       class="flex-1 inline-flex items-center justify-center px-6 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-times mr-3"></i>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="flex-1 inline-flex items-center justify-center px-6 py-4 gradient-bg hover:opacity-90 text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-arrow-right mr-3"></i>
                        Continue to Select Criteria
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Help Section -->
    <div class="mt-8 bg-gradient-to-r from-purple-50 to-blue-50 rounded-3xl p-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">What's Next?</h3>        <div class="grid md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="w-12 h-12 bg-gradient-to-r from-green-400 to-blue-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-white font-bold">1</span>
                </div>
                <h4 class="font-semibold text-gray-900 mb-2">Select Criteria</h4>
                <p class="text-gray-600 text-sm">Choose which criteria to use for evaluation and assign weights</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-gradient-to-r from-purple-400 to-pink-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-white font-bold">2</span>
                </div>
                <h4 class="font-semibold text-gray-900 mb-2">Add Alternatives</h4>
                <p class="text-gray-600 text-sm">Define the options you want to compare with criteria values</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-white font-bold">3</span>
                </div>
                <h4 class="font-semibold text-gray-900 mb-2">Get Results</h4>
                <p class="text-gray-600 text-sm">View optimized rankings using MOORA analysis</p>
            </div>
        </div>
    </div>
</div>
@endsection
