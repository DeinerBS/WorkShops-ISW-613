{{-- VISTA: formulario para crear --}}
@extends('layouts.app')

@section('titulo', 'Nuevo producto')

@section('contenido')
<h1 class="h3 mb-3">Nuevo producto</h1>

<div class="card card-body">
    <form action="{{ route('productos.store') }}" method="POST">
        @csrf {{-- token de seguridad obligatorio en Laravel --}}
        @include('productos._form')
        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
