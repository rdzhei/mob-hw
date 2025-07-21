<?php
declare(strict_types=1);

namespace App\Tests\Unit;

use App\Utils\Factories\WeatherStationFactory;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class WeatherStationFactoryTest extends KernelTestCase
{


    public function testShouldCreateWeatherStationIfParamsMissingOrShuffled(): void
    {
        // (1) boot the Symfony kernel
        self::bootKernel([
            'environment' => 'test',
        ]);

        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();

        $combinedWeatherStationRow = [
            'NAME' => 'Kuldīga',
            'WMO_ID' => '123',
            'STATION_ID' => 'KULDIG',
        ];

        /** @var WeatherStationFactory $weatherStationFactory */
        $weatherStationFactory = $container->get(WeatherStationFactory::class);

        $weatherStation = $weatherStationFactory->makeWeatherStationDTOFromCsv($combinedWeatherStationRow);

        //if it didn't fail and crash and burn, we're already somewhat good

        Assert::assertNotNull($weatherStation);
        Assert::assertEquals($combinedWeatherStationRow['STATION_ID'], $weatherStation->STATION_ID);
        Assert::assertEquals($combinedWeatherStationRow['NAME'], $weatherStation->NAME);
        Assert::assertNull($weatherStation->LATITUDE);
    }
}
