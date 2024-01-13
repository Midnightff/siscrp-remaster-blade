<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dash(){
        return view('admin.dashboard');
    }

    public function pacients(){
        return view('admin.pacientes');
    }

    public function antecedents(){
        return view('admin.antecedentes');
    }
}
