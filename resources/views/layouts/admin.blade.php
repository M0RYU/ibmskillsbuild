<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Decision Support System')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-card {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .gradient-success {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .gradient-purple {
            background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
        }
        
        .gradient-orange {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .glassmorphism {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
    </style>
      @yield('styles')
</head>
<body class="min-h-screen bg-gray-50 flex flex-col">
    <!-- Modern Admin Navigation -->
    <nav class="gradient-bg shadow-lg relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('admin.index') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-cog text-white text-lg"></i>
                        </div>
                        <span class="text-white font-bold text-xl">DSS Admin</span>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('admin.index') }}" 
                       class="px-4 py-2 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition duration-300 {{ request()->routeIs('admin.index') ? 'bg-white bg-opacity-25' : '' }}">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('admin.criterias.index') }}" 
                       class="px-4 py-2 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition duration-300 {{ request()->routeIs('admin.criterias.*') ? 'bg-white bg-opacity-25' : '' }}">
                        <i class="fas fa-list-check mr-2"></i>Criteria
                    </a>
                    <a href="{{ route('client.index') }}" 
                       class="px-4 py-2 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition duration-300">
                        <i class="fas fa-home mr-2"></i>Client Area
                    </a>
                    
                    <!-- User Menu -->
                    <div class="relative ml-4" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 px-4 py-2 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition duration-300">
                            <div class="w-8 h-8 bg-white bg-opacity-30 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                            <span class="font-medium">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 z-50" style="display: none;">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition duration-300">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button type="button" class="text-white hover:text-gray-300 focus:outline-none" id="mobile-menu-button">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Navigation -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-black bg-opacity-20">
                <a href="{{ route('admin.index') }}"
                   class="block px-3 py-2 rounded-md text-white hover:bg-white hover:bg-opacity-20 transition duration-300">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <a href="{{ route('admin.criterias.index') }}" 
                   class="block px-3 py-2 rounded-md text-white hover:bg-white hover:bg-opacity-20 transition duration-300">
                    <i class="fas fa-list-check mr-2"></i>Criteria
                </a>
                <a href="{{ route('client.index') }}" 
                   class="block px-3 py-2 rounded-md text-white hover:bg-white hover:bg-opacity-20 transition duration-300">
                    <i class="fas fa-home mr-2"></i>Client Area
                </a>
                <div class="border-t border-white border-opacity-20 my-2"></div>
                <div class="px-3 py-2 text-white text-sm">
                    <p class="font-medium">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-blue-200">{{ Auth::user()->email }}</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-white hover:bg-red-500 hover:bg-opacity-50 transition duration-300">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>    <!-- Main Content -->
    <main class="flex-1 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    </div>
                    <button type="button" class="flex-shrink-0 text-green-500 hover:text-green-700" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-red-800 font-medium">{{ session('error') }}</p>
                    </div>
                    <button type="button" class="flex-shrink-0 text-red-500 hover:text-red-700" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-red-800 font-medium mb-2">Please fix the following errors:</h3>
                            <ul class="text-red-700 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li class="flex items-center space-x-2">
                                        <i class="fas fa-circle text-xs"></i>
                                        <span>{{ $error }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="flex-shrink-0 text-red-500 hover:text-red-700" onclick="this.parentElement.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </main>    <!-- Modern Footer -->
    <footer class="bg-gray-800 text-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="text-center">
                <div class="flex items-center justify-center space-x-3 mb-3">
                    <div class="w-6 h-6 bg-gradient-to-r from-blue-500 to-purple-600 rounded flex items-center justify-center">
                        <i class="fas fa-cog text-white text-xs"></i>
                    </div>
                    <span class="text-lg font-bold">DSS Admin Panel</span>
                </div>
                <p class="text-gray-400 text-sm">Decision Support System Administration &copy; {{ date('Y') }}</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
      @yield('scripts')
</body>
</html>
