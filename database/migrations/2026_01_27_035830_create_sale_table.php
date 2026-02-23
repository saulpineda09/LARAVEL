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
        Schema::create('sale', function (Blueprint $table) {
            $table->id();
            $table ->decimal('total', 10, 2);
            $table ->timestamp('sale_date')->useCurrent(); //formato esperado para el dia es: (año-mes-dia) YYYY-MM-DD
            $table ->string('email');
            $table ->softDeletes(); // Para eliminar registros sin borrarlos físicamente
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale');
    }
};
