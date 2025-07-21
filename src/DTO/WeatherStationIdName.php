<?php
declare(strict_types=1);

namespace App\DTO;

use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema(
    type: 'object',
    title: 'Weather Station ID and Name',
    description: 'Represents a weather station with its ID and name.',
)]
class WeatherStationIdName
{
    public function __construct(
        #[Property(
            description: 'The unique identifier of the weather station.',
            example: 'KALNCIEM'
        )]
        public string $STATION_ID,
        #[Property(
            description: 'The name of the weather station.',
            example: 'Kuldiga'
        )]
        public string $NAME,
    ) {
    }


}
