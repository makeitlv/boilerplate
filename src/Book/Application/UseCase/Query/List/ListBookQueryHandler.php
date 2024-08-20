<?php

declare(strict_types=1);

namespace App\Book\Application\UseCase\Query\List;

use App\Book\Domain\Query\BookQueryInterface;
use App\Book\Domain\ReadModel\BookRead;
use App\Common\Application\Bus\Query\QueryHandlerInterface;

final readonly class ListBookQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private BookQueryInterface $bookQuery,
    ) {}

    /**
     * @return array<BookRead>
     */
    public function __invoke(ListBookQuery $listBookQuery): array
    {
        return $this->bookQuery->fetchBooks();
    }
}
