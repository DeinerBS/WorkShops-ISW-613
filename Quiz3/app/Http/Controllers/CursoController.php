<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

// CONTROLADOR: CRUD de cursos
class CursoController extends Controller
{
    // Validación compartida; al editar, ignora el código del mismo curso en el unique
    private function validar(Request $request, ?Curso $curso = null): array
    {
        return $request->validate([
            'nombre'     => 'required|string|max:100',
            'codigo'     => ['required', 'string', 'max:20', Rule::unique('cursos', 'codigo')->ignore($curso)],
            'creditos'   => 'required|integer|min:1|max:10',
            'carrera_id' => 'required|exists:carreras,id',
        ], [], [
            'codigo'     => 'código',
            'creditos'   => 'créditos',
            'carrera_id' => 'carrera',
        ]);
    }

    // READ: lista (with evita una consulta por cada carrera)
    public function index()
    {
        $cursos = Curso::with('carrera')->orderBy('codigo')->get();
        return view('cursos.index', compact('cursos'));
    }

    public function create()
    {
        $carreras = Carrera::orderBy('nombre')->get();
        return view('cursos.create', compact('carreras'));
    }

    // CREATE
    public function store(Request $request)
    {
        Curso::create($this->validar($request));
        return redirect()->route('cursos.index')->with('ok', 'Curso creado.');
    }

    // READ: detalle
    public function show(Curso $curso)
    {
        $curso->load('carrera')->loadCount('matriculas');
        return view('cursos.show', compact('curso'));
    }

    public function edit(Curso $curso)
    {
        $carreras = Carrera::orderBy('nombre')->get();
        return view('cursos.edit', compact('curso', 'carreras'));
    }

    // UPDATE
    public function update(Request $request, Curso $curso)
    {
        $curso->update($this->validar($request, $curso));
        return redirect()->route('cursos.index')->with('ok', 'Curso actualizado.');
    }

    // DELETE: no se borra si ya tiene estudiantes matriculados
    public function destroy(Curso $curso)
    {
        if ($curso->matriculas()->exists()) {
            return redirect()->route('cursos.index')->with('error', 'No se puede eliminar: el curso tiene matrículas.');
        }

        $curso->delete();
        return redirect()->route('cursos.index')->with('ok', 'Curso eliminado.');
    }
}
