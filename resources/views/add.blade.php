<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Tambah Aktivitas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome (jika belum dimasukkan di app.js) -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100 font-poppins min-h-screen flex flex-col">

    <!-- Header -->
    <header class="text-center mt-10 mb-6">
        <h1 class="text-5xl font-extrabold text-lime-700 relative inline-block">
            <i class="fas fa-list-check mr-3 text-lime-500 animate-bounce"></i>
            To Do List
            <span
                class="absolute -top-2 -right-10 text-xs text-white bg-red-500 px-2 py-0.5 rounded-full animate-pulse shadow-lg">
                💪 Focus!
            </span>
        </h1>
    </header>

    <!-- Form Container -->
    <main class="w-full max-w-lg mx-auto bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition mb-20">

        <h2 class="text-3xl font-bold text-center text-emerald-600 mb-8">✍️ Tambah Aktivitas</h2>

        @if (session('success'))
            <div class="bg-green-500 text-white text-sm p-3 rounded-md mb-4 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('add.simpan') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Judul -->
            <div>
                <label class="block mb-1 font-semibold text-gray-700">📝 Judul</label>
                <input type="text" name="title" required placeholder="Masukkan Judul"
                    class="w-full p-2 border border-gray-300 rounded-md shadow-inner focus:outline-none focus:ring-2 focus:ring-emerald-400">
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block mb-1 font-semibold text-gray-700">📄 Deskripsi</label>
                <textarea name="description" required placeholder="Masukkan Deskripsi"
                    class="w-full p-2 border border-gray-300 rounded-md shadow-inner resize-y focus:outline-none focus:ring-2 focus:ring-emerald-400 min-h-[80px]"></textarea>
            </div>

            <!-- Status -->
            <div>
                <label class="block mb-1 font-semibold text-gray-700">📌 Status</label>
                <select name="status" required
                    class="w-full p-2 border border-gray-300 rounded-md shadow-inner focus:outline-none focus:ring-2 focus:ring-emerald-400">
                    <option value="Pending" selected>🕒 Pending</option>
                    <option value="In Progress">⚙️ In Progress</option>
                    <option value="Done" disabled>✅ Done (Terkunci)</option>
                </select>
            </div>

            <!-- Prioritas -->
            <div>
                <label class="block mb-1 font-semibold text-gray-700">🔥 Prioritas</label>
                <select name="priority" required
                    class="w-full p-2 border border-gray-300 rounded-md shadow-inner focus:outline-none focus:ring-2 focus:ring-emerald-400">
                    <option disabled selected>Pilih Prioritas</option>
                    <option value="Low">🟢 Low</option>
                    <option value="Medium">🟡 Medium</option>
                    <option value="High">🔴 High</option>
                </select>
            </div>

            <!-- Tanggal -->
            <div>
                <label class="block mb-1 font-semibold text-gray-700">📅 Tanggal</label>
                <input type="date" name="date" required
                    class="w-full p-2 border border-gray-300 rounded-md shadow-inner focus:outline-none focus:ring-2 focus:ring-emerald-400"
                    min="{{ now()->format('Y-m-d') }}"
                    value="{{ now()->format('Y-m-d') }}"
                    onkeydown="return false">
            </div>

            <!-- Tombol -->
            <div class="flex gap-4 pt-4">
                <button type="submit"
                    class="w-full bg-emerald-500 hover:bg-emerald-700 text-white font-semibold py-2 rounded-md shadow-md transition">
                    ✅ Simpan
                </button>
                <button type="button" onclick="window.location.href='{{ route('home.index') }}'"
                    class="w-full bg-red-400 hover:bg-red-600 text-white font-semibold py-2 rounded-md shadow-md transition">
                    ❌ Keluar
                </button>
            </div>
        </form>
    </main>

</body>

</html>
