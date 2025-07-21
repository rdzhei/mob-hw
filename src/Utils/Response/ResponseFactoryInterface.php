<?php
declare(strict_types=1);

namespace App\Utils\Response;

use Psr\Http\Message\ResponseInterface;

interface ResponseFactoryInterface
{
    public function createUnauthorizedResponse(): ResponseInterface;

}
