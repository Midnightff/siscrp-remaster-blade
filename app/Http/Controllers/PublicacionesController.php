<?php

namespace App\Http\Controllers;

use App\Models\Publicaciones;
use App\Models\Tratamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publicaciones = Publicaciones::all();
        $tratamientos = Tratamiento::all();
        return view('admin.publicaciones', compact('publicaciones', 'tratamientos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return view('admin.publicaciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), Publicaciones::$rules, Publicaciones::$customMessages);

            if ($validator->fails()) {
                return redirect()->route('publicaciones.index')->with('error', $validator->errors()->first());
            }

            $publicacion = new Publicaciones();
            $publicacion->titulo = $request->titulo;
            $publicacion->descripcion = $request->descripcion;
            $publicacion->precio = $request->precio;
            $publicacion->fechaInicio = $request->fechaInicio;
            $publicacion->fechaFinal = $request->fechaFinal;
            $publicacion->tratamiento_id = $request->tratamiento_id;

            if ($request->hasFile('rutaImagen')) {
                $rutaImagen = $request->file('rutaImagen');
                $nombreImagen = time() . '_' . $rutaImagen->getClientOriginalName();
                $rutaImagen->move(public_path('img/publicaciones/'), $nombreImagen);
                $publicacion->rutaImagen = $nombreImagen;
            } else {
                $publicacion->rutaImagen = "none.png";
            }

            if ($publicacion->save()) {
                return redirect()->route('publicaciones.index')->with('success', 'Publicacion agregada con exito!');
            } else {
                return redirect()->route('publicaciones.index')
                    ->with('error', 'Error al agregar la publicacion. Inténtalo de nuevo.');
            }
        } catch (\Exception $e) {
            return redirect()->route('publicaciones.index')
                ->with('error', 'Error al agregar la publicacion. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $publicacion = Publicaciones::findOrFail($id)->get();
        // dd($publicacion);
        return view('admin.publicaciones_show', compact('publicacion'));
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
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'titulo' => 'sometimes|required|max:45|unique:publicaciones,titulo',
                'descripcion' => 'sometimes|required|string',
                'rutaImagen' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'precio' => 'sometimes|required|numeric|between:0,999999.99',
                'fechaInicio' => 'required|date',
                'fechaFinal' => 'required|date',
                'tratamiento_id' => 'numeric'
            ]);

            // dd($request);
            
            $publicacion = Publicaciones::findOrFail($id);

            $canBeUpdated = ['titulo', 'descripcion', 'precio', 'fechaInicio', 'fechaFinal', 'tratamiento_id'];

            if ($request->hasFile('rutaImagen')) {
                $imagen = $request->file('rutaImagen');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $imagen->move(public_path('img/publicaciones/'), $nombreImagen);
                $publicacion->rutaImagen = $nombreImagen;
            }

            foreach ($canBeUpdated as $data) {
                if ($request->has($data)) {
                    $publicacion->$data = $request->$data;
                }
            }


            if ($publicacion->save()) {
                return redirect()->route('publicaciones.index')
                    ->with('success', 'Publicacion actualizada exitosamente.');
            } else {
                return redirect()->route('publicaciones.index')
                    ->with('error', 'Error al actualizar la publicacion. Inténtalo de nuevo.');
            }
        } catch (\Exception $e) {
            return redirect()->route('publicaciones.index')
                ->with('error', 'Error al actualizar esta publicacion. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $publicacion = Publicaciones::findOrFail($id);

            if ($publicacion->rutaImagen = !"none.jpg") {
                $imagePath = public_path('img/publicaciones/') . $publicacion->rutaImagen;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            if ($publicacion->delete()) {
                return redirect()->route('publicaciones.index')->with('success', 'Publicación Eliminada con éxito.');
            } else {
                return redirect()->route('publicaciones.index')->with('error', 'Ha ocurrido un error al eliminar la publicación.');
            }
        } catch (\Exception $e) {
            return redirect()->route('publicaciones.index')
                ->with('error', 'Error al eliminar la publicacion. ' . $e->getMessage());
        }
    }

    public function indexCliente()
    {
        $publicaciones = Publicaciones::all();
        return view('cliente.publicaciones', compact('publicaciones'));
    }
}
