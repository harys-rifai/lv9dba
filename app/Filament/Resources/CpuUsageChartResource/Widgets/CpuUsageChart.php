<?php

namespace App\Filament\Resources\CpuUsageChartResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use App\Models\FilteredMetric;

class CpuUsageChart extends ChartWidget
{
    protected static ?string $heading = 'CPU Usage by DBNAME';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'yesterday' => 'Yesterday',
            'this_week' => 'This Week',
            'last_7_days' => 'Last 7 Days',
            'this_month' => 'This Month',
            'last_30_days' => 'Last 30 Days',
            'last_month' => 'Last Month',
        ];
    }

    protected function getData(): array
    {
        $filter = $this->filter ?? 'today';

        switch ($filter) {
            case 'yesterday':
                $endTime = now()->subDay()->endOfDay();
                break;
            case 'this_week':
            case 'last_7_days':
            case 'this_month':
            case 'last_30_days':
                $endTime = now();
                break;
            case 'last_month':
                $endTime = now()->subMonth()->endOfMonth();
                break;
            case 'today':
            default:
                $endTime = now();
                break;
        }

        $startTime = $endTime->copy()->subHours(4);

        $metrics = DB::table('system_metrics')
            ->whereBetween('timestamp', [$startTime, $endTime])
            ->orderByDesc('timestamp')
            ->limit(1000)
            ->get()
            ->groupBy('environment');

        $labels = collect();
        $datasets = [];

        foreach ($metrics as $env => $records) {
            $cpuData = [];

            foreach ($records->sortBy('timestamp') as $record) {
                $labels->push(date('H:i', strtotime($record->timestamp)));
                $cpuData[] = floatval(str_replace('%', '', $record->cpu_usage));
            }

            $color = FilteredMetric::getEnvironmentColor($env) ?? 'rgba(128, 128, 128, 0.5)';

            $datasets[] = [
                'label' => $env,
                'data' => $cpuData,
                'borderColor' => $color,
                'borderWidth' => 1,
                'fill' => false,
                'pointRadius' => 3,
                'pointStyle' => 'circle',
                'pointBackgroundColor' => $color,
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $labels->unique()->values(),
        ];
    }
     public function loadData(): void
    {
        // Tidak perlu isi apa-apa jika hanya ingin trigger render ulang
    }
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'labels' => [
                        'usePointStyle' => true,
                        'pointStyle' => 'circle',
                    ],
                ],
            ],
        ];
    }

    protected function getPollingInterval(): ?string
    {
        return '20s'; // Auto-refresh every 60 seconds
    }
}