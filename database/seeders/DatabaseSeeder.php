<?php

namespace Database\Seeders;

use App\Models\Capacitacion;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Puesto::factory(10)->create();   
        \App\Models\Empleado::factory(13)->create(); 
        Capacitacion::factory(10)->create();  
        //lenar tabla empleado_capacitacion
        for($i=1; $i<=10; $i++){
            $capacitacion = Capacitacion::find($i);
            $capacitacion->empleados()->attach(random_int(1,13));
        }
    }
}
