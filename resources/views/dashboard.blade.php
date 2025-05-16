<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Todo List Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen font-poppins">

    <nav
        class="bg-white shadow-md flex items-center justify-between px-8 py-4 sticky top-0 z-30 border-b border-blue-200">
        <div
            class="flex items-center space-x-3 text-teal-600 font-bold text-2xl hover:text-teal-700 transition cursor-default">
            <i class="fa-solid fa-list-check"></i>
            <span>TodoVick</span>
            <span class="animate-bounce">📝</span>
        </div>

        <form method="GET" action="{{ route('dashboard.index') }}" class="flex-grow max-w-xl mx-8 flex space-x-2">
            <input type="text" name="q" value="{{ request('q') }}"
                placeholder="🔍 Cari judul atau deskripsi..."
                class="flex-grow p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-300 transition" />

            @if (request('q'))
                <a href="{{ route('dashboard.index') }}"
                    class="flex items-center space-x-2 bg-red-100 hover:bg-red-200 text-red-600 px-4 py-2 rounded-lg transition shadow-sm font-semibold">
                    <i class="fa-solid fa-xmark"></i>
                    <span>Reset</span>
                </a>
            @endif
        </form>


        <div class="flex items-center space-x-5 text-sm font-semibold">
            @guest
                <a href="{{ route('register.form') }}"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-lg shadow-md flex items-center space-x-2 transition">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Register</span>
                </a>
                <a href="{{ route('login') }}"
                    class="bg-lime-600 hover:bg-lime-700 text-white px-5 py-2 rounded-lg shadow-md flex items-center space-x-2 transition">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>Login</span>
                </a>
            @endguest

            @auth
                <span
                    class="text-gray-700 font-semibold flex items-center space-x-2 border border-gray-300 rounded-lg px-3 py-1 bg-white shadow-sm">
                    <i class="fa-solid fa-user-circle text-blue-600"></i>
                    <span>{{ Auth::user()->nama ?? Auth::user()->name }}</span>
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 font-semibold shadow-md transition">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>
            @endauth
        </div>
    </nav>

    <main class="p-6 space-y-6 max-w-4xl mx-auto mt-8">
        @auth
            @forelse ($todos as $data)
                <div class="relative bg-white p-6 rounded-xl shadow-lg cursor-pointer hover:shadow-2xl hover:bg-teal-50 transition flex flex-col space-y-2"
                    onclick="openModal(`{{ addslashes($data->title) }}`, `{{ addslashes($data->description) }}`)">

                    <h2 class="text-xl font-semibold flex items-center space-x-3 text-teal-700">
                        {{-- Emoji status di depan judul --}}
                        @if (strtolower($data->status) == 'pending')
                            <span title="Pending">🕒</span>
                        @elseif(strtolower($data->status) == 'in progress')
                            <span title="In Progress">⚙️</span>
                        @elseif(strtolower($data->status) == 'done')
                            <span title="Done">✅</span>
                        @endif
                        <span>{{ $data->title }}</span>
                    </h2>

                    <ul class="list-disc pl-6 text-gray-700 max-h-24 overflow-hidden">
                        @foreach (explode("\n", $data->description) as $i => $line)
                            @if ($i < 3 && trim($line) !== '')
                                <li>{{ $line }}</li>
                            @endif
                        @endforeach
                    </ul>

                    <div class="flex justify-between items-center text-xs text-gray-500">
                        <span><i class="fa-regular fa-clock"></i>
                            {{ \Carbon\Carbon::parse($data->date)->format('d M Y') }}</span>
                        <span class="capitalize">
                            <i class="fa-solid fa-flag text-yellow-400"></i> {{ $data->priority }}
                        </span>
                        <span>
                            {{-- Status dengan emoji di samping --}}
                            @if (strtolower($data->status) == 'pending')
                                🕒 Pending
                            @elseif(strtolower($data->status) == 'in progress')
                                ⚙️ In Progress
                            @elseif(strtolower($data->status) == 'done')
                                ✅ Done
                            @else
                                {{ $data->status }}
                            @endif
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 italic mt-10">Belum ada todo. <i
                        class="fa-regular fa-face-sad-tear"></i></div>
            @endforelse
        @else
            <div class="text-center text-gray-600 mt-16 text-lg font-semibold">
                <i class="fa-solid fa-circle-info text-blue-500 mr-2"></i> Silakan login untuk melihat dan mengelola todo
                list Anda.
            </div>
        @endauth
    </main>

    @auth
        <a href="{{ route('home.index') }}"
            class="fixed bottom-6 right-6 bg-green-600 hover:bg-green-700 text-white rounded-full w-14 h-14 text-3xl flex items-center justify-center shadow-lg transition-all"
            title="Tambah Todo">
            <i class="fa-solid fa-plus text-2xl"></i>
        </a>
    @endauth

    <!-- Modal Detail Todo -->
    <div id="modalDetail" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-8 w-full max-w-md relative max-h-[80vh] overflow-y-auto shadow-lg">
            <button onclick="document.getElementById('modalDetail').classList.add('hidden')"
                class="absolute top-5 right-5 text-gray-400 hover:text-gray-700 text-3xl font-bold transition">&times;</button>
            <h2 id="detailTitle" class="text-2xl font-semibold mb-5 text-blue-700 flex items-center space-x-3">
                <i class="fa-solid fa-circle-info"></i>
                <span></span>
            </h2>
            <p id="detailDesc" class="whitespace-pre-line text-gray-700 text-base leading-relaxed"></p>
        </div>
    </div>

    <script>
        function openModal(title, desc) {
            document.getElementById('detailTitle').querySelector('span').textContent = title;
            document.getElementById('detailDesc').textContent = desc;
            document.getElementById('modalDetail').classList.remove('hidden');
        }
    </script>

</body>

</html>
