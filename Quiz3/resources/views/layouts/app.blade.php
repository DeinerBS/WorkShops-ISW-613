<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Matrícula') · Quiz 3</title>
    {{-- Tema Solar de Bootswatch (el mismo de SIGEL) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/solar/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/estilos.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('matriculas.create') }}">Matrícula UTN · Laravel</a>
            <div class="navbar-nav">
                <a class="nav-link {{ request()->routeIs('matriculas.create') ? 'active' : '' }}" href="{{ route('matriculas.create') }}">Matricular</a>
                <a class="nav-link {{ request()->routeIs('matriculas.index', 'matriculas.show') ? 'active' : '' }}" href="{{ route('matriculas.index') }}">Matrículas</a>
                <a class="nav-link {{ request()->routeIs('cursos.*') ? 'active' : '' }}" href="{{ route('cursos.index') }}">Cursos</a>
            </div>
        </div>
    </nav>

    <main class="container pb-5">
        {{-- Mensajes que manda el controlador --}}
        @if (session('ok'))
            <div class="alert alert-success">{{ session('ok') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('contenido')
    </main>
</body>
</html>
