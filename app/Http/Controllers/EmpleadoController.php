<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Puesto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmpleadoController extends Controller
{
    public function index()
    {
        $puestos = Puesto::all();
        $empleados = Empleado::with('puesto:id,puesto','capacitacions:nombre')->get();
        return Inertia::render('Empleados/Index',[
            'empleados' =>$empleados,
            'puestos' =>$puestos
         ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:80',
            'apellidos' => 'required|max:80',
            'puesto_id' => 'required|numeric',
            'email' => 'required|email'
        ]);
        $empleado = new Empleado($request->input());
        $empleado->save();
        return redirect('empleados');
    }

    public function show(Empleado $empleado)
    {
        //
    }

    public function edit(Empleado $empleado)
    {
        //
    }

    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'nombre' => 'required|max:80',
            'apellidos' => 'required|max:80',
            'puesto_id' => 'required|numeric',
            'email' => 'required|email'
        ]);
        $empleado->update($request->input());
        return redirect('empleados');
    }

    public function destroy(Empleado $empleado)
    {
        $empleado->delete();
        return redirect('empleados');
    }
}
