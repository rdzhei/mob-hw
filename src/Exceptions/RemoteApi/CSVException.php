<?php
declare(strict_types=1);

namespace App\Exceptions\RemoteApi;

class CSVException extends \RuntimeException
{
    public function __construct(
        string $message = 'CSV processing error',
        int $code = 500,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
