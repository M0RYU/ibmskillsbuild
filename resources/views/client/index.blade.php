@extends('layouts.app')

@section('title', 'Mobile Legends Hero Selector - Home')

@section('content')
<!-- Hero Section with Gradient -->
<div class="relative overflow-hidden">
    <div class="gradient-bg rounded-3xl p-8 md:p-12 text-white">
        <div class="relative z-10">
            <div class="text-center">
                <div class="inline-flex items-center px-6 py-3 bg-white bg-opacity-20 rounded-full mb-6">
                    <i class="fas fa-gamepad mr-2 text-xl"></i>
                    <span class="font-semibold">Mobile Legends: Bang Bang</span>
                </div>
                <h1 class="text-4xl md:text-6xl font-bold mb-6 bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent">
                    Hero Selection Assistant
                </h1>
                <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-4xl mx-auto">
                    Temukan Hero Terbaik untuk Setiap Situasi dengan Metode MOORA
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('rankings.create') }}" 
                       class="inline-flex items-center px-8 py-4 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-xl text-white font-semibold transition-all duration-300 transform hover:scale-105 glassmorphism">
                        <i class="fas fa-plus-circle mr-3 text-xl"></i>
                        Pilih Hero Sekarang
                    </a>
                    <a href="{{ route('rankings.index') }}" 
                       class="inline-flex items-center px-8 py-4 bg-transparent border-2 border-white border-opacity-50 hover:bg-white hover:bg-opacity-10 rounded-xl text-white font-semibold transition-all duration-300">
                        <i class="fas fa-history mr-3"></i>
                        Riwayat Pemilihan
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white bg-opacity-10 rounded-full -translate-y-32 translate-x-32"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-white bg-opacity-5 rounded-full translate-y-48 -translate-x-48"></div>
    </div>
</div>

<!-- About Section -->
<div class="mt-16 grid lg:grid-cols-2 gap-12 items-center">
    <div class="space-y-6">
        <div class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
            <i class="fas fa-info-circle mr-2"></i>
            Tentang Sistem Ini
        </div>
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
            Pilih Hero Terbaik 
            <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                Untuk Setiap Situasi
            </span>
        </h2>
        <p class="text-lg text-gray-600 leading-relaxed">
            Sistem ini membantu Anda memilih hero Mobile Legends yang paling sesuai berdasarkan berbagai kriteria seperti role, damage output, durability, mobility, dan karakteristik lainnya menggunakan metode MOORA (Multi-Objective Optimization).
        </p>
        <div class="space-y-4">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-green-400 to-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shield-alt text-white"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Analisis Komprehensif</h3>
                    <p class="text-gray-600">Evaluasi hero berdasarkan berbagai aspek penting dalam game</p>
                </div>
            </div>
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-purple-400 to-pink-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-white"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Sesuai Kebutuhan Tim</h3>
                    <p class="text-gray-600">Tentukan hero yang cocok untuk komposisi dan strategi tim Anda</p>
                </div>
            </div>
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-trophy text-white"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Rekomendasi Terpercaya</h3>
                    <p class="text-gray-600">Dapatkan rekomendasi hero terbaik berdasarkan perhitungan matematis</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="lg:order-first">
        <div class="relative">
            <div class="gradient-card rounded-3xl p-8 text-white card-hover">
                <h3 class="text-2xl font-bold mb-6">Cara Menggunakan</h3>
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center text-sm font-bold">1</div>
                        <div>
                            <h4 class="font-semibold mb-1">Tentukan Situasi</h4>
                            <p class="text-sm text-white text-opacity-90">Buat skenario baru dengan deskripsi kondisi pertandingan</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center text-sm font-bold">2</div>
                        <div>
                            <h4 class="font-semibold mb-1">Pilih Hero Kandidat</h4>
                            <p class="text-sm text-white text-opacity-90">Tambahkan hero-hero yang ingin Anda pertimbangkan</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center text-sm font-bold">3</div>
                        <div>
                            <h4 class="font-semibold mb-1">Evaluasi Kriteria</h4>
                            <p class="text-sm text-white text-opacity-90">Nilai setiap hero berdasarkan kriteria yang telah ditentukan</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center text-sm font-bold">4</div>
                        <div>
                            <h4 class="font-semibold mb-1">Dapatkan Rekomendasi</h4>
                            <p class="text-sm text-white text-opacity-90">Sistem akan merekomendasikan hero terbaik untuk situasi Anda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Cards -->
