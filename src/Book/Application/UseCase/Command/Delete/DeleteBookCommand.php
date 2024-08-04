<?php

declare(strict_types=1);

namespace App\Book\Application\UseCase\Command\Delete;

final readonly class DeleteBookCommand
{
    public function __construct(
        public string $uuid,
    ) {}
}
