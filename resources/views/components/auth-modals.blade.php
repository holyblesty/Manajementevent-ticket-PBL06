<!-- LOGIN MODAL -->
<div id="loginModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-sm">
    <div class="bg-white w-[90%] sm:w-[420px] p-8 rounded-xl shadow-2xl relative transition-all duration-300 border border-gray-100">

        <button onclick="closeModal('loginModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer">
            &times;
        </button>

        <h3 class="text-2xl font-bold text-center text-gray-800 uppercase tracking-wide mb-4">
            Masuk Ke Akun
        </h3>

        @if($errors->has('username') && !old('email'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-xs font-semibold">
                {{ $errors->first('username') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">
                    Nama Akun / Username
                </label>

                <input
                    type="text"
                    name="username"
                    value="{{ old('username') }}"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purplePrimary text-sm"
                    placeholder="Isi nama akun anda"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-semibold mb-2">
                    Kata Sandi
                </label>

                <div class="relative">
                    <input
                        id="loginPass"
                        type="password"
                        name="password"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purplePrimary text-sm"
                        placeholder="Isi kata sandi anda"
                        required
                    >

                    <button
                        type="button"
                        onclick="togglePassword('loginPass', this)"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-purplePrimary"
                    >
                        SHOW
                    </button>
                </div>
            </div>

            <div class="mb-5 text-right">
                <a
                    href="javascript:void(0)"
                    onclick="switchModal('loginModal','forgotModal')"
                    class="text-xs text-purplePrimary hover:underline font-semibold"
                >
                    Lupa Password?
                </a>
            </div>

            <button
                type="submit"
                class="w-full py-2.5 bg-purpleAccent hover:bg-purplePrimary text-white font-medium rounded-lg transition shadow-md shadow-purpleAccent/20 cursor-pointer text-sm"
            >
                Masuk
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-5">
            Belum punya akun?
            <a
                href="javascript:void(0)"
                onclick="switchModal('loginModal','registerModal')"
                class="text-purplePrimary font-semibold hover:underline"
            >
                Registrasi disini!
            </a>
        </p>

    </div>
</div>

<!-- REGISTER MODAL -->
<div id="registerModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-sm">

    <div class="bg-white w-[90%] sm:w-[440px] p-7 rounded-xl shadow-2xl relative max-h-[92vh] overflow-y-auto no-scrollbar border border-gray-100">

        <button onclick="closeModal('registerModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer">
            &times;
        </button>

        <h3 class="text-2xl font-bold text-center text-gray-800 uppercase tracking-wide mb-4">
            DAFTAR AKUN
        </h3>

        @if($errors->any() && (old('email') || old('name')))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-xs space-y-1 font-semibold">
                @foreach($errors->all() as $error)
                    <p>
                        <i class="fa-solid fa-circle-exclamation me-1"></i>
                        {{ $error }}
                    </p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="block text-gray-700 text-xs font-semibold mb-1">
                    Nama Lengkap
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-purplePrimary"
                    placeholder="Isi nama lengkap anda"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="block text-gray-700 text-xs font-semibold mb-1">
                    Buat Nama Akun (Username)
                </label>

                <input
                    type="text"
                    name="username"
                    value="{{ old('username') }}"
                    class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-purplePrimary"
                    placeholder="Isi nama akun anda"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="block text-gray-700 text-xs font-semibold mb-1">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-purplePrimary"
                    placeholder="Isi email aktif anda"
                    required
                >
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">

                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">
                        Kata Sandi
                    </label>

                    <div class="relative">
                        <input
                            id="regPass"
                            type="password"
                            name="password"
                            class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-purplePrimary"
                            placeholder="Minimal 6 karakter"
                            required
                        >

                        <button
                            type="button"
                            onclick="togglePassword('regPass', this)"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-[10px] font-bold text-purplePrimary"
                        >
                            SHOW
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-semibold mb-1">
                        Ulangi Sandi
                    </label>

                    <div class="relative">
                        <input
                            id="regConfirmPass"
                            type="password"
                            name="password_confirmation"
                            class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-purplePrimary"
                            placeholder="Konfirmasi sandi"
                            required
                        >

                        <button
                            type="button"
                            onclick="togglePassword('regConfirmPass', this)"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-[10px] font-bold text-purplePrimary"
                        >
                            SHOW
                        </button>
                    </div>
                </div>

            </div>

            <div class="mb-3">
                <label class="block text-gray-700 text-xs font-semibold mb-1">
                    No. HP
                </label>

                <input
                    type="text"
                    name="no_hp"
                    value="{{ old('no_hp') }}"
                    class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-purplePrimary"
                    placeholder="Isi nomor ponsel aktif"
                >
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 text-xs font-semibold mb-1">
                    Alamat Rumah
                </label>

                <textarea
                    name="alamat"
                    rows="2"
                    class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-purplePrimary"
                    placeholder="Isi alamat rumah anda"
                >{{ old('alamat') }}</textarea>
            </div>

            <button
                type="submit"
                class="w-full py-2.5 bg-purpleAccent hover:bg-purplePrimary text-white font-medium rounded-lg transition shadow-md shadow-purpleAccent/20 text-sm cursor-pointer"
            >
                Buat Akun Baru
            </button>

        </form>

        <p class="text-center text-xs text-gray-500 mt-4">
            Sudah punya akun?

            <a
                href="javascript:void(0)"
                onclick="switchModal('registerModal','loginModal')"
                class="text-purplePrimary font-semibold hover:underline"
            >
                Masuk disini!
            </a>
        </p>

    </div>
</div>

<!-- FORGOT PASSWORD MODAL -->
<div id="forgotModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-sm">

    <div class="bg-white w-[90%] sm:w-[400px] p-8 rounded-xl shadow-2xl relative border border-gray-100">

        <button onclick="closeModal('forgotModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer">
            &times;
        </button>

        <h3 class="text-xl font-bold text-center text-gray-800 mb-4">
            Lupa Password?
        </h3>

        <form action="{{ route('password.email') }}" method="POST">
            @csrf

            <div class="mb-4">
                <input
                    type="email"
                    name="email"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm"
                    placeholder="Email terdaftar"
                    required
                >
            </div>

            <button
                type="submit"
                class="w-full py-2.5 bg-purpleAccent hover:bg-purplePrimary text-white rounded-lg text-sm cursor-pointer"
            >
                Kirim Link Reset
            </button>
        </form>

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

    function togglePassword(id, button) {
        const input = document.getElementById(id);

        if (input.type === 'password') {
            input.type = 'text';
            button.innerText = 'HIDE';
        } else {
            input.type = 'password';
            button.innerText = 'SHOW';
        }
    }

    window.onclick = function(event) {
        if (event.target.id === 'loginModal')
            closeModal('loginModal');

        if (event.target.id === 'registerModal')
            closeModal('registerModal');

        if (event.target.id === 'forgotModal')
            closeModal('forgotModal');
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