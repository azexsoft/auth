<?php

declare(strict_types=1);

namespace Azexsoft\Auth\Action;

use Azexsoft\Auth\AuthenticationServiceInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RetrieveTokenAction implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly AuthenticationServiceInterface $authenticationService,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var array{username: string, password: string} $body */
        $body = $request->getParsedBody();

        $user = $this->authenticationService->findUserByCredentials($body['username'], $body['password']);
        $token = $this->authenticationService->retrieveAuthToken($user);

        $response = $this->responseFactory->createResponse()
            ->withHeader('Content-Type', 'application/json')
        ;
        $response->getBody()->write(json_encode($token, JSON_THROW_ON_ERROR));
        return $response;
    }
}
