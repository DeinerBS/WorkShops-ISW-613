{{-- Campos compartidos entre crear y editar. old() conserva lo escrito si falla la validación --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="m-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label class="form-label">Nombre del curso</label>
    <input type="text" name="nombre" class="form-control" maxlength="100"
           value="{{ old('nombre', $curso->nombre ?? '') }}" required>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Código del curso</label>
        <input type="text" name="codigo" class="form-control" maxlength="20" placeholder="ISW-613"
               value="{{ old('codigo', $curso->codigo ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Cantidad de créditos</label>
        <input type="number" name="creditos" class="form-control" min="1" max="10"
               value="{{ old('creditos', $curso->creditos ?? '') }}" required>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Carrera</label>
    {{-- Las carreras vienen del seed --}}
    <select name="carrera_id" class="form-select" required>
        <option value="">-- Seleccione una carrera --</option>
        @foreach ($carreras as $carrera)
            <option value="{{ $carrera->id }}" @selected(old('carrera_id', $curso->carrera_id ?? '') == $carrera->id)>
                {{ $carrera->nombre }}
            </option>
        @endforeach
    </select>
</div>
