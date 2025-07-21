<?php
declare(strict_types=1);

namespace App\Utils\Response;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class ResponseFactory implements ResponseFactoryInterface
{

    public function createUnauthorizedResponse(): ResponseInterface
    {
        return new Response(
            content: json_encode([
                'success' => false,
                'message' => 'Unauthorized'
            ]),
            status: Response::HTTP_UNAUTHORIZED,
            headers: ['Content-Type' => 'application/json']
        );
    }
}
