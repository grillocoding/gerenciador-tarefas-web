<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{

    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = auth()->user()->tasks();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tasks = $query->orderByRaw("FIELD(prioridade, 'alta', 'media', 'baixa')")
                       ->orderBy('data_entrega')
                       ->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'       => 'required|string|max:255',
            'descricao'    => 'nullable|string',
            'prioridade'   => 'required|in:baixa,media,alta',
            'data_entrega' => 'nullable|date',
        ], [
            'titulo.required'   => 'O título é obrigatório.',
            'prioridade.required' => 'A prioridade é obrigatória.',
        ]);

        auth()->user()->tasks()->create($request->all());

        return redirect()->route('tasks.index')
                         ->with('success', 'Tarefa criada com sucesso!');
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'titulo'       => 'required|string|max:255',
            'descricao'    => 'nullable|string',
            'status'       => 'required|in:pendente,em_andamento,concluida',
            'prioridade'   => 'required|in:baixa,media,alta',
            'data_entrega' => 'nullable|date',
        ], [
            'titulo.required'    => 'O título é obrigatório.',
            'status.required'    => 'O status é obrigatório.',
            'prioridade.required' => 'A prioridade é obrigatória.',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')
                         ->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return redirect()->route('tasks.index')
                         ->with('success', 'Tarefa excluída com sucesso!');
    }
}