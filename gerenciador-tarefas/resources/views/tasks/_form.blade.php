<div class="mb-3">
    <label class="form-label">Título <span class="text-danger">*</span></label>
    <input type="text" name="titulo"
        class="form-control @error('titulo') is-invalid @enderror"
        value="{{ old('titulo', $task->titulo ?? '') }}" required>
    @error('titulo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Descrição</label>
    <textarea name="descricao" rows="3"
        class="form-control">{{ old('descricao', $task->descricao ?? '') }}</textarea>
</div>

@isset($task)
<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
        <option value="pendente"
            {{ old('status', $task->status) == 'pendente' ? 'selected' : '' }}>
            Pendente
        </option>
        <option value="em_andamento"
            {{ old('status', $task->status) == 'em_andamento' ? 'selected' : '' }}>
            Em andamento
        </option>
        <option value="concluida"
            {{ old('status', $task->status) == 'concluida' ? 'selected' : '' }}>
            Concluída
        </option>
    </select>
</div>
@endisset

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Prioridade <span class="text-danger">*</span></label>
        <select name="prioridade" class="form-select">
            <option value="baixa"
                {{ old('prioridade', $task->prioridade ?? '') == 'baixa' ? 'selected' : '' }}>
                Baixa
            </option>
            <option value="media"
                {{ old('prioridade', $task->prioridade ?? 'media') == 'media' ? 'selected' : '' }}>
                Média
            </option>
            <option value="alta"
                {{ old('prioridade', $task->prioridade ?? '') == 'alta' ? 'selected' : '' }}>
                Alta
            </option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Data de entrega</label>
        <input type="date" name="data_entrega" class="form-control"
            value="{{ old('data_entrega', isset($task) ? $task->data_entrega?->format('Y-m-d') : '') }}">
    </div>
</div>