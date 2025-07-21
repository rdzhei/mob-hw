<?php
declare(strict_types=1);

namespace App\Services;

use App\DTO\WeatherStationIdName;

interface WeatherStationProviderInterface
{

    /** @return WeatherStationIdName[] */
    public function getAllWeatherStationIdNames(): array;


    public function getWeatherStation(string $id);
}
