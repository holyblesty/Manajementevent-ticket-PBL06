<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Ticket - Riwayat Pendaftaran</title>
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

    <div class="max-w-7xl mx-auto px-6 py-8 flex">
        
        <aside class="w-1/4 pr-6">
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
                <a href="#" class="flex items-center space-x-3 px-4 py-3 bg-[#f3e8ff] text-[#4a046c] font-bold rounded-lg">
                    <i class="fa-solid fa-clock-rotate-left text-[#4a046c]"></i> <span>Riwayat Pendaftaran</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 hover:bg-purple-50 hover:text-purple-900 rounded-lg transition">
                    <i class="fa-solid fa-user text-gray-400"></i> <span>Profil</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 text-red-500 hover:bg-red-50 rounded-lg transition pt-8">
                    <i class="fa-solid fa-right-from-bracket"></i> <span>Keluar</span>
                </a>
            </nav>
        </aside>

        <main class="w-3/4 pl-6 border-l border-gray-100 min-h-[60vh]">
            <div class="mb-6">
                <h1 class="text-xl font-bold text-gray-900">Riwayat Pendaftaran</h1>
                <p class="text-xs text-gray-400 mt-1">Berikut adalah riwayat event yang telah Anda ikuti.</p>
            </div>

            <div class="space-y-4">
                @foreach($riwayat as $item)
                <div class="bg-white border border-gray-100 rounded-xl p-5 flex justify-between items-center shadow-sm hover:shadow-md transition">
                    
                    <div class="flex space-x-5 w-8/12">
                        <img src="{{ $item['banner'] }}" alt="Cover" class="w-28 h-28 object-cover rounded-lg shadow-inner bg-purple-50">
                        <div class="space-y-1.5 flex flex-col justify-center">
                            <h2 class="font-bold text-sm text-gray-900 tracking-tight uppercase leading-tight">{{ $item['nama_event'] }}</h2>
                            
                            <div class="text-[11px] text-gray-500 space-y-0.5">
                                <p class="flex items-center"><i class="fa-regular fa-calendar w-4 text-purple-600 shrink-0"></i> <span>{{ $item['hari_tanggal'] }} &nbsp;•&nbsp; {{ $item['jam'] }}</span></p>
                                <p class="flex items-center"><i class="fa-solid fa-location-dot w-4 text-purple-600 shrink-0"></i> <span>{{ $item['lokasi'] }}</span></p>
                            </div>
                            
                            <div class="text-[11px] pt-1">
                                <p class="text-gray-900 font-medium">Tiket: <span class="text-gray-400 font-normal">{{ $item['qty'] }} x {{ $item['jenis_tiket'] }}</span></p>
                                <p class="text-purple-800 font-bold mt-0.5">Kode Order: <span class="font-mono bg-purple-50 px-1 py-0.5 rounded text-[10px]">{{ $item['kode_order'] }}</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-end justify-between h-28 w-4/12 text-right">
                        <div>
                            <div class="flex items-center justify-end space-x-2">
                                <span class="text-[11px] text-gray-400">Status</span>
                                <span class="bg-[#f5f0fa] text-[#6b21a8] text-[10px] px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wide">{{ $item['status'] }}</span>
                            </div>
                            <div class="text-[10px] text-gray-400 mt-2 space-y-0.5">
                                <p class="flex items-center justify-end"><i class="fa-regular fa-calendar mr-1"></i> {{ $item['tanggal_beli'] }}</p>
                                <p class="flex items-center justify-end"><i class="fa-regular fa-clock mr-1"></i> {{ $item['jam_beli'] }}</p>
                            </div>
                        </div>

                        <div class="flex flex-col space-y-1 w-36">
                            <a href="#" class="text-center text-[11px] border border-purple-300 text-purple-800 py-1.5 rounded-md font-medium hover:bg-purple-50 transition">Lihat Detail</a>
                            <a href="#" class="text-center text-[11px] bg-[#500c6d] hover:bg-[#3d0852] text-white py-1.5 rounded-md font-medium flex items-center justify-center space-x-1 transition shadow-sm">
                                <i class="fa-solid fa-qrcode text-[10px]"></i> <span>Lihat E-Tiket</span>
                            </a>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-center items-center space-x-1 text-xs">
                <button class="p-2 border border-gray-200 rounded-md hover:bg-gray-50 text-gray-400"><i class="fa-solid fa-chevron-left text-[10px]"></i></button>
                <button class="px-3 py-1.5 bg-[#4a046c] text-white font-bold rounded-md">1</button>
                <button class="px-3 py-1.5 border border-gray-200 rounded-md text-gray-600 hover:bg-gray-50">2</button>
                <button class="p-2 border border-gray-200 rounded-md hover:bg-gray-50 text-gray-600"><i class="fa-solid fa-chevron-right text-[10px]"></i></button>
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