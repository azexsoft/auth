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
        $requestBody = $request->getParsedBody();

        if (!is_string($requestBody['refreshToken'] ?? null)) {
            $code = 400;
            $responseBody = ['message' => 'Field "refreshToken" must exist and be a string'];
        } else {
            $code = 200;
            $responseBody = $this->authenticationService->refreshAuthToken($requestBody['refreshToken']);
        }

        $response = $this->responseFactory->createResponse($code)
            ->withHeader('Content-Type', 'application/json')
        ;
        $response->getBody()->write(json_encode($responseBody, JSON_THROW_ON_ERROR));
        return $response;
    }
}
