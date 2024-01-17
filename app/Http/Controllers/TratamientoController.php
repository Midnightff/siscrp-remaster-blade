<?php

namespace App\Http\Controllers;

use App\Models\Tratamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TratamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tratamientos = Tratamiento::all();
        return view('admin.tratamientos', compact('tratamientos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tratamientos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validar los datos de la solicitud
            $validator = Validator::make($request->all(), Tratamiento::$rules, Tratamiento::$customMessages);

            if ($validator->fails()) {
                return redirect()->route('tratamientos.index')
                    ->with('error', $validator->errors()->first());
            }

            // Crear una nueva instancia de Tratamiento
            $tratamiento = new Tratamiento();
            $tratamiento->nombreTratamiento = $request->nombreTratamiento;
            $tratamiento->descripcion = $request->descripcion;
            $tratamiento->precio = $request->precio;
            $tratamiento->estado = $request->estado;

            // Subir y guardar la imagen
            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $imagen->move(public_path('img/tratamientos/'), $nombreImagen);
                $tratamiento->nombreImagen = $nombreImagen;
            } else {
                $tratamiento->nombreImagen = "none.jpg";
            }

            // Guardar el Tratamiento
            if ($tratamiento->save()) {
                return redirect()->route('tratamientos.index')
                    ->with('success', 'Tratamiento agregado exitosamente.');
            } else {
                return redirect()->route('tratamientos.index')
                    ->with('error', 'Error al agregar el tratamiento. Inténtalo de nuevo.');
            }
        } catch (\Exception $e) {
            return redirect()->route('tratamientos.index')
                ->with('error', 'Error al agregar el tratamiento. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // Validar los datos de la solicitud directamente en el controlador
            $request->validate([
                'nombreTratamiento' => 'sometimes|required|string|max:255|unique:tratamientos,nombreTratamiento,' . $id,
                'descripcion' => 'sometimes|required|string',
                'precio' => 'sometimes|required|numeric',
                'estado' => 'sometimes|required|string|max:255',
                'imagen' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
          



            // Obtener el tratamiento a actualizar
            $tratamiento = Tratamiento::findOrFail($id);

            // Actualizar los campos solo si se proporcionan en la solicitud
            if ($request->has('nombreTratamiento')) {
                $tratamiento->nombreTratamiento = $request->nombreTratamiento;
            }

            if ($request->has('descripcion')) {
                $tratamiento->descripcion = $request->descripcion;
            }

            if ($request->has('precio')) {
                $tratamiento->precio = $request->precio;
            }

            if ($request->has('estado')) {
                $tratamiento->estado = $request->estado;
            }

            // Actualizar la imagen si se proporciona una nueva
            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $imagen->move(public_path('img/tratamientos/'), $nombreImagen);
                $tratamiento->nombreImagen = $nombreImagen;
            }

            // Guardar los cambios en el tratamiento
            if ($tratamiento->save()) {
                return redirect()->route('tratamientos.index')
                    ->with('success', 'Tratamiento actualizado exitosamente.');
            } else {
                return redirect()->route('tratamientos.index')
                    ->with('error', 'Error al actualizar el tratamiento. Inténtalo de nuevo.');
            }
        } catch (\Exception $e) {
            return redirect()->route('tratamientos.index')
                ->with('error', 'Error al actualizar el tratamiento. ' . $e->getMessage());
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Obtener el tratamiento por su ID
            $tratamiento = Tratamiento::findOrFail($id);

            // Verificar y eliminar la imagen si no es "none.jpg"
            if ($tratamiento->nombreImagen != "none.jpg") {
                $imagenPath = public_path('img/tratamientos/') . $tratamiento->nombreImagen;
                if (file_exists($imagenPath)) {
                    unlink($imagenPath);
                }
            }

            // Eliminar el tratamiento
            if ($tratamiento->delete()) {
                return redirect()->route('tratamientos.index')
                    ->with('success', 'Tratamiento eliminado exitosamente.');
            } else {
                return redirect()->route('tratamientos.index')
                    ->with('error', 'Error al eliminar el tratamiento. Inténtalo de nuevo.');
            }
        } catch (\Exception $e) {
            return redirect()->route('tratamientos.index')
                ->with('error', 'Error al eliminar el tratamiento. ' . $e->getMessage());
        }
    }

    public function indexCliente()
    {
        $tratamientos = Tratamiento::all();
        return view('cliente.tratamientos', compact('tratamientos'));
    }
}
