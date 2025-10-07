<?php

namespace App\Filament\Widgets;

use App\Actions\Trend;
use App\Models\Periphel;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\TrendValue;

class PeriphelsChart extends LineChartWidget
{
    protected static ?string $heading = 'One Day Periperal';

    protected static ?int $sort = 7;

    public ?string $filter = 'this_year'; // Bisa: this_year, this_month

    public bool $readyToLoad = false;

    protected int|string|array $columnSpan = 'full';

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

        $publishedData = Trend::model(Periphel::class)
            ->filterBy($activeFilter)
            ->count();

        $purchasedData = Trend::model(Periphel::class)
            ->filterBy($activeFilter)
            ->count('purchased_at');

        return [
            'datasets' => [
                [
                    'label' => 'Periphel Publish',
                    'data' => $publishedData->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(255, 205, 86, 0.2)',
                    'borderColor' => 'rgb(255, 205, 86)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Purchased',
                    'data' => $purchasedData->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgb(75, 192, 192)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $publishedData->map(fn (TrendValue $value) => $value->date),
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
                    'label' => 'Loading publish data...',
                    'data' => [],
                    'backgroundColor' => 'rgba(255, 205, 86, 0.2)',
                    'borderColor' => 'rgb(255, 205, 86)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Loading purchased data...',
                    'data' => [],
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgb(75, 192, 192)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => [],
        ];
    }
}
