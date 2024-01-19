<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Radiografias;
use App\Models\Tratamiento;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RadiografiasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $radiografias = Radiografias::all();
        $tratamientos = Tratamiento::all();
        $pacientes = Paciente::all();
        return view('admin.radiografias', compact('radiografias', 'tratamientos', 'pacientes'));
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
            $validator = Validator::make($request->all(), Radiografias::$rules, Radiografias::$customMessages);
            if ($validator->fails()) {
                return redirect()->route('radiografias.index')->with('error', $validator->errors()->first());
            }

            $radiografia = new Radiografias();
            $radiografia->fechaRealizada = $request->fechaRealizada;
            $radiografia->tratamiento_id = $request->tratamiento_id;
            $radiografia->paciente_id = $request->paciente_id;

            if ($request->hasFile('nombreRadiografia')) {
                $rutaImagen = $request->file('nombreRadiografia');
                $nombreImagen = time() . '_' . $rutaImagen->getClientOriginalName();
                $rutaImagen->move(public_path('img/radiografias/'), $nombreImagen);
                $radiografia->nombreRadiografia = $nombreImagen;
            } else {
                dd($request->hasFile('nombreRadiografia'));
                $radiografia->nombreRadiografia = "none.png";
            }

            if ($radiografia->save()) {
                return redirect()->route('radiografias.index')->with('success', 'Radiografia agregada con éxito!');
            } else {
                return redirect()->route('radiografias.index')->with('error', 'Error al agregar la Radiografia.');
            }
        } catch (\Exception $e) {
            return redirect()->route('radiografias.index')->with('error', 'Error al agregar la publicacion. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $radiografia = Radiografias::with(['paciente', 'tratamiento'])->where('paciente_id', $id)->get();
        // dd($radiografia);
        return view('admin.radiografias_show', compact('radiografia'));
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