<div class="mt-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Mulai Sekarang</h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">Pilih cara untuk memulai pemilihan hero terbaik Anda</p>
    </div>
    
    <div class="grid md:grid-cols-2 gap-8">
        <!-- Hero Selection Card -->
        <div class="group relative">
            <div class="gradient-success rounded-3xl p-8 text-white card-hover">
                <div class="text-center">
                    <div class="w-20 h-20 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-user-shield text-4xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Pilih Hero</h3>
                    <p class="text-white text-opacity-90 mb-8 text-lg">Mulai proses pemilihan hero terbaik berdasarkan situasi dan kebutuhan tim Anda.</p>
                    <div class="space-y-3">
                        <a href="{{ route('rankings.create') }}" 
                           class="block w-full bg-white bg-opacity-20 hover:bg-opacity-30 rounded-xl py-4 px-6 text-white font-semibold transition-all duration-300 glassmorphism">
                            <i class="fas fa-plus-circle mr-2"></i>Buat Pemilihan Baru
                        </a>
                        <a href="{{ route('rankings.index') }}" 
                           class="block w-full bg-transparent border-2 border-white border-opacity-50 hover:bg-white hover:bg-opacity-10 rounded-xl py-4 px-6 text-white font-semibold transition-all duration-300">
                            <i class="fas fa-history mr-2"></i>Lihat Riwayat
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Management Card -->
        <div class="group relative">
            <div class="gradient-purple rounded-3xl p-8 text-white card-hover">
                <div class="text-center">
                    <div class="w-20 h-20 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-cogs text-4xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Pengaturan</h3>
                    <p class="text-white text-opacity-90 mb-8 text-lg">Kelola kriteria evaluasi dan pengaturan sistem untuk hasil yang lebih akurat.</p>
                    <div class="space-y-3">
                        <a href="{{ route('admin.index') }}" 
                           class="block w-full bg-white bg-opacity-20 hover:bg-opacity-30 rounded-xl py-4 px-6 text-white font-semibold transition-all duration-300 glassmorphism">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard Admin
                        </a>
                        <a href="{{ route('admin.criterias.index') }}" 
                           class="block w-full bg-transparent border-2 border-white border-opacity-50 hover:bg-white hover:bg-opacity-10 rounded-xl py-4 px-6 text-white font-semibold transition-all duration-300">
                            <i class="fas fa-list-check mr-2"></i>Kelola Kriteria
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if(isset($rankings) && count($rankings) > 0)
<!-- Recent Rankings Section -->
<div class="mt-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Pemilihan Hero Terbaru</h2>
        <p class="text-lg text-gray-600">Riwayat pemilihan hero yang baru saja Anda buat</p>
    </div>
    
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
        <div class="gradient-bg p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-semibold text-white">Riwayat Terbaru</h3>
                <a href="{{ route('rankings.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg text-white font-medium transition-all duration-300 glassmorphism">
                    <i class="fas fa-external-link-alt mr-2"></i>Lihat Semua
                </a>
            </div>
        </div>
        
        <div class="p-6">
            <div class="space-y-4">
                @foreach($rankings as $ranking)
                <div class="flex items-center justify-between p-6 bg-gray-50 hover:bg-gray-100 rounded-2xl transition-all duration-300 card-hover">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-shield text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-lg">{{ $ranking->title }}</h4>
                            @if($ranking->description)
                                <p class="text-gray-600 text-sm">{{ Str::limit($ranking->description, 60) }}</p>
                            @endif
                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                <span>
                                    <i class="fas fa-user mr-1"></i>{{ $ranking->created_by ?? 'Guest' }}
                                </span>
                                <span>
                                    <i class="fas fa-calendar mr-1"></i>{{ $ranking->created_at->format('d M Y') }}
                                </span>
                                <span>
                                    <i class="fas fa-users mr-1"></i>{{ $ranking->alternatives->count() }} hero
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('rankings.show', $ranking->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-eye mr-2"></i>Lihat Hasil
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<!-- Statistics Section -->
<div class="mt-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center p-8 bg-white rounded-3xl shadow-lg card-hover">
            <div class="w-16 h-16 bg-gradient-to-r from-green-400 to-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-history text-2xl text-white"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ isset($rankings) ? count($rankings) : 0 }}</h3>
            <p class="text-gray-600">Pemilihan Terbaru</p>
        </div>
        
        <div class="text-center p-8 bg-white rounded-3xl shadow-lg card-hover">
            <div class="w-16 h-16 bg-gradient-to-r from-purple-400 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-brain text-2xl text-white"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">MOORA</h3>
            <p class="text-gray-600">Metode Analisis</p>
        </div>
        
        <div class="text-center p-8 bg-white rounded-3xl shadow-lg card-hover">
            <div class="w-16 h-16 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-trophy text-2xl text-white"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Akurat</h3>
            <p class="text-gray-600">Rekomendasi Terpercaya</p>
        </div>
    </div>
</div>
@endsection
