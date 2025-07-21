<?php
declare(strict_types=1);

namespace App\DTO;

use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema(type:'object')]
class WeatherStation
{

    public function __construct(
        #[Property(example: 'KALNCIEM')]
        public string $STATION_ID,
        #[Property()]
        public string $NAME,
        #[Property()]
        public ?string $WMO_ID,
        // consider using DateTime
        #[Property()]
        public ?string $BEGIN_DATE,
        #[Property()]
        public ?string $END_DATE,
        #[Property()]
        public ?string $LATITUDE,
        #[Property()]
        public ?string $LONGITUDE,
        #[Property()]
        public ?string $GAUSS1,
        #[Property()]
        public ?string $GAUSS2,
        #[Property()]
        public ?string $GEOGR1,
        #[Property()]
        public ?string $GEOGR2,
        #[Property()]
        public ?string $ELEVATION,
        #[Property()]
        public ?string $ELEVATION_PRESSURE,
    ) {
    }
}
