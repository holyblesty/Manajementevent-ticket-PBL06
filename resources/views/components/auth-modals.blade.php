  <div id="loginModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-sm">
        <div class="bg-white w-[90%] sm:w-[420px] p-8 rounded-xl shadow-2xl relative transition-all duration-300 border border-gray-100">
            <button onclick="closeModal('loginModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer">&times;</button>
            
            <h3 class="text-2xl font-bold text-center text-gray-800 uppercase tracking-wide mb-4">Masuk Ke Akun</h3>
            
            @if($errors->has('username') && !old('email'))
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-xs font-semibold">
                    {{ $errors->first('username') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Nama Akun / Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" 
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none 
                    focus:border-purplePrimary text-sm" placeholder="Isi nama akun anda" required>
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Kata Sandi</label>
                    <input type="password" name="password" class="w-full px-4 py-2.5 border 
                    border-gray-200 rounded-lg focus:outline-none focus:border-purplePrimary text-sm" 
                    placeholder="Isi kata sandi anda" required>
                </div>
                
                <button type="submit" class="w-full py-2.5 bg-purpleAccent hover:bg-purplePrimary 
                text-white font-medium rounded-lg transition shadow-md shadow-purpleAccent/20 cursor-pointer text-sm">
                    Masuk
                </button>
            </form>
            
            <p class="text-center text-sm text-gray-500 mt-5">
                Belum punya akun? <a href="javascript:void(0)" 
                onclick="switchModal('loginModal', 'registerModal')" class="text-purplePrimary font-semibold 
                hover:underline">Registrasi disini!</a>
            </p>
        </div>
    </div>

    <div id="registerModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-sm">
        <div class="bg-white w-[90%] sm:w-[440px] p-7 rounded-xl shadow-2xl relative max-h-[92vh] overflow-y-auto no-scrollbar border border-gray-100">
            <button onclick="closeModal('registerModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer">&times;</button>
            
            <h3 class="text-2xl font-bold text-center text-gray-800 uppercase tracking-wide mb-4">DAFTAR AKUN</h3>
            
            @if($errors->any() && (old('email') || old('name')))
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-xs space-y-1 font-semibold">
                    @foreach($errors->all() as $error)
                        <p><i class="fa-solid fa-circle-exclamation me-1"></i> {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                    class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg 
                    focus:outline-none focus:border-purplePrimary" placeholder="Isi nama lengkap anda" required>
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Buat Nama Akun (Username)</label>
                    <input type="text" name="username" value="{{ old('username') }}" 
                    class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg 
                    focus:outline-none focus:border-purplePrimary" placeholder="Isi nama akun anda" required>
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                    class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg 
                    focus:outline-none focus:border-purplePrimary" placeholder="Isi email aktif anda" required>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-gray-700 text-xs font-semibold mb-1">Kata Sandi</label>
                        <input type="password" name="password" class="w-full px-3.5 py-2 text-sm 
                        border border-gray-200 rounded-lg focus:outline-none focus:border-purplePrimary" 
                        placeholder="Minimal 6 karakter" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-xs font-semibold mb-1">Ulangi Sandi</label>
                        <input type="password" name="password_confirmation" class="w-full 
                        px-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none 
                        focus:border-purplePrimary" placeholder="Konfirmasi sandi" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700 text-xs font-semibold mb-1">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" 
                    class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg 
                    focus:outline-none focus:border-purplePrimary" placeholder="Isi nomor ponsel aktif">
                </div>

                <div class="mb-5">
                    <label class="block text-gray-700 text-xs font-semibold mb-1">Alamat Rumah</label>
                    <textarea name="alamat" rows="2" class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-purplePrimary" placeholder="Isi alamat rumah anda">{{ old('alamat') }}</textarea>
                </div>
                
                <div class="text-center">
                    <button type="submit" class="w-full py-2.5 bg-purpleAccent hover:bg-purplePrimary text-white font-medium rounded-lg transition shadow-md shadow-purpleAccent/20 text-sm cursor-pointer">
                        Buat Akun Baru
                    </button>
                </div>
            </form>
            
            <p class="text-center text-xs text-gray-500 mt-4">
                Sudah punya akun? 
                <a href="javascript:void(0)" onclick="switchModal('registerModal', 'loginModal')" 
                class="text-purplePrimary font-semibold hover:underline">Masuk disini!</a>
            </p>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function switchModal(modalToClose, modalToOpen) {
            closeModal(modalToClose);
            openModal(modalToOpen);
        }

        window.onclick = function(event) {
            if (event.target.id === 'loginModal') closeModal('loginModal');
            if (event.target.id === 'registerModal') closeModal('registerModal');
        }

        document.addEventListener("DOMContentLoaded", function() {
            @if($errors->any())
                @if(old('email') || old('name'))
                    openModal('registerModal');
                @else
                    openModal('loginModal');
                @endif
            @endif
        });
    </script>
