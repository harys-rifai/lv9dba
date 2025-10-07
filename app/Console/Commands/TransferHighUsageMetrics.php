<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SystemMetric;
use Illuminate\Support\Facades\DB;

class TransferHighUsageMetrics extends Command
{
    protected $signature = 'metrics:transfer-high-usage';
    protected $description = 'Transfer data dari dbapru ke dba_user jika CPU atau RAM melebihi threshold';

    public function handle()
    {
        $thresholdCpu = 80;
        $thresholdRam = 80;

        $data = SystemMetric::where('cpu_usage', '>', $thresholdCpu)
            ->orWhere('memory_usage', '>', $thresholdRam)
            ->get();

        foreach ($data as $row) {
            DB::connection('pgsql')->table('filtered_metrics')->insert([
                'timestamp' => $row->timestamp,
                'hostname' => $row->hostname,
                'environment' => $row->environment,
                'cpu_usage' => $row->cpu_usage,
                'memory_usage' => $row->memory_usage,
                'status' => $row->status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->info("Data berhasil ditransfer: " . $data->count() . " baris.");
    }
}