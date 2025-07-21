<?php
declare(strict_types=1);

namespace App\DTO;

class WeatherStation
{

    public function __construct(
        public string $STATION_ID,
        public string $NAME,
        public ?string $WMO_ID,
        // consider using DateTime
        public ?string $BEGIN_DATE,
        public ?string $END_DATE,
        public ?string $LATITUDE,
        public ?string $LONGITUDE,
        public ?string $GAUSS1,
        public ?string $GAUSS2,
        public ?string $GEOGR1,
        public ?string $GEOGR2,
        public ?string $ELEVATION,
        public ?string $ELEVATION_PRESSURE,
    ) {
    }
}
