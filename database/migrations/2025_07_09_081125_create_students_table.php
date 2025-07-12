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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('unit', ['TK', 'SD', 'SMP', 'SMK']);
            // $table->string('nis')->unique();
            $table->date('birth');
            $table->string('gender');
            $table->string('parent_number');
            $table->string('other_parent_number')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('identifier')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
