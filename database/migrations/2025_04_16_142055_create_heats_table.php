<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devices.heats', function (Blueprint $table) {
            $table->id();
            $table->string('ieee_address', 18)->unique();
            $table->string('friendly_name', 70)->unique();
            $table->float('energy')->nullable();
            $table->string('keypad_lockout')->nullable();
            $table->integer('linkquality')->nullable();
            $table->integer('local_temperature')->nullable();
            $table->integer('occupied_heating_setpoint')->nullable();
            $table->integer('pi_heating_demand')->nullable();
            $table->integer('power')->nullable();
            $table->string('running_state')->nullable();
            $table->string('system_mode')->nullable();
            $table->string('temperature_display_mode')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices.heats');
    }
};
