<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Matricula;
use Illuminate\Http\Request;

// CONTROLADOR: formulario de matrícula (página principal)
class MatriculaController extends Controller
{
    // Página principal: formulario con el listado de cursos
    public function create()
    {
        $cursos = Curso::with('carrera')->orderBy('codigo')->get();
        return view('matriculas.create', compact('cursos'));
    }

    // Guarda la matrícula y redirige a la vista con los datos del registro
    public function store(Request $request)
    {
        $datos = $request->validate([
            'cedula'            => 'required|string|max:20',
            'nombre_estudiante' => 'required|string|max:100',
            'curso_id'          => 'required|exists:cursos,id',
        ], [
            'curso_id.required' => 'Debe seleccionar un curso de la lista.',
        ], [
            'nombre_estudiante' => 'nombre del estudiante',
            'curso_id'          => 'curso',
            'cedula'            => 'cédula',
        ]);

        $matricula = Matricula::create($datos);

        return redirect()->route('matriculas.show', $matricula)->with('ok', 'Matrícula registrada correctamente.');
    }

    // Muestra los datos del registro recién guardado
    public function show(Matricula $matricula)
    {
        $matricula->load('curso.carrera');
        return view('matriculas.show', compact('matricula'));
    }

    // Lista de matrículas registradas
    public function index()
    {
        $matriculas = Matricula::with('curso')->latest()->get();
        return view('matriculas.index', compact('matriculas'));
    }
}
