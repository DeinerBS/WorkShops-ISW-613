{{-- VISTA: lista de cursos --}}
@extends('layouts.app')

@section('titulo', 'Cursos')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 m-0">Cursos</h1>
    <a href="{{ route('cursos.create') }}" class="btn btn-primary">+ Nuevo curso</a>
</div>

<div class="card">
    <table class="table table-hover m-0 align-middle">
        <thead>
            <tr>
                <th>Código</th><th>Nombre</th><th>Créditos</th><th>Carrera</th><th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cursos as $c)
                <tr>
                    <td><span class="badge text-bg-secondary">{{ $c->codigo }}</span></td>
                    <td>{{ $c->nombre }}</td>
                    <td>{{ $c->creditos }}</td>
                    <td>{{ $c->carrera->nombre }}</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('cursos.show', $c) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                        <a href="{{ route('cursos.edit', $c) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                        {{-- Eliminar usa un form porque necesita método DELETE --}}
                        <form action="{{ route('cursos.destroy', $c) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar el curso {{ $c->codigo }}?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No hay cursos registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
