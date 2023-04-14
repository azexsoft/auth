<?php

declare(strict_types=1);

namespace Azexsoft\Auth\Controller;

use Azexsoft\Auth\IdentityInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class GetUserAction implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var IdentityInterface $user */
        $user = $request->getAttribute(IdentityInterface::class);

        $response = $this->responseFactory->createResponse()
            ->withHeader('Content-Type', 'application/json')
        ;
        $response->getBody()->write(json_encode($user, JSON_THROW_ON_ERROR));
        return $response;
    }
}
