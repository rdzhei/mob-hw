<?php
declare(strict_types=1);

namespace App\Utils\Factories;

use Symfony\Component\HttpFoundation\Response;

class ResponseFactory implements ResponseFactoryInterface
{

    // In an ideal world I would like to instead return a PSR-7 compliant
    // ResponseInterface, but Symfony's Event Listener requires specifically
    // Symfony's Response class, which doesn't implement ResponseInterface. :(
    // I could, of course extend Symfony's Response class and then implement
    // ResponseInterface in the child, but that would be a bit of an overkill for this task
    public function createUnauthorizedResponse(): Response
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

    public function createSuccessfulDataResponse(
        array $data = [],
        int $status = Response::HTTP_OK,
        array $headers = [],
    ): Response {

        $headers['Content-Type'] = 'application/json';

        return new Response(
            content: json_encode([
                'success' => true,
                'data' => $data
            ]),
            status: $status,
            headers: $headers
        );
    }
}
