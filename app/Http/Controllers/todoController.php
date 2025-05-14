<?php

namespace App\Http\Controllers;

use App\Models\todoModel;
use Illuminate\Http\Request;

class todoController extends Controller
{

    //Konfirmasi database
    public function index() {
        $data_todo = todoModel::all();

        return view('home', compact('data_todo'));
    }

    public function show() {

        $todos = todoModel::orderBy('date', 'desc')->get();

        return view('first', compact('todos'));

    }

    //Adding data ke database
    public function create(){
        return view('add');
    }

    //Validasi data ke database
    public function simpan(Request $request) {
        //Validasi Input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:Pending,In Progress, Done',
            'priority' => 'required|in:Low,Medium,High',
            'date' => 'required|date',
        ]);

        // $title = $validated['title'];
        // $desc = $validated['description'];
        // $stats = $validated['status'];
        // $prority = $validated['prority'];
        // $date = $validated['date'];

        // todoModel::create([
        //     'title' => $title,
        //     'description' => $desc,
        //     'status' => $stats,
        //     'priority' => $prority,
        //     'date' => $date,
        // ]);

        todoModel::create($validated);

        return redirect()->route('home.index')->with('success', 'data berhasil disimpan');
    }

        //Perbarui data yang ada di database
    public function update(Request $request, $id) {
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

    
    // //Perbarui data yang ada di database
    // public function update(Request $request, $id) {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'required|string',
    //         'status' => 'required|in:Pending,In Progress, Done',
    //         'priority' => 'required|in:Low,Medium,High',
    //         'date' => 'required|date',
    //     ]);

    //     $edit_todo = todoModel::findOrFail($id);
    //     $edit_todo->update([
    //         'title' => $request->title,
    //         'description' => $request->description,
    //         'status' => $request->status,
    //         'priority' => $request->priority,
    //         'date' => $request->date,
    //     ]);

    //     return redirect()->route('home.index')->with('success', 'data berhasil diperbarui');
    // }
    
    // //Perbaruan hanya untuk status
    // public function updateStat(Request $request, $id) {
    //     $request->validate([
    //         'status' => 'required|in:Pending,In Progress,Done',
    //     ]);

    //     $todo = todoModel::findOrFail($id);
    //     $todo->status = $request->status;
    //     $todo->save();

    //     return redirect()->back()->with('success', 'status data berhasil diperbarui');
    // }
    
    //Hapus data yang ada di database
    public function delete($id) {
        $data_todo = todoModel::findOrFail($id);
        $data_todo->delete();

        return redirect()->route('home.index')->with('success', 'data berhasil dihapus');
    }
}
