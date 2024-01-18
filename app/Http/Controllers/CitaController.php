<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Tratamiento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

            // Crear la cita
            $cita = new Cita([
                'dia' => $request->input('dia'),
                'hora' => $request->input('hora'),
                'estado' => 'e',
                'paciente_id' => $request->input('paciente_id'),
                'tratamiento_id' => $request->input('tratamiento_id'),
            ]);

            $cita->save();

            // Crear la consulta asociada a la cita
            $consulta = new Consulta([
                'estado' => 'e',
                'observacion' => '',
                'costoConsulta' => 0.00,
                'cita_id' => $cita->id,
            ]);

            $consulta->save();

            return redirect()->route('pacientes.index')
                ->with('success', 'Cita y consulta creadas exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al crear la cita y la consulta: ' . $e->getMessage()]);
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

            // Crear la cita
            $cita = new Cita([
                'dia' => $request->input('dia'),
                'hora' => $request->input('hora'),
                'estado' => 'e',
                'paciente_id' => $request->input('paciente_id'),
                'tratamiento_id' => $request->input('tratamiento_id'),
            ]);

            $cita->save();

            // Crear la consulta asociada a la cita
            $consulta = new Consulta([
                'estado' => 'e',
                'observacion' => '',
                'costoConsulta' => 0.00,
                'cita_id' => $cita->id,
            ]);

            $consulta->save();

            return redirect()->route('citas.create')
                ->with('success', 'Cita y consulta creadas exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al crear la cita y la consulta: ' . $e->getMessage()]);
        }
    }


    public function mostrarCitasPorPaciente(string $id)
    {
        try {
            $paciente = Paciente::findOrFail($id);

            $citas = Cita::where('paciente_id', $paciente->id)
                ->where('estado', 'e')
                ->orderBy('id', 'desc')
                ->get();

            return view('cliente.citas-show-paciente', compact('citas', 'paciente'));
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


    public function cancelarCita($id)
    {
        $cita = Cita::find($id);
        if ($cita) {
            $cita->estado = 'c';
            $cita->save();
            return redirect()->route('pacientes')->with('success', 'Cita cancelada exitosamente');
        } else {
            return redirect()->route('pacientes')->with('error', 'La cita no existe');
        }
    }

    public function Citas(Request $request)
    {
        $fechaActual = Carbon::now()->toDateString();
        $tratamientos = Tratamiento::all(); // Asegúrate de tener esto en tu controlador

        $fechaBusqueda = $request->input('fecha');
        $tratamientoId = $request->input('tratamiento_id');
        $estado = $request->input('estado');

        $citasQuery = Cita::query();

        if ($fechaBusqueda) {
            $citasQuery->whereDate('dia', $fechaBusqueda);
        }

        if ($tratamientoId) {
            $citasQuery->where('tratamiento_id', $tratamientoId);
        }

        if ($estado) {
            $citasQuery->where('estado', $estado);
        }

        $citas = $citasQuery->get();

        if ($request->ajax()) {
            return view('admin.citas-show', compact('citas'));
        }

        return view('admin.citas-show', compact('citas', 'tratamientos'));
    }



    public function cancelarCitaAdmin($id)
    {
        return $this->cambiarEstadoCita($id, 'c', 'Cancelada');
    }

    private function cambiarEstadoCita($id, $nuevoEstado, $mensajeExito)
    {
        try {
            // Encuentra la cita por su ID
            $cita = Cita::findOrFail($id);

            // Actualiza el estado de la cita
            $cita->estado = $nuevoEstado;
            $cita->save();

            // Verifica si hay una consulta asociada
            if ($cita->consulta) {
                // Encuentra la consulta por su ID
                $consulta = Consulta::findOrFail($cita->consulta->id);

                // Actualiza el estado de la consulta
                $consulta->estado = $nuevoEstado;
                $consulta->save();
            }

            // Redirige a la ruta deseada con un mensaje de éxito
            return redirect()->route('citas.agendadas')->with('success', 'Estado de la cita ' . $mensajeExito . ' con éxito');
        } catch (\Exception $e) {
            // Manejo de errores
            return redirect()->route('citas.agendadas')->with('error', 'Error al actualizar el estado de la cita: ' . $e->getMessage());
        }
    }


    public function cancelarCitaCliente($id)
    {
        return $this->cambiarEstadoCitaCliente($id, 'c', 'Cancelada');
    }

    private function cambiarEstadoCitaCliente($id, $nuevoEstado, $mensajeExito)
    {
        try {
            // Encuentra la cita por su ID
            $cita = Cita::findOrFail($id);

            // Actualiza el estado de la cita
            $cita->estado = $nuevoEstado;
            $cita->save();

            // Verifica si hay una consulta asociada
            if ($cita->consulta) {
                // Encuentra la consulta por su ID
                $consulta = Consulta::findOrFail($cita->consulta->id);

                // Actualiza el estado de la consulta
                $consulta->estado = $nuevoEstado;
                $consulta->save();
            }

            // Redirige a la ruta deseada con un mensaje de éxito
            return redirect()->route('pacientes')->with('success', 'Estado de la cita ' . $mensajeExito . ' con éxito');
        } catch (\Exception $e) {
            // Manejo de errores
            return redirect()->route('pacientes')->with('error', 'Error al actualizar el estado de la cita: ' . $e->getMessage());
        }
    }
}
