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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('complaint_number')->unique();
            $table->foreignId('resident_id')->constrained('residents')->onDelete('cascade');
            $table->enum('category', ['infrastructure', 'service', 'social', 'economy', 'other'])->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['received', 'in_progress', 'completed', 'rejected'])->default('received')->nullable();
            $table->timestamp('response_date')->nullable();
            $table->text('response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
