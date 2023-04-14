<?php

declare(strict_types=1);

namespace Azexsoft\Auth;

interface PasswordHasherInterface
{
    public function hashPassword(string $password): string;

    public function verifyPassword(string $password, string $hash): bool;
}
