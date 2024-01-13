<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PacienteController extends Controller
{

    public function index()
    {
        $pacientes = Paciente::all();
        $usuarios = User::all();

        foreach ($pacientes as $paciente) {
            $paciente->fechaNacimiento = $this->calcularEdad($paciente->fechaNacimiento);
        }

        return view('admin.pacientes', compact('pacientes', 'usuarios'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), Paciente::$rules, Paciente::$customMessages);

            if ($validator->fails()) {
                return redirect()->route('pacientes.index')
                    ->with('error', $validator->errors()->first());
            }

            $paciente = new Paciente();
            $paciente->codigo = $this->getCodigo();
            $paciente->nombres = $request->nombres;
            $paciente->apellidos = $request->apellidos;
            $paciente->sexo = $request->sexo;
            $paciente->numeroTelefonico = $request->numeroTelefonico;
            $paciente->fechaNacimiento = $request->fechaNacimiento;
            $paciente->user_id = $request->user_id;

            // dd($paciente);

            if ($paciente->save()) {
                return redirect()->route('pacientes.index')
                    ->with('success', 'Paciente agregado con éxito.');
            } else {
                return redirect()->route('pacientes.index')
                    ->with('error', 'Error al agregar a el paciente. Inténtalo de nuevo.');
            }
        } catch (\Exception $e) {
            return redirect()->route('pacientes.index')
                ->with('error', 'Error al agregar a el paciente. ' . $e->getMessage());
        }
    }

    private function getCodigo()
    {
        $result = DB::select("SELECT CONCAT(TRIM(YEAR(CURDATE())),LPAD(TRIM(MONTH(CURDATE())),2,0),LPAD(IFNULL(MAX(TRIM(SUBSTRING(codigo,7,4))),0)+1,4,0)) as codigo FROM pacientes WHERE SUBSTRING(codigo,1,6) = CONCAT(TRIM(YEAR(CURDATE())),LPAD(TRIM(MONTH(CURDATE())),2,0))");
        return $result[0]->codigo;
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        try {

            $request->validate([
                'nombres' => 'sometimes|required|string|max:45',
                'apellidos' => 'sometimes|required|string|max:45',
                'numeroTelefonico' => 'sometimes|required',
            ]);

            $paciente = Paciente::findOrfail($id);

            if ($request->has('nombres')) {
                $paciente->nombres = $request->nombres;
            }
            if ($request->has('apellidos')) {
                $paciente->apellidos = $request->apellidos;
            }
            if ($request->has('numeroTelefonico')) {
                $paciente->numeroTelefonico = $request->numeroTelefonico;
            }

            if ($paciente->update() >= 1) {
                return redirect()->route('pacientes.index')
                    ->with('success', 'Paciente actualizado con éxito.');
            }
        } catch (\Exception $e) {
            return redirect()->route('pacientes.index')
                ->with('error', 'Paciente no ha sido actualizado.' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $paciente = Paciente::findOrfail($id);
            if ($paciente->delete()) {
                return redirect()->route('pacientes.index')
                    ->with('success', 'Paciente eliminado con éxito.');
            } else {
                return redirect()->route('pacientes.index')
                    ->with('error', 'Error al eliminar el paciente. Inténtalo de nuevo.');
            }
        } catch (\Exception $e) {
            return redirect()->route('pacientes.index')
                ->with('error', 'Error al eliminar el paciente. ' . $e->getMessage());
        }
    }

    public function calcularEdad($fechaNacimiento)
    {
        $fechaActual = Carbon::now();
        $birthDay = Carbon::parse($fechaNacimiento);
        $edad = $fechaActual->diffInYears($fechaNacimiento);
        return $edad;
    }
}
