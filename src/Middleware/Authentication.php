<?php

declare(strict_types=1);

namespace Azexsoft\Auth\Middleware;

use Azexsoft\Auth\AuthenticationServiceInterface;
use Azexsoft\Auth\IdentityInterface;
use Azexsoft\Auth\InvalidCredentialsException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class Authentication implements MiddlewareInterface
{
    public function __construct(
        protected readonly AuthenticationServiceInterface $authenticationService,
        protected readonly string $headerName = 'Authorization',
    ) {
    }

    /**
     * @throws InvalidCredentialsException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $authorization = $this->parseHeader($request);
        if (!$authorization) {
            return $this->unauthorized($request);
        }

        try {
            $user = $this->findUser($authorization);
            return $handler->handle($request->withAttribute(IdentityInterface::class, $user));
        } catch (InvalidCredentialsException) {
            return $this->unauthorized($request);
        }
    }

    abstract protected function getAuthType(): string;

    /**
     * @throws InvalidCredentialsException
     */
    abstract protected function unauthorized(ServerRequestInterface $request): ResponseInterface;

    /**
     * @throws InvalidCredentialsException
     */
    abstract protected function findUser(string $authorization): IdentityInterface;

    private function parseHeader(ServerRequestInterface $request): ?string
    {
        $header = $request->getHeaderLine($this->headerName);
        if (!str_starts_with($header, $this->getAuthType())) {
            return null;
        }
        return substr($header, strlen($this->getAuthType()) + 1);
    }
}
