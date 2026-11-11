{{-- VISTA: detalle de un producto --}}
@extends('layouts.app')

@section('titulo', $producto->nombre)

@section('contenido')
<div class="card">
    <div class="card-body">
        <h1 class="h3">{{ $producto->nombre }}</h1>
        <p class="text-muted">{{ $producto->descripcion ?: 'Sin descripción' }}</p>
        <p><strong>Precio:</strong> ₡{{ number_format($producto->precio, 2) }}</p>
        <p><strong>Stock:</strong> {{ $producto->stock }}</p>
        <p class="small text-muted">Creado: {{ $producto->created_at->format('d/m/Y H:i') }}</p>

        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-primary">Editar</a>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@endsection
