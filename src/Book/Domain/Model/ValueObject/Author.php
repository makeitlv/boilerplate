<?php

declare(strict_types=1);

namespace App\Book\Domain\Model\ValueObject;

use App\Common\Domain\Assert\Assert;

final readonly class Author implements \Stringable
{
    private string $firstname;

    private string $lastname;

    public function __construct(string $firstname, string $lastname)
    {
        Assert::stringNotEmpty($firstname);
        Assert::length($firstname, 64);

        Assert::stringNotEmpty($lastname);
        Assert::length($lastname, 64);

        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    #[\Override]
    public function __toString(): string
    {
        return \sprintf('%s %s', $this->firstname, $this->lastname);
    }
}
