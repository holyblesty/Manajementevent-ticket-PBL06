<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami - EventTicket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        purplePrimary: '#7a4988',
                        purpleAccent: '#9e7bb5',
                        purpleDark: '#24112e',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#fdf2f8] font-sans overflow-x-hidden">

    {{-- Decorative Background Circles --}}
    <div class="fixed top-[-100px] right-[-100px] w-96 h-96 bg-purpleAccent rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>

    <div class="relative container mx-auto px-6 py-16">
        
        <a href="{{ url('/') }}" class="inline-flex items-center text-purplePrimary font-black hover:scale-110 transition-transform">
            <i class="fa-solid fa-arrow-left mr-2"></i> KEMBALI
        </a>

        <div class="text-center mt-10 mb-16">
            <h1 class="text-6xl font-black text-purpleDark uppercase italic rotate-[-1deg] mb-4">
                SAPA <span class="text-purplePrimary">KAMI!</span>
            </h1>
            <p class="text-xl font-bold text-gray-700">Ada pertanyaan? Jangan ragu, kami siap membantu!</p>
        </div>

        <div class="grid md:grid-cols-2 gap-12 max-w-5xl mx-auto items-start">
            
            {{-- Info Kontak Card --}}
            <div class="bg-purplePrimary p-10 rounded-[2rem] text-white shadow-[8px_8px_0px_rgba(36,17,46,0.3)] transform hover:rotate-[-2deg] transition-all">
                <h2 class="text-3xl font-black mb-8 uppercase">Let's Connect</h2>
                <div class="space-y-8">
                    <div class="flex items-center gap-5">
                        <div class="bg-white/20 p-4 rounded-2xl"><i class="fa-solid fa-envelope text-2xl"></i></div>
                        <div>
                            <p class="text-xs uppercase font-bold opacity-70">Email Kami</p>
                            <p class="text-xl font-black">Jesinaaurora@gmail.com</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-5">
                        <div class="bg-white/20 p-4 rounded-2xl"><i class="fa-brands fa-whatsapp text-2xl"></i></div>
                        <div>
                            <p class="text-xs uppercase font-bold opacity-70">WhatsApp</p>
                            <p class="text-xl font-black">+62 895 3128 7505</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="bg-white p-10 rounded-[2rem] shadow-[8px_8px_0px_rgba(122,73,136,0.2)] border-2 border-purplePrimary transform hover:rotate-[1deg] transition-all">
                <form action="https://formspree.io/f/xkoaejer" method="POST" class="space-y-5">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Nama Lengkap</label>
                        <input type="text" name="nama" class="w-full px-5 py-3 rounded-2xl border-2 border-gray-200 focus:border-purplePrimary outline-none transition" placeholder="Siapa namamu?" required>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Email</label>
                        <input type="email" name="email" class="w-full px-5 py-3 rounded-2xl border-2 border-gray-200 focus:border-purplePrimary outline-none transition" placeholder="Email untuk balasan" required>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Pesan</label>
                        <textarea name="message" rows="4" class="w-full px-5 py-3 rounded-2xl border-2 border-gray-200 focus:border-purplePrimary outline-none transition" placeholder="Tulis sesuatu..." required></textarea>
                    </div>
                    <button type="submit" class="w-full bg-purpleDark hover:bg-purplePrimary text-white font-black py-4 rounded-2xl transition-all shadow-lg uppercase tracking-widest text-sm hover:scale-[1.02]">
                        Kirim Pesan!
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>