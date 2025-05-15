<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todolist</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 p-3 font-poppins">
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-center mb-10">
            <h1 class="text-5xl font-bold text-lime-700 relative inline-block">
                <i class="fas fa-list-check mr-3 text-lime-500 animate-bounce"></i>
                    To Do List
                <span class="absolute -top-2 -right-8 text-sm text-white bg-red-500 px-2 py-0.5 rounded-full animate-pulse shadow-lg">
                    💪 Focus!
                </span>
            </h1>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4 max-w-lg mx-auto text-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- <div class="mb-4 flex justify-end">
            <a href="{{ route('add.create') }}"
                class="bg-lime-600 hover:bg-lime-700 text-white px-4 py-2 rounded shadow-md transition duration-300 border border-lime-700">
                Add <i class="fa-solid fa-plus mr-1"></i>
            </a>
        </div> --}}

        <div class="overflow-x-auto rounded-lg shadow-xl overflow-hidden bg-white p-2">
            <table class="table-auto w-full border border-gray-300">
                <thead class="bg-lime-500">
                    <tr>
                        <th class="border px-4 py-2">Judul</th>
                        <th class="border px-4 py-2">Deskripsi</th>
                        <th class="border px-4 py-2">Status</th>
                        <th class="border px-4 py-2">Prioritas</th>
                        <th class="border px-4 py-2">Tanggal</th>
                        <th class="border px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_todo as $data)
                        <tr class="bg-gray-100 hover:bg-lime-100 transition-colors duration-300">
                            <td class="border-r border-gray-400 px-2 py-2">{{ $data->title }}</td>
                            <td class="border-r border-gray-400 px-2 py-2">{{ $data->description }}</td>
                            <td class="border-r border-gray-400 px-2 py-2">
                                @if ($data->status === 'Pending')
                                    <i class="fas fa-clock text-yellow-500 animate-spin"></i>
                                @elseif ($data->status === 'In Progress')
                                    <i class="fas fa-cogs text-teal-600 animate-spin"></i>
                                @elseif ($data->status === 'Done')
                                    <i class="fas fa-check-circle text-green-600 animate-pulse"></i>
                                @else
                                    <i class="fas fa-question-circle text-gray-600 animate-ping"></i>
                                @endif
                                <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                    @if ($data->status === 'Pending') bg-yellow-100 text-yellow-700
                                    @elseif ($data->status === 'In Progress') bg-teal-100 text-teal-700
                                    @elseif ($data->status === 'Done') bg-green-100 text-green-700
                                    @else bg-gray-100 text-gray-700 @endif">
                                    {{ ucfirst($data->status) }}
                                </span>
                            </td>
                            <td class="border-r border-gray-400 px-2 py-2">
                                @if ($data->priority === 'Low')
                                    <i class="fa-solid fa-circle w-4 h-4 text-yellow-500"></i>
                                @elseif ($data->priority === 'Medium')
                                    <i class="fa-solid fa-circle w-4 h-4 text-orange-500"></i>
                                @elseif ($data->priority === 'High')
                                    <i class="fa-solid fa-circle w-4 h-4 text-red-600"></i>
                                @else
                                    <i class="fas fa-question-circle text-gray-600"></i>
                                @endif
                                <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                    @if ($data->priority === 'Low') bg-yellow-100 text-yellow-700
                                    @elseif ($data->priority === 'Medium') bg-orange-100 text-orange-700
                                    @elseif ($data->priority === 'High') bg-red-100 text-red-700
                                    @else bg-gray-100 text-gray-700 @endif">
                                    {{ ucfirst($data->priority) }}
                                </span>
                            </td>
                            <td class="border px-4 py-2">{{ $data->date }}</td>
                            <td class="border px-4 py-2">
                                <div class="flex items-center justify-center gap-4">
                                    <button type="button" onclick="openModal('editModal{{ $data->id }}')"
                                        class="bg-green-500 hover:bg-emerald-600 text-white py-1.9 px-2 rounded transition duration-300 transform hover:scale-110">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <form action="{{ route('home.delete', $data->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white py-1.9 px-2 rounded transition duration-300 transform hover:scale-110">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>

                                    <div id="editModal{{ $data->id }}"
                                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300 z-50">
                                        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
                                            <button onclick="closeModal('editModal{{ $data->id }}')"
                                                class="absolute text-2xl top-2 right-4 text-gray-500 hover:text-gray-700">&times;</button>
                                            <h2 class="text-2xl font-bold mb-6">Edit Todo</h2>
                                            <form action="{{ route('home.update', $data->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-4">
                                                    <label class="block text-gray-700 mb-1">Status</label>
                                                    <select name="status"
                                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-lime-500"
                                                        required>
                                                        <option value="" disabled {{ $data->status ? '' : 'selected' }}>Pilih Status</option>
                                                        <option value="Pending" {{ $data->status === 'Pending' ? 'selected' : '' }}>🕒Pending</option>
                                                        <option value="In Progress" {{ $data->status === 'In Progress' ? 'selected' : '' }}>⚙️In Progress</option>
                                                        <option value="Done" {{ $data->status == 'Done' ? 'selected' : '' }}>✅Done</option>
                                                    </select>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="block text-gray-700 mb-1">Prioritas</label>
                                                    <select name="priority"
                                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-lime-500"
                                                        required>
                                                        <option value="" disabled {{ $data->priority ? '' : 'selected' }}>Pilih Prioritas</option>
                                                        <option value="Low" {{ $data->priority === 'Low' ? 'selected' : '' }}>🟡Low</option>
                                                        <option value="Medium" {{ $data->priority === 'Medium' ? 'selected' : '' }}>🟠Medium</option>
                                                        <option value="High" {{ $data->priority === 'High' ? 'selected' : '' }}>🔴High</option>
                                                    </select>
                                                </div>
                                                <div class="flex justify-end gap-2">
                                                    <button type="button"
                                                        onclick="closeModal('editModal{{ $data->id }}')"
                                                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Batal</button>
                                                    <button type="submit"
                                                        class="bg-lime-600 hover:bg-lime-700 text-white px-4 py-2 rounded">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('add.create') }}"
        class="fixed bottom-6 right-6 bg-lime-600 hover:bg-lime-700 text-white p-4 rounded-full shadow-lg transition duration-300 z-50">
        <i class="fa-solid fa-plus"></i>
    </a>

    <script>
        function openModal(id) {`
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('opacity-100');
                modal.classList.remove('opacity-0');
            }, 10);
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.add('opacity-0');
            modal.classList.remove('opacity-100');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
</body>

</html>
