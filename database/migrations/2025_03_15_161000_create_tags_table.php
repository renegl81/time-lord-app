<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color', 7)->nullable();
            $table->foreignId('workspace_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['name', 'workspace_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
