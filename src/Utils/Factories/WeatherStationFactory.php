<?php
declare(strict_types=1);

namespace App\Utils\Factories;

use App\Exceptions\RemoteApi\CSVException;
use App\DTO\WeatherStationIdName;

class WeatherStationFactory
{

    // mandatory keys
    public const ID_KEY = 'STATION_ID';
    public const NAME_KEY = 'NAME';


    /**
     * Trash in, DTO out.
     *
     * @param array $chunk
     * @param array $headerNames
     * @return WeatherStationIdName
     */
    public function makeWeatherStationIdNameStructFromCsv(
        array $chunk,
        array $headerNames
    ): WeatherStationIdName {

        $combinedStationRow = array_combine($headerNames, $chunk);

        if (
            ! isset($combinedStationRow[self::ID_KEY])
            ||
            ! isset($combinedStationRow[self::NAME_KEY])
        ) {
            // todo log this error with the nastiest error level.
            // We cannot return a valid DTO with at least id and name

            throw new CSVException('Unexpected error', 500);
        }

        return new WeatherStationIdName(
            Station_id: $combinedStationRow[self::ID_KEY],
            Name: $combinedStationRow[self::NAME_KEY]
        );
    }
}
