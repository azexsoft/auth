<?php

declare(strict_types=1);

namespace Azexsoft\Auth;

interface IdentityInterface
{
    public function getId(): int|string;

    public function getUsername(): string;

    public function getName(): string;
}
