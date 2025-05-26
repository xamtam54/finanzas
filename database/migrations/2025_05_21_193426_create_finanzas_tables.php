<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('periodos', function (Blueprint $table) {
            $table->id('idperiodo');
            $table->integer('cantidaddias');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ingresos', function (Blueprint $table) {
            $table->id('idingreso');
            $table->decimal('valor', 10, 2);
            $table->date('fecha');
            $table->string('descripcion')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ahorros', function (Blueprint $table) {
            $table->id('idahorro');
            $table->date('fechainicio');
            $table->date('fechafin');
            $table->unsignedBigInteger('periodo_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('periodo_id')->references('idperiodo')->on('periodos')->onDelete('cascade');
        });

        Schema::create('ahorro_ingreso', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ahorro_id');
            $table->unsignedBigInteger('ingreso_id');
            $table->decimal('porcentaje', 5, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ahorro_id')->references('idahorro')->on('ahorros')->onDelete('cascade');
            $table->foreign('ingreso_id')->references('idingreso')->on('ingresos')->onDelete('cascade');
        });

        Schema::create('egresos', function (Blueprint $table) {
            $table->id('idegreso');
            $table->decimal('valor', 10, 2);
            $table->date('fecha');
            $table->string('descripcion')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('gastos_fijos', function (Blueprint $table) {
            $table->id('idgastofijo');
            $table->string('descripcion');
            $table->unsignedBigInteger('periodo_id');
            $table->decimal('valor', 10, 2);
            $table->date('fecha_inicio');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('periodo_id')->references('idperiodo')->on('periodos')->onDelete('cascade');
        });

        Schema::create('gasto_egreso', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gastofijo_id');
            $table->unsignedBigInteger('egreso_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('gastofijo_id')->references('idgastofijo')->on('gastos_fijos')->onDelete('cascade');
            $table->foreign('egreso_id')->references('idegreso')->on('egresos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gasto_egreso');
        Schema::dropIfExists('gastos_fijos');
        Schema::dropIfExists('egresos');
        Schema::dropIfExists('ahorro_ingreso');
        Schema::dropIfExists('ahorros');
        Schema::dropIfExists('ingresos');
        Schema::dropIfExists('periodos');
    }
};
