<?php

declare(strict_types=1);

namespace Azexsoft\Auth;

interface AuthenticationServiceInterface
{
    /**
     * @throws InvalidCredentialsException
     */
    public function findUserByCredentials(string $username, string $password): IdentityInterface;

    /**
     * @throws InvalidCredentialsException
     */
    public function findUserByAuthToken(string $token): IdentityInterface;

    public function retrieveAuthToken(IdentityInterface $user): AuthTokenInterface;

    /**
     * @throws InvalidCredentialsException
     */
    public function refreshAuthToken(string $refreshToken): AuthTokenInterface;
}
