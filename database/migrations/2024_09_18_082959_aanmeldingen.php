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
        Schema::create('aanmeldingen', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_accepted')->default(false);
            $table->foreignId('huisdier_id')->constrained('aangeboden_huisdieren')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // De gebruiker die zich aanmeldt
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aanmeldingen');
    }
};
