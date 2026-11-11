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
    <label class="form-label">Nombre</label>
    <input type="text" name="nombre" class="form-control"
           value="{{ old('nombre', $producto->nombre ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Precio (₡)</label>
        <input type="number" step="0.01" min="0" name="precio" class="form-control"
               value="{{ old('precio', $producto->precio ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Stock</label>
        <input type="number" min="0" name="stock" class="form-control"
               value="{{ old('stock', $producto->stock ?? 0) }}" required>
    </div>
</div>
