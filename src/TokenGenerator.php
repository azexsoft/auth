<?php

declare(strict_types=1);

namespace Azexsoft\Auth;

use Exception;
use RuntimeException;

final class TokenGenerator implements TokenGeneratorInterface
{
    public function generateToken(): string
    {
        try {
            return bin2hex(random_bytes(64));
        } catch (Exception $exception) {
            throw new RuntimeException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
