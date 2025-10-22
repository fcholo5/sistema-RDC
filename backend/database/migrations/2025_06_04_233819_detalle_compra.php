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
         Schema::create('detalle_compra', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compras_id')->constrained('compras')->cascadeOnDelete();
            $table->foreignId('productos_id')->constrained('productos')->cascadeOnDelete();
            $table->integer('precio_unitario');
            $table->float('cantidad');
            $table->float('sub_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_compra');
    }
};
