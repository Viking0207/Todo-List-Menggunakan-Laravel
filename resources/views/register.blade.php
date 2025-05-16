<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gradient-to-br from-green-100 to-blue-100 min-h-screen flex items-center justify-center font-poppins">
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-md w-full relative">

        <!-- Tombol Kembali -->
        <a href="{{ route('dashboard.index') }}"
            class="absolute top-4 left-4 text-teal-600 hover:text-teal-800 transition text-sm flex items-center space-x-1">
            <i class="fa-solid fa-circle-chevron-left text-lg"></i>
            <span>Kembali</span>
        </a>

        <!-- Judul -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center justify-center gap-2">
                <i class="fa-solid fa-user-plus text-teal-600"></i>
                Daftar Akun Baru
            </h1>
        </div>

        <!-- Error Message -->
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 rounded">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Form Register -->
        <form action="{{ route('register.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="nama" class="block font-semibold mb-1">Nama</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" name="nama" id="nama" required
                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-teal-400" />
                </div>
            </div>

            <div>
                <label for="email" class="block font-semibold mb-1">Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="email" name="email" id="email" required
                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-teal-400" />
                </div>
            </div>

            <div>
                <label for="password" class="block font-semibold mb-1">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" name="password" id="password" required
                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-teal-400" />
                </div>
            </div>

            <div>
                <label for="password_confirmation" class="block font-semibold mb-1">Konfirmasi Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-teal-400" />
                </div>
            </div>

            <button type="submit"
                class="w-full bg-teal-600 text-white py-2 rounded-lg hover:bg-teal-700 transition font-semibold flex justify-center items-center gap-2">
                <i class="fa-solid fa-user-check"></i>
                Daftar
            </button>
        </form>

        @auth
        <p class="mt-6 text-center text-green-600 font-semibold text-sm">
            Anda sudah login sebagai {{ Auth::user()->nama ?? Auth::user()->name }}.<br>
            <a href="{{ route('dashboard.index') }}" class="text-blue-600 hover:underline">Lihat Todo List Anda</a>
        </p>
        @else
        <p class="mt-6 text-center text-sm text-gray-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-teal-600 font-semibold hover:underline">
                Login di sini
            </a>
        </p>
        @endauth
    </div>
</body>
</html>
