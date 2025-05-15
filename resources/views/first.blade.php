<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Todo List Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen relative">

    <!-- Logo + Search, tanpa header -->
    <div class="flex justify-between items-center px-4 pt-4">
        <!-- Logo Emoji -->
        <a href="{{ route('home.index') }}" class="flex items-center space-x-2">
            <div class="bg-blue-100 text-blue-600 rounded-full p-3 text-xl">
                🗄️
            </div>
        </a>

        <!-- Tombol Search -->
        <button onclick="document.getElementById('searchInput').classList.toggle('hidden')"
            class="text-blue-600 px-3 py-1 rounded hover:bg-blue-100 transition">
            🔍 Search
        </button>
    </div>

    <!-- Kolom input search -->
    <div id="searchInput" class="px-4 mt-2 hidden">
        <form method="GET" action="{{ route('first.index') }}">
            <input type="text" name="q" placeholder="Cari judul atau deskripsi..."
                class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </form>
    </div>


    <!-- Search Input -->
    <div id="searchInput" class="p-4 hidden">
        <input type="text" placeholder="Cari judul atau deskripsi..."
            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    <!-- Main Content -->
    <main class="p-4 space-y-4">
        @foreach ($todos as $data)
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
        @endforeach
    </main>

    <!-- Tombol + -->
    <button id="floatingBtn"
        class="fixed bg-blue-600 text-white rounded-full w-14 h-14 text-2xl flex items-center justify-center shadow-lg transition-all">
        +
    </button>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-20">
        <div class="bg-white p-6 rounded shadow max-w-lg w-full">
            <h2 id="modalTitle" class="text-xl font-bold mb-2"></h2>
            <p id="modalDesc" class="text-gray-700"></p>
            <button onclick="closeModal()"
                class="mt-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Tutup</button>
        </div>
    </div>

    <script>
        // Modal logic
        function openModal(title, desc) {
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalDesc').innerText = desc;
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('modal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
            document.getElementById('modal').classList.remove('flex');
        }

        // Floating button follows scroll
        const btn = document.getElementById("floatingBtn");
        window.addEventListener("scroll", () => {
            const scrollY = window.scrollY;
            btn.style.top = `${scrollY + window.innerHeight - 80}px`;
            btn.style.left = `${window.innerWidth - 80}px`;
        });
    </script>

</body>

</html>
