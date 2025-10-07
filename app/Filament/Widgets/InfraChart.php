<?php

namespace App\Filament\Widgets;

use App\Actions\Trend;
use App\Models\Infra;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\TrendValue;

class InfraChart extends LineChartWidget
{
    protected static ?string $heading = 'Infra';

    protected static ?int $sort = 7;

    public ?string $filter = 'this_year';

    public bool $readyToLoad = false;

    public function loadData(): void
    {
        $this->readyToLoad = true;
    }

    protected function getData(): array
    {
        if (! $this->readyToLoad) {
            return $this->getSkeletonLoad();
        }

        $activeFilter = $this->filter;

        $data = Trend::model(Infra::class)
            ->filterBy($activeFilter)
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Infra Publish',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(255, 205, 86, 0.2)',
                    'borderColor' => 'rgb(255, 205, 86)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getFilters(): ?array
    {
        return Trend::filterType();
    }

    private function getSkeletonLoad(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Loading data...',
                    'data' => [],
                    'backgroundColor' => 'rgba(201, 203, 207, 0.2)',
                    'borderColor' => 'rgb(201, 203, 207)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => [],
        ];
    }
}
