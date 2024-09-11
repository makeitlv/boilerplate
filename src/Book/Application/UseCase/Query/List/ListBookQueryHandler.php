<?php

declare(strict_types=1);

namespace App\Book\Application\UseCase\Query\List;

use App\Book\Domain\Query\BookQueryInterface;
use App\Book\Domain\ReadModel\BookRead;
use App\Common\Application\Bus\Query\QueryHandlerInterface;
use App\Common\Domain\ReadModel\PaginationData;

final readonly class ListBookQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private BookQueryInterface $bookQuery,
    ) {}

    /**
     * @return PaginationData<BookRead>
     */
    public function __invoke(ListBookQuery $listBookQuery): PaginationData
    {
        return $this->bookQuery->fetchBooks(
            $listBookQuery->page->value(),
            $listBookQuery->limit->value(),
        );
    }
}
