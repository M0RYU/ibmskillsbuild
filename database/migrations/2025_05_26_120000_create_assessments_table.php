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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alternative_id')->constrained()->onDelete('cascade');
            $table->foreignId('criteria_id')->constrained('criterias')->onDelete('cascade');
            $table->decimal('value', 10, 2)->nullable(); // For number-type criteria
            $table->unsignedBigInteger('criteria_option_id')->nullable();
            $table->timestamps();
            
            // Ensure each alternative is only assessed once per criteria
            $table->unique(['alternative_id', 'criteria_id']);
            
            // Add foreign key for criteria_option_id
            $table->foreign('criteria_option_id')
                  ->references('id')
                  ->on('criteria_options')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
