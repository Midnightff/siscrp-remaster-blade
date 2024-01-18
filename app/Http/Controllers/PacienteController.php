<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $pacientes = Paciente::all();
        return view('admin.cita', compact('pacientes'));
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


    public function verificarPaciente()
    {
        // Verificar si el usuario tiene un paciente asociado
        $tienePaciente = Paciente::where('user_id', Auth::user()->id)->exists();

        return response()->json(['tienePaciente' => $tienePaciente]);
    }


    public function crearPaciente()
    {
        // Consulta SQL para obtener información del usuario y su paciente asociado
        $result = DB::select('SELECT b.id, b.nombres, p.email, p.name 
                              FROM users p 
                              INNER JOIN pacientes b 
                              WHERE b.user_id = p.id 
                              AND p.id = :user_id', ['user_id' => Auth::user()->id]);

        // Verificar si el resultado está vacío
        if (empty($result)) {
            // Si no hay paciente asociado, redirigir al formulario para crear un nuevo paciente
            return view('cliente.paciente');
        } else {
            // Si hay paciente asociado, redirigir a la página de citas
            return redirect()->route('citas.create');
        }
    }

    public function storeCliente(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), Paciente::$rules, Paciente::$customMessages);

            if ($validator->fails()) {
                return redirect()->route('pacientes')
                    ->with('error', $validator->errors()->first());
            }

            $paciente = new Paciente();
            // GENERAR CODIGO PARA PACIENTES
            $paciente->codigo = $this->getCodigo();
            $paciente->nombres = $request->nombres;
            $paciente->apellidos = $request->apellidos;
            $paciente->sexo = $request->sexo;
            $paciente->numeroTelefonico = $request->numeroTelefonico;
            $paciente->fechaNacimiento = $request->fechaNacimiento;
            $paciente->user_id = $request->user_id;

            // dd($paciente);

            if ($paciente->save()) {
                return redirect()->route('citas.create')
                    ->with('success', 'Paciente agregado con éxito.');
            } else {
                return redirect()->route('welcome')
                    ->with('error', 'Error al agregar a el paciente. Inténtalo de nuevo.');
            }
        } catch (\Exception $e) {
            return redirect()->route('welcome')
                ->with('error', 'Error al agregar a el paciente. ' . $e->getMessage());
        }
    }

    public function obtenerCantidadPacientes()
    {
        $user = Auth::user();
        $cantidadPacientes = Paciente::where('user_id', $user->id)->count();

        return response()->json(['cantidadPacientes' => $cantidadPacientes]);
    }
    public function showPacientes()
    {
        $user = Auth::user();
        $pacientes = Paciente::where('user_id', $user->id)->get();

        return response()->json(['pacientes' => $pacientes]);
    }

    public function Pacientes()
    {
        $user = Auth::user();
        $pacientes = Paciente::where('user_id', $user->id)->get();

        return view('cliente.pacientes', ['pacientes' => $pacientes]);
    }

    public function updateCliente(Request $request, string $id)
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
                return redirect()->route('pacientes')
                    ->with('success', 'Paciente actualizado con éxito.');
            }
        } catch (\Exception $e) {
            return redirect()->route('pacientes')
                ->with('error', 'Paciente no ha sido actualizado.' . $e->getMessage());
        }
    }
}
