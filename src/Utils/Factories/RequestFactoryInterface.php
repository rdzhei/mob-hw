<?php
declare(strict_types=1);

namespace App\Utils\Factories;

use Psr\Http\Message\RequestInterface;

interface RequestFactoryInterface
{
    public function makeRequest(
        string $method,
        string $url,
        array $headers = [],
    ): RequestInterface;
}
