<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Training schedule was previously stored as a flat key-value object:
 *   {"days": "Onsdag, Lørdag", "time": "10:30 – 12:00", "location": "Byparken"}
 *
 * It is now stored as an array of session objects:
 *   [{"day": "wednesday", "time": "10:30 – 12:00", "location": "Byparken"}]
 *
 * Old-format records are reset to an empty array so the Filament Repeater
 * doesn't try to render them. Admins will re-enter training schedules.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('age_groups')
            ->whereNotNull('training_schedule')
            ->get(['id', 'training_schedule'])
            ->each(function ($row) {
                $data = json_decode($row->training_schedule, true);

                // New format: indexed array of objects with a 'day' key
                // Old format: associative array (has string keys like 'days', 'time', 'location')
                $isNewFormat = is_array($data)
                    && array_is_list($data)
                    && !empty($data)
                    && isset($data[0]['day']);

                if (! $isNewFormat) {
                    DB::table('age_groups')
                        ->where('id', $row->id)
                        ->update(['training_schedule' => json_encode([])]);
                }
            });
    }

    public function down(): void
    {
        // Non-reversible — old free-text data cannot be recovered
    }
};
