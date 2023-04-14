<?php

declare(strict_types=1);

namespace Azexsoft\Auth;

interface IdentityInterface
{
    public function getUsername(): string;

    public function getPassword(): string;

    public function getName(): string;
}
