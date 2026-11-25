{{-- VISTA: matrículas registradas --}}
@extends('layouts.app')

@section('titulo', 'Matrículas')

@section('contenido')
<h1 class="h3 mb-3">Matrículas registradas</h1>

<div class="card">
    <table class="table table-hover m-0 align-middle">
        <thead>
            <tr><th>#</th><th>Cédula</th><th>Estudiante</th><th>Curso</th><th>Fecha</th><th></th></tr>
        </thead>
        <tbody>
            @forelse ($matriculas as $m)
                <tr>
                    <td>{{ $m->id }}</td>
                    <td>{{ $m->cedula }}</td>
                    <td>{{ $m->nombre_estudiante }}</td>
                    <td>{{ $m->curso->codigo }} · {{ $m->curso->nombre }}</td>
                    <td>{{ $m->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-end"><a href="{{ route('matriculas.show', $m) }}" class="btn btn-sm btn-outline-secondary">Ver</a></td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Aún no hay matrículas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
