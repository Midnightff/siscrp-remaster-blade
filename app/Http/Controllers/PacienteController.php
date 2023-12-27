<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PacienteController extends Controller
{

    public function index()
    {
        $pacientes = Paciente::all();
        $usuarios = User::all();
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
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
