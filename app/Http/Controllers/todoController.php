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
        $data_todo = todoModel::all();

        return view('home', compact('data_todo'));
    }

    public function show()
    {

        if (Auth::check()) {
            $todos = todoModel::where('id_user', Auth::id())->orderBy('date', 'desc')->get();
        } else {
            $todos = collect(); // kosong kalau belum login
        }

        return view('dashboard', compact('todos'));
    }

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
            'status' => 'required|in:Pending,In Progress, Done',
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

        $edit_todo = todoModel::findOrFail($id);
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
        $data_todo = todoModel::findOrFail($id);
        $data_todo->delete();

        return redirect()->route('home.index')->with('success', 'data berhasil dihapus');
    }
}
