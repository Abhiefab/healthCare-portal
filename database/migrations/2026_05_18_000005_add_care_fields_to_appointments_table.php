<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dateTime('reschedule_requested_at')->nullable()->after('appointment_at');
            $table->text('reschedule_reason')->nullable()->after('reason');
            $table->text('prescription')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'reschedule_requested_at',
                'reschedule_reason',
                'prescription',
            ]);
        });
    }
};
