<?php

declare(strict_types=1);

namespace Azexsoft\Auth\Middleware;

use Azexsoft\Auth\AuthenticationServiceInterface;
use Azexsoft\Auth\IdentityInterface;
use Azexsoft\Auth\InvalidCredentialsException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

final class BasicAuthentication extends Authentication
{
    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly StreamFactoryInterface $streamFactory,
        AuthenticationServiceInterface $authenticationService,
        string $headerName = 'Authorization',
        private readonly string $realm = 'Authentication required.',
    ) {
        parent::__construct($authenticationService, $headerName);
    }

    protected function getAuthType(): string
    {
        return 'Basic';
    }

    protected function unauthorized(ServerRequestInterface $request): ResponseInterface
    {
        return $this->responseFactory->createResponse(401)
            ->withHeader('WWW-Authenticate', sprintf('Basic realm="%s"', $this->realm))
            ->withBody($this->streamFactory->createStream($this->realm))
        ;
    }

    protected function findUser(string $authorization): IdentityInterface
    {
        /** @var string|false $header */
        $header = base64_decode($authorization, true);
        if ($header === false) {
            throw new InvalidCredentialsException();
        }

        [$username, $password] = explode(':', $header, 2);

        return $this->authenticationService->findUserByCredentials($username, $password);
    }
}
