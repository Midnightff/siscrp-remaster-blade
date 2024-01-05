<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\HorarioDoctor;
use App\Models\Tratamiento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\error;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctores = Doctor::with('tratamiento', 'horarios')->get();
        $tratamientos = Tratamiento::all();
        $usuarios = User::all();
        //dd($doctores);
        return view('admin.doctores', compact('doctores', 'tratamientos', 'usuarios'));
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
            $request->validate([
                'nombres' => 'required|string|max:45',
                'apellidos' => 'required|string|max:45',
                'sexo' => 'required|in:m,f',
                'numeroTelefonico' => 'required|string|max:12',
                'user_id' => 'required|exists:users,id',
                'tratamiento_id' => 'nullable|exists:tratamientos,id',
                'horarios' => 'required|array|min:1',
                'horarios.*.dias' => 'required|array|min:1',
                'horarios.*.dias.*' => 'in:l,m,mi,j,v,s',
                'horarios.*.hora_inicio' => 'required|date_format:H:i',
                'horarios.*.hora_fin' => 'required|date_format:H:i|after:horarios.*.hora_inicio',
            ]);

            // Usar una transacción para asegurar que todas las operaciones se realicen o ninguna
            DB::beginTransaction();

            $doctor = Doctor::create([
                'nombres' => $request->input('nombres'),
                'apellidos' => $request->input('apellidos'),
                'sexo' => $request->input('sexo'),
                'numeroTelefonico' => $request->input('numeroTelefonico'),
                'user_id' => $request->input('user_id'),
                'tratamiento_id' => $request->input('tratamiento_id'),
            ]);

            // Crear los horarios asociados al doctor
            foreach ($request->input('horarios') as $horarioData) {
                $horario = new HorarioDoctor([
                    'dias' => implode(',', $horarioData['dias']),
                    'hora_inicio' => $horarioData['hora_inicio'],
                    'hora_fin' => $horarioData['hora_fin'],
                ]);

                $doctor->horarios()->save($horario);
            }

            DB::commit();

            return redirect()->route('doctores.index')
                ->with('success', 'Doctor creado exitosamente');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al crear el doctor. Por favor, inténtalo de nuevo.')
                ->withErrors([$e->getMessage()]);
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
            $request->validate([
                'nombres' => 'required|string|max:45',
                'apellidos' => 'required|string|max:45',
                //'sexo' => 'required|in:m,f',
                'numeroTelefonico' => 'required|string|max:12',
               // 'user_id' => 'required|exists:users,id',
                'tratamiento_id' => 'nullable|exists:tratamientos,id',
                'horarios' => 'required|array|min:1',
                'horarios.*.dias' => 'required|array|min:1',
                'horarios.*.dias.*' => 'in:l,m,mi,j,v,s',
                
            ]);

            // Usar una transacción para asegurar que todas las operaciones se realicen o ninguna
            DB::beginTransaction();

            // Obtener el doctor a actualizar
            $doctor = Doctor::findOrFail($id);

            // Actualizar la información del doctor
            $doctor->update([
                'nombres' => $request->input('nombres'),
                'apellidos' => $request->input('apellidos'),
                //'sexo' => $request->input('sexo'),
                'numeroTelefonico' => $request->input('numeroTelefonico'),
                //'user_id' => $request->input('user_id'),
                'tratamiento_id' => $request->input('tratamiento_id'),
            ]);

            // Eliminar los horarios existentes asociados al doctor
            $doctor->horarios()->delete();

            // Crear los nuevos horarios asociados al doctor
            foreach ($request->input('horarios') as $horarioData) {
                $horario = new HorarioDoctor([
                    'dias' => implode(',', $horarioData['dias']),
                    'hora_inicio' => $horarioData['hora_inicio'],
                    'hora_fin' => $horarioData['hora_fin'],
                ]);

                $doctor->horarios()->save($horario);
            }

            DB::commit();

            return redirect()->route('doctores.index')
                ->with('success', 'Doctor actualizado exitosamente');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al actualizar el doctor. Por favor, inténtalo de nuevo.')
                ->withErrors([$e->getMessage()]);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $doctor = Doctor::findOrFail($id);

            // Eliminar los horarios asociados al doctor
            $doctor->horarios()->delete();

            // Eliminar al doctor
            $doctor->delete();

            return redirect()->route('doctores.index')
                ->with('success', 'Doctor y horarios asociados eliminados exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el doctor. Por favor, inténtalo de nuevo.')
                ->withErrors([$e->getMessage()]);
        }
    }
}
