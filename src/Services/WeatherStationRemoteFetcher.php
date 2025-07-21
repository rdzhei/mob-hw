<?php
declare(strict_types=1);
namespace App\Services;

use App\Environment\EnvProviderInterface;
use App\DTO\WeatherStationIdName;
use App\Utils\Factories\WeatherStationFactory;
use App\Utils\Http\HttpClient;


/**
 * Implementation of WeatherStationProviderInterface.
 * In case we don't want fetch data from remote API anymore,
 * replace this implementation with one that looks into DB or elsewhere
 */
class WeatherStationRemoteFetcher implements WeatherStationProviderInterface
{

    public const WEATHER_STATION_URL_API_ENV = 'app.weather_station_api_url';
    public function __construct(
        private readonly HttpClient $client,
        private readonly EnvProviderInterface $envProvider,
        private readonly WeatherStationFactory $weatherStationFactory,

    ) {
    }

    /** @return WeatherStationIdName[] */
    public function getAllWeatherStationIdNames(): array
    {
        // generator "promise"
        $res = $this->client->queryForCsv(
            'GET',
            $this->envProvider->getEnv(self::WEATHER_STATION_URL_API_ENV)
        );

        $weatherStations = [];
        $headers = [];
        foreach ($res as $i => $chunk) {

            if ($i === 0) {
                $headers = $chunk;

                continue;
            }

            $weatherStations[] = $this->weatherStationFactory
                ->makeWeatherStationIdNameStructFromCsv($chunk, $headers);
        }

        return $weatherStations;
    }

    public function getWeatherStation(string $id)
    {
        // TODO: Implement getWeatherStation() method.
    }
}
