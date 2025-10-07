<?php

namespace App\Filament\Widgets;

//use App\Models\Hardware;
//use App\Models\Periphel;
//use App\Models\Provaider;
//use App\Models\Software;
//use App\Models\Infra;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 6;

    public bool $readyToLoad = false;

    public function loadData(): void
    {
        $this->readyToLoad = true;
    }

    protected function getCards(): array
    {
        if (! $this->readyToLoad) {
            return $this->getSkeletonLoad();
        }

       // $hardwares = Hardware::count();
        //$softwares = Software::count();
        //$provaiders = Provaider::count();
        //$periphels = Periphel::count();
       // $infras = Infra::count();

        return [
          //  Card::make('Hardware', $hardwares),
           // Card::make('Software', $softwares),
            //Card::make('Provaiders', $provaiders),
            //Card::make('Periphels', $periphels),
           // Card::make('Infra', $infras),
        ];
    }

    protected function getSkeletonLoad(): array
    {
        return [
         //   Card::make('Hardware', 'Loading...'),
           // Card::make('Software', 'Loading...'),
            //Card::make('Provaiders', 'Loading...'),
            //Card::make('Periphels', 'Loading...'),
           // Card::make('Infra', 'Loading...'),
        ];
    }
}
