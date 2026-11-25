{{-- VISTA: editar curso (PUT) --}}
@extends('layouts.app')

@section('titulo', 'Editar curso')

@section('contenido')
<h1 class="h3 mb-3">Editar curso {{ $curso->codigo }}</h1>
<div class="card"><div class="card-body">
    <form action="{{ route('cursos.update', $curso) }}" method="POST">
        @csrf
        @method('PUT')
        @include('cursos._form')
        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('cursos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div></div>
@endsection
