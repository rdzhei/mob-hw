<?php
declare(strict_types=1);

namespace App\Tests\Mock\Http;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class MockHttpClient implements ClientInterface
{

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return new Response(
            status: 200,
            headers: [],
            body: file_get_contents(__DIR__ . '/MockResponseBody.csv')
        );
    }
}
