<?php

declare(strict_types=1);

namespace Azexsoft\Auth;

use DateTimeImmutable;

interface AuthTokenInterface
{
    public function getIdentity(): IdentityInterface;

    public function getToken(): string;

    public function getRefreshToken(): string;

    public function getIssuedAt(): DateTimeImmutable;

    public function getExpiresAt(): DateTimeImmutable;

    public function getRefreshTokenExpiresAt(): DateTimeImmutable;
}
