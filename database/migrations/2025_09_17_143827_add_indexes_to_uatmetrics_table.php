<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration {
    public function up(): void
    {
        Schema::table('uatmetrics', function (Blueprint $table) {
            $table->index('timestamp', 'idx_uatmetrics_timestamp');
            $table->index('Hostname', 'idx_uatmetrics_hostname');
            $table->index('IP_Address', 'idx_uatmetrics_ip_address');
            $table->index('Database', 'idx_uatmetrics_database');
            $table->index('CPU', 'idx_uatmetrics_cpu');
            $table->index('Memory', 'idx_uatmetrics_memory');
            $table->index('DiskVolGroupAvg', 'idx_uatmetrics_diskvolgroupavg');
            $table->index('DiskDataAvg', 'idx_uatmetrics_diskdataavg');
            $table->index('ServerStatus', 'idx_uatmetrics_serverstatus');
            $table->index('LongQueryCount', 'idx_uatmetrics_longquerycount');
            $table->index('IdleInQ', 'idx_uatmetrics_idleinQ');
            $table->index('LockingCount', 'idx_uatmetrics_lockingcount');
            $table->index('PostgresVersion', 'idx_uatmetrics_postgresversion');
            $table->index('flag', 'idx_uatmetrics_flag');
            $table->index('state', 'idx_uatmetrics_state');
            $table->index('created_at', 'idx_uatmetrics_created_at');
            $table->index('updated_at', 'idx_uatmetrics_updated_at');
        });
    }

    public function down(): void
    {
        Schema::table('uatmetrics', function (Blueprint $table) {
            $table->dropIndex('idx_uatmetrics_timestamp');
            $table->dropIndex('idx_uatmetrics_hostname');
            $table->dropIndex('idx_uatmetrics_ip_address');
            $table->dropIndex('idx_uatmetrics_database');
            $table->dropIndex('idx_uatmetrics_cpu');
            $table->dropIndex('idx_uatmetrics_memory');
            $table->dropIndex('idx_uatmetrics_diskvolgroupavg');
            $table->dropIndex('idx_uatmetrics_diskdataavg');
            $table->dropIndex('idx_uatmetrics_serverstatus');
            $table->dropIndex('idx_uatmetrics_longquerycount');
            $table->dropIndex('idx_uatmetrics_idleinQ');
            $table->dropIndex('idx_uatmetrics_lockingcount');
            $table->dropIndex('idx_uatmetrics_postgresversion');
            $table->dropIndex('idx_uatmetrics_flag');
            $table->dropIndex('idx_uatmetrics_state');
            $table->dropIndex('idx_uatmetrics_created_at');
            $table->dropIndex('idx_uatmetrics_updated_at');
        });
    }
};
