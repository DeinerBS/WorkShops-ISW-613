{{-- VISTA: detalle de un curso --}}
@extends('layouts.app')

@section('titulo', $curso->nombre)

@section('contenido')
<div class="card">
    <div class="card-body">
        <h1 class="h3">{{ $curso->nombre }}</h1>
        <p><strong>Código:</strong> {{ $curso->codigo }}</p>
        <p><strong>Créditos:</strong> {{ $curso->creditos }}</p>
        <p><strong>Carrera:</strong> {{ $curso->carrera->nombre }}</p>
        <p><strong>Estudiantes matriculados:</strong> {{ $curso->matriculas_count }}</p>

        <a href="{{ route('cursos.edit', $curso) }}" class="btn btn-primary">Editar</a>
        <a href="{{ route('cursos.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@endsection
