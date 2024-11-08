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
        Schema::create('aangeboden_huisdieren', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ras');
            $table->string('photo')->nullable();
            $table->decimal('geld', 8, 2);
            $table->string('informatie');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aangeboden_huisdieren');
    }
};
