<?php

declare(strict_types=1);

namespace App\Common\Domain\Model\ValueObject;

use App\Common\Domain\Assert\Assert;

final readonly class Uuid implements \Stringable
{
    private string $uuid;

    public function __construct(string $uuid)
    {
        Assert::uuid($uuid);

        $this->uuid = $uuid;
    }

    #[\Override]
    public function __toString(): string
    {
        return $this->uuid;
    }
}
