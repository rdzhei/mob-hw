<?php
declare(strict_types=1);

namespace App\Tests\Unit;

use PHPUnit\Framework\Assert;
use App\Utils\Http\HttpClient;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HttpTest extends KernelTestCase
{

    public function testShouldProcessCsvResponse(): void
    {
        // (1) boot the Symfony kernel
        self::bootKernel([
            'environment' => 'test',
        ]);

        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();

        /** @var HttpClient $httpClient */
        $httpClient = $container->get(HttpClient::class);

        $res = $httpClient->queryForCsv('GET', 'https://example.com');

        $fullRes = [];
        foreach ($res as $i => $chunk) {
            $fullRes[] = $chunk;
        }

        Assert::assertEquals(3, count($fullRes));
        Assert::assertEquals(['STATION_ID', 'NAME', 'LATITUDE'], $fullRes[0]);
        Assert::assertEquals(['KALNCIEM', 'Kalnciems', '56.9667'], $fullRes[1]);
        Assert::assertEquals(['KULDIGA', 'Kuldīga', '56.111'], $fullRes[2]);


    }
}
