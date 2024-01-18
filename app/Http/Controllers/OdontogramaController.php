<?php

namespace App\Http\Controllers;

use App\Models\Odontograma;
use App\Models\Paciente;
use Illuminate\Http\Request;

class OdontogramaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pacientes = Paciente::all();
        return view('admin.odontograma', compact('pacientes'));
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validación de datos
            $request->validate([
                'numeroDiente' => 'required|integer',
                'estadoDiente' => 'required|in:b,f,r,e,p',
                'seccionDiente' => [
                    'required',
                    'regex:/^(\d,)*\d$/',
                    function ($attribute, $value, $fail) {
                        $secciones = explode(',', $value);
                        $seccionesValidas = ['1', '2', '3', '4', '5'];
    
                        foreach ($secciones as $seccion) {
                            if (!in_array($seccion, $seccionesValidas)) {
                                $fail("La sección diente '$seccion' es inválida.");
                            }
                        }
                    },
                ],
                'observaciones' => 'nullable|string',
                'paciente_id' => 'required|exists:pacientes,id',
            ]);
    
            // Crear un nuevo odontograma
            $odontograma = new Odontograma([
                'numeroDiente' => $request->input('numeroDiente'),
                'estadoDiente' => $request->input('estadoDiente'),
                'seccionDiente' => $request->input('seccionDiente'),
                'observaciones' => $request->input('observaciones'),
                'paciente_id' => $request->input('paciente_id'),
            ]);
    
            // Guardar el odontograma
            $odontograma->save();
    
            return redirect()->route('odontograma.index')
                ->with('success', 'Guardado exitosamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('odontograma.index')
                ->with('error', 'Error al guardar');
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
