<?php
declare(strict_types=1);

namespace App\Environment;

interface EnvProviderInterface
{

    // practically returns strings, it's on dev to cast them as necessary
    public function getEnv(string $key): string;

}
