{{-- VISTA: lista de productos --}}
@extends('layouts.app')

@section('titulo', 'Productos')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 m-0">Productos</h1>
    <a href="{{ route('productos.create') }}" class="btn btn-primary">+ Nuevo producto</a>
</div>

<div class="card">
    <table class="table table-hover m-0 align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th><th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($productos as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->nombre }}</td>
                    <td>₡{{ number_format($p->precio, 2) }}</td>
                    <td>{{ $p->stock }}</td>
                    <td class="text-end">
                        <a href="{{ route('productos.show', $p) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                        <a href="{{ route('productos.edit', $p) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                        {{-- Eliminar usa un form porque necesita método DELETE --}}
                        <form action="{{ route('productos.destroy', $p) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este producto?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No hay productos registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
