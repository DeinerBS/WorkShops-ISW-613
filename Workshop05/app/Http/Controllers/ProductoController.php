<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

// CONTROLADOR: recibe la petición, usa el modelo y devuelve una vista
class ProductoController extends Controller
{
    // Reglas de validación compartidas por guardar y actualizar
    private function validar(Request $request): array
    {
        return $request->validate([
            'nombre'      => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio'      => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
        ]);
    }

    // READ: lista todos los productos
    public function index()
    {
        $productos = Producto::orderBy('id', 'desc')->get();
        return view('productos.index', compact('productos'));
    }

    // Muestra el formulario vacío
    public function create()
    {
        return view('productos.create');
    }

    // CREATE: guarda el nuevo producto
    public function store(Request $request)
    {
        Producto::create($this->validar($request));
        return redirect()->route('productos.index')->with('ok', 'Producto creado.');
    }

    // READ: detalle de un producto
    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

    // Muestra el formulario con los datos actuales
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    // UPDATE: guarda los cambios
    public function update(Request $request, Producto $producto)
    {
        $producto->update($this->validar($request));
        return redirect()->route('productos.index')->with('ok', 'Producto actualizado.');
    }

    // DELETE: elimina el producto
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('ok', 'Producto eliminado.');
    }
}
