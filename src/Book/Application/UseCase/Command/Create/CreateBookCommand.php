<?php

declare(strict_types=1);

namespace App\Book\Application\UseCase\Command\Create;

final readonly class CreateBookCommand
{
    public function __construct(
        public string $uuid,
        public string $title,
        public string $description,
        public string $authorFirstName,
        public string $authorLastName,
    ) {}
}
