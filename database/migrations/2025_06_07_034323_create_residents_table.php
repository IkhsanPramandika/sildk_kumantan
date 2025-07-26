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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('family_card_number', 16);
            $table->string('full_name');
            $table->text('address');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->string('hamlet', 50)->nullable();
            $table->string('birth_place');
            $table->date('birth_date');
            $table->enum('gender', ['male', 'female']);
            $table->enum('religion', ['islam', 'christian', 'catholic', 'hindu', 'buddhist', 'confucian', 'other']);
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']);
            $table->string('occupation', 100)->nullable();
            $table->enum('last_education', ['none', 'elementary', 'junior_high', 'senior_high', 'd1', 'd2', 'd3', 's1', 's2', 's3']);
            $table->enum('blood_type', ['A', 'B', 'AB', 'O', 'Unknown']);
            $table->enum('citizenship', ['wni', 'wna'])->default('wni');
            $table->enum('life_status', ['alive', 'deceased'])->default('alive');
            $table->string('mother_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('family_relationship_status', 50)->nullable();
            $table->string('disability_type', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
