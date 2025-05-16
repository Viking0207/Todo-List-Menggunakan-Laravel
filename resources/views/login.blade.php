<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome CDN -->
    <script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script> <!-- Ganti yourkitid dengan ID kamu -->
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
                <i class="fa-solid fa-right-to-bracket text-teal-600"></i>
                Masuk ke Akun
            </h1>
        </div>

        <!-- Pesan Error -->
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 rounded">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Form -->
        <form action="{{ route('login.do') }}" method="POST" class="space-y-4">
            @csrf
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

            <button type="submit"
                class="w-full bg-teal-600 text-white py-2 rounded-lg hover:bg-teal-700 transition font-semibold flex justify-center items-center gap-2">
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                Masuk
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            Belum punya akun?
            <a href="{{ route('register.form') }}" class="text-teal-600 font-semibold hover:underline">
                Daftar di sini
            </a>
        </p>
    </div>
</body>

</html>
