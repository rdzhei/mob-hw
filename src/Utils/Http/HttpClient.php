<?php
declare(strict_types=1);

namespace App\Utils\Http;

use App\Utils\Factories\RequestFactoryInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Client\ClientInterface;

class HttpClient
{

    public const RESPONSE_CHUNK_SIZE = 4096;

    public function __construct(
        private readonly ClientInterface $httpClient,
        private readonly RequestFactoryInterface $requestFactory,
    ) {

    }

    /**
     * Yields CSV rows as arrays
     *
     * @param string $method
     * @param string $url
     * @param array $headers
     * @return \Generator
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function queryForCsv(string $method, string $url, array $headers = []): \Generator
    {
        $request = $this->requestFactory->makeRequest($method, $url, $headers);

        try {
            $res = $this->httpClient->sendRequest($request);

            $stream = $res->getBody();

            // Obviously, streaming a 5kb-sized response is an overkill. I am simply showing off.
            // But seriously though - if the remote API returns a nice CSV,
            // it almost invites you to stream / chunk it.
            $buffer = '';
            while (! $stream->eof()) {
                $buffer .= str_replace("\u{FEFF}", '', $stream->read(self::RESPONSE_CHUNK_SIZE));

                while (($pos = strpos($buffer, "\n")) !== false) {
                    $row = substr($buffer, 0, $pos);
                    $buffer = substr($buffer, $pos + 1);

                    yield str_getcsv($row);
                }
            }

            if (!empty($buffer)) {
                yield str_getcsv($buffer);
            }

        } catch (GuzzleException $exception) {
            // todo: log the exception and context: $url, $method, $headers

        }

    }
}

