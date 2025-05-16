<?php

namespace App\Http\Controllers;

use App\Models\todoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class todoController extends Controller
{

    //Konfirmasi database
    public function index()
    {
        if (Auth::check()) {
            $data_todo = todoModel::where('id_user', Auth::id())->orderBy('date', 'desc')->get();
        } else {
            // tampilkan todo milik user lain secara umum, atau kosongkan
            $data_todo = todoModel::orderBy('date', 'desc')->get(); // atau bisa gunakan filter sesuai kebutuhan
        }


        return view('home', compact('data_todo'));
    }

    public function show(Request $request)
    {
        $query = $request->input('q'); // ambil keyword dari input search

        if (Auth::check()) {
            $todosQuery = todoModel::where('id_user', Auth::id())
                ->orderBy('date', 'desc');

            if ($query) {
                $todosQuery->where(function ($q) use ($query) {
                    $q->where('title', 'like', '%' . $query . '%')
                        ->orWhere('description', 'like', '%' . $query . '%');
                });
            }

            $todos = $todosQuery->get();
        } else {
            $todos = collect(); // kosong jika belum login
        }

        return view('dashboard', compact('todos'));
    }

    // public function __construct()
    // {
    //     $this->middleware('auth')->only(['create', 'simpan', 'update', 'delete']);
    // }

    //Adding data ke database
    public function create()
    {
        return view('add');
    }

    //Validasi data ke database
    public function simpan(Request $request)
    {
        //Validasi Input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:Pending,In Progress,Done',
            'priority' => 'required|in:Low,Medium,High',
            'date' => 'required|date|after_or_equal:today',
        ]);

        todoModel::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'priority' => $request->priority,
            'date' => $request->date,
            'id_user' => Auth::id(),  // sambungkan dengan user login
        ]);

        return redirect()->route('home.index')->with('success', 'data berhasil disimpan');
    }

    //Perbarui data yang ada di database
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,In Progress,Done',
            'priority' => 'required|in:Low,Medium,High',
            'date' => 'required|date|after_or_equal:today',

        ]);

        $edit_todo = todoModel::where('id', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail(); // hanya data milik user

        $edit_todo->update([
            'status' => $request->status,
            'priority' => $request->priority,
            'date' => $request->date,
        ]);

        return redirect()->route('home.index')->with('success', 'data berhasil diperbarui');
    }


    //Hapus data yang ada di database
    public function delete($id)
    {
        $data_todo = todoModel::where('id', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail(); // hanya data milik user

        $data_todo->delete();

        return redirect()->route('home.index')->with('success', 'data berhasil dihapus');
    }

    public function markDone($id)
    {
        // Cari todo milik user yang login
        $todo = todoModel::where('id', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail();

        // Update status jadi Done
        $todo->update([
            'status' => 'Done',
        ]);

        return redirect()->back()->with('success', 'Todo berhasil ditandai selesai!');
    }
}
