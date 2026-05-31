<!-- ======================================================
FILE : resources/views/Pengunjung/detail-tiket.blade.php
FULL REVISI FINAL (FULL WIDTH LANDSCAPE)
====================================================== -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Tiket</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Poppins', sans-serif;

            background:
                linear-gradient(
                    135deg,
                    #2b1238,
                    #4b1d52,
                    #7a4988,
                    #9e7bb5
                );

            background-size:400% 400%;
            animation:swush 12s ease infinite;

            min-height:100vh;
            color:#111827;
        }

        @keyframes swush{

            0%{
                background-position:0% 50%;
            }

            50%{
                background-position:100% 50%;
            }

            100%{
                background-position:0% 50%;
            }

        }

        .main-card{
            background:white;
            width:100%;
            min-height:100vh;
        }

        .header-main{
            background:#24112e;
            border-bottom:4px solid #7a4988;
        }

        .menu-hover:hover{
            background:#f3f4f6;
            transition:0.3s;
        }

        .search-bg{
            background:#5e007d;
        }

    </style>

</head>

<body>

<!-- ======================================================
WRAPPER
====================================================== -->
<div class="w-full min-h-screen">

    <!-- ======================================================
    MAIN CARD
    ====================================================== -->
    <div class="main-card">

        <!-- ======================================================
        NAVBAR
        ====================================================== -->
        <nav class="bg-white border-b border-gray-200">

            <div class="w-full px-10 py-5 flex items-center justify-between">

                <!-- LOGO -->
                <div class="flex items-center gap-4">

                    <div class="w-16 h-16 rounded-2xl bg-purple-100 flex items-center justify-center text-3xl">
                        🎟️
                    </div>

                    <div>

                        <h1 class="font-bold text-2xl text-[#24112e] leading-none">
                            Event Ticket
                        </h1>

                        <p class="text-sm text-gray-500 mt-1">
                            EVENT & TICKETING
                        </p>

                    </div>

                </div>

                <!-- SEARCH -->
                <div class="flex items-center w-[500px]">

                    <input
                        type="text"
                        placeholder="Cari event..."
                        class="w-full border border-gray-300 px-5 py-4 rounded-l-2xl outline-none text-lg"
                    >

                    <button class="search-bg text-white px-10 py-4 rounded-r-2xl font-semibold text-lg">
                        Cari
                    </button>

                </div>

                <!-- MENU -->
                <div class="flex items-center gap-12 text-lg font-medium text-gray-900">

                    <a href="#">
                        Beranda
                    </a>

                    <a href="#">
                        Acara
                    </a>

                    <a href="#">
                        Tentang Kami
                    </a>

                </div>

            </div>

        </nav>

        <!-- ======================================================
        CONTENT
        ====================================================== -->
        <div class="flex min-h-[calc(100vh-100px)]">

            <!-- ======================================================
            SIDEBAR
            ====================================================== -->
            <aside class="w-[320px] bg-white border-r border-gray-200">

                <!-- PROFILE -->
                <div class="flex flex-col items-center py-12 border-b border-gray-200">

                    <img
                        src="https://i.pravatar.cc/200?img=32"
                        class="w-36 h-36 rounded-full object-cover shadow-xl"
                    >

                    <h2 class="font-bold text-3xl mt-6 text-gray-900">
                        Jesina Holy
                    </h2>

                    <p class="text-lg text-[#7a4988] mt-2">
                        Pengunjung
                    </p>

                </div>

                <!-- MENU -->
                <div class="py-6">

                    <a href="#" class="menu-hover flex items-center gap-4 px-10 py-5 text-gray-900 text-lg">
                        🏠 Beranda
                    </a>

                    <a href="#" class="flex items-center gap-4 px-10 py-5 bg-purple-100 text-[#5e007d] font-bold text-lg">
                        🎫 Tiket Saya
                    </a>

                    <a href="#" class="menu-hover flex items-center gap-4 px-10 py-5 text-gray-900 text-lg">
                        📝 Riwayat Pendaftaran
                    </a>

                    <a href="#" class="menu-hover flex items-center gap-4 px-10 py-5 text-gray-900 text-lg">
                        👤 Profil
                    </a>

                    <a href="#" class="menu-hover flex items-center gap-4 px-10 py-5 text-gray-900 text-lg">
                        🚪 Keluar
                    </a>

                </div>

            </aside>

            <!-- ======================================================
            MAIN CONTENT
            ====================================================== -->
            <main class="flex-1 bg-[#fafafa] overflow-x-hidden">

                <!-- HEADER -->
                <div class="header-main px-12 py-10">

                    <button class="text-white text-lg mb-7 hover:text-purple-300 transition">
                        ← Kembali ke Tiket Saya
                    </button>

                    <h1 class="text-6xl font-bold text-white">
                        Detail Tiket
                    </h1>

                    <p class="text-purple-300 mt-4 text-xl">
                        Informasi detail tiket event yang telah Anda beli
                    </p>

                </div>

                <!-- ======================================================
                BODY CONTENT
                ====================================================== -->
                <div class="p-8">

                    <!-- EVENT CARD -->
                    <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-7 flex gap-7">

                        <!-- IMAGE -->
                        <img
                            src="https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=1200&auto=format&fit=crop"
                            class="w-[300px] h-[210px] rounded-3xl object-cover"
                        >

                        <!-- INFO -->
                        <div class="flex-1">

                            <h2 class="text-4xl font-bold text-gray-900 leading-tight">
                                AI & MASA DEPAN KITA TECH FORUM 2024
                            </h2>

                            <div class="mt-8 space-y-5 text-gray-900 text-lg">

                                <div class="flex items-center gap-4">
                                    📅
                                    <span>
                                        Kamis, 29 Mei 2024 • 09.00 - 17.00 WIB
                                    </span>
                                </div>

                                <div class="flex items-center gap-4">
                                    📍
                                    <span>
                                        Gedung Utama <br>
                                        Jl. Teknologi No.1, Bandung
                                    </span>
                                </div>

                                <div class="flex items-center gap-4">
                                    🛒
                                    <span>
                                        Tanggal Pembelian : 20 Mei 2024
                                    </span>
                                </div>

                            </div>

                        </div>

                        <!-- STATUS -->
                        <div class="w-[300px] border-l border-gray-200 pl-7">

                            <h3 class="font-bold text-2xl text-gray-900">
                                Status Tiket
                            </h3>

                            <div class="inline-block bg-purple-100 text-[#5e007d] px-6 py-3 rounded-full text-lg font-bold mt-6">
                                Akan Datang
                            </div>

                            <p class="text-gray-500 text-base leading-relaxed mt-7">
                                Tiket ini belum digunakan.
                                Silakan tunjukkan kode unik tiket saat check-in.
                            </p>

                        </div>

                    </div>

                    <!-- DETAIL -->
                    <div class="grid grid-cols-2 gap-5 mt-5">

                        <!-- LEFT -->
                        <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-8">

                            <h2 class="text-3xl font-bold text-[#24112e] mb-8">
                                Informasi Tiket
                            </h2>

                            <div class="space-y-5 text-lg">

                                <div class="flex justify-between border-b pb-5">
                                    <span class="text-gray-500">Nama Pemesan</span>
                                    <span class="font-semibold text-gray-900">Jesina Holy</span>
                                </div>

                                <div class="flex justify-between border-b pb-5">
                                    <span class="text-gray-500">Email</span>
                                    <span class="font-semibold text-gray-900">jesina@gmail.com</span>
                                </div>

                                <div class="flex justify-between border-b pb-5">
                                    <span class="text-gray-500">No. Telepon</span>
                                    <span class="font-semibold text-gray-900">081234567890</span>
                                </div>

                                <div class="flex justify-between border-b pb-5">
                                    <span class="text-gray-500">Jenis Tiket</span>
                                    <span class="font-semibold text-gray-900">VIP</span>
                                </div>

                                <div class="flex justify-between border-b pb-5">
                                    <span class="text-gray-500">Jumlah Tiket</span>
                                    <span class="font-semibold text-gray-900">1</span>
                                </div>

                                <div class="flex justify-between border-b pb-5">
                                    <span class="text-gray-500">Harga Tiket</span>
                                    <span class="font-semibold text-gray-900">Rp 150.000</span>
                                </div>

                                <div class="flex justify-between border-b pb-5">
                                    <span class="text-gray-500">Biaya Layanan</span>
                                    <span class="font-semibold text-gray-900">Rp 5.000</span>
                                </div>

                                <div class="flex justify-between pt-4 text-2xl">

                                    <span class="font-bold text-gray-900">
                                        Total Pembayaran
                                    </span>

                                    <span class="font-bold text-[#5e007d]">
                                        Rp 155.000
                                    </span>

                                </div>

                            </div>

                        </div>

                        <!-- RIGHT -->
                        <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-8">

                            <h2 class="text-3xl font-bold text-[#24112e]">
                                Kode Unik Tiket
                            </h2>

                            <p class="text-gray-500 text-lg mt-5 text-center">
                                Tunjukkan kode unik ini kepada petugas saat check-in
                            </p>

                            <div class="border-2 border-dashed border-[#9e7bb5] rounded-3xl p-12 text-center mt-8">

                                <p class="text-gray-500 text-lg">
                                    Kode Unik
                                </p>

                                <h1 class="text-6xl font-bold text-[#5e007d] tracking-widest mt-5">
                                    EVT-290524-001
                                </h1>

                            </div>

                            <div class="bg-purple-100 rounded-3xl p-6 mt-8 flex gap-5">

                                <div class="text-3xl text-[#5e007d]">
                                    ℹ️
                                </div>

                                <p class="text-base text-gray-900 leading-relaxed">
                                    Simpan kode unik ini dengan baik.
                                    Kode unik hanya berlaku untuk 1 kali check-in.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </main>

        </div>

    </div>

</div>

</body>
</html>