<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="nama" class="block text-gray-700">Nama</label>
                <input type="text" name="nama" id="nama" class="w-full p-2 border border-gray-300 rounded" value="{{ old('nama') }}">
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="w-full p-2 border border-gray-300 rounded" value="{{ old('email') }}">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="pass" class="block text-gray-700">Password</label>
                <input type="password" name="pass" id="pass" class="w-full p-2 border border-gray-300 rounded">
                @error('pass')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="pass_confirmation" class="block text-gray-700">Konfirmasi Password</label>
                <input type="password" name="pass_confirmation" id="pass_confirmation" class="w-full p-2 border border-gray-300 rounded">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
                Register
            </button>

            <div class="mt-4 text-center">
                <a href="{{ route('login.form') }}" class="text-blue-600 text-sm">Sudah punya akun? Login</a>
            </div>
        </form>
    </div>
</body>
</html>
