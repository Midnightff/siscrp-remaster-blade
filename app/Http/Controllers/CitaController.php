<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Tratamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tratamientos = Tratamiento::all();
        return view('admin.cita', compact('tratamientos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tratamientos = Tratamiento::all();
        return view('cliente.citas', compact('tratamientos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'dia' => 'required|date',
                'hora' => 'required|date_format:H:i',
                'paciente_id' => 'required|exists:pacientes,id',
                'tratamiento_id' => 'required|exists:tratamientos,id',
            ]);


            $cita = new Cita([
                'dia' => $request->input('dia'),
                'hora' => $request->input('hora'),
                'estado' => 'e',
                'paciente_id' => $request->input('paciente_id'),
                'tratamiento_id' => $request->input('tratamiento_id'),
            ]);


            $cita->save();

            return redirect()->route('pacientes.index')
                ->with('success', 'Cita creada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al crear la cita: ' . $e->getMessage()]);
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


    public function disponibilidad(Request $request)
    {
        try {
            $tratamientoId = $request->input('tratamiento_id');

            // Verifica si se ha seleccionado un tratamiento
            if ($tratamientoId) {
                // Obtén el tratamiento seleccionado
                $tratamiento = Tratamiento::findOrFail($tratamientoId);

                // Obtén los doctores asociados al tratamiento
                $doctores = $tratamiento->doctores;

                // Verifica si hay doctores asociados y si la colección no es null
                if ($doctores && $doctores->isNotEmpty()) {
                    // Inicializa un array para almacenar la información de disponibilidad
                    $disponibilidad = [];

                    // Recorre todos los doctores asociados
                    foreach ($doctores as $doctor) {
                        // Obtén los horarios del doctor
                        $horariosDisponibles = $doctor->horarios;

                        // Obtén los días disponibles para el doctor
                        $diasDisponibles = $horariosDisponibles->pluck('dias')->flatten()->unique();

                        // Agrega la información de disponibilidad al array
                        $disponibilidad[] = [
                            'doctor' => $doctor,
                            'dias_disponibles' => $diasDisponibles,
                        ];
                    }

                    // Retorna un JSON con la información de disponibilidad
                    return response()->json($disponibilidad);
                } else {
                    return response()->json(['error' => 'No hay doctores asociados a este tratamiento.'], 404);
                }
            } else {
                return response()->json(['error' => 'Seleccione un tratamiento antes de buscar disponibilidad.'], 400);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'El tratamiento seleccionado no existe.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ha ocurrido un error inesperado.'], 500);
        }
    }

    public function getHorasOcupadas($fechaSeleccionada)
    {
        $horasOcupadas = Cita::whereDate('dia', $fechaSeleccionada)
            ->pluck('hora')
            ->toArray();

        return response()->json(['horas_ocupadas' => $horasOcupadas]);
    }

    public function storeCita(Request $request)
    {
        try {
            $request->validate([
                'dia' => 'required|date',
                'hora' => 'required|date_format:H:i',
                'paciente_id' => 'required|exists:pacientes,id',
                'tratamiento_id' => 'required|exists:tratamientos,id',
            ]);


            $cita = new Cita([
                'dia' => $request->input('dia'),
                'hora' => $request->input('hora'),
                'estado' => 'e',
                'paciente_id' => $request->input('paciente_id'),
                'tratamiento_id' => $request->input('tratamiento_id'),
            ]);


            $cita->save();

            return redirect()->route('citas.create')
                ->with('success', 'Cita creada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al crear la cita: ' . $e->getMessage()]);
        }
    }
}
