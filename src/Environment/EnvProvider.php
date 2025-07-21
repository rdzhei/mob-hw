<?php
declare(strict_types=1);

namespace App\Environment;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class EnvProvider implements EnvProviderInterface
{

    public function __construct(
        private readonly ParameterBagInterface $parameterBag,
    ) {
    }

    public function getEnv(string $key): string
    {
        try {
            return $this->parameterBag->get($key);
        } catch (\Throwable) {
            return '';
        }
    }
}
