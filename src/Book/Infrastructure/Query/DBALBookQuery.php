<?php

declare(strict_types=1);

namespace App\Book\Infrastructure\Query;

use App\Book\Domain\Query\BookQueryInterface;
use App\Book\Domain\ReadModel\BookRead;
use App\Common\Infrastructure\Query\DBAL\AbstractDBALQuery;

final readonly class DBALBookQuery extends AbstractDBALQuery implements BookQueryInterface
{
    /**
     * @return array<BookRead>
     */
    #[\Override]
    public function fetchBooks(): array
    {
        /** @var array<array-key, array<string, string>> $books */
        $books = $this->queryBuilder->select('*')
            ->from('books')
            ->executeQuery()
            ->fetchAllAssociative()
        ;

        return \array_map(static fn (array $book): BookRead => new BookRead(
            $book['title'],
            \sprintf('%s - %s', $book['firstname'], $book['lastname']),
            $book['description'],
        ), $books);
    }
}
