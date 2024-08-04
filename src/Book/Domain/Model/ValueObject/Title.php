<?php

declare(strict_types=1);

namespace App\Book\Domain\Model\ValueObject;

use App\Common\Domain\Assert\Assert;

final readonly class Title implements \Stringable
{
    private string $title;

    public function __construct(string $title)
    {
        Assert::stringNotEmpty($title);
        Assert::maxLength($title, 255);

        $this->title = $title;
    }

    #[\Override]
    public function __toString(): string
    {
        return $this->title;
    }
}
