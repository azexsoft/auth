<?php

declare(strict_types=1);

namespace Azexsoft\Auth\Middleware;

use Azexsoft\Auth\IdentityInterface;
use Azexsoft\Auth\InvalidCredentialsException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class BearerAuthentication extends Authentication
{
    protected function getAuthType(): string
    {
        return 'Bearer';
    }

    protected function unauthorized(ServerRequestInterface $request): ResponseInterface
    {
        throw new InvalidCredentialsException();
    }

    protected function findUser(string $authorization): IdentityInterface
    {
        return $this->authenticationService->findUserByAuthToken($authorization);
    }
}
