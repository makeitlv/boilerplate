<?php

declare(strict_types=1);

namespace App\Book\Application\UseCase\Command\Delete;

use App\Book\Domain\Repository\BookRepositoryInterface;
use App\Common\Application\Bus\Command\CommandHandlerInterface;
use App\Common\Domain\Model\ValueObject\Uuid;

final readonly class DeleteBookCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private BookRepositoryInterface $bookRepository,
    ) {}

    public function __invoke(DeleteBookCommand $deleteBookCommand): void
    {
        $this->bookRepository->removeByUuid(new Uuid($deleteBookCommand->uuid));
    }
}
