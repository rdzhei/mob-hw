<?php
declare(strict_types=1);

namespace App\DTO;

class WeatherStationIdName
{
    public function __construct(
        public string $Station_id,
        public string $Name,
    ) {
    }


}
