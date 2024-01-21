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

    public function odontogramasPorPaciente($id)
    {
        $odontogramas = Odontograma::where('paciente_id', $id)->get();

        return redirect()->route('odontograma.index')->with('odontogramas', $odontogramas);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'numeroDiente' => 'required|integer',
                'estadoDiente' => 'required|in:b,f,r,e,p,c,o,a',
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

            Odontograma::create([
                'numeroDiente' => $request->input('numeroDiente'),
                'estadoDiente' => $request->input('estadoDiente'),
                'seccionDiente' => $request->input('seccionDiente'),
                'observaciones' => $request->input('observaciones'),
                'paciente_id' => $request->input('paciente_id'),
            ]);

            return redirect()->route('odontograma.index', ['id' => $request->input('paciente_id')])->with('success', 'Guardado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('odontograma.index')->with('error', 'Error al guardar');
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
    public function opcionesEstadoDiente()
    {
        $opciones = [
            'b' => 'Bueno', 'f' => 'Fracturado', 'r' => 'Restaurado', 'e' => 'Extraído', 'p' => 'Puente', 'c' => 'Carie',
            'o' => 'Obturación',
            'a' => 'Ausente'
        ];

        return response()->json(['opciones' => $opciones]);
    }

    public function obtenerDatosPorNumeroDiente($paciente_id, $numeroDiente)
    {
        try {
            // Buscar todos los registros que coincidan con el número de diente y el ID del paciente
            $datosDiente = Odontograma::where('numeroDiente', $numeroDiente)
                ->where('paciente_id', $paciente_id)
                ->get();

            return response()->json(['datosDiente' => $datosDiente], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los datos del diente'], 500);
        }
    }
}
