<?php

declare(strict_types=1);

namespace Azexsoft\Auth;

final class PasswordHasher implements PasswordHasherInterface
{
    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
