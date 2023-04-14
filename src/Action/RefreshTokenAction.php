<?php

declare(strict_types=1);

namespace Azexsoft\Auth\Action;

use Azexsoft\Auth\AuthenticationServiceInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RefreshTokenAction implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly AuthenticationServiceInterface $authenticationService,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var array{refreshToken: string} $body */
        $body = $request->getParsedBody();
        $token = $this->authenticationService->refreshAuthToken($body['refreshToken']);

        $response = $this->responseFactory->createResponse()
            ->withHeader('Content-Type', 'application/json')
        ;
        $response->getBody()->write(json_encode($token, JSON_THROW_ON_ERROR));
        return $response;
    }
}
