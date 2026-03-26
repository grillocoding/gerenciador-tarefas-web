@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold">Minhas Tarefas</h4>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Nova Tarefa
    </a>
</div>

{{-- Filtro --}}
<form method="GET" action="{{ route('tasks.index') }}" class="mb-4">
    <div class="d-flex gap-2">
        <select name="status" class="form-select w-auto">
            <option value="">Todos os status</option>
            <option value="pendente"
                {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
            <option value="em_andamento"
                {{ request('status') == 'em_andamento' ? 'selected' : '' }}>Em andamento</option>
            <option value="concluida"
                {{ request('status') == 'concluida' ? 'selected' : '' }}>Concluída</option>
        </select>
        <button class="btn btn-outline-secondary">Filtrar</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-danger">Limpar</a>
    </div>
</form>

{{-- Lista --}}
@forelse($tasks as $task)
    @php
        $corStatus = match($task->status) {
            'pendente'     => 'warning',
            'em_andamento' => 'info',
            'concluida'    => 'success',
        };
        $corPrioridade = match($task->prioridade) {
            'alta'  => 'danger',
            'media' => 'secondary',
            'baixa' => 'light',
        };
        $labelStatus = match($task->status) {
            'pendente'     => 'Pendente',
            'em_andamento' => 'Em andamento',
            'concluida'    => 'Concluída',
        };
    @endphp

    <div class="card mb-3 {{ $task->status === 'concluida' ? 'opacity-75' : '' }}">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div class="flex-grow-1">
                    <h5 class="card-title mb-1
                        {{ $task->status === 'concluida' ? 'text-decoration-line-through text-muted' : '' }}">
                        {{ $task->titulo }}
                    </h5>

                    @if($task->descricao)
                        <p class="card-text text-muted small mb-2">{{ $task->descricao }}</p>
                    @endif

                    <div class="d-flex gap-2 flex-wrap">
                        <span class="badge bg-{{ $corStatus }}">{{ $labelStatus }}</span>
                        <span class="badge bg-{{ $corPrioridade }} text-dark border">
                            Prioridade: {{ ucfirst($task->prioridade) }}
                        </span>
                        @if($task->data_entrega)
                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-calendar3"></i>
                                {{ $task->data_entrega->format('d/m/Y') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="d-flex gap-2 flex-shrink-0">
                    <a href="{{ route('tasks.edit', $task) }}"
                       class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                          onsubmit="return confirm('Deseja excluir esta tarefa?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="text-center text-muted py-5">
        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
        Nenhuma tarefa encontrada.
        <div class="mt-3">
            <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">
                Criar primeira tarefa
            </a>
        </div>
    </div>
@endforelse
@endsection