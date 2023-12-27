<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\User;
use Illuminate\Http\Request;

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
        dd($request->all());
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
