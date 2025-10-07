<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSystemMetricsTable extends Migration
{
    public function up(): void
    {
        // Create the main partitioned table
        DB::statement(<<<SQL
            CREATE TABLE IF NOT EXISTS public.system_metrics (
                "timestamp" timestamp(6) without time zone NOT NULL,
                hostname varchar(50) NOT NULL,
                environment varchar(50) NOT NULL,
                cpu_usage text,
                memory_usage text,
                disk_usage text,
                network_usage text,
                status varchar(150) NOT NULL,
                extra1 varchar(150) NOT NULL,
                extra2 varchar(150) NOT NULL,
                file_name varchar(150) NOT NULL,
                load_status varchar(150) NOT NULL,
                pgver text
            ) PARTITION BY RANGE ("timestamp");
        SQL);


        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2025_q1 PARTITION OF system_metrics
            FOR VALUES FROM ('2025-01-01') TO ('2025-04-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2025_q2 PARTITION OF system_metrics
            FOR VALUES FROM ('2025-04-01') TO ('2025-07-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2025_q3 PARTITION OF system_metrics
            FOR VALUES FROM ('2025-07-01') TO ('2025-10-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2025_q4 PARTITION OF system_metrics
            FOR VALUES FROM ('2025-10-01') TO ('2026-01-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2026_q1 PARTITION OF system_metrics
            FOR VALUES FROM ('2026-01-01') TO ('2026-04-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2026_q2 PARTITION OF system_metrics
            FOR VALUES FROM ('2026-04-01') TO ('2026-07-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2026_q3 PARTITION OF system_metrics
            FOR VALUES FROM ('2026-07-01') TO ('2026-10-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2026_q4 PARTITION OF system_metrics
            FOR VALUES FROM ('2026-10-01') TO ('2027-01-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2027_q1 PARTITION OF system_metrics
            FOR VALUES FROM ('2027-01-01') TO ('2027-04-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2027_q2 PARTITION OF system_metrics
            FOR VALUES FROM ('2027-04-01') TO ('2027-07-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2027_q3 PARTITION OF system_metrics
            FOR VALUES FROM ('2027-07-01') TO ('2027-10-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2027_q4 PARTITION OF system_metrics
            FOR VALUES FROM ('2027-10-01') TO ('2028-01-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2028_q1 PARTITION OF system_metrics
            FOR VALUES FROM ('2028-01-01') TO ('2028-04-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2028_q2 PARTITION OF system_metrics
            FOR VALUES FROM ('2028-04-01') TO ('2028-07-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2028_q3 PARTITION OF system_metrics
            FOR VALUES FROM ('2028-07-01') TO ('2028-10-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2028_q4 PARTITION OF system_metrics
            FOR VALUES FROM ('2028-10-01') TO ('2029-01-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2029_q1 PARTITION OF system_metrics
            FOR VALUES FROM ('2029-01-01') TO ('2029-04-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2029_q2 PARTITION OF system_metrics
            FOR VALUES FROM ('2029-04-01') TO ('2029-07-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2029_q3 PARTITION OF system_metrics
            FOR VALUES FROM ('2029-07-01') TO ('2029-10-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2029_q4 PARTITION OF system_metrics
            FOR VALUES FROM ('2029-10-01') TO ('2030-01-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2030_q1 PARTITION OF system_metrics
            FOR VALUES FROM ('2030-01-01') TO ('2030-04-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2030_q2 PARTITION OF system_metrics
            FOR VALUES FROM ('2030-04-01') TO ('2030-07-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2030_q3 PARTITION OF system_metrics
            FOR VALUES FROM ('2030-07-01') TO ('2030-10-01');
        SQL);

        DB::statement(<<<SQL
            CREATE TABLE system_metrics_2030_q4 PARTITION OF system_metrics
            FOR VALUES FROM ('2030-10-01') TO ('2031-01-01');
        SQL);

    }

    public function down(): void
    {
        DB::statement("DROP TABLE IF EXISTS public.system_metrics CASCADE;");
    }
}
