<div class="bg-white rounded-3xl shadow-xl overflow-hidden mt-8">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-history text-white"></i>
                </div>
                <h2 class="text-xl font-bold text-white">Ranking History</h2>
            </div>
            <form action="{{ route('rankings.index') }}" method="GET" class="flex w-full lg:w-auto">
                <div class="relative flex-1 lg:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" 
                           class="w-full pl-10 pr-4 py-3 rounded-l-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 text-gray-700 placeholder-gray-400" 
                           placeholder="Search by title..." 
                           name="search">
                </div>
                <button type="submit" 
                        class="px-6 py-3 bg-white hover:bg-gray-100 rounded-r-xl text-gray-700 font-semibold transition-all duration-300 border-2 border-l-0 border-gray-200">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
    <div class="p-6">
        @if(count($rankings) > 0)
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm mb-6">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Title</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Created By</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Date</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($rankings as $ranking)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                        <span class="font-semibold text-gray-800">{{ $ranking->title }}</span>
                                    </div>
                                    @if($ranking->description)
                                        <p class="text-gray-500 text-sm pl-6">{{ Str::limit($ranking->description, 50) }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-600">{{ $ranking->created_by ?? 'Guest' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2 text-gray-500 text-sm">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>{{ $ranking->created_at->format('M d, Y') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('rankings.show', $ranking->id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 rounded-lg text-white text-sm font-medium transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-eye mr-2"></i> 
                                    View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="text-center">
                <a href="{{ route('rankings.index') }}" 
                   class="inline-flex items-center px-6 py-3 border-2 border-blue-300 rounded-xl text-blue-600 font-semibold hover:bg-blue-50 hover:border-blue-400 transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-list mr-3"></i>
                    View All Rankings
                </a>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-info-circle text-blue-500 text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">No Rankings Created</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    No rankings have been created yet. Get started by creating your first ranking.
                </p>
                
                <a href="{{ route('client.create-ranking') }}" 
                   class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 rounded-xl text-white font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <i class="fas fa-plus-circle mr-3"></i>
                    Create First Ranking
                </a>
            </div>
        @endif
    </div>
</div>
