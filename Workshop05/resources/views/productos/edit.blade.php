{{-- VISTA: formulario para editar --}}
@extends('layouts.app')

@section('titulo', 'Editar producto')

@section('contenido')
<h1 class="h3 mb-3">Editar producto #{{ $producto->id }}</h1>

<div class="card card-body">
    <form action="{{ route('productos.update', $producto) }}" method="POST">
        @csrf
        @method('PUT') {{-- HTML solo envía GET/POST; Laravel simula PUT --}}
        @include('productos._form')
        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
