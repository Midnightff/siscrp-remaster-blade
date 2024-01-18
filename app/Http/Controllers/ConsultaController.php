<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Consulta;
use App\Models\Paciente;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
    }

    public function mostrarConsultasPorPaciente($id)
    {
        try {
            $paciente = Paciente::findOrFail($id);

            // Obtener todas las consultas del paciente con relaciones cargadas
            $consultas = $paciente->consultas()
                ->with('cita.paciente', 'cita.tratamiento', 'cita.tratamiento.doctores')
                ->get();
            //dd($consultas);
            return view('admin.expediente', compact('consultas', 'paciente'));
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
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
        //
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
        try {
            $request->validate([
                'observacion' => 'nullable|string|max:100',
                'costoConsulta' => 'required|numeric|between:0,999999.99',
            ]);

            // Encuentra la consulta por su ID
            $consulta = Consulta::findOrFail($id);

            $consulta->observacion = $request->input('observacion');
            $consulta->costoConsulta = $request->input('costoConsulta');

            // Guarda los cambios en la base de datos
            $consulta->save();

            // Redirige de nuevo a la vista de detalles de la consulta
            return redirect()->route('mostrar.consulta', $consulta->id)->with('success', 'Consulta actualizada con éxito');
        } catch (\Exception $e) {
            // Manejo de errores
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al actualizar la consulta: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function atenderConsulta($id)
    {
        return $this->cambiarEstadoConsulta($id, 'a', 'Atendida');
    }


    private function cambiarEstadoConsulta($id, $nuevoEstado, $mensajeExito)
    {
        try {
            // Encuentra la consulta por su ID
            $consulta = Consulta::findOrFail($id);

            // Actualiza el estado de la consulta
            $consulta->estado = $nuevoEstado;
            $consulta->save();

            // Verifica si hay una cita asociada
            if ($consulta->cita) {
                // Encuentra la cita por su ID
                $cita = Cita::findOrFail($consulta->cita->id);

                // Actualiza el estado de la cita
                $cita->estado = $nuevoEstado;
                $cita->save();
            }

            // Redirige a la ruta deseada con un mensaje de éxito
            return redirect()->route('pacientes.index')->with('success', 'Estado de la consulta ' . $mensajeExito . ' con éxito');
        } catch (\Exception $e) {
            // Manejo de errores
            return redirect()->route('pacientes.index')->with('error', 'Error al actualizar el estado de la consulta: ' . $e->getMessage());
        }
    }
}
