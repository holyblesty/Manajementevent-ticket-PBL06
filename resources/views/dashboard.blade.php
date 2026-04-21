@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

@vite(['resources/css/app.css', 'resources/js/app.js'])


<!-- HEADER -->
<div class="bg-gradient-to-r from-purple-700 to-purple-400 text-white px-8 py-6 shadow">
    <h1 class="text-2xl font-bold">DASHBOARD ADMIN</h1>
    <p class="opacity-90">Kelola Acara</p>
</div>

<div class="flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white shadow-md p-6 min-h-screen">
        <div class="text-center mb-6">
            <div class="w-20 h-20 bg-gray-300 rounded-full mx-auto mb-3"></div>
            <h2 class="font-bold">WELCOME ADMIN</h2>
        </div>

        <ul class="space-y-3">
            <li class="bg-purple-600 text-white p-2 rounded text-center">Kelola Acara</li>
            <li class="p-2 hover:bg-gray-200 rounded text-center cursor-pointer">Kelola Peserta</li>
            <li class="p-2 hover:bg-gray-200 rounded text-center cursor-pointer">Statistik</li>
        </ul>
    </aside>

    <!-- CONTENT -->
    <main class="flex-1 p-8">
        <h2 class="text-xl font-semibold">Ini isi dashboard</h2>
    </main>

</div>

<!-- FOOTER -->
<footer class="footer-custom mt-10">
    <div class="text-center py-4">
        © 2026 Event Ticketing System
    </div>
</footer>

@endsection
