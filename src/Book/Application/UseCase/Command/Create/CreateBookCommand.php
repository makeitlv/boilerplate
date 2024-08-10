<?php

declare(strict_types=1);

namespace App\Book\Application\UseCase\Command\Create;

use App\Common\Application\Bus\Command\CommandInterface;

final readonly class CreateBookCommand implements CommandInterface
{
    public function __construct(
        public string $uuid,
        public string $title,
        public string $description,
        public string $authorFirstName,
        public string $authorLastName,
    ) {}
}
