<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('CREATE INDEX filtered_metrics_timestamp_idx ON filtered_metrics USING btree (timestamp)');
        DB::statement('CREATE INDEX filtered_metrics_hostname_idx ON filtered_metrics USING btree (hostname)');
        DB::statement('CREATE INDEX filtered_metrics_environment_idx ON filtered_metrics USING btree (environment)');
        DB::statement('CREATE INDEX filtered_metrics_cpu_usage_idx ON filtered_metrics USING btree (cpu_usage)');
        DB::statement('CREATE INDEX filtered_metrics_memory_usage_idx ON filtered_metrics USING btree (memory_usage)');
        DB::statement('CREATE INDEX filtered_metrics_status_idx ON filtered_metrics USING btree (status)');
    }

    public function down(): void
    {
        DB::statement('DROP INDEX IF EXISTS filtered_metrics_timestamp_idx');
        DB::statement('DROP INDEX IF EXISTS filtered_metrics_hostname_idx');
        DB::statement('DROP INDEX IF EXISTS filtered_metrics_environment_idx');
        DB::statement('DROP INDEX IF EXISTS filtered_metrics_cpu_usage_idx');
        DB::statement('DROP INDEX IF EXISTS filtered_metrics_memory_usage_idx');
        DB::statement('DROP INDEX IF EXISTS filtered_metrics_status_idx');
    }
};