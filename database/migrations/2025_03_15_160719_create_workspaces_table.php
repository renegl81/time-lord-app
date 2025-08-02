<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workspaces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->string('currency')->default('EUR');
            $table->json('settings')->default(json_encode([
                'timeTracking' => [
                    'timeFormat' => '24h',
                    'firstDayOfWeek' => 1, // Lunes
                    'minimumEntryDuration' => 0, // En minutos
                    'roundingInterval' => 0, // En minutos (0 = sin redondeo)
                    'allowOverlap' => false,
                    'trackIdle' => true,
                ],
                'display' => [
                    'dateFormat' => 'DD/MM/YYYY',
                    'timezone' => 'Europe/Madrid',
                ],
                'billing' => [
                    'defaultTaxRate' => 21.0, // IVA España
                    'roundToNearestMinute' => 15,
                    'automaticReminders' => true,
                ],
                'permissions' => [
                    'whoCanSeeRates' => 'admins',
                    'whoCanSeeEarnings' => 'admins',
                    'projectVisibilityDefault' => 'public',
                ],
                'notifications' => [
                    'reminderToTrackTime' => true,
                    'dailySummary' => false,
                    'weeklySummary' => true,
                ],
            ]));
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workspaces');
    }
};
