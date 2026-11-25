{{-- VISTA: crear curso --}}
@extends('layouts.app')

@section('titulo', 'Nuevo curso')

@section('contenido')
<h1 class="h3 mb-3">Nuevo curso</h1>
<div class="card"><div class="card-body">
    <form action="{{ route('cursos.store') }}" method="POST">
        @csrf
        @include('cursos._form')
        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('cursos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div></div>
@endsection
