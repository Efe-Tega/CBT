<?php

use App\Models\School;
use App\Models\Teacher;
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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->references('id')->on('classes');
            $table->foreignIdFor(School::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Teacher::class)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('code', 20)->unique()->nullable();
            $table->integer('duration')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
