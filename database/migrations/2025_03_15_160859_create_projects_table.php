<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('client_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('workspace_id')->constrained()->onDelete('cascade');
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->integer('estimate')->nullable(); // en minutos
            $table->decimal('budget', 12, 2)->nullable();
            $table->string('color', 7)->nullable();
            $table->boolean('is_billable')->default(true);
            $table->boolean('is_public')->default(true);
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
