<?php
declare(strict_types=1);

namespace App\EventListener;

use App\Environment\EnvProviderInterface;
use App\Utils\Response\ResponseFactoryInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
class BearerTokenAuth
{
    public const AUTH_TOKEN_PARAM_KEY = 'app.auth-token';

    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly EnvProviderInterface $envProvider,
    ) {
    }

    // In a real world my weapon of choice would instead be a JWT Bearer
    // token as it allows more flexibility && allows servicing
    // multiple different clients with different tokens.
    // But here I'm going to save time and go with a simple preshared token auth.
    public function onKernelRequest(RequestEvent $event): void
    {

        $request = $event->getRequest();

        $authHeader = $request->headers->get('Authorization');

        if (!$authHeader || $authHeader !== $this->envProvider->getEnv(self::AUTH_TOKEN_PARAM_KEY)) {

            $event->setResponse($this->responseFactory->createUnauthorizedResponse());

        }

    }

}
