<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Redirect; 
use Barryvdh\DomPDF\Facade\Pdf;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

  public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'due_date' => 'nullable|date',
        'priority' => 'required|in:düşük,orta,yüksek',
    ]);

    auth()->user()->tasks()->create([
        'title' => $request->title,
        'due_date' => $request->due_date,
        'priority' => $request->priority,
    ]);

    return redirect()->back();
    }
    public function exportPdf()
{
    $tasks = auth()->user()->tasks()->orderBy('due_date')->get();

    $pdf = Pdf::loadView('tasks.pdf', compact('tasks'));

    return $pdf->download('gorev-listesi.pdf');
}
    public function toggle(Task $task)
{
    $task->completed = !$task->completed;
    $task->save();

    return redirect('/');
}

// Görevi sil
public function destroy(Task $task)
{
    $task->delete();

    return redirect('/');
}
    //
}
