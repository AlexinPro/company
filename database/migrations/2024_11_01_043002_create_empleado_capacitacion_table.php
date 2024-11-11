<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up(): void
        {
            Schema::create('capacitacion_empleado', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('capacitacion_id');
                $table->unsignedBigInteger('empleado_id');
                $table->foreign('capacitacion_id')->references('id')->on('capacitacions')->onDelete('cascade');
                $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');
                
                $table->timestamps();
            });
        }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleado_capacitacion');
    }
};