{{-- VISTA: datos del registro de matrícula guardado --}}
@extends('layouts.app')

@section('titulo', 'Matrícula #' . $matricula->id)

@section('contenido')
<div class="card border-success">
    <div class="card-header bg-success text-white">Comprobante de matrícula #{{ $matricula->id }}</div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-4">Cédula</dt>                 <dd class="col-sm-8">{{ $matricula->cedula }}</dd>
            <dt class="col-sm-4">Estudiante</dt>            <dd class="col-sm-8">{{ $matricula->nombre_estudiante }}</dd>
            <dt class="col-sm-4">Código del curso</dt>      <dd class="col-sm-8">{{ $matricula->curso->codigo }}</dd>
            <dt class="col-sm-4">Curso</dt>                 <dd class="col-sm-8">{{ $matricula->curso->nombre }}</dd>
            <dt class="col-sm-4">Créditos</dt>              <dd class="col-sm-8">{{ $matricula->curso->creditos }}</dd>
            <dt class="col-sm-4">Carrera</dt>               <dd class="col-sm-8">{{ $matricula->curso->carrera->nombre }}</dd>
            <dt class="col-sm-4">Fecha de matrícula</dt>    <dd class="col-sm-8">{{ $matricula->created_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('matriculas.create') }}" class="btn btn-primary">Nueva matrícula</a>
    <a href="{{ route('matriculas.index') }}" class="btn btn-secondary">Ver matrículas</a>
</div>
@endsection
