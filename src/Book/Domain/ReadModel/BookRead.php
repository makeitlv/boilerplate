<?php

declare(strict_types=1);

namespace App\Book\Domain\ReadModel;

final readonly class BookRead
{
    public function __construct(
        public string $title,
        public string $author,
        public string $description,
    ) {}
}
