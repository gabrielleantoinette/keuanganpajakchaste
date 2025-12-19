<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Aplikasi Keuangan Chaste')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-teal-50 to-blue-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-gradient-to-r from-teal-600 to-blue-600 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-white">📊 Aplikasi Keuangan Chaste</h1>
                    <nav class="flex items-center space-x-4">
                        @auth
                            <a href="{{ route('expenses.index') }}" class="text-white hover:text-teal-100 font-medium transition-colors">
                                Daftar Pengeluaran
                            </a>
                            <a href="{{ route('expenses.report') }}" class="text-white hover:text-teal-100 font-medium transition-colors">
                                Laporan
                            </a>
                            <a href="{{ route('expenses.create') }}" class="bg-white text-teal-600 px-4 py-2 rounded-lg hover:bg-teal-50 transition-colors font-medium shadow-md">
                                + Tambah Pengeluaran
                            </a>
                            <div class="flex items-center space-x-4 border-l border-teal-400 border-opacity-50 pl-4">
                                <span class="text-sm text-white">Halo, <span class="font-semibold">{{ Auth::user()->name }}</span></span>
                                <form action="{{ route('logout') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-100 hover:text-white font-medium text-sm transition-colors">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-white hover:text-teal-100 font-medium transition-colors">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="bg-white text-teal-600 px-4 py-2 rounded-lg hover:bg-teal-50 transition-colors font-medium shadow-md">
                                Daftar
                            </a>
                        @endauth
                    </nav>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <p class="text-center text-gray-600 text-sm">
                    &copy; {{ date('Y') }} Aplikasi Keuangan Chaste. Dibuat dengan Laravel & Tailwind CSS.
                </p>
            </div>
        </footer>
    </div>
</body>
</html>