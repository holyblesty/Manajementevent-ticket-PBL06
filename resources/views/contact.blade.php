@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-16">
    <h1 class="text-5xl font-black text-purplePrimary text-center mb-16 uppercase">Hubungi Kami</h1>
    
    <div class="max-w-2xl mx-auto bg-white p-10 rounded-3xl shadow-xl border border-gray-100">
        <div class="space-y-8">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-envelope text-2xl text-purplePrimary"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-400 uppercase text-xs">Email</h4>
                    <p class="text-xl font-bold">Jesinaaurora@gmail.com</p>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-phone text-2xl text-purplePrimary"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-400 uppercase text-xs">WhatsApp</h4>
                    <p class="text-xl font-bold">+62 895 3128 7505</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection