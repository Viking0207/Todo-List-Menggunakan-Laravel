<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Todo List Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-pVUQsi+QpI2kzjYtCfjPReh+Udbv6ItOp+PtTzPeEaAgq5TX7RT3YnKRvpuYScOKnp51Ic65p4GzX2JbqJ5X0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-100 min-h-screen font-poppins">

    <nav class="bg-white shadow flex items-center justify-between px-6 py-3 sticky top-0 z-30">
        <a href="{{ route('dashboard.index') }}" class="flex items-center space-x-2 text-blue-600 font-bold text-xl">
            <i class="fa-solid fa-list-check"></i>
            <span>TodoVick</span>
        </a>

        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="GET" action="{{ route('dashboard.index') }}" class="flex-grow max-w-xl mx-6">
            <input type="text" name="q" placeholder="Cari judul atau deskripsi..."
                class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </form>

        <div class="flex items-center space-x-4">
            @guest
                <a href="{{ route('register.form') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded">Register</a>
                <a href="{{ route('login') }}" class="bg-lime-600 hover:bg-lime-700 text-white px-4 py-2 rounded">Login</a>
            @endguest

            @auth
                <span class="text-gray-700 font-semibold flex items-center space-x-2">
                    <i class="fa-solid fa-user"></i>
                    <span>{{ Auth::user()->nama ?? Auth::user()->name }}</span>
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded flex items-center space-x-1 font-semibold">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>
            @endauth
        </div>
    </nav>

    <main class="p-4 space-y-4 max-w-4xl mx-auto mt-6">
        @auth
            @forelse ($todos as $data)
                <div onclick="openModal(`{{ $data->title }}`, `{{ $data->description }}`)"
                    class="bg-white p-4 rounded shadow cursor-pointer hover:bg-blue-50">
                    <h2 class="text-lg font-semibold">{{ $data->title }}</h2>
                    <ul class="list-disc pl-5 text-gray-600">
                        @foreach (explode("\n", $data->description) as $i => $line)
                            @if ($i < 3 && trim($line) !== '')
                                <li>{{ $line }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @empty
                <div class="text-center text-gray-500">Belum ada todo.</div>
            @endforelse
        @else
            <div class="text-center text-gray-600 mt-10">
                Silakan login untuk melihat dan mengelola todo list Anda.
            </div>
        @endauth
    </main>

    @auth
        <button id="floatingBtn"
            class="fixed bg-blue-600 text-white rounded-full w-14 h-14 text-2xl flex items-center justify-center shadow-lg transition-all"
            onclick="document.getElementById('modalAdd').classList.remove('hidden')">
            +
        </button>
    @endauth

    <!-- Modal Tambah Todo -->
    <div id="modalAdd" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white rounded p-6 w-96 relative">
            <button onclick="document.getElementById('modalAdd').classList.add('hidden')"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl font-bold">&times;</button>
            <h2 class="text-xl font-semibold mb-4">Tambah Todo</h2>
            <form action="{{ route('add.simpan') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="title" class="block font-semibold mb-1">Judul</label>
                    <input type="text" name="title" id="title" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label for="description" class="block font-semibold mb-1">Deskripsi</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
                </div>
                <div class="text-right">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Detail Todo -->
    <div id="modalDetail" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white rounded p-6 w-96 relative max-h-[80vh] overflow-y-auto">
            <button onclick="document.getElementById('modalDetail').classList.add('hidden')"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl font-bold">&times;</button>
            <h2 id="detailTitle" class="text-xl font-semibold mb-4"></h2>
            <p id="detailDesc" class="whitespace-pre-line text-gray-700"></p>
        </div>
    </div>

    <script>
        function openModal(title, desc) {
            document.getElementById('detailTitle').textContent = title;
            document.getElementById('detailDesc').textContent = desc;
            document.getElementById('modalDetail').classList.remove('hidden');
        }
    </script>

</body>

</html>
