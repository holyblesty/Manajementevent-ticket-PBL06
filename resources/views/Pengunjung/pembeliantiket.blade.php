<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Ticket - Pembelian Tiket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#fcfbfe] font-sans text-gray-800 antialiased">

    <header class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-3.5 flex items-center justify-between">
            
            <div class="flex items-center">
                <a href="#" class="flex items-center">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Event Ticket Header" class="h-11 w-auto object-contain">
                </a>
            </div>
            
            <div class="flex w-5/12 mx-4">
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-gray-400 text-sm"></i>
                    </span>
                    <input type="text" placeholder="Cari event..." class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-l-md bg-gray-50 focus:outline-none focus:ring-1 focus:ring-purple-700 focus:bg-white transition">
                </div>
                <button class="bg-[#500c6d] hover:bg-[#3d0852] text-white text-sm px-6 py-2 rounded-r-md font-medium transition">Cari</button>
            </div>

            <nav class="flex space-x-7 text-sm font-medium text-gray-700">
                <a href="#" class="hover:text-purple-900 transition">Beranda</a>
                <a href="#" class="hover:text-purple-900 transition">Acara</a>
                <a href="#" class="hover:text-purple-900 transition">Tentang kami</a>
            </nav>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-6 py-6 flex">
        
        <aside class="w-1/4 pr-6 shrink-0">
            <div class="flex flex-col items-center text-center pb-6 border-b border-gray-100">
                <div class="w-20 h-20 rounded-full overflow-hidden ring-4 ring-purple-100 mb-3">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&q=80" alt="Avatar Jesina" class="w-full h-full object-cover">
                </div>
                <h3 class="font-bold text-gray-900 text-base">Jesina Holy</h3>
                <span class="text-xs text-purple-600 font-medium mt-1">Pengunjung</span>
            </div>

            <nav class="mt-6 space-y-1 text-sm font-medium text-gray-600">
                <a href="#" class="flex items-center space-x-3 px-4 py-3 hover:bg-purple-50 hover:text-purple-900 rounded-lg transition">
                    <i class="fa-solid fa-house text-gray-400"></i> <span>Beranda</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 hover:bg-purple-50 hover:text-purple-900 rounded-lg transition">
                    <i class="fa-solid fa-ticket text-gray-400"></i> <span>Tiket Saya</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 hover:bg-purple-50 hover:text-purple-900 rounded-lg transition">
                    <i class="fa-solid fa-clock-rotate-left text-gray-400"></i> <span>Riwayat Pendaftaran</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 hover:bg-purple-50 hover:text-purple-900 rounded-lg transition">
                    <i class="fa-solid fa-user text-gray-400"></i> <span>Profil</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 text-red-500 hover:bg-red-50 rounded-lg transition pt-8">
                    <i class="fa-solid fa-right-from-bracket"></i> <span>Keluar</span>
                </a>
            </nav>
        </aside>

        <main class="w-3/4 pl-6 border-l border-gray-100">
            <nav class="text-[11px] text-gray-400 mb-2 font-medium">
                <span class="hover:text-gray-600 cursor-pointer">Beranda</span> &nbsp;&gt;&nbsp; 
                <span class="hover:text-gray-600 cursor-pointer">Acara</span> &nbsp;&gt;&nbsp; 
                <span class="text-purple-900 font-semibold">Pembelian Tiket</span>
            </nav>

            <h1 class="text-xl font-bold text-[#310444] mb-5">Pembelian Tiket</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                
                <div class="lg:col-span-2 space-y-5">
                    
                    <div class="bg-white border border-gray-100 rounded-xl p-4 flex gap-4 shadow-sm">
                        <img src="{{ $event['banner'] }}" alt="Banner Event" class="w-44 h-44 object-cover rounded-lg shrink-0">
                        <div class="flex flex-col justify-center space-y-2">
                            <h2 class="font-bold text-sm text-gray-900 leading-snug tracking-tight">{{ $event['nama_event'] }}</h2>
                            <div class="text-[11px] text-gray-500 space-y-1">
                                <p class="flex items-center"><i class="fa-regular fa-calendar w-4 text-purple-600"></i> <span>{{ $event['hari_tanggal'] }} &nbsp;•&nbsp; {{ $event['jam'] }}</span></p>
                                <p class="flex items-center"><i class="fa-solid fa-location-dot w-4 text-purple-600"></i> <span>{{ $event['lokasi'] }}</span></p>
                            </div>
                            <p class="text-[11px] text-gray-400 leading-relaxed pt-1">{{ $event['deskripsi'] }}</p>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm space-y-4">
                        <h3 class="font-bold text-xs text-purple-900 uppercase tracking-wider">Informasi Pembeli</h3>
                        <div class="grid grid-cols-1 gap-3 text-xs">
                            <div>
                                <label class="block text-gray-500 mb-1">Nama Lengkap</label>
                                <input type="text" value="Jesina Holy" class="w-full p-2 border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:ring-1 focus:ring-purple-600">
                            </div>
                            <div>
                                <label class="block text-gray-500 mb-1">No. HP</label>
                                <input type="text" value="08124567890" class="w-full p-2 border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:ring-1 focus:ring-purple-600">
                            </div>
                            <div>
                                <label class="block text-gray-500 mb-1">Email</label>
                                <input type="email" value="jesina@mail.com" class="w-full p-2 border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:ring-1 focus:ring-purple-600">
                            </div>
                            <div>
                                <label class="block text-gray-500 mb-1">Alamat</label>
                                <textarea rows="2" class="w-full p-2 border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:ring-1 focus:ring-purple-600">Jl. Malaka No. 12, Bandung, Jawa Barat</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm space-y-4">
                        <h3 class="font-bold text-xs text-purple-900 uppercase tracking-wider">Pilihan Tiket</h3>
                        
                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <label class="border border-gray-200 rounded-xl p-3 flex flex-col justify-between cursor-pointer hover:bg-purple-50/50 transition">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="font-bold text-gray-900">Early Bird</p>
                                        <p class="text-purple-700 font-bold mt-0.5">Rp 30.000</p>
                                    </div>
                                    <input type="radio" name="ticket_type" class="text-purple-700 focus:ring-purple-500">
                                </div>
                                <span class="text-[10px] text-gray-400 mt-3 block">Sisa 10</span>
                            </label>

                            <label class="border border-gray-200 rounded-xl p-3 flex flex-col justify-between cursor-pointer hover:bg-purple-50/50 transition">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="font-bold text-gray-900">Normal</p>
                                        <p class="text-purple-700 font-bold mt-0.5">Rp 50.000</p>
                                    </div>
                                    <input type="radio" name="ticket_type" class="text-purple-700 focus:ring-purple-500">
                                </div>
                                <span class="text-[10px] text-gray-400 mt-3 block">Sisa 32</span>
                            </label>

                            <label class="border-2 border-purple-700 bg-purple-50/30 rounded-xl p-3 col-span-2 flex flex-col justify-between cursor-pointer transition">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="font-bold text-gray-900">VIP</p>
                                        <p class="text-purple-700 font-bold mt-0.5">Rp 150.000</p>
                                        <ul class="text-[10px] text-gray-500 mt-2 space-y-1 list-none">
                                            <li><i class="fa-solid fa-check text-green-600 mr-1.5"></i> Akses area khusus</li>
                                            <li><i class="fa-solid fa-check text-green-600 mr-1.5"></i> Tempat duduk prioritas</li>
                                            <li><i class="fa-solid fa-check text-green-600 mr-1.5"></i> Merchandise eksklusif</li>
                                        </ul>
                                    </div>
                                    <input type="radio" name="ticket_type" checked class="text-purple-700 focus:ring-purple-500 h-4 w-4">
                                </div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                            <span class="text-xs font-bold text-gray-800">Jumlah Tiket</span>
                            <div class="flex items-center border border-gray-200 rounded-md bg-gray-50 text-xs overflow-hidden">
                                <button type="button" class="px-2.5 py-1.5 bg-white hover:bg-gray-100 text-gray-500 font-bold border-r border-gray-200">-</button>
                                <span class="px-4 font-semibold text-gray-800">1</span>
                                <button type="button" class="px-2.5 py-1.5 bg-white hover:bg-gray-100 text-gray-500 font-bold border-l border-gray-200">+</button>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="space-y-5">
                    
                    <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm space-y-4">
                        <h3 class="font-bold text-xs text-purple-900 uppercase tracking-wider">Pilih Metode Pembayaran</h3>
                        <div class="space-y-3.5 text-xs font-medium text-gray-700">
                            
                            <label class="flex items-start justify-between cursor-pointer">
                                <div class="flex items-center space-x-2">
                                    <input type="radio" name="payment" checked class="text-purple-700 focus:ring-purple-500">
                                    <span>Transfer Bank</span>
                                </div>
                                <div class="flex gap-1 text-[9px] font-bold text-gray-400">
                                    <span class="border border-gray-200 px-1 py-0.5 rounded bg-gray-50">BCA</span>
                                    <span class="border border-gray-200 px-1 py-0.5 rounded bg-gray-50">Mandiri</span>
                                </div>
                            </label>

                            <label class="flex items-start justify-between cursor-pointer">
                                <div class="flex items-center space-x-2">
                                    <input type="radio" name="payment" class="text-purple-700 focus:ring-purple-500">
                                    <span>Virtual Account</span>
                                </div>
                                <div class="flex gap-1 text-[9px] font-bold text-gray-400">
                                    <span class="border border-gray-200 px-1 py-0.5 rounded bg-gray-50">BNI</span>
                                    <span class="border border-gray-200 px-1 py-0.5 rounded bg-gray-50">BRI</span>
                                </div>
                            </label>

                            <label class="flex items-start justify-between cursor-pointer">
                                <div class="flex items-center space-x-2">
                                    <input type="radio" name="payment" class="text-purple-700 focus:ring-purple-500">
                                    <span>E-Wallet</span>
                                </div>
                                <div class="flex gap-1 text-[9px] font-bold text-gray-400">
                                    <span class="border border-gray-200 px-1 py-0.5 rounded bg-gray-50">GoPay</span>
                                    <span class="border border-gray-200 px-1 py-0.5 rounded bg-gray-50">OVO</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm space-y-4">
                        <h3 class="font-bold text-xs text-purple-900 uppercase tracking-wider">Ringkasan Pesanan</h3>
                        
                        <div class="text-xs space-y-2 border-b border-gray-100 pb-3">
                            <div class="flex justify-between text-gray-500">
                                <span>Tiket VIP x1</span>
                                <span class="font-semibold text-gray-800">Rp 150.000</span>
                            </div>
                            <div class="flex justify-between text-gray-500">
                                <span>Biaya layanan</span>
                                <span class="font-semibold text-gray-800">Rp 5.000</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center text-xs pt-1">
                            <span class="font-bold text-gray-800">Total</span>
                            <span class="text-base font-extrabold text-purple-900">Rp 155.000</span>
                        </div>

                        <div class="space-y-2 pt-2">
                            <button class="w-full bg-[#4a046c] hover:bg-[#360250] text-white text-xs py-2.5 rounded-lg font-bold transition shadow-sm">Bayar Sekarang</button>
                            <button class="w-full border border-gray-300 hover:bg-gray-50 text-gray-600 text-xs py-2.5 rounded-lg font-semibold transition">Batal</button>
                        </div>
                    </div>

                </div>

            </div>
        </main>
    </div>

    <footer class="bg-[#201132] text-gray-300 pt-10 pb-4 text-xs mt-12">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8 border-b border-[#2d1a45] pb-8">
            
            <div class="space-y-3">
                <img src="{{ asset('images/footer.jpg') }}" alt="Logo Event Ticket Footer" class="h-12 w-auto object-contain">
                <p class="text-gray-400 leading-relaxed text-[11px]">EventTicketing adalah platform untuk menemukan dan memesan tiket event terbaik dengan mudah dan cepat.</p>
            </div>
            
            <div>
                <h4 class="font-bold text-white mb-3 text-[11px] tracking-wider uppercase">Navigasi</h4>
                <ul class="space-y-2 text-gray-400 text-[11px]">
                    <li><a href="#" class="hover:text-white transition">Beranda</a></li>
                    <li><a href="#" class="hover:text-white transition">Acara</a></li>
                    <li><a href="#" class="hover:text-white transition">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-white transition">Kontak Kami</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-white mb-3 text-[11px] tracking-wider uppercase">Kategori</h4>
                <ul class="space-y-2 text-gray-400 text-[11px]">
                    <li><a href="#" class="hover:text-white transition">Hiburan</a></li>
                    <li><a href="#" class="hover:text-white transition">Olahraga</a></li>
                    <li><a href="#" class="hover:text-white transition">Seminar</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-white mb-3 text-[11px] tracking-wider uppercase">Hubungi Kami</h4>
                <ul class="space-y-2 text-gray-400 text-[11px]">
                    <li class="flex items-center"><i class="fa-regular fa-envelope w-5 text-gray-500"></i> Jesinaaa@appmail.com</li>
                    <li class="flex items-center"><i class="fa-solid fa-phone w-5 text-gray-500"></i> +62 896 3128 7605</li>
                </ul>
            </div>
        </div>
        <div class="text-center mt-4 text-[10px] text-gray-500">
            © 2026 Event Ticketing System. All Rights Reserved
        </div>
    </footer>

</body>
</html>