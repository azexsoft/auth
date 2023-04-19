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
        $requestBody = $request->getParsedBody();

        if (!is_string($requestBody['username'] ?? null) || !is_string($requestBody['password'] ?? null)) {
            $code = 400;
            $responseBody = ['message' => 'Field "username" and "password" must exist and be a string'];
        } else {
            $code = 200;
            $user = $this->authenticationService->findUserByCredentials($requestBody['username'], $requestBody['password']);
            $responseBody = $this->authenticationService->retrieveAuthToken($user);
        }

        $response = $this->responseFactory->createResponse($code)
            ->withHeader('Content-Type', 'application/json')
        ;
        $response->getBody()->write(json_encode($responseBody, JSON_THROW_ON_ERROR));
        return $response;
    }
}
