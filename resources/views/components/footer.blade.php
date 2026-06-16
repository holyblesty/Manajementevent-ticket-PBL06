<footer class="bg-[#1E0F30] w-full pt-16 pb-8 px-6 mt-20">
    <div class="max-w-[1400px] mx-auto grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
        
        {{-- Kolom 1: Identitas --}}
        <div class="col-span-1">
            <div class="flex items-center gap-3 mb-">
                <img src="{{ asset('images/footer.jpg') }}" class="h-24 w-24 object-contain rounded-xl p-1">
                <span class="text-xl font-black text-white tracking-tighter">EVENT<span class="text-[#be93d4]">TICKET</span></span>
            </div>
            <p class="text-sm text-gray-400 leading-relaxed">
                Platform sistem informasi manajemen event terpadu untuk memudahkan pengelolaan dan pemesanan tiket secara efisien.
            </p>
        </div>

        {{-- Kolom 2: Legal & Informasi --}}
        <div>
            <h4 class="text-xs font-bold text-white uppercase tracking-[0.2em] mb-6 opacity-60">Informasi</h4>
            <ul class="text-sm space-y-4 text-gray-400">
                <li><a href="#" class="hover:text-[#be93d4] transition-colors">Syarat & Ketentuan</a></li>
                <li><a href="#" class="hover:text-[#be93d4] transition-colors">Kebijakan Privasi</a></li>
                <li><a href="#" class="hover:text-[#be93d4] transition-colors">FAQ</a></li>
            </ul>
        </div>

        {{-- Kolom 3: Dukungan --}}
        <div>
            <h4 class="text-xs font-bold text-white uppercase tracking-[0.2em] mb-6 opacity-60">Dukungan</h4>
            <ul class="text-sm space-y-4 text-gray-400">
                <li class="flex items-center gap-3"><i class="fa-solid fa-envelope"></i> Jesinaaurora@gmail.com</li>
                <li class="flex items-center gap-3"><i class="fa-brands fa-whatsapp"></i> +62 895 3128 7505</li>
                <li class="flex items-center gap-3"><i class="fa-solid fa-clock"></i> 09:00 - 17:00 WIB</li>
            </ul>
        </div>

        {{-- Kolom 4: Developer Info --}}
        <div>
            <h4 class="text-xs font-bold text-white uppercase tracking-[0.2em] mb-6 opacity-60">Dikembangkan Oleh</h4>
            <div class="bg-white/5 p-4 rounded-xl border border-white/10">
                <p class="text-xs text-gray-300 font-bold mb-1">Tim 06 IF 2A Malam Project Based Learning</p>
                <p class="text-[11px] text-gray-500 uppercase">Politeknik Negeri Batam</p>
            </div>
            <div class="flex gap-4 mt-6 text-white text-xl">
                <a href="#" class="hover:text-[#be93d4]"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="hover:text-[#be93d4]"><i class="fa-brands fa-linkedin"></i></a>
            </div>
        </div>
    </div>

    {{-- Copyright --}}
    <div class="max-w-[1400px] mx-auto border-t border-white/10 pt-8 text-center">
        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-[0.3em]">
            © 2026 EVENT TICKET MANAGEMENT SYSTEM. ALL RIGHTS RESERVED.
        </p>
    </div>
</footer>