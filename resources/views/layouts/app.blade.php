<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Decision Support System - MOORA Method')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
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
    </style>  </head>
<body class="min-h-screen bg-gray-50 flex flex-col">
    <!-- Modern Navigation with gradient -->
    <nav class="gradient-bg shadow-lg relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('client.index') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-line text-white text-lg"></i>
                        </div>
                        <span class="text-white font-bold text-xl">DSS MOORA</span>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('client.index') }}" 
                       class="px-4 py-2 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition duration-300 {{ request()->routeIs('client.index') ? 'bg-white bg-opacity-25' : '' }}">
                        <i class="fas fa-home mr-2"></i>Home
                    </a>
                    <a href="{{ route('rankings.index') }}" 
                       class="px-4 py-2 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition duration-300 {{ request()->routeIs('rankings.*') ? 'bg-white bg-opacity-25' : '' }}">
                        <i class="fas fa-list mr-2"></i>Rankings
                    </a>
                    <a href="{{ route('admin.index') }}" 
                       class="px-4 py-2 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition duration-300">
                        <i class="fas fa-cog mr-2"></i>Admin
                    </a>
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
                <a href="{{ route('client.index') }}" 
                   class="block px-3 py-2 rounded-md text-white hover:bg-white hover:bg-opacity-20 transition duration-300">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
                <a href="{{ route('rankings.index') }}" 
                   class="block px-3 py-2 rounded-md text-white hover:bg-white hover:bg-opacity-20 transition duration-300">
                    <i class="fas fa-list mr-2"></i>Rankings
                </a>
                <a href="{{ route('admin.index') }}" 
                   class="block px-3 py-2 rounded-md text-white hover:bg-white hover:bg-opacity-20 transition duration-300">
                    <i class="fas fa-cog mr-2"></i>Admin
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
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
    </main>

    <!-- Modern Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <div class="flex items-center justify-center space-x-3 mb-4">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-white"></i>
                    </div>
                    <span class="text-xl font-bold">DSS MOORA</span>
                </div>
                <p class="text-gray-400">Decision Support System using MOORA Method &copy; {{ date('Y') }}</p>
                <p class="text-sm text-gray-500 mt-2">Multi-Objective Optimization on the basis of Ratio Analysis</p>
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
