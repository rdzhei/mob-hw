<?php
declare(strict_types=1);

namespace App\Utils\Factories;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class GuzzleRequestFactory implements RequestFactoryInterface
{

    public function makeRequest(
        string $method,
        string $url,
        array $headers = [],
    ): RequestInterface {

        return new Request(
            method: $method,
            uri: $url,
            headers: $headers
        );
    }
}
