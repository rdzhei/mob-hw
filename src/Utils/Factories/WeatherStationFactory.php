<?php
declare(strict_types=1);

namespace App\Utils\Factories;

use App\DTO\WeatherStation;
use App\DTO\WeatherStationIdName;

class WeatherStationFactory
{

    public const ID_KEY = 'STATION_ID';
    public const NAME_KEY = 'NAME';

    /**
     * Trash in, DTO out.
     *
     * @param array $combinedStationRow
     * @return WeatherStationIdName
     */
    public function makeWeatherStationIdNameStructFromCsv(
        array $combinedStationRow,
    ): WeatherStationIdName {

        return new WeatherStationIdName(
            STATION_ID: $combinedStationRow[self::ID_KEY],
            NAME: $combinedStationRow[self::NAME_KEY]
        );
    }

    public function makeWeatherStationDTOFromCsv(
        array $combinedStationRow,
    ): WeatherStation {

        return new WeatherStation(
            STATION_ID: $combinedStationRow[self::ID_KEY],
            NAME: $combinedStationRow[self::NAME_KEY],
            WMO_ID: $combinedStationRow['WMO_ID'] ?? null,
            BEGIN_DATE: $combinedStationRow['BEGIN_DATE'] ?? null,
            END_DATE: $combinedStationRow['END_DATE'] ?? null,
            LATITUDE: $combinedStationRow['LATITUDE'] ?? null,
            LONGITUDE: $combinedStationRow['LONGITUDE'] ?? null,
            GAUSS1: $combinedStationRow['GAUSS1'] ?? null,
            GAUSS2: $combinedStationRow['GAUSS2'] ?? null,
            GEOGR1: $combinedStationRow['GEOGR1'] ?? null,
            GEOGR2: $combinedStationRow['GEOGR2'] ?? null,
            ELEVATION: $combinedStationRow['ELEVATION'] ?? null,
            ELEVATION_PRESSURE: $combinedStationRow['ELEVATION_PRESSURE'] ?? null,
        );
    }
}
