<?php

namespace App\Http\Controllers;

use App\Models\AntecedentesMedicos;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AntecedentesController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    // public function index()
    // {
    //     $allPacientes = Paciente::all();
    //     $antecedentes = [];
    //     // $pacientesByAnteced = [];
    //     foreach ($allPacientes as $paciente ) {
    //         $antecedente = AntecedentesMedicos::where('paciente_id', $paciente->id)->get();
    //         $antecedentes[] = $antecedente;
    //     }

    //     dd($antecedentes);
    //     return view('admin.antecedentes', compact('antecedentes', 'allPacientes'));
    // }


    public function index()
    {
        $allPacientes = Paciente::all();
        $antecedentesMedicos = AntecedentesMedicos::with('paciente')->get();

        return view('admin.antecedentes', compact('antecedentesMedicos', 'allPacientes'));
    }

    public function showAntecedenteByPacient($paciente_id)
    {
        $antecedentesMedicos = AntecedentesMedicos::with('paciente')
            ->where('paciente_id', $paciente_id)
            ->get();

        return view('admin.antecedentes_user', compact('antecedentesMedicos'));
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
        // dd($request->all());
        try {
            $validator = Validator::make($request->all(), AntecedentesMedicos::$rules, AntecedentesMedicos::$customMessages);

            if ($validator->fails()) {
                return redirect()->route('antecedentes.index')
                    ->with('error', $validator->errors()->first());
            }

            $antecedentes_medicos = new AntecedentesMedicos();
            $antecedentes_medicos->hipertencionArterial = $request->hipertencionArterial;
            $antecedentes_medicos->cardiopatia = $request->cardiopatia;
            $antecedentes_medicos->diabetesMellitu = $request->diabetesMellitu;
            $antecedentes_medicos->problemaRenal = $request->problemaRenal;
            $antecedentes_medicos->problemaRespiratorio = $request->problemaRespiratorio;
            $antecedentes_medicos->problemaHepatico = $request->problemaHepatico;
            $antecedentes_medicos->problemaEndocrino = $request->problemaEndocrino;
            $antecedentes_medicos->problemaHemorragico = $request->problemaHemorragico;
            $antecedentes_medicos->alergiaMedicamentos = $request->alergiaMedicamentos;
            $antecedentes_medicos->embarazo = $request->embarazo;
            $antecedentes_medicos->otrosMedicamentosQueToma = $request->otrosMedicamentosQueToma;
            $antecedentes_medicos->otrosDatos = $request->otrosDatos;
            $antecedentes_medicos->paciente_id = $request->paciente_id;

            if ($antecedentes_medicos->save()) {
                return redirect()->route('antecedentes.index')
                    ->with('success', 'Antecedentes agregados con éxito.');
            } else {
                return redirect()->route('antecedentes.index')
                    ->with('error', 'Error al agregar los antecedentes. Inténtalo de nuevo.');
            }
        } catch (\Exception $e) {
            return redirect()->route('antecedentes.index')
                ->with('error', 'Error al agregar los antecedentes. ' . $e->getMessage());
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
