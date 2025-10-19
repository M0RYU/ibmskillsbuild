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
    {        Schema::create('criterias', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('weight', 5, 2);  // Weight in percentage (e.g., 15.5 for 15.5%)
            $table->enum('type', ['cost', 'benefit']);  // Cost = smaller is better, Benefit = larger is better
            $table->enum('input_type', ['number', 'options']);  // Type of input: number or predefined options
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criterias');
    }
};
