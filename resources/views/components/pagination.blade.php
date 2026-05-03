{{-- resources/views/components/pagination.blade.php --}}
<div class="flex items-center justify-center gap-1 py-6 bg-white rounded-b-lg">
    {{-- Tombol Sebelumnya --}}
    <a href="#" class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-400 cursor-not-allowed">&lt; Sebelumnya</a>
    
    {{-- Halaman --}}
    <a href="#" class="px-4 py-2 bg-[#7a4988] text-white rounded-md text-sm font-bold shadow-md">1</a>
    <a href="#" class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-600 hover:bg-gray-100 transition-all">2</a>
    <a href="#" class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-600 hover:bg-gray-100 transition-all">3</a>
    <span class="px-2 text-gray-400">...</span>
    <a href="#" class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-600 hover:bg-gray-100 transition-all">7</a>
    
    {{-- Tombol Selanjutnya --}}
    <a href="#" class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-500 hover:bg-gray-100 transition-all">Selanjutnya &gt;</a>
</div>