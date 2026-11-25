{{-- VISTA: página principal, formulario de matrícula --}}
@extends('layouts.app')

@section('titulo', 'Matricular')

@section('contenido')
<h1 class="h3 mb-3">Formulario de matrícula</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="m-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('matriculas.store') }}" method="POST">
    @csrf

    <div class="card mb-3"><div class="card-body">
        <h2 class="h5">Datos del estudiante</h2>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Cédula</label>
                <input type="text" name="cedula" class="form-control" maxlength="20" placeholder="2-0123-0456"
                       value="{{ old('cedula') }}" required>
            </div>
            <div class="col-md-8 mb-3">
                <label class="form-label">Nombre completo</label>
                <input type="text" name="nombre_estudiante" class="form-control" maxlength="100"
                       value="{{ old('nombre_estudiante') }}" required>
            </div>
        </div>
    </div></div>

    <div class="card mb-3">
        <div class="card-body pb-0"><h2 class="h5">Seleccione un curso</h2></div>
        {{-- Listado de cursos que vienen de la BD (seed); un radio por curso --}}
        <table class="table table-hover m-0 align-middle">
            <thead>
                <tr><th></th><th>Código</th><th>Curso</th><th>Créditos</th><th>Carrera</th></tr>
            </thead>
            <tbody>
                @forelse ($cursos as $c)
                    <tr>
                        <td>
                            <input class="form-check-input" type="radio" name="curso_id" id="curso{{ $c->id }}"
                                   value="{{ $c->id }}" @checked(old('curso_id') == $c->id) required>
                        </td>
                        <td><label for="curso{{ $c->id }}">{{ $c->codigo }}</label></td>
                        <td><label for="curso{{ $c->id }}">{{ $c->nombre }}</label></td>
                        <td>{{ $c->creditos }}</td>
                        <td>{{ $c->carrera->nombre }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No hay cursos. Ejecute <code>php artisan db:seed</code>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <button class="btn btn-success btn-lg">Matricular</button>
</form>
@endsection
