<?php
declare(strict_types=1);

namespace App\Utils\Response;

use Symfony\Component\HttpFoundation\Response;

interface ResponseFactoryInterface
{

    // In an ideal world I would like to instead return a PSR-7 compliant
    // ResponseInterface, but Symfony's Event Listener requires specifically
    // Symfony's Response class, which doesn't implement ResponseInterface. :(
    // I could, of course extend Symfony's Response class and then implement
    // ResponseInterface in the child, but that would be a bit of an overkill for this task
    public function createUnauthorizedResponse(): Response;

}
