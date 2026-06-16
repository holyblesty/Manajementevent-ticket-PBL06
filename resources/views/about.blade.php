@extends('layouts.app') 

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="max-w-4xl mx-auto text-center">
        <h1 class="text-5xl font-black text-purplePrimary mb-6 uppercase">Tentang Kami</h1>
        <div class="w-24 h-2 bg-purpleAccent mx-auto mb-10 rounded-full"></div>
        
        <p class="text-xl text-gray-700 leading-relaxed mb-8">
            <strong>EventTicket</strong> hadir sebagai solusi modern untuk pengelolaan dan pemesanan tiket acara. 
            Kami berkomitmen menghubungkan penyelenggara acara futsal, musik, hingga seminar dengan audiens yang tepat secara efisien.
        </p>

        <div class="grid md:grid-cols-3 gap-8 mt-12">
            <div class="p-6 border border-purple-100 rounded-2xl bg-purple-50">
                <i class="fa-solid fa-bolt text-4xl text-purplePrimary mb-4"></i>
                <h3 class="font-bold text-lg">Cepat & Mudah</h3>
                <p class="text-sm mt-2">Pemesanan tiket dalam hitungan detik.</p>
            </div>
            <div class="p-6 border border-purple-100 rounded-2xl bg-purple-50">
                <i class="fa-solid fa-shield-halved text-4xl text-purplePrimary mb-4"></i>
                <h3 class="font-bold text-lg">Terpercaya</h3>
                <p class="text-sm mt-2">Keamanan data peserta adalah prioritas.</p>
            </div>
            <div class="p-6 border border-purple-100 rounded-2xl bg-purple-50">
                <i class="fa-solid fa-users text-4xl text-purplePrimary mb-4"></i>
                <h3 class="font-bold text-lg">User-Centric</h3>
                <p class="text-sm mt-2">Didesain untuk kenyamanan pengguna.</p>
            </div>
        </div>
    </div>
</div>
@endsection