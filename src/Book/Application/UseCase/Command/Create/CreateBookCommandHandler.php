<?php

declare(strict_types=1);

namespace App\Book\Application\UseCase\Command\Create;

use App\Book\Domain\Model\Book;
use App\Book\Domain\Model\ValueObject\Author;
use App\Book\Domain\Model\ValueObject\Description;
use App\Book\Domain\Model\ValueObject\Title;
use App\Book\Domain\Repository\BookRepositoryInterface;
use App\Common\Application\Bus\Command\CommandHandlerInterface;
use App\Common\Domain\Model\ValueObject\Uuid;

final readonly class CreateBookCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private BookRepositoryInterface $bookRepository,
    ) {}

    public function __invoke(CreateBookCommand $createBookCommand): void
    {
        $book = new Book(
            new Uuid($createBookCommand->uuid),
            new Title($createBookCommand->title),
            new Description($createBookCommand->description),
            new Author(
                $createBookCommand->authorFirstName,
                $createBookCommand->authorLastName,
            ),
        );

        $this->bookRepository->persist($book);
    }
}
