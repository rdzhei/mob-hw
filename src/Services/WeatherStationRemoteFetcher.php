<?php
declare(strict_types=1);
namespace App\Services;

use App\DTO\WeatherStation;
use App\Environment\EnvProviderInterface;
use App\DTO\WeatherStationIdName;
use App\Exceptions\RemoteApi\CSVException;
use App\Utils\Factories\WeatherStationFactory;
use App\Utils\Http\HttpClient;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


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
                $this->validateHeader($headers);

                continue;
            }

            $combinedStationRow = array_combine($headers, $chunk);

            $weatherStations[] = $this->weatherStationFactory
                ->makeWeatherStationIdNameStructFromCsv($combinedStationRow);
        }

        return $weatherStations;
    }

    public function getWeatherStation(string $id): ?WeatherStation
    {
        $res = $this->client->queryForCsv(
            'GET',
            $this->envProvider->getEnv(self::WEATHER_STATION_URL_API_ENV)
        );

        $headers = [];
        foreach ($res as $i => $chunk) {
            if ($i === 0) {
                $headers = $chunk;
                $this->validateHeader($headers);

                continue;
            }

            $combinedStationRow = array_combine($headers, $chunk);

            if ($combinedStationRow[WeatherStationFactory::ID_KEY] !== $id) {
                continue;
            }

            // It's possible to skip the hassle of building a DTO, and return a
            // dirty array to the client. Returning whatever we receive would
            // also safeguard us in cases if the remote API unexpectedly changes.
            // However, in that case it's senseless to make an OA schema (which
            // is a requirement of this task), because the OA schema would be unreliable.
            return $this->weatherStationFactory
                ->makeWeatherStationDTOFromCsv($combinedStationRow);
        }

        return null;
    }

    private function validateHeader(array $header): void
    {

        if (
            ! in_array(WeatherStationFactory::ID_KEY, $header)
            ||
            ! in_array(WeatherStationFactory::NAME_KEY, $header)
        ) {
            // todo: log this error with the nastiest error level.
            // We cannot return a valid DTO with at least id and name

            throw new CSVException('Unexpected error', 500);
        }
    }
}
