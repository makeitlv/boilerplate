<?php

declare(strict_types=1);

namespace App\Book\Domain\Model\ValueObject;

use App\Common\Domain\Assert\Assert;

final readonly class Description implements \Stringable
{
    private string $description;

    public function __construct(string $description)
    {
        Assert::stringNotEmpty($description);

        $this->description = $description;
    }

    #[\Override]
    public function __toString(): string
    {
        return $this->description;
    }
}
