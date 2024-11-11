<?php

namespace App\Http\Controllers;

use App\Models\Capacitacion;
use App\Models\Empleado;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;


class CapacitacionController extends Controller
{
    public function index()
    {
        return Inertia::render('Capacitaciones/Index',[
            'capacitacions' => Capacitacion::paginate(10)
        ]);
    }

    public function create()
    {
        return Inertia::render('Capacitaciones/Create',[
            'empleados' => Empleado::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:20',
            'empresa' => 'required|max:70',
            'descripcion' => 'required|max:280',
            'duracion' => 'required|max:50',
            'imagen' => 'required|file|mimes:png,jpg,gif',
            'empleados' => 'required|array'
        ]);
        $capacitacion = Capacitacion::create($request->all());
        if($request->hasFile('imagen')){
            $imgName = microtime(true).'.'.$request->file('imagen')
                ->getClientOriginalExtension();
            $request->file('imagen')->storeAs('img',$imgName);
            $capacitacion->imagen = '/img/'.$imgName;
            $capacitacion->save();
        }
        $capacitacion->empleados()->sync($request->empleados);
        return redirect('capacitacions/create')->with('success','Capacitacion creada');
    }

    public function updateCapacitacion(Request $request){
        $request->validate([
            'nombre' => 'required|max:20',
            'empresa' => 'required|max:70',
            'descripcion' => 'required|max:280',
            'duracion' => 'required|max:50',
            'id' => 'required|numeric',
            'imagen' => 'required|file|mimes:png,jpg,gif',
            'id' => 'required|numeric',
        ]);
        $capacitacion = Capacitacion::find($request->id);
        $capacitacion->update($request->input());
        if($request->hasFile('imagen')){
            Storage::disk('public')->delete($capacitacion->imagen);
            $imgName = microtime(true).'.'.$request->file('imagen')
                ->getClientOriginalExtension();
            $request->file('imagen')->storeAs('img',$imgName, 'public');
            $capacitacion->imagen = '/img/'.$imgName;
            $capacitacion->save();
        }
        $capacitacion->empleados()->sync($request->empleados);
        return redirect('capacitacions')->with('success','Capacitacion modificada');
    }

    public function show(Capacitacion $capacitacion)
    {
        return Inertia::render('Capacitaciones/Show',[
            'capacitacion' => $capacitacion, 'empleados' => $capacitacion->empleados
        ]);
    }

    public function edit(Capacitacion $capacitacion)
    {
        return Inertia::render('Capacitaciones/Edit',[
            'empleados' => Empleado::all(),
            'capacitacion' => $capacitacion,
            'empleadosOfCap' => $capacitacion->empleados
        ]);
    }

    public function update(Request $request, Capacitacion $capacitacion)
    {
     
    }

    public function destroy(Capacitacion $capacitacion)
    {
        $capacitacion->delete();
        return redirect('capacitacions')->with('success','Capacitacion eliminada');
    }
}
