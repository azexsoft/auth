<?php

declare(strict_types=1);

namespace Azexsoft\Auth;

interface TokenGeneratorInterface
{
    public function generateToken(): string;
}
