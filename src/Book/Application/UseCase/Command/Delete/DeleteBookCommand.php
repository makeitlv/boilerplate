<?php

declare(strict_types=1);

namespace App\Book\Application\UseCase\Command\Delete;

use App\Common\Application\Bus\Command\CommandInterface;

final readonly class DeleteBookCommand implements CommandInterface
{
    public function __construct(
        public string $uuid,
    ) {}
}
